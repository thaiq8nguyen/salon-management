/**
 * Created by Thai Nguyen on 5/17/2017.
 */
var app = (function(){
    var $paymentForm, $addButton, $removeButton, maxPayment;

    maxPayment = 3;

    var init = function(){

        cached();
        bindEvents();
    }
    var cached = function(){
        $paymentForm = $('.payment-form');
        //additionalPayment = $('#additional-payment').html();
        $addButton = $paymentForm.find('.add-button');

    }
    var bindEvents = function(){
        var paymentCount = 1;
        $addButton.click(function(){
            if(paymentCount < maxPayment){
                paymentCount++;
                var template = $('#additional-payment-template').html();
                var additionalPayment = $(template);
                additionalPayment.find('.payment-amount').attr('name','payments['+paymentCount+'][amount]');
                additionalPayment.find('.payment-reference').attr('name','payments['+paymentCount+'][reference]');
                additionalPayment.find('.payment-method').attr('name','payments['+paymentCount+'][method]');

                $(additionalPayment).insertBefore('.btn-pay');
            }
        });
        $paymentForm.on('click','.remove-button',function(event){
            event.preventDefault();
            $(this).parents('.form-group').remove();
            paymentCount--;
        })
    }


    return{
        init:init
    }
})();

$(document).ready(app.init());