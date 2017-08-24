<template>
	<div>
		<v-app v-if="landscape">
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
											<v-card-title class = "amber darken-1 white--text">
												<p id = "certificate-listing-title">Recent Sales</p>
											</v-card-title>
											<v-card-text id = "certificate-listing" v-if="showRecentSales">
												<template v-for="(gift,index) in gifts">
													<v-card :key="gift.squareId" @click="select(index)"
													        :class="{'blue lighten-4 white--text':selectedStyle(gift.id)}">
														<v-card-text>
															<v-layout row>
																<v-flex lg4>
																	<v-list-tile-title>
																		<p class = "title green--text text-darken-1">{{ gift.squareId.substring(0,5) }}</p>
																	</v-list-tile-title>
																</v-flex>
																<v-flex lg4>
																	<v-list-tile-title>
																		<p class = "title">$ {{ gift.amount }}</p>
																	</v-list-tile-title>
																</v-flex>
																<v-flex lg4>
																	<v-list-tile-title>
																		<p class = "title">{{ formattedDate(gift.sold_at) }}</p>
																	</v-list-tile-title>
																</v-flex>
															</v-layout>
														</v-card-text>
													</v-card>
												</template>
											</v-card-text>
											<v-card-text v-else>
												<p class="title text-xs-center">There are no recent gift certificate sale within a week</p>
											</v-card-text>
										</v-card>

									</v-flex>
									<v-flex lg6 v-if="showCertificate" >
										<div class = "certificate">
											<div class = "certificateTitle">
												<p>Gift Certificate</p>
											</div>
											<div class = "certificateText">
												<v-layout row wrap>
													<v-flex lg12 md12>
														<h1 class = text-xs-center :class="{'green--text text--darken-1':amountChange}">$ {{selected.amount}}</h1>
													</v-flex>
													<v-flex lg12 md12 mt-3>
														<p class = "title">ID: {{selected.squareId}}</p>
													</v-flex>
													<v-flex lg6 md6 mt-3>
														<p class = "title">Sold: {{formattedDate(selected.sold_at)}}</p>
													</v-flex>
													<v-flex lg6 md6 mt-3>
														<p class = "title">Expired: {{formattedDate(selected.expired_at)}}</p>
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
				<component :is="currentDialog" :gift="selected" :title="dialogTitle" v-on:completed="completed" v-on:cancel="showDialog = false"></component>
			</v-dialog>
		</v-app>
		<v-app v-else>
			<v-container fluid>
				<v-layout class = "top-buffer">
					<v-flex xs10 offset-xs1>
						<v-card>
							<v-card-text>
								<p class = "text-xs-center"><v-icon large class="display-1">screen_rotation</v-icon></p>
								<p class = "headline text-xs-center">Please rotate your device to the landscape position</p>
							</v-card-text>
						</v-card>
					</v-flex>
				</v-layout>
			</v-container>
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
            window.addEventListener('orientationchange',this.detectDeviceOrientation);
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
	            showRecentSales: false,
	            currentDialog:null,
	            dialogTitle:null,
	            landscape: window.matchMedia("(orientation: landscape)").matches,

            }
        },
        methods: {
	        detectDeviceOrientation(){
                this.landscape = window.matchMedia("(orientation: landscape)").matches;

	        },
			recent(){
			    this.$axios.get('/api/gift-certificate/recent').then(response =>{
			        if(response.data.length > 0){
                        this.gifts = response.data;
                        this.showRecentSales = true;
			        }

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
	@import url('https://fonts.googleapis.com/css?family=Patua+One');
	.top-buffer{
		margin-top: 50%;
	}
	.certificateTitle{
		background:#2196f3;
		padding:2px;
		text-align: center;


	}
	.certificateTitle p{
		font-size:28px;
		font-family: 'Patua One', cursive;
		font-weight: bold;
		color:white;
	}
	#certificate-listing{
		max-height: 480px;
		overflow-y: scroll;
	}
	#certificate-listing-title{
		font-size:24px;
		font-family: 'Patua One', cursive;
		font-weight: bold;
		color:white;
	}
</style>