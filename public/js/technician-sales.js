/**
 * Created by Thai Nguyen on 5/8/2017.
 */
var app = (function(){
    var $changeSaleLnk, $saleDateInput, $changeConfirmation, $changeSaleModal,
        $modalSaleTxt, $modalAdditionalSaleTxt, $submitChangeForm, $newSaleForm, $submitAddForm, $newSaleAlert;

    var init = function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        cachedVariables();
        bindEvents();
        var date = moment();
        var aMonthAgo = date.clone().subtract(1,'month');
        $saleDateInput.val(date.format('MM/DD/YYYY'));
        var pickerOption = {
            format: 'mm/dd/yyyy',
            startDate: aMonthAgo.format('MM/DD/YYYY'),
            endDate: date.format('MM/DD/YYYY'),
            todayBtn: true,
            todayHighlight: true,
            autoclose:true
        }
        $saleDateInput.datepicker(pickerOption);

    }
    var cachedVariables = function(){
        $saleDateInput = $('#sale-date');
        $changeSaleLnk = $('.change-sale-link');
        $changeSaleModal = $('#change-sale-modal');
        $newSaleForm = $('#sale-entry-form');
        $submitAddForm = $newSaleForm.find('.btn-submit');
        $newSaleAlert = $newSaleForm.next('#alert-new-sale');
        $changeConfirmation = $changeSaleModal.find('.change-confirmation');
        $modalSaleTxt = $changeSaleModal.find('.current-sale span');
        $modalAdditionalSaleTxt = $changeSaleModal.find('.current-additional-sale span');
        $submitChangeForm = $changeSaleModal.find('.btn-submit');

    }
    var bindEvents = function(){
        $saleDateInput.on('change', function(){
            searchSale($('#sale-entry-form').find('#technicianID').val(), $saleDateInput.val())
        });


        $changeSaleModal.on('show.bs.modal', function(event){
            var link = $(event.relatedTarget);
            var modal = $(this);
            modal.find('#sale-id').val(link.data('sale-id'));
            $modalSaleTxt.text(link.data('sales'));
            $modalAdditionalSaleTxt.text(link.data('additional-sales'));
        });

        $changeSaleModal.on('hide.bs.modal', function(){
            $modalSaleTxt.removeClass();
            $modalAdditionalSaleTxt.removeClass();
            $changeConfirmation.text('');
        });

        $submitChangeForm.on('click', function(event){
            event.preventDefault();
            $.ajax({
                method:'PUT',
                url:'/api/technician-sale/change',
                data:$('#change-sale-form').serializeArray(),
                dataType:'json'
            }).done(function(response){
                if(response.success){
                    $modalSaleTxt.text(response.sale).addClass('text-success');
                    $modalAdditionalSaleTxt.text(response.additionalSale).addClass('text-success');
                    $changeConfirmation.text(response.message)
                    document.getElementById('change-sale-form').reset();
                }
            }).fail(function(jqXHR){
                var errors = $.parseJSON(jqXHR.responseText);
                var list = '';
                $.each(errors.message,function(index, value){
                    list += '<li>' + value + '</li>';
                });
                $changeConfirmation.html('<ul>' + list + '</ul>');
                document.getElementById('change-sale-form').reset();
            });
        });
    }

    var searchSale = function(technicianID, saleDate){
        var date = moment(new Date(saleDate)).format('YYYY-MM-DD');
        $.ajax({
            method:'get',
            url:'/api/technician-sale/search',
            data:{technicianID: technicianID, saleDate: date },
            dataType:'json',
            contentType: 'application/json; charset=UTF-8'
        }).done(function(response){
            console.log(response);
            if(response.success){
                var sale = response.message
                if(sale.length === 0){
                    $submitAddForm.prop('disabled',false);
                    $newSaleAlert.text('').removeClass('alert-new-sale');
                }
                else{
                    $submitAddForm.prop('disabled',true);
                    $newSaleAlert.text('Sale is already entered').addClass('alert-new-sale');
                }
            }
        }).fail(function(jqXHR){
            console.log(jqXHR);
        });
    }

    return{
        init:init
    }
})();

$(document).ready(app.init())
