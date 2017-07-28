<template>
	<div>
		<v-app>
			<v-container fluid>
				<v-layout row wrap>
					<v-flex lg4><!--Calendar-->
						<v-date-picker v-model="saleDate"></v-date-picker>
					</v-flex>
					<v-flex lg4>
						<v-card>
							<v-card-text>
								<v-list>
									<template v-for="technician in allTechnicians">
										<v-list-tile v-on:click.native="getTechnicianDetails(technician.firstName)">
											<v-list-tile-avatar>
												<i class = "fa fa-user-circle fa-lg"></i>
											</v-list-tile-avatar>
											<v-list-tile-content>
												<v-list-tile-title v-html="technician.fullName"></v-list-tile-title>
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
						<v-card>
							<v-card-title>
								<p class = "headline">Add Sale</p>
							</v-card-title>
							<template v-if="onTechnician.firstName">
								<template v-if="doesSaleExist()">
									<v-card-text>
										<v-alert info value="true" transition="scale-transition">{{ onTechnician.firstName + '\'s sale is already recorded'}}</v-alert>
									</v-card-text>
								</template>
								<template v-else>
									<v-card-text>
										<v-text-field label="Sale" name = "sale" v-model="newSale.sale"></v-text-field>
										<v-text-field label="Tip" name = "tip" v-model="newSale.tip"></v-text-field>
									</v-card-text>
									<v-card-actions>
										<v-btn primary @click.native="addSale">Save</v-btn>
									</v-card-actions>
								</template>
							</template>
							<template v-else>
								<v-card-text>
									<v-alert info value="true" transition="scale-transition">Select a technician to add sale</v-alert>
								</v-card-text>
							</template>
						</v-card>
						<v-card v-if="onTechnician.firstName">
							<v-card-title primary-title>
								<p class = "headline">Sale Records</p>
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
											                               @click.prevent.stop="showEditSaleDialog(props.item.id,props.item.sales,props.item.additional_sales)">Change</a></td>
										</template>
									</v-data-table>
								</div>
							</v-card-text>
						</v-card>
					</v-flex>
				</v-layout>
			</v-container>

		<v-dialog v-model="editSaleDialogConfig.show">

			<v-card>
				<v-card-title><div class = "headline">Edit Sale</div></v-card-title>

				<v-card-text>
					<form>
						<v-text-field label = "SaleID" name = "sale-id" v-model="editSaleDialogConfig.saleID" disabled></v-text-field>
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
    export default{

        props:['periodId'],

        data(){
            return{
				allTechnicians:'',

				saleDate: this.$moment().format('YYYY-MM-DD'),

                newSale:{
				    technicianID: null,
                    saleDate: null,
	                sale: null,
	                tip: null,

                },
				onTechnician:{
				    firstName:'',
					sales:''
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

                editSaleDialogConfig:{
                    show:false,
	                saleID:null,
	                sale:null,
	                tip:null
                },
	            alert:{
                    show:false,
		            message:null,
		            hasError:false
	            }
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
			}
	    },
        methods:{
            getAllTechnicians(){
                this.$axios.get('/api/technician-sale/all?saleDate=' + this.saleDate).then(response =>{
                    this.allTechnicians = response.data.technicians;
                });
            },

	        getTechnicianDetails(firstName){
                this.$axios.get('/api/technician-sale/pay-period/'+ this.onPeriodID +'/technician/' + firstName).then(response => {
                    this.newSale.technicianID = response.data.id;
                    this.newSale.saleDate = this.saleDate;
                    this.onTechnician.firstName = response.data.first_name;
                    this.onTechnician.sales = response.data.daily_sales;
					this.$emit('name', response.data.first_name + ' ' + response.data.last_name);

                });
	        },
            readableDate(date){

                return this.$moment(date).format('MM/DD/YY dd');

            },
	        addSale(){

				this.$axios.post('/api/technician-sale/add',this.newSale
				).then(response => {
				    if(response.data.success){
				        this.alert.show = true;
				        this.alert.hasError = false;
				        this.alert.message = response.data.message;
				        this.resetAddSale();
				        //this.getTechnicianDetails(this.onTechnician.firstName);
				    }
				}).catch(error => {
				    if(error.response){
                        this.alert.show = true;
                        this.alert.hasError = true;
                        this.alert.message = error.response.data.message;
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
				    console.log(error.response);
					if(error.response){
                        this.alert.show = true;
                        this.alert.hasError = true;
                        this.alert.message = error.response.data.message;
					}
				});
	        },
	        resetAddSale(){

	            this.newSale.sale = '';
	            this.newSale.tip = '';
                this.allTechnicians = '';
                this.getAllTechnicians();
                this.onTechnician.firstName = '';

	        },
	        doesSaleExist(){
				let saleExists = false;
	            for(let i = 0; i < this.onTechnician.sales.length; i++){
	                if(this.saleDate === this.onTechnician.sales[i].sale_date ){
	                    saleExists = true;
	                }
	            }
	            return saleExists;
	        }
        }
    }
</script>

<style>

</style>