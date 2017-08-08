<template>
	<div>
		<v-app class = "blue lighten-4">
		<v-container fluid>

			<v-layout>
				<v-flex>
					<v-alert success v-model="isAdded" transition="fade" class = "text-lg-center" dismissible>
						<p class = "headline ">Technician Sale has been added</p>
					</v-alert>
					<v-card>
						<v-card-text>
							<v-layout row>
								<v-flex lg3>
									<v-date-picker v-model="date"></v-date-picker>
								</v-flex>
								<v-flex lg4>
									<v-list v-if="square.success">
										<p class = "headline">Gross Sales: $ {{square.grossSale}}</p>
										<p class = "headline">Card Tip: $ {{square.cardTip}}</p>
										<p class = "headline">Convenience Fee: $ {{square.convenienceFee}}</p>
										<p class = "headline">Gift Sales $ {{ square.giftSale}}</p>
									</v-list>
									<v-list>
										<p class = "headline">Gross Sales : $ {{ technicianGrossSale }}</p>
										<p class = "headline">Card Tip :$ {{ technicianCardTip }}</p>
									</v-list>
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
											<p class = "text-xs-center":class="['title blue white--text']" v-if="sales[index].existing_sale_id !== null && sales[index].sales > 0 ">Update</p>
											<p class = "text-xs-center":class="['title green white--text']" v-if="sales[index].existing_sale_id == null && sales[index].sales > 0">Add</p>
											<p class = "text-xs-center":class="['title red white--text']" v-if="sales[index].toBeDeleted">Delete</p>
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
					success:false,
		            grossSale:null,
		            cardTip:null,
		            convenienceFee:null,
		            giftSale:null
	            },

	            technicians:[],
	            sale:null,
	            sales:[],
	            isAdded: false,
	            active: null,
	            openDialog: false,

            }


        },

		computed:{
            saleStatus(index){

            },
            saleDate(){
                return this.$moment(this.date).format('dddd MM/DD/YYYY');
            },
            technicianGrossSale(){
                let grossSale = 0;
                for(let i = 0; i < this.sales.length; i++){
                    grossSale += parseInt(this.sales[i].sales);
                }
                if(isNaN(grossSale)){
                    grossSale = 'Pending...';
                }

                return grossSale;
			},
			technicianCardTip(){
                let cardTip = 0;
                for(let i = 0; i < this.sales.length; i++){
                    cardTip += parseInt(this.sales[i].additional_sales);
                }
                if(isNaN(cardTip)){
                    cardTip = 'Pending...';
                }

                return cardTip;
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
                this.$axios('/api/salon/daily-sale?date=' + this.date).then(response=>{
                    this.square.success = response.data.success;
                    if(this.square.success){
                        this.square.grossSale = response.data.sales['Square Gross Sales'];
                        this.square.cardTip =  response.data.tips['Square Tips'];
                        this.square.convenienceFee = response.data.sales['Convenience Fee'];
                        this.square.giftSale = response.data.sales['Gift Certificate'];
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