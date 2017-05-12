/**
 * Created by Thai Nguyen on 5/8/2017.
 */
var app = (function(){
    var $changeSaleLnk, $saleDateInput, $changeConfirmation, $changeSaleModal,
        $modalSaleTxt, $modalAdditionalSaleTxt, $submitChangeForm;
    var init = function(){
        cachedVariables();
        bindEvents();
        var date = moment();
        $saleDateInput.val(date.format('MM/DD/YYYY'));
        $saleDateInput.datepicker({
            format:'mm/dd/yyyy',
            todayBtn: true,
            todayHighlight: true,
        });

    }
    var cachedVariables = function(){
        $saleDateInput = $('#sale-date');
        $changeSaleLnk = $('.change-sale-link');
        $changeSaleModal = $('#change-sale-modal');
        $changeConfirmation = $changeSaleModal.find('.change-confirmation');
        $modalSaleTxt = $changeSaleModal.find('.current-sale span');
        $modalAdditionalSaleTxt = $changeSaleModal.find('.current-additional-sale span');
        $submitChangeForm = $changeSaleModal.find('.btn-submit');


    }
    var bindEvents = function(){
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
    return{
        init:init
    }
})();

$(document).ready(app.init())
