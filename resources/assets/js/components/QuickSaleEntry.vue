<template>
	<div>
		<v-app>
		<v-container fluid class = "blue lighten-4">
			<div label id = "sale-sticker" class ="sticker">
				<p class = "subheading">Gross Sale</p>
				<p class = "body-2">$ {{technicianSale}}</p>
			</div>
			<div label id = "tip-sticker" class ="sticker">
				<p class = "subheading">Gross Tip</p>
				<p class = "body-2">$ {{technicianCardTip}}</p>
			</div>
			<v-layout row wrap>
				<v-flex lg12 xs12>
					<v-alert success v-model="isAdded" transition="fade" class = "text-lg-center" dismissible>
						<p class = "headline ">Technician Sale has been updated</p>
					</v-alert>
				</v-flex>
				<v-flex lg12 xs12>
					<v-card>
						<v-card-text>
							<v-layout row wrap>
								<v-flex lg6 xs12>
									<v-layout row wrap>
										<v-flex lg11>
											<v-layout row>
												<v-flex lg3>
													<v-btn primary @click.native="previousDate(date)">
														<v-icon class = "white--text">keyboard_arrow_left</v-icon>Previous</v-btn>
												</v-flex>
												<v-flex lg6>
													<v-menu
															lazy
															:close-on-content-click="true"
															v-model="dateMenu"
															transition="scale-transition"
															offset-y
															full-width
															:nudge-left="40"
															max-width="290px"
													>
														<v-text-field
																slot="activator"
																label="Select a sale date"
																v-model="date"
																prepend-icon="event"
																readonly
														></v-text-field>
														<v-date-picker v-model="date" no-title scrollable actions ></v-date-picker>
													</v-menu>
												</v-flex>
												<v-flex lg3>
													<v-btn primary @click.native="nextDate(date)">Next<v-icon
															class = "white--text">keyboard_arrow_right</v-icon></v-btn>
												</v-flex>
											</v-layout>
										</v-flex>
										<v-flex lg11 mt-2><!--Square Data-->
											<template v-if="isSquareData">
												<salon-sale-table :saleData="squareData"></salon-sale-table>
											</template>
											<template v-else>
												<v-card>
													<v-card-text class = "text-lg-center">
														<v-icon large class = "red--text">info</v-icon>
														<p class = "subheading">There is no data recorded for this date</p>
													</v-card-text>
												</v-card>
											</template>
										</v-flex>
										<v-flex lg6 mt-2>
											<v-btn class = "ma-3" primary @click.native.stop="openDialog" block >Verify</v-btn>
										</v-flex>

									</v-layout>
								</v-flex>
								<v-flex lg6>
									<v-layout row wrap>
										<template v-for="(technician,index) in technicians">
											<v-flex lg4 md4 mt-1>
												<v-card @mouseover = "hover(index)" @mouseleave = "hover(null)"
												        :class="[{'grey lighten-4':select(index)},
											                     {'green--text text-darken-1':sales[index].sales !== 0},
											                     {'red--text text-darken-1}': sales[index].toBeDeleted}]">
													<v-card-title class = "subheading">
														<strong>{{technician.technicianID}}. {{ technician.fullName }}</strong>
													</v-card-title>
													<v-card-text>
														<v-layout row>
															<v-flex lg6>
																<v-text-field label = "Sale" prefix="$"
																              v-model.number="sales[index].sales"
																              :disabled = "sales[index].toBeDeleted"
																              @focus="clearInput(index,'sale')"
																              @blur="checkInput(index,'sale')" hint="SALE"
																              @keypress="filtering">

																</v-text-field>
															</v-flex>
															<v-flex lg6>
																<p v-if="technician.dailySales.length > 0" class = "blue--text body-2">
																	$ {{ technician.dailySales[0].sales }}
																</p>
															</v-flex>
														</v-layout>
														<v-layout row wrap>
															<v-flex lg6>
																<v-text-field label = "Tip" prefix="$"
																              v-model.number="sales[index].additional_sales"
																              :disabled = "sales[index].toBeDeleted"
																              max="6"
																              @focus="clearInput(index,'tip')"
																              @blur="checkInput(index,'tip')" hint="TIP"
																              @keypress="filtering">

																</v-text-field>
															</v-flex>
															<v-flex lg6>
																<p v-if="technician.dailySales.length > 0" class = "blue--text body-2">
																	$ {{ technician.dailySales[0].sales }}
																</p>

															</v-flex>
															<v-flex lg6>
																<v-checkbox :label="`Delete`" v-model="sales[index].toBeDeleted"
																            v-if="sales[index].existing_sale_id && sales[index].sales == 0">

																</v-checkbox>
															</v-flex>
														</v-layout>
													</v-card-text>
												</v-card>
											</v-flex>
										</template>
									</v-layout>
							</v-flex>
						</v-layout>
						</v-card-text>
					</v-card>
				</v-flex>
			</v-layout>
		</v-container>
		<v-dialog v-model="dialog" width="600">
			<v-card>
				<v-card-title class = "text-lg-center blue darken-1">
					<p class = "headline white--text">Confirm Sale for {{ formattedDate }} </p>
				</v-card-title>
				<v-card-text>
					<v-layout row>
						<v-flex lg6></v-flex>
						<v-flex lg2>
							<p class = "title">Sale</p>
						</v-flex>
						<v-flex lg2>
							<p class = "title">Tip</p>
						</v-flex>
						<v-flex lg2></v-flex>
					</v-layout>
					<template v-for="(technician,index) in technicians">
						<v-card flat>
							<v-card-text>
								<v-layout>
									<v-flex lg6>
										<p class = "title">{{ technician.fullName }}</p>
									</v-flex>
									<v-flex lg2 ml-1>
										<p class = "title">$ {{ sales[index].sales }}</p>
									</v-flex>
									<v-flex lg2 ml-1>
										<p class = "title">$ {{ sales[index].additional_sales }}</p>
									</v-flex>
									<v-flex lg2>
										<v-chip label class = "subheading blue white--text"
										        v-if="sales[index].existing_sale_id !== null && sales[index].sales > 0">
											Update
										</v-chip>
										<v-chip label class = "subheading green white--text"
										        v-if="sales[index].existing_sale_id == null && sales[index].sales > 0">
											Add
										</v-chip>
										<v-chip label class = "subheading red white--text"
										        v-if="sales[index].toBeDeleted">
											Delete
										</v-chip>
									</v-flex>
								</v-layout>
							</v-card-text>
						</v-card>
					</template>

					<v-spacer></v-spacer>
					<v-btn @click.native="addSale" primary v-show="newSales.length > 0"><v-icon class = "white--text">add</v-icon>Add</v-btn>
					<v-btn @click.native="closeDialog">Close</v-btn>
				</v-card-text>
			</v-card>
		</v-dialog>
	</v-app>
	</div>
