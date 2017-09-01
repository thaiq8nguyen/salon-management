<template>
	<div>
		<v-app>
			<v-container fluid>
				<v-layout row wrap>
					<v-flex lg5><!--Calendar-->
						<v-layout row wrap>
							<v-flex lg12>
								<v-card>
									<v-card-text>
										<v-date-picker class="elevation-0" v-model="saleDate" landscape></v-date-picker>
									</v-card-text>
								</v-card>
							</v-flex>
							<v-flex lg12 mt-2>
								<daily-sale-card :date="saleDate" :refresh="saleAdded"></daily-sale-card>
							</v-flex>
						</v-layout>
					</v-flex>
					<v-flex lg3>
						<v-card>
							<v-card-text>
								<v-list>
									<template v-for="technician in allTechnicians">
										<v-list-tile :class="{orange: selectedTechnician == technician.firstName}"
										             @click.native="getTechnicianDetails(technician.firstName)">
											<v-list-tile-avatar>
												<i class = "fa fa-user-circle fa-lg"></i>
											</v-list-tile-avatar>
											<v-list-tile-content>
												<v-list-tile-title :class="{'white--text':selectedTechnician == technician.firstName}"
												                   v-html="technician.fullName"></v-list-tile-title>
											</v-list-tile-content>
											<v-icon v-if="technician.countSales.length == 1" class = "teal--text">done</v-icon>
										</v-list-tile>
										<v-divider></v-divider>
									</template>
								</v-list>
							</v-card-text>
						</v-card>
					</v-flex>
					<v-flex lg4>
						<v-layout row wrap>
							<v-flex lg12>
								<v-card>
									<v-card-title  primary-title class = "blue lighten-1">
										<p class = "headline white--text">Add Sale</p>
									</v-card-title>
									<template v-if="onTechnician.fullName">
										<template v-if="doesSaleExist()">
											<v-card-text>
												<v-alert info value="true" transition="scale-transition">
													{{ onTechnician.fullName + ' \'s sale is already recorded for ' + readableDate(saleDate)}}</v-alert>
											</v-card-text>
										</template>
										<template v-else>
											<v-card-text>
												<form @keyup.enter="addSale">
													<v-text-field label="Sale" name = "sale" v-model="newSale.sale" prefix="$" autofocus></v-text-field>
													<v-text-field label="Tip" name = "tip"
													              v-model="newSale.tip" prefix="$"></v-text-field>
												</form>

											</v-card-text>
											<v-card-actions>
												<v-btn primary @click.native="addSale">Save</v-btn>
											</v-card-actions>
											<v-spacer></v-spacer>
											<template v-if="addSaleAlert.hasError">
												<v-card-text>
													<v-alert :class="addSaleAlert.status" :icon="addSaleAlert.icon"
													         v-model="addSaleAlert.show">{{addSaleAlert.message}}</v-alert>
												</v-card-text>
											</template>
										</template>
									</template>
									<template v-else>
										<v-card-text>
											<v-alert :class="addSaleAlert.status" :icon="addSaleAlert.icon"
											         v-model="addSaleAlert.show">{{addSaleAlert.message}}</v-alert>
										</v-card-text>
									</template>
								</v-card>
							</v-flex>
							<v-flex lg-12 mt-2>
								<v-card v-if="onTechnician.fullName">
									<v-card-title primary-title class = "blue lighten-1">
										<p class = "headline white--text">Sale Records</p>
									</v-card-title>
									<v-card-text>
										<div v-if="onTechnician.sales.length == 0">
											<p class = "text-lg-center">There are no recorded sales</p>
										</div>
										<div v-else>
											<v-data-table :headers="technicianSale.headers"
											              :items="onTechnician.sales" hide-actions>
												<template slot = "items" scope="props">
													<td class = "text-xs-right">{{ readableDate(props.item.sale_date) }}</td>
													<td class = "text-xs-right">$ {{ props.item.sales }}</td>
													<td class = "text-xs-right">$ {{ props.item.additional_sales }}</td>
													<td class = "text-xs-right"><a href="#"
					                               @click.prevent.stop="
					                               showEditSaleDialog(props.item.id,props.item.sales,props.item.additional_sales)">
														Change</a></td>
												</template>
											</v-data-table>
										</div>
									</v-card-text>
								</v-card>
							</v-flex>
						</v-layout>
					</v-flex>
				</v-layout>
			</v-container>
		<v-dialog v-model="editSaleDialogConfig.show">
			<v-card>
				<v-card-title><div class = "headline">Edit Sale</div></v-card-title>

				<v-card-text>
					<form>
						<v-text-field label = "SaleID" name = "sale-id" v-model="editSaleDialogConfig.saleID"
						              disabled></v-text-field>
						<v-text-field label = "Sale:"  name = "sale" v-model="editSaleDialogConfig.sale"></v-text-field>
						<v-text-field label = "Tip:"  name = "additonal-sale" v-model="editSaleDialogConfig.tip"></v-text-field>
					</form>
				</v-card-text>
				<v-card-actions>
					<v-btn primary @click.native="editSale">Save</v-btn>
					<v-btn light @click.native="editSaleDialogConfig.show = false">Exit</v-btn>
				</v-card-actions>
				<v-spacer></v-spacer>
				<v-card-text v-if="!alert.hasError">
					<v-alert success v-model="alert.show" transition="scale-transition">{{ alert.message }}</v-alert>
				</v-card-text>
				<v-card-text v-else>
					<v-alert error v-model="alert.show" transition="scale-transition">{{ alert.message }}</v-alert>
				</v-card-text>
			</v-card>
		</v-dialog>
	</v-app>
	</div>
