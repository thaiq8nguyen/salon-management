import Datepicker from 'vuejs-datepicker';
import moment from 'moment-es6';
import axios from 'axios';
import Vue from 'vue';

Vue.component('datepicker',Datepicker);

Vue.component('confirmation-alert',{

    props:['message'],
    template: '#confirmation-alert'
});
Vue.component('failure-alert',{
    prop:['message'],
    template: '#failure-alert'
});

let app = new Vue({
    el: '.main-content',

    data:{

        grossSales: '',
        giftCardSolds:'',
        giftCardRedeemeds:'',
        convenienceFees:'',
        tips:'',
        message:'',
        showEntryConfirmation:false,
        showFailureAlert:false,
        date: new Date(),
        dateFormat: 'MM/dd/yyyy'

    },

    methods: {
        addSales(event){
            event.preventDefault();
            let self = this;
            let saleDate = moment(new Date(self.date)).format('YYYY-MM-DD');
            axios.post('/api/salon-sale/store',{date: saleDate,
                grossSales:self.grossSales, giftCardSolds:self.giftCardSolds, giftCardRedeemeds: self.giftCardRedeemeds,
                convenienceFees:self.convenienceFees, tips:self.tips
            }).then(function(response){
                console.log(response);
                if(response.data.success){
                    self.showEntryConfirmation = true;
                    self.message = response.data.message;
                }else{
                    self.showFailureAlert = true;
                    self.message = response.data.message;
                }

            }).catch(function(error){
                console.log(error);
            });

        }
    }
});
