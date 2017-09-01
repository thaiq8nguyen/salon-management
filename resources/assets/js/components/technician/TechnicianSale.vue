<template>
	<div id = "technician-sale-container">
		<v-app id = "technician-sale-app">
			<v-toolbar class = "white">
				<v-btn icon :href="home">
					<v-icon>home</v-icon>
				</v-btn>
				<v-btn icon :href="sale">
					<v-icon>attach_money</v-icon>
				</v-btn>
				<v-spacer></v-spacer>
				<v-btn icon :href="logout">
					<v-icon>exit_to_app</v-icon>
				</v-btn>
			</v-toolbar>
			<v-container fluid>
				<v-layout>
					<v-flex xs12>
						<v-select :items="payPeriods" label="Select Working Period" single-line dark auto
						          v-model="selectPayPeriodId" item-text="periods" item-value="id">
						</v-select>
					</v-flex>
				</v-layout>
				<v-layout row>
					<v-flex xs12>
						<div  id = "content-container">
							<sale :daily-sales="dailySales" v-show="show.dailySales" class ="white"></sale>
							<wage :total-sales="wage" v-show="show.wage"></wage>
							<payment :payments="payments" v-show="show.payment"></payment>
							<balance :pay-period-id="selectPayPeriodId" :first-name="firstName" v-show="show.payment"></balance>
						</div>
					</v-flex>
				</v-layout>
			</v-container>
			<v-bottom-nav value="true" class="white">
				<v-btn flat light class="blue--text" @click.native="toggleScreen('sale')" :value="screen === 'sale'">
					<span>Sales</span>
					<v-icon>fa-credit-card</v-icon>
				</v-btn>
				<v-btn flat light class="blue--text" @click.natives="toggleScreen('wage')" :value="screen === 'wage'">
					<span>Wages</span>
					<v-icon>fa-clock-o</v-icon>
				</v-btn>
				<v-btn flat light class="blue--text" @click.native="toggleScreen('pay')" :value="screen === 'pay'">
					<span>Pays</span>
					<v-icon>fa-bank</v-icon>
				</v-btn>
			</v-bottom-nav>
		</v-app>
	</div>
</template>

<script>
	import TechnicianDailySaleTable from '../common/TechnicianDailySaleTable.vue';
	import TechnicianTotalSaleTable from '../common/TechnicianTotalSaleTable.vue';
	import TechnicianPaymentTable from '../common/TechnicianPaymentTable.vue';
	import TechnicianBalance from '../common/TechnicianBalance.vue';
    export default {
        props: [],

	    components:{
            'sale':TechnicianDailySaleTable,
		    'wage':TechnicianTotalSaleTable,
		    'payment': TechnicianPaymentTable,
		    'balance': TechnicianBalance,

	    },

        data() {
            return {
                home:'/technician',
                logout:'/logout',
                sale: '/technician/sale',
	            payPeriods:[],
	            currentPayPeriod:null,
	            selectPayPeriodId:null,
	            selectPayPeriod: null,
	            dailySales:[],
	            wage:[],
	            payments:[],
	            firstName: sessionStorage.getItem('firstName'),
	            screen:'sale',
	            show:{
                    dailySales:true,
		            wage:false,
		            payment:false,
	            }

            }


        },
	    mounted(){
          this.getPayPeriod();

	    },
		watch:{
	        selectPayPeriodId(){
                sessionStorage.setItem('lastSelectedPeriodIdPayDay', this.selectPayPeriodId);
                this.getSaleByPeriod();
                this.getWageByPeriod();
                this.getPaymentByPeriod();
	        }
		},
        methods: {
            getPayPeriod() {
                this.$axios.get('/api/pay-period/list').then(response => {

                    this.payPeriods = response.data;
                    this.currentPayPeriod = response.data[response.data.length - 1];
                    this.selectPayPeriod = this.currentPayPeriod.periods;
                    this.selectPayPeriodId = parseInt(sessionStorage.getItem('lastSelectedPeriodIdPayDay'));

                    if (isNaN(this.selectPayPeriodId)) {
                        this.selectPayPeriodId = this.currentPayPeriod.id;
                        sessionStorage.setItem('lastSelectedPeriodIdPayDay', this.selectPayPeriodId);
                    }
                    this.getSaleByPeriod();
                    this.getWageByPeriod();
                    this.getPaymentByPeriod();
                });
            },

            getSaleByPeriod() {
                this.$axios.get('/api/technician-sale/pay-period/' + this.selectPayPeriodId + '/technician/'
                    + this.firstName).then(response => {
                    this.dailySales = response.data.daily_sales;

                });
            },
            getWageByPeriod() {
                this.$axios.get('/api/technician-wage/pay-period/' + this.selectPayPeriodId + '/technician/'
                    + this.firstName).then(response => {
                    this.wage = response.data;

                });
            },

	        getPaymentByPeriod(){
                this.$axios.get('/api/technician-payment/pay-period/' + this.selectPayPeriodId + '/technician/'
	                + this.firstName).then(response => {
	                    this.payments = response.data;
                });
	        },


            toggleScreen(screen) {

				if(screen === 'sale'){
				    this.screen = 'sale';
				    this.show.dailySales = true;
				    this.show.wage = false;
				    this.show.payment = false;

				}
				else if(screen === 'wage'){
                    this.screen = 'wage';
                    this.show.dailySales = false;
                    this.show.wage = true;
                    this.show.payment = false;
				}
				else if(screen === 'pay'){
                    this.screen = 'pay';
                    this.show.dailySales = false;
                    this.show.wage = false;
                    this.show.payment = true;
				}


            }
        }


    }
</script>

<style>
	#technician-sale-app{
		background-color: #2196F3;
	}

	/*IPHONE 5/5S*/
	@media only screen
	and (min-device-width: 320px)
	and (max-device-width: 568px)
	and (-webkit-min-device-pixel-ratio: 2) {
		th, td{
			padding:1px !important;

		}

		#content-container{
			height: 330px;
			overflow-y: scroll;
		}
	}

	/*IPHONE 6/6S*/
	@media only screen
    and (min-device-width: 375px)
    and (max-device-width: 667px)
    and (-webkit-min-device-pixel-ratio: 2) {
		th, td{

			padding:1px !important;

		}
		#content-container{
			height: 429px; /*429*/
			overflow-y: scroll;
		}
	}

	/*IPHONE 6+*/
	@media only screen
	and (min-device-width: 414px)
	and (max-device-width: 736px)
	and (-webkit-min-device-pixel-ratio: 3) {
		th, td{

			padding:1px !important;

		}
		#content-container{
			height: 498px;
			overflow-y: scroll;
		}
	}
	/*IPAD*/
	@media only screen
	and (min-device-width: 768px)
	and (max-device-width: 1024px)
	and (-webkit-min-device-pixel-ratio: 2) {
		#content-container{
			height: 786px;
			overflow-y: scroll;
		}
	}
	/*IPAD PRO*/
	@media only screen
	and (min-device-width: 1024px)
	and (max-device-width: 1366px)
	and (-webkit-min-device-pixel-ratio: 2) {
		#content-container{
			height: 1128px;
			overflow-y: scroll;
		}
	}


</style>