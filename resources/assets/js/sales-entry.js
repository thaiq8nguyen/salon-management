import Datepicker from 'vuejs-datepicker';

class Errors{

    constructor(){
        this.errors = {};
    }
    has(field){
        return this.errors.hasOwnProperty(field);
    }

    any(){

        return Object.keys(this.errors).length > 0;
    }
    get(field){
        if(this.errors[field]){
            return this.errors[field][0];
        }
    }
    record(errors){
        this.errors = errors;
    }

    clear(field){
        delete this.errors[field];
    }
}

Vue.component('datepicker',Datepicker);

Vue.component('entry-alert',{

    props:['message'],
    template:'#entry-alert'

});


let app = new Vue({
    el: '.main-content',
    data:{
        grossSales: '',
        giftCardSolds:'',
        giftCardRedeemeds:'',
        convenienceFees:'',
        tips:'',
        bootstrapStyling:true,

        //alert property
        alertMessage: '',
        showEntryAlert:false,
        alertClass: '',

        date: new Date(),
        dateFormat: 'MM/dd/yyyy',
        errors: new Errors()

    },

    methods: {
        addSales(){

            let saleDate = moment(new Date(this.date)).format('YYYY-MM-DD');
            axios.post('/api/salon-sale/store',{date: saleDate,
                grossSales:this.grossSales, giftCardSolds:this.giftCardSolds, giftCardRedeemeds: this.giftCardRedeemeds,
                convenienceFees:this.convenienceFees, tips:this.tips
            }).then(this.onSuccess).catch(this.onError)

        },

        onSuccess(response){
            if(response.data.success) {

                this.alertMessage = response.data.message;
                this.alertClass = 'alert-success';
            }
            else{
                this.alertMessage =  response.data.message;
                this.alertClass = 'alert-info';

            }
            this.grossSales = '';
            this.giftCardSolds = '';
            this.giftCardRedeemeds = '';
            this.convenienceFees = '';
            this.tips = '';
            this.showEntryAlert = true;
        },
        onError(error){
            this.errors.record(error.response.data);
        }
    }


});

