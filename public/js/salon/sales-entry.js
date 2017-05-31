var app = new Vue({
    el: '.main-content',

    data:{

        grossSale: '',
        giftCardSold:'',
        giftCardRedeemed:'',
        convenienceFee:'',
        tip:'',
        confirmation:''
    },

    methods: {
        addSales: function(event){
            event.preventDefault();
            var self = this;
            axios.post('/api/salon-sale/store',{
                grossSale:self.grossSale, giftCardSold:self.giftCardSold, convenienceFee:self.convenienceFee,
                tip:self.tip
            }).then(function(response){
                console.log(response.data);
                self.confirmation = response.data;

            }).catch(function(error){
                console.log(error);
            });

        }
    }
});