</template>
<script>

	import SalonSaleTable from './SalonSaleTable.vue';
    export default {
        components: {SalonSaleTable},
        props: [],

        data() {
            return {
                date: this.$moment().format('YYYY-MM-DD'),
	            dateMenu:false,
	            squareData:[],
	            isSquareData: false,

				technician:{
                    grossSale:null,
					cardTip:null,
				},

	            technicians:[],
	            sale:null,
	            sales:[],
	            newSales:[],
	            isAdded: false,
	            active: null,
	            dialog: false,
	            loadingData:false,

            }
        },

		computed:{
            formattedDate(){
                return this.$moment(this.date).format('dddd MM/DD/YYYY');
            },
            technicianSale(){
                let grossSale = this.technician.grossSale;
                for(let i = 0; i < this.sales.length; i++){
                    grossSale += parseFloat(this.sales[i].sales);
                }
                if(isNaN(grossSale)){
                    grossSale = 0;
                }

                return grossSale;
			},
			technicianCardTip(){
                let cardTip = this.technician.cardTip;
                for(let i = 0; i < this.sales.length; i++){
                    cardTip += parseFloat(this.sales[i].additional_sales);
                }
                if(isNaN(cardTip)){
                    cardTip = 0;
                }

                return cardTip;
			},


		},
	    mounted(){
            this.handleDate();
            this.getSquareData();
            this.getAllTechnicians();

	    },

		watch:{
	        date(){
	            this.getSquareData();
	            this.getAllTechnicians();
	            sessionStorage.setItem('saleDate',this.date);
	            this.newSales = [];
	        }
		},
        methods: {
	        handleDate(){
				let saleDate = sessionStorage.getItem('saleDate');
				if(saleDate === null){
				    sessionStorage.setItem('saleDate', this.date);
				}else{
				    this.date = saleDate;
				}
	        },
	        getSquareData(){
	            this.loadingData = true;

                this.$axios.get('/api/salon/daily-sale?date=' + this.date).then(response=>{
                    this.loadingData = false;
                    this.isSquareData = response.data.success;
                    console.log(response.data);
                    if(this.isSquareData){
                        this.squareData = response.data;
                        this.technician.grossSale = parseFloat(response.data.sales['Technician Sales']);
                        this.technician.cardTip = parseFloat(response.data.tips['Technician Tips']);

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
				this.$axios.post('/api/technician-sale/handle-quick-sale',{sales:this.newSales}).then(response =>{
				    if(response.data.success){
				        this.dialog = false;
				        this.isAdded = true;
				        this.newSales = [];
				        this.reset();
				    }

				});
	        },

	        openDialog(){
                for(let i = 0; i < this.sales.length; i++){
                    if(this.sales[i].sales !== 0 || this.sales[i].toBeDeleted === true){
                        this.newSales.push(this.sales[i]);
                    }
                }
                this.dialog = true;

	        },

	        closeDialog(){
	            this.newSales = [];
	            this.dialog = false;
	        },

			reset(){
	            this.getSquareData();
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

	        },
	        previousDate(date){
	            this.date = this.$moment(date).subtract(1,'days').format('YYYY-MM-DD');
	        },
	        nextDate(date){
                this.date = this.$moment(date).add(1,'days').format('YYYY-MM-DD');
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

<style>
	.sticker{
		position:fixed;
		height:75px;
		width: 95px;
		background-color: #2e7d32;
		top:23%;
		right:0;
		z-index:10000;
		border-radius: 3px;
		padding: 2px;
		color:white;
		opacity:0.8;
		text-align:center;
	}
	#sale-sticker{

		background-color: #2e7d32;
		top:23%;


	}
	#tip-sticker{
		background-color: orange;
		top:40%;

	}
</style>