</template>

<script>

    import DailySaleCard from './DailySaleCard.vue';
    import Alert from '../partials/Alert.vue';

    export default{

        props:['periodId'],

        components:{
            'daily-sale-card':DailySaleCard,

        },

        data(){
            return{
				allTechnicians:null,

				saleDate: this.$moment().format('YYYY-MM-DD'),

                newSale:{
				    technicianID: null,
                    saleDate: null,
	                sale: null,
	                tip: null,

                },
				onTechnician:{
				    fullName:null,
					sales:null
				},
                technicianSale:{
                    headers:[
		                    {text: 'Sale Date', value:'sale_date', sortable:false},
		                    {text: 'Sale', value: 'sales', sortable:false},
		                    {text: 'Tip', value: 'additional_sales', sortable:false},
	                        {text: 'Change', value:'', sortable:false}
                    ],
	                items:[]

                },

	            selectedTechnician:null,

                editSaleDialogConfig:{
                    show:false,
	                saleID:null,
	                sale:null,
	                tip:null
                },

	            addSaleAlert:{
                    icon:null,
		            status:null,
		            message:null,
                    show:false,
		            hasError:false
	            },
	            alert:{
                    show:false,
		            message:null,
		            hasError:false
	            },

	            saleAdded:false,

            }
        },

		mounted(){
            this.getAllTechnicians();


		},
		watch:{
		    saleDate:function(){
		        this.resetAddSale();
		    }
		},
	    computed:{
			onPeriodID(){
			    if(this.periodId !== null){
			        return this.periodId;
			    }
			},

	    },
        methods:{
            getAllTechnicians(){
                this.$axios.get('/api/technician-sale/all?saleDate=' + this.saleDate).then(response =>{
                    this.allTechnicians = response.data.technicians;
                    if(this.saleAdded === false){
                        this.setSaleAlert('info','info','Select a technician to begin adding', true,false);
                    }

                });
            },

	        getTechnicianDetails(firstName){
                this.selectedTechnician = firstName;
                this.$axios.get('/api/technician-sale/pay-period/'+ this.onPeriodID +'/technician/'
	                + firstName).then(response => {
                    this.newSale.technicianID = response.data.id;
                    this.newSale.saleDate = this.saleDate;
                    this.newSale.tip = 0;
                    this.onTechnician.fullName = response.data.full_name;
                    this.onTechnician.sales = response.data.daily_sales;
                    this.saleAdded = false;
					this.$emit('name', this.onTechnician.fullName);


                });
	        },
            readableDate(date){
                return this.$moment(date).format('MM/DD/YY dd');
            },
	        addSale(){
				this.$axios.post('/api/technician-sale/add',this.newSale
				).then(response => {

				    if(response.data.success){
                        this.setSaleAlert('check','success',response.data.message,true);
                        this.saleAdded = true;
				        this.resetAddSale();

				    }else{
                        this.setSaleAlert('error','error',response.data.message,true,false);
				    }
				}).catch(error => {
				    if(error.response){
                        this.setSaleAlert('error','error',error.response.data.message,true,true);

				    }
				});
	        },

			showEditSaleDialog(saleID,sale,tip){

                this.editSaleDialogConfig.show = true;
				this.editSaleDialogConfig.saleID = saleID;
				this.editSaleDialogConfig.sale = sale;
				this.editSaleDialogConfig.tip = tip;
				this.alert.show = false; //hide any alert from the previous edit

			},
	        editSale(){
				this.$axios.put('/api/technician-sale/edit',{
				    saleID:this.editSaleDialogConfig.saleID,
					sale:this.editSaleDialogConfig.sale,
					tip:this.editSaleDialogConfig.tip
				}).then(response => {
				    if(response.data.success){
				        this.alert.show = true;
				        this.alert.message = response.data.message;
				    }
				}).catch(error => {
					if(error.response){
                        this.alert.show = true;
                        this.alert.hasError = true;
                        this.alert.message = error.response.data.message;
					}
				});
	        },
	        resetAddSale(){

	            this.newSale.sale = null;
	            this.newSale.tip = null;
                this.allTechnicians = '';
                this.getAllTechnicians();
                this.onTechnician.fullName = null;
		        this.selectedTechnician = null;
		        this.$emit('name',null);

	        },
			setSaleAlert(icon,status,message,show,hasError){
	            this.addSaleAlert.icon = icon;
	            this.addSaleAlert.status = status;
	            this.addSaleAlert.message = message;
	            this.addSaleAlert.show = show;
	            this.addSaleAlert.hasError = hasError;

			},

	        doesSaleExist(){
				let saleExists = false;
	            for(let i = 0; i < this.onTechnician.sales.length; i++){
	                if(this.saleDate === this.onTechnician.sales[i].sale_date ){
	                    saleExists = true;
	                }
	            }
	            return saleExists;
	        },
        }
    }
</script>

<style>

</style>