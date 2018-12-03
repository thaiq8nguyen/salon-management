<template>
	<div>
		<v-app>
			<v-content>
				<primary-nav-bar></primary-nav-bar>
				<v-container fluid class = "blue lighten-4" grid-list-lg fill-height>
					<v-layout>
						<v-flex>
							<v-card flat>
								<v-card-text>
									<v-layout row>
										<v-flex lg4>
											<v-layout row wrap>
												<v-flex lg12><!--Calendar with date selection component-->
													<calendar v-on:selectedDate="handleDate"></calendar><!--handleDate() assigned a date value returns from the component-->
												</v-flex>
												<v-flex lg6><!--Redeem certificate component-->
													<redeem-certificate :date="chosenDate" v-on:redeemed="handleCertificateRedemption"></redeem-certificate>
												</v-flex>
												<v-flex lg6>
													<v-card height="250">
														<v-card-title class="purple white--text">
															<h3 class="headline">Gross Sale & Tip</h3>
														</v-card-title>
														<v-card-text>
                                                            <v-list>
                                                                <v-list-tile>
                                                                    <v-list-tile-content>
                                                                        <v-list-tile-title>Gross Sale</v-list-tile-title>
                                                                        <v-list-tile-sub-title class="subheading">$&nbsp{{ technicianSale }}</v-list-tile-sub-title>

                                                                    </v-list-tile-content>
                                                                </v-list-tile>
                                                                <v-divider></v-divider>
                                                                <v-list-tile>
                                                                    <v-list-tile-content>
                                                                        <v-list-tile-title>Gross Tip</v-list-tile-title>
                                                                        <v-list-tile-sub-title class="subheading">$&nbsp{{ technicianCardTip }}</v-list-tile-sub-title>
                                                                    </v-list-tile-content>
                                                                </v-list-tile>
                                                            </v-list>
                                                        </v-card-text>

													</v-card>
												</v-flex>
											</v-layout>
										</v-flex>
										<v-flex lg8 class="bordered">
											<v-layout row wrap>
												<v-flex lg12>
													<salon-sale-metric :date="chosenDate" :refresh="refreshSalonSaleMetric" @complete="handleSalonSaleMetric"></salon-sale-metric>
												</v-flex>
												<v-flex lg12>
													<v-card>
														<v-card-text>Reserved for cash receivable</v-card-text>
													</v-card>
												</v-flex>
											</v-layout>

										</v-flex>
									</v-layout>
									<v-layout row mt-3>
                                        <v-flex lg12>
                                            <v-card v-if="loadingData===false">
                                                <v-card-text>
                                                    <v-layout row wrap>
                                                        <template v-for="(technician,index) in technicians">
                                                            <v-flex lg2>
                                                                <v-card height="170px"flat @mouseover = "hover(index)" @mouseleave = "hover(null)"
                                                                        :class="[{active_technician_card:select(index)},
											                     {'green--text text-darken-1':sales[index].sales !== 0},
											                     {'red--text text-darken-1}': sales[index].toBeDeleted}]">
                                                                    <v-card-title class="blue white--text" >
                                                                        <h3><strong>{{ technician.fullName }}</strong></h3>
                                                                    </v-card-title>
                                                                    <v-card-text>
                                                                        <v-layout row wrap>
                                                                            <v-flex lg4>
                                                                                <v-text-field label = "Sale" prefix="$"
                                                                                              v-model.number="sales[index].sales"
                                                                                              :disabled = "sales[index].toBeDeleted"
                                                                                              @focus="clearSaleInput(index)"
                                                                                              @blur="verifySaleInput(index)"
                                                                                              @keypress="filtering" >
                                                                                </v-text-field>
                                                                            </v-flex>
                                                                            <v-flex lg4>
                                                                                <v-text-field label = "Tip" prefix="$"
                                                                                              v-model.number="sales[index].additional_sales"
                                                                                              :disabled = "sales[index].toBeDeleted || sales[index].sales == null"
                                                                                              max="6"
                                                                                              @focus="clearAdditionalSaleInput(index)"
                                                                                              @blur="verifyAdditionalSaleInput(index)"
                                                                                              @keypress="filtering">

                                                                                </v-text-field>
                                                                            </v-flex>
                                                                            <v-flex lg4>
                                                                                <v-checkbox :label="`Delete`" v-model="sales[index].toBeDeleted"
                                                                                            v-if="sales[index].existing_sale_id">

                                                                                </v-checkbox>
                                                                            </v-flex>
                                                                        </v-layout>
                                                                    </v-card-text>
                                                                </v-card>
                                                            </v-flex>
                                                        </template>
                                                    </v-layout>
                                                </v-card-text>
                                                <v-card-actions>
                                                    <v-btn color="success" @click="openDialog" :disabled="invalidSubmission">Submit</v-btn>
                                                </v-card-actions>
                                            </v-card>
                                            <v-card v-else flat height="440px">
                                                <v-card-text>
                                                    <h2 class="text-lg-center">Loading technicians...</h2>
                                                </v-card-text>
                                            </v-card>
                                        </v-flex>

									</v-layout>
								</v-card-text>
							</v-card>
						</v-flex>
					</v-layout>
				</v-container>
				<v-dialog v-model="dialog" width="1000">
					<v-card>
						<v-card-title class = "blue darken-1">
							<p class = "headline white--text">Confirming Sale for {{this.formattedDate}} </p>
						</v-card-title>
						<v-card-title class = "subheading purple white--text">
							<v-layout>
								<v-flex lg3>
									Gross Sale: $&nbsp{{ this.technicianSale}}
								</v-flex>
								<v-flex lg3>
									Gross Tip: $&nbsp{{ this.technicianCardTip}}
								</v-flex>
							</v-layout>
						</v-card-title>
						<v-card-text>
							<v-layout row wrap>
								<template v-for="(technician,index) in technicians">
									<v-flex lg3>
										<v-card flat class="bordered">
											<v-card-title>
												<h4>{{technician.fullName}}</h4>
											</v-card-title>
											<v-card-text>
												<v-layout wrap>
													<v-flex lg6><p>Sale: $&nbsp{{sales[index].sales}}</p></v-flex>
													<v-flex lg6><p>Tip: $&nbsp{{sales[index].additional_sales}}</p></v-flex>
													<v-flex lg6>
														<v-chip label class = "blue white--text"
																v-if="sales[index].toBeUpdated ">
															Update
														</v-chip>
														<v-chip label class = "green white--text"
																v-if="sales[index].toBeInserted">
															Add
														</v-chip>
														<v-chip label class = "red white--text"
																v-if="sales[index].toBeDeleted">
															Delete
														</v-chip>

                                                        <v-chip label class = "grey white--text"
                                                                v-if="!sales[index].toBeUpdated &&
                                                                !sales[index].toBeInserted &&
                                                                !sales[index].toBeDeleted">
                                                            No Change
                                                        </v-chip>
													</v-flex>
												</v-layout>
											</v-card-text>
										</v-card>
									</v-flex>
								</template>
							</v-layout>

							<v-spacer></v-spacer>

						</v-card-text>
						<v-card-actions>
							<v-btn @click.native="addSale" class="success" :disabled="newSales.length === 0">Submit</v-btn>
							<v-btn @click.native="closeDialog">Close</v-btn>
						</v-card-actions>

					</v-card>
				</v-dialog>
			</v-content>
	</v-app>
	</div>
