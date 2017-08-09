<template>
	<div>
		<v-app class = "blue lighten-4">
		<v-container fluid>
			<v-layout row wrap>
				<v-flex lg12>
					<v-alert success v-model="isAdded" transition="fade" class = "text-lg-center" dismissible>
						<p class = "headline ">Technician Sale has been added</p>
					</v-alert>
				</v-flex>
				<v-flex lg12>
					<v-card>
						<v-card-text>
							<v-layout row wrap>
								<v-flex lg6>
									<v-layout row wrap>
										<v-flex lg11>
											<v-date-picker v-model="date" landscape></v-date-picker>
										</v-flex>
										<v-flex lg6 mt-2><!--Square Data-->
											<v-card>
												<v-card-title class = "grey lighten-4">
													<img :src="images[0].src" :height="74">
												</v-card-title>
												<v-card-text>
													<div v-if="loadingData" class = "text-lg-center">
														<v-progress-circular indeterminate class="red--text"></v-progress-circular>
														<p class = "headline">Loading...</p>
													</div>
													<div v-if="noSquareData" class = "text-lg-center">
														<v-icon large class = "red--text">warning</v-icon>
														<p class = "headline">No Square data available, please choose another date</p>
													</div>
													<div v-else>
														<p class = "headline">Gross Sales: $ {{square.grossSale}}</p>
														<p class = "headline">Card: $ {{square.cardCollected}}</p>
														<p class = "headline">Cash: $ {{square.cashCollected}}</p>
														<p class = "headline">Card Tip: $ {{square.cardTip}}</p>
														<p class = "headline">Convenience Fee: $ {{square.convenienceFee}}</p>
														<p class = "headline" v-if="square.giftSale > 0">Gift Sales: $ {{ square.giftSale}}</p>
														<p class = "headline" v-if="square.giftRedeem < 0">Gift Redeemed $ {{ square.giftRedeem }}</p>
														<p class = "headline" v-if="square.refunded > 0">Refunded: $ {{ square.refunded}}</p>
													</div>
												</v-card-text>
											</v-card>
										</v-flex>
										<v-flex lg6 mt-2>
											<v-card>
												<v-card-title class = "amber darken-1">
													<h3 class = "display-1 white--text">Technician Sale</h3>
												</v-card-title>
												<v-card-text>
													<v-list>
														<p class = "headline"
														   :class="{'green--text darken-1': square.grossSale == technicianGrossSale}">
															<strong>Gross Sales:</strong> $ {{ technicianGrossSale}}</p>
														<p class = "headline"><strong>Tech Sales :</strong> $ {{ technicianSale }}</p>
														<p class = "headline"><strong>Card Tip :</strong>$ {{ technicianCardTip }}</p>
													</v-list>
												</v-card-text>
											</v-card>
										</v-flex>
										<v-flex lg6 mt-2>
											<v-card>
												<v-card-title class = "indigo darken-1">
													<h3 class = "display-1 white--text">Redeem Gift</h3>
												</v-card-title>
												<v-card-text>
													<form>
														<v-text-field type="number" max="3" label = "Amount" v-model="redeemGiftAmount" prefix="$"></v-text-field>
														<v-btn @click.submit.prevent="redeemGift" primary >Redeem</v-btn>
													</form>
													<v-spacer></v-spacer>
													<v-alert success v-model="giftRedeemed" dismissible>The gift is redeemed</v-alert>
												</v-card-text>
											</v-card>
										</v-flex>

									</v-layout>
								</v-flex>
								<v-flex lg6>
									<v-list two-line>
										<template v-for="(technician,index) in technicians">
											<v-list-tile-content @mouseover = "hover(index)" @mouseleave = "hover(null)"
										                        :class="[{'grey lighten-4':select(index)},
											                     {'green--text text-darken-1':sales[index].sales !== 0},
											                     {'red--text text-darken-1}': sales[index].toBeDeleted}]">

											<v-list-tile-title class = "title">
												<v-chip label>{{ index + 1 }}</v-chip>
												{{ technician.fullName }}</v-list-tile-title>
											<v-list-tile-sub-title>
												<v-layout>
													<v-flex lg3>
														<v-text-field label = "Sale" prefix="$"
														              v-model.number="sales[index].sales"
														              type="number"
														              max="3"
														              :disabled = "sales[index].toBeDeleted"

														              @focus="clearInput(index,'sale')"
														              @blur="checkInput(index,'sale')" hint="SALE">
														</v-text-field>
													</v-flex>
													<v-flex lg2>
														<p v-if="technician.dailySales.length > 0" class = "blue--text heading">
															$ {{ technician.dailySales[0].sales }}
														</p>
													</v-flex>
													<v-flex lg3>
														<v-text-field label = "Tip" prefix="$"
														              v-model.number="sales[index].additional_sales"
														              type="number"
														              max="3"
														              :disabled = "sales[index].toBeDeleted"

														              @focus="clearInput(index,'tip')"
														              @blur="checkInput(index,'tip')" hint="TIP"></v-text-field>
													</v-flex>
													<v-flex lg2>
														<p v-if="technician.dailySales.length > 0" class = "blue--text heading">
															$ {{ technician.dailySales[0].additional_sales }}
														</p>
													</v-flex>
													<v-flex lg2>
														<v-checkbox :label="`Delete`" v-model="sales[index].toBeDeleted"
														            v-if="sales[index].existing_sale_id && sales[index].sales == 0"></v-checkbox>
													</v-flex>
													<v-flex lg2>

													</v-flex>
												</v-layout>
											</v-list-tile-sub-title>
										</v-list-tile-content>
									</template>
								</v-list>
							</v-flex>
						</v-layout>
						</v-card-text>
						<v-divider></v-divider>
						<v-card-text class = "text-xs-right">
							<v-btn class = "ma-3" primary @click.native.stop="openDialog = true">Verify</v-btn>
						</v-card-text>
					</v-card>
				</v-flex>


			</v-layout>
		</v-container>
		<v-dialog v-model="openDialog" width="480">
			<v-card>
				<v-card-title class = "text-lg-center blue darken-1">
					<p class = "headline white--text">Confirm Sale for {{ saleDate }} </p>
				</v-card-title>
				<v-card-text>
					<v-list>
						<v-layout>
							<v-flex lg6>
							</v-flex>
							<v-flex lg3>
								<p class = "title">Sale</p>
							</v-flex>
							<v-flex lg3>
								<p class = "title">Tip</p>
							</v-flex>
							<v-flex lg3>

							</v-flex>
						</v-layout>
						<template v-for="(technician,index) in technicians">
							<v-list-tile-content>
								<v-list-tile-sub-title>
									<v-layout>
										<v-flex lg6>
											<p class = "title">{{ technician.fullName }}</p>
										</v-flex>
										<v-flex lg3>
											<p class = "title">$ {{ sales[index].sales }}</p>
										</v-flex>
										<v-flex lg3>
											<p class = "title">$ {{ sales[index].additional_sales }}</p>
										</v-flex>
										<v-flex lg3>
											<p class = "text-xs-center":class="['title blue white--text']"
											   v-if="sales[index].existing_sale_id !== null && sales[index].sales > 0 ">Update</p>
											<p class = "text-xs-center":class="['title green white--text']"
											   v-if="sales[index].existing_sale_id == null && sales[index].sales > 0">Add</p>
											<p class = "text-xs-center":class="['title red white--text']"
											   v-if="sales[index].toBeDeleted">Delete</p>
										</v-flex>
									</v-layout>
								</v-list-tile-sub-title>
							</v-list-tile-content>
						</template>
					</v-list>
				</v-card-text>
				<v-card-actions>
					<v-btn @click.native="addSale" primary><v-icon class = "white--text">add</v-icon>Add</v-btn>
					<v-btn @click.native="openDialog = false">Close</v-btn>
				</v-card-actions>
			</v-card>
		</v-dialog>
	</v-app>
	</div>
