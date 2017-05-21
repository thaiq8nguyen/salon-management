/**
 * Created by Thai Nguyen on 5/8/2017.
 */
var app = (function(){
    var $changeSaleLnk, $saleDateInput, $saleChangeConfirmation, $changeSaleModal,
        $modalSaleTxt, $modalAdditionalSaleTxt, $submitChangeForm, $newSaleForm, $submitAddForm, $newSaleAlert;

    var init = function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        cachedVariables();
        bindEvents();
        $.get('/api/pay-period/current',initCalendar,'json');

        var date = moment();
        $saleDateInput.val(date.format('MM/DD/YYYY'));

    }
    var initCalendar = function(response){
        var pickerOption = {
            format: 'mm/dd/yyyy',
            startDate: response.beginDate,
            endDate: response.endDate,
            todayBtn: true,
            todayHighlight: true,
            autoclose:true
        };
        $saleDateInput.datepicker(pickerOption);
    }
    var cachedVariables = function(){
        $saleDateInput = $('#sale-date');
        $changeSaleLnk = $('.change-sale-link');
        $changeSaleModal = $('#change-sale-modal');
        $newSaleForm = $('#sale-entry-form');
        $submitAddForm = $newSaleForm.find('.btn-submit');
        $newSaleAlert = $newSaleForm.next('#alert-new-sale');
        $saleChangeConfirmation = $changeSaleModal.find('#sale-change-confirmation');
        $modalSaleTxt = $changeSaleModal.find('.current-sale');
        $modalAdditionalSaleTxt = $changeSaleModal.find('.current-additional-sale');
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
            $saleChangeConfirmation.empty().removeClass();
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
                    $modalSaleTxt.text(response.sale).addClass('text-danger');
                    $modalAdditionalSaleTxt.text(response.additionalSale).addClass('text-danger');
                    $saleChangeConfirmation.html(
                        '<div class = "row">'+
                            '<div class = "col-md-2">' +
                                '<i class = "fa fa-info fa-2x"></i>' +
                            '</div>' +
                            '<div class = "col-md-10">'+
                                '<p>' + response.message + '</p>' +
                            '</div>' +
                            '</div>').addClass('alert alert-success');
                    document.getElementById('change-sale-form').reset();
                    location.reload();
                }
            }).fail(function(jqXHR){
                var errors = $.parseJSON(jqXHR.responseText);
                var list = '';
                $.each(errors.message,function(index, value){
                    list += '<li>' + value + '</li>';
                });
                $saleChangeConfirmation.html(
                    '<div class = "row">'+
                    '<div class = "col-md-2">' +
                    '<i class = "fa fa-exclamation fa-2x"></i>' +
                    '</div>' +
                    '<div class = "col-md-10">'+
                    '<ul>' + list + '</ul>' +
                    '</div>' +
                    '</div>').addClass('alert alert-danger');
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