</template>
<script>

	import PrimaryNavBar from './PrimaryNavBar';
	import Calendar from './Calendar';
	import RedeemCertificate from './RedeemCertificate';
	import SalonSaleMetric from './SalonSaleMetric';
    export default {

        components: {PrimaryNavBar, Calendar, RedeemCertificate, SalonSaleMetric},
        props: [],

        data: function () {
            return {

                picker: null,
                chosenDate: null,
                dateMenu: false,
                refreshSalonSaleMetric: false,

                current: {
                    grossSale: 0,
                    grossTipByCreditCard: 0,
                },

                technicians: [],
                sale: null,
                sales: [],
                newSales: [],
                savedSales: null,
                savedAdditionalSales: null,
                isAdded: false,
                active: null,
                dialog: false,
                loadingData: false,

            }
        },

		computed:{
            formattedDate(){
                return this.$moment(this.date).format('dddd MM/DD/YYYY');
            },
            /*Compute the total gross sale after each time a technician's sale is enter*/
            technicianSale(){
                let grossSale = this.current.grossSale;
                let sale = 0;
                for(let i = 0; i < this.sales.length; i++){
                    if(!this.sales[i].sales){ //if a technician's sale is blank or null, set the sale to zero
                        sale = 0;
                    }
                    else{
                        sale = parseFloat(this.sales[i].sales); //convert a sale from a string to a decimal
                    }
                    grossSale += sale;
                }
                return grossSale;
			},

			technicianCardTip(){
                let grossTipByCreditCard = this.current.grossTipByCreditCard;
                let tip = 0;
                for(let i = 0; i < this.sales.length; i++){
                    if(!this.sales[i].additional_sales){
                        tip = 0;
                    }
                    else{
                        tip = parseFloat(this.sales[i].additional_sales);
                    }
                    grossTipByCreditCard += tip;
                }


                return grossTipByCreditCard;
			},

            invalidSubmission(){
                return this.technicianSale === 0;
            }
		},
	    mounted(){

            this.getAllTechnicians();

	    },

		watch:{
	        chosenDate(){

	            this.getAllTechnicians();
	            this.newSales = [];
	        }
		},
        methods: {

	        handleDate(selectedDate) {

	            this.chosenDate = selectedDate;

	        },

			handleCertificateRedemption(){
                this.refreshSalonSaleMetric = true; //refresh the salon sale metric after a certificate redeem value is entered
			},
			handleSalonSaleMetric(){
				this.refreshSalonSaleMetric = false; //the salon sale metric had been refreshed, set this variable to false
			},


			getAllTechnicians(){
	            this.loadingData = true;
                this.$axios.get('/api/technician-sale/get?saleDate=' + this.chosenDate).then(response =>{

                    this.technicians = response.data.technicians;
                    this.sales = [];

                    for(let i = 0; i < this.technicians.length; i++){

                        if(this.technicians[i].dailySales.length > 0){
                            this.sale = {technician_id:this.technicians[i].technicianID,
                                sales:this.technicians[i].dailySales[0].sales,
                                additional_sales:this.technicians[i].dailySales[0].additional_sales,sale_date: this.chosenDate,
                                existing_sale_id: this.technicians[i].dailySales[0].id, toBeDeleted:false,
                                toBeInserted: false, toBeUpdated: false};
                        }
                        else{
                            this.sale = {technician_id:this.technicians[i].technicianID, sales:null,
                                additional_sales:null,sale_date: this.chosenDate, existing_sale_id:null,
                                toBeDeleted:false, toBeInserted: false, toBeUpdated: false};
                        }

                        this.sales.push(this.sale); //create a sales array composes of all the technician info & sale data

                    }
                    this.sale = null;
                    this.loadingData = false;
                });
			},
            //submit all the sales
	        addSale(){
				this.$axios.post('/api/technician-sale/handle-quick-sale',{sales:this.newSales}).then(response =>{
				    if(response.data.success){
				        this.dialog = false;
				        this.isAdded = true;
				        this.newSales = [];
				        this.refreshSalonSaleMetric = true; //refresh the salon sale metric
				        this.reset();
				    }

				});
	        },

	        openDialog(){
	            //if a technician has no sale or tip, set the sale and/or tip to zero
                for(let i = 0; i < this.sales.length; i++){
                    if(this.sales[i].sales == null){
                        this.sales[i].sales = 0;
                    }
                    if(this.sales[i].additional_sales == null){
                        this.sales[i].additional_sales = 0;
                    }
                }
                //only push a sale to the newSales[] if it has the inserted, updated, or deleted status
                for(let i = 0; i < this.sales.length; i++){
                    if(this.sales[i].toBeInserted === true
                        || this.sales[i].toBeDeleted === true
                        || this.sales[i].toBeUpdated === true){
                        this.newSales.push(this.sales[i]);
                    }
                }
                this.dialog = true; //open the confirmation dialog

	        },

	        closeDialog(){
	            this.newSales = [];
	            this.dialog = false;
	        },

			reset(){

	            this.getAllTechnicians();

			},
            //this method is fired when a sale text field is being focused
	        clearSaleInput(currentIndex){
			    this.active = true;
                let lastIndex = currentIndex;
                if(lastIndex !== currentIndex){ //this performs when the user click on another technician
                    this.sales[lastIndex].sales = this.savedSales; //set the previous technician sale the saved sale
                }
                else{ //this performs when the user click on a technician sale and stay there
                    if(this.sales[currentIndex].sales >= 0){ //if a current sale is >=0
                        this.savedSales = this.sales[currentIndex].sales; //save the sale
                        this.sales[currentIndex].sales =''; //clear the sale
                    }
                    //there is no need to perform the above actions if the sale is null
                }
	        },
            clearAdditionalSaleInput(currentIndex){

                this.active = true;
                let lastIndex = currentIndex;
                if(lastIndex !== currentIndex){
                    this.sales[lastIndex].additional_sales = this.savedAdditionalSales;
                }
                else{
                    if(this.sales[currentIndex].additional_sales >= 0){
                        this.savedAdditionalSales = this.sales[currentIndex].additional_sales;
                        this.sales[currentIndex].additional_sales ='';
                    }
                }
            },
            //this method is fired when a sale text field is out of focus or blur
	        verifySaleInput(index){

	            if(this.sales[index].sales === 0){ //when the user is enter a zero
                    this.sales[index].sales = this.savedSales; //populate the sale text field with the saved sale
                }
                else if(this.sales[index].sales !== this.savedSales && this.sales[index].existing_sale_id !== null){
	                this.sales[index].toBeUpdated = true; //if the current sale is !== to the saved sale and there is an existing sale id, update the sale
                }
                else if(this.sales[index].existing_sale_id === null && this.sales[index].sales > 0){
                    this.sales[index].toBeInserted = true; // if there is an existing sale id and the current sale value is > 0 then insert the sale
                }

	        },
            verifyAdditionalSaleInput(index){

                if(this.sales[index].additional_sales === '' || this.sales[index].addtional_sales === 0){
                    this.sales[index].additional_sales = this.savedAdditionalSales;
                }
                else if(this.sales[index].additional_sales !== this.savedAdditionalSales && this.sales[index].existing_sale_id !== null){
                    this.sales[index].toBeUpdated = true;
                }
                
            },

	        hover(index){
	            this.active = index;
	        },
	        select(index){
	            return this.active === index;

	        },

	        filtering(event){
                let charCode = (typeof event.which == "number") ? event.which : event.keyCode;
                if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46 && charCode !== 127) {
                    event.preventDefault();
                }
                else {
                    return true;

                }
	        },

        }
    }
</script>

<style scoped>

	.active_technician_card{
		background-color: #E1F5FE;
	}
	.bordered{
		border: 3px dashed #E1F5FE;
	}
    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s;
    }
    .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
        opacity: 0;
    }
</style>