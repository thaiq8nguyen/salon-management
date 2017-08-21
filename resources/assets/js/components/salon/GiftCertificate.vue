<template>
	<div>
		<v-app>
			<nav-top-bar></nav-top-bar>
			<v-container fluid>
				<v-layout>
					<v-flex lg12 md12>
						<v-card>
							<v-card-text>

								<search v-on:selected="searchSelect"></search>

								<v-layout>
									<v-flex :class="certificateListing">
										<v-card flat>
											<v-card-title>
												<p class = "headline">Recent Sold Certificates</p>
											</v-card-title>
											<v-card-text>
												<template v-for="(gift,index) in gifts">
													<v-card :key="gift.squareId" @click="select(index)"
													        :class="{'blue lighten-1 white--text':selectedStyle(gift.id)}">
														<v-card-text>
															<v-layout row>
																<v-flex lg4>
																	<v-list-tile-title>
																		<p class = "title">ID: {{ gift.squareId.substring(0,5) }}</p>
																	</v-list-tile-title>
																</v-flex>
																<v-flex lg4>
																	<v-list-tile-title>
																		<p class = "title">Value: $ {{ gift.amount }}</p>
																	</v-list-tile-title>
																</v-flex>
																<v-flex lg4>
																	<v-list-tile-title>
																		<p class = "title">Sold On: {{ formattedDate(gift.sold_at) }}</p>
																	</v-list-tile-title>
																</v-flex>
															</v-layout>
														</v-card-text>
													</v-card>
												</template>
											</v-card-text>
										</v-card>
									</v-flex>
									<v-flex lg6 v-if="showCertificate" >
										<div class = "certificate">
											<div class = "certificateTitle">
												<h5>Sugar Nail Certificate</h5>
											</div>
											<div class = "certificateText">
												<v-layout row wrap>
													<v-flex lg12 md12>
														<h1 class = text-lg-center :class="{'green--text text--darken-1':amountChange}">$ {{selected.amount}}</h1>
													</v-flex>
													<v-flex lg6 md12 mt-3>
														<p class = "subheading">ID: {{selected.squareId}}</p>
													</v-flex>
													<v-flex lg3 md6 mt-3>
														<p class = "subheading">Sold: {{formattedDate(selected.sold_at)}}</p>
													</v-flex>
													<v-flex lg3 md6 mt-3>
														<p class = "subheading">Expired: {{formattedDate(selected.expired_at)}}</p>
													</v-flex>
												</v-layout>
											</div>
										</div>
										<v-divider></v-divider>
										<v-layout row wrap>
											<v-flex lg6>
												<v-btn class = "green darken-1 white--text headline" large  block @click.native.stop="useCertificate">Use</v-btn>
											</v-flex>
											<v-flex lg6>
												<v-btn class = "deep-purple darken-1 white--text headline" large block @click.native.stop="voidCertificate">Void</v-btn>
											</v-flex>
										</v-layout>
									</v-flex>
								</v-layout>
							</v-card-text>
						</v-card>
					</v-flex>
				</v-layout>
			</v-container>
			<v-dialog v-model="showDialog" width="540">
				<component :is="currentDialog" :id="selected.id" :title="dialogTitle" v-on:completed="completed" v-on:cancel="showDialog = false"></component>
			</v-dialog>
		</v-app>
	</div>
</template>

<script>
	import NavigationTopbar from '../navigation/NavigationTopBar.vue';
	import Search from './SearchGiftCertificate.vue';
	import UseCertificate from './UseGiftCertificate.vue';
	import VoidCertificate from './VoidGiftCertificate.vue';

    export default {
        props: [],

	    components:{
			'nav-top-bar': NavigationTopbar,
		    'search': Search,
            'use-certificate':UseCertificate,
		    'void-certificate':VoidCertificate,
	    },

	    mounted(){
            this.recent();
	    },
		computed:{

		},
        data() {
            return {
                gifts: null,
				showCertificate:false,
	            certificateListing:'lg12',
	            showDialog:false,
	            amountChange:false,
	            selected:{},
	            currentDialog:null,
	            dialogTitle:null,
            }
        },
        methods: {
			recent(){
			    this.$axios.get('/api/gift-certificate/recent').then(response =>{
			        this.gifts = response.data;
			    })
			},
	        select(index){
			    this.certificateListing = 'lg6';
			    this.selected = this.gifts[index];
			    this.amountChange = false;
			    sessionStorage.setItem('giftIndex',index);
                this.showCertificate = true;

	        },
	        searchSelect(gift){
		        this.selected = gift;
                this.certificateListing = 'lg6';
                this.amountChange = false;
                this.showCertificate = true;

	        },
			completed(amount){
				this.selected.amount = amount;
				const index = sessionStorage.getItem('giftIndex');
				this.gifts[index].amount = amount;
				this.showDialog = false;
				this.amountChange = true;

			},
	        useCertificate(){
			    this.dialogTitle = 'Use Certificate';
                this.currentDialog = 'use-certificate';
                this.showDialog = true;
	        },
	        voidCertificate(){
	            this.dialogTitle = 'Void Certificate';
                this.currentDialog = 'void-certificate';
                this.showDialog = true;
	        },
	        selectedStyle(id){
	          return this.selected.id === id;
	        },
            formattedDate(date){
                return this.$moment(date).format('MM/DD/YYYY');
            }
        }


    }
</script>
<style>
	.certificateTitle{
		background:#2196f3;
		padding:2px;
		text-align: center;
	}
	.certificateTitle h5{
		font-weight: bold;
		color:white;
	}
</style>