</template>
<script>


    export default {
        components: {},
        props: [],

        data() {
            return {
                date: this.$moment().format('YYYY-MM-DD'),
	            square:{
		            grossSale:null,
		            cardTip:null,
		            convenienceFee:null,
		            giftSale:null,
		            giftRedeem:null,
		            cardCollected:null,
		            cashCollected:null,
		            refunded:null,
	            },
				technician:{
                    grossSale:null,
					cardTip:null,
				},

	            technicians:[],
	            sale:null,
	            sales:[],
	            isAdded: false,
	            active: null,
	            openDialog: false,
	            loadingData:false,
	            noSquareData:false,
	            redeemGiftAmount:null,
	            giftRedeemed:false,

	            images:[
		            {name:'Square Logo', src:'/images/square-logo.png'}
	            ]

            }
        },

		computed:{
            saleDate(){
                return this.$moment(this.date).format('dddd MM/DD/YYYY');
            },
            technicianSale(){
                let grossSale = parseFloat(this.technician.grossSale);
                for(let i = 0; i < this.sales.length; i++){
                    grossSale += parseFloat(this.sales[i].sales);
                }
                if(isNaN(grossSale)){
                    grossSale = 0;
                }

                return grossSale;
			},
			technicianCardTip(){
                let cardTip = parseFloat(this.technician.cardTip);
                for(let i = 0; i < this.sales.length; i++){
                    cardTip += parseFloat(this.sales[i].additional_sales);
                }
                if(isNaN(cardTip)){
                    cardTip = 0;
                }

                return cardTip;
			},

			technicianGrossSale(){
			    return this.technicianSale + this.square.giftSale + this.square.giftRedeem + this.square.convenienceFee;
			}
		},
	    mounted(){
            this.getSquareData();
            this.getAllTechnicians();
	    },
		watch:{
	        date(){
	            this.getSquareData();
	            this.getAllTechnicians();
	        }
		},
        methods: {
	        getSquareData(){
	            this.loadingData = true;
                this.$axios('/api/salon/daily-sale?date=' + this.date).then(response=>{

                    this.loadingData = false;
                    if(response.data.success){
                        this.square.grossSale = response.data.sales['Square Gross Sales'];
                        this.square.cardTip =  response.data.tips['Square Tips'];
                        this.square.convenienceFee = parseFloat(response.data.sales['Convenience Fee']);
                        this.square.giftSale = parseFloat(response.data.sales['Gift Certificate']);
                        this.square.giftRedeem = parseFloat(response.data.sales['Gift Certificate Redeemed']);
                        this.square.cardCollected = response.data.sales['Card Collected'];
                        this.square.cashCollected = response.data.sales['Cash Collected'];
                        this.square.refunded =  response.data.sales['Refunded'];
                        this.technician.grossSale = response.data.sales['Technician Sales'];
                        this.technician.cardTip = response.data.tips['Technician Tips'];
                        this.noSquareData =  false;
                    }
                    else{
                        this.square.grossSale = 0;
                        this.square.cardTip =  0;
                        this.square.convenienceFee = 0;
                        this.square.giftRedeem = 0;
                        this.square.cardCollected = 0;
                        this.square.cashCollected = 0;
                        this.square.refunded =  0;
                        this.technician.grossSale = 0;
                        this.technician.cardTip = 0;
                        this.noSquareData = true;
                    }
                });
	        },

			getAllTechnicians(){
                this.$axios.get('/api/technician-sale/get?saleDate=' + this.date).then(response =>{

                    this.technicians = response.data.technicians;
                    this.sales = [];

                    for(let i = 0; i < this.technicians.length; i++){
                        if(this.technicians[i].dailySales.length > 0){
                            this.sale = {technician_id:this.technicians[i].technicianID, sales:0,
                                additional_sales:0,sale_date: this.date,
	                            existing_sale_id: this.technicians[i].dailySales[0].id, toBeDeleted:false};
                        }
                        else{
                            this.sale = {technician_id:this.technicians[i].technicianID, sales:0,
                                additional_sales:0,sale_date: this.date, existing_sale_id:null, toBeDeleted:false};
                        }

                        this.sales.push(this.sale);

                    }
                    this.sale = null;
                });


			},
	        addSale(){
			    let newSales = [];
				for(let i = 0; i < this.sales.length; i++){
				    if(this.sales[i].sales !== 0 || this.sales[i].toBeDeleted === true){
				        newSales.push(this.sales[i]);
				    }
				}
				this.$axios.post('/api/technician-sale/handle-quick-sale',{sales:newSales}).then(response =>{
				    if(response.data.success){
				        this.openDialog = false;
				        this.isAdded = true;
				        this.reset();
				    }

				});
	        },

	        redeemGift(){
				this.$axios.post('/api/salon-sale/redeem-gift-certificate',{date:this.date, amount:this.redeemGiftAmount})
					.then(response =>{
                        console.log(response.data);
						if(response.data.success){
						    this.giftRedeemed = true;
						    this.redeemGiftAmount = null;
						}

					});
	        },
			reset(){
	            this.getAllTechnicians();

			},
	        clearInput(index,input){
			    this.active = true;
	            if(input === 'sale'){
                    this.sales[index].sales ='';
	            }else if(input === 'tip'){
	                this.sales[index].additional_sales = ''
	            }
	        },
	        checkInput(index, input){
	            if(input === 'sale'){
                    if(this.sales[index].sales === '') {
                        this.sales[index].sales = 0;

                    }
	            }else if(input === 'tip'){
                    if(this.sales[index].additional_sales === '') {
                        this.sales[index].additional_sales = 0;
                    }
	            }

	        },
	        hover(index){
	            this.active = index;
	        },
	        select(index){
	            return this.active === index;

	        }

        }


    }
</script>

<style>

</style>