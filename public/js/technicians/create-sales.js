/**
 * Created by Thai Nguyen on 5/8/2017.
 */
var app = (function(){
    var $changeSaleLnk, $saleDateInput, $saleChangeConfirmation, $changeSaleModal,
        $modalSaleTxt, $modalAdditionalSaleTxt, $submitChangeForm, $newSaleForm, $submitAddForm, $newSaleAlert,
        $technicianList, saleDate, alertDangerTemplate, alertSuccessTemplate, options, $template;

    var init = function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        cachedVariables();
        bindEvents();
        var payPeriodRequest = $.ajax({
            method:'get',
            url:'/api/pay-period/current',
            data:{},
            dataType:'json'
        });
        payPeriodRequest.done(initCalendar);
        payPeriodRequest.fail(function(jqXHR){
            console.log(jqXHR.responseText);
        });
    }
    var initCalendar = function(response){
        var now = moment();
        var pickerOption = {
            format: 'mm/dd/yyyy',
            //startDate: response.beginDate, /*This needs to be corrected later*/
            endDate: now.format('MM/DD/YYYY'),
            todayBtn: true,
            todayHighlight: true,
            autoclose:true
        };
        $saleDateInput.datepicker(pickerOption);
    }
    var cachedVariables = function(){
        $saleDateInput = $('#sale-date-input');
        $technicianList = $('.technician-list-container');
        $changeSaleLnk = $('.change-sale-link');
        $changeSaleModal = $('#change-sale-modal');
        $newSaleForm = $('#sale-entry-form');
        $submitAddForm = $newSaleForm.find('.btn-submit');
        $newSaleAlert = $newSaleForm.next();
        $saleChangeConfirmation = $changeSaleModal.find('#sale-change-confirmation');
        $modalSaleTxt = $changeSaleModal.find('.current-sale');
        $modalAdditionalSaleTxt = $changeSaleModal.find('.current-additional-sale');
        $submitChangeForm = $changeSaleModal.find('.btn-submit');
        alertDangerTemplate = $.get('/template/alert-danger.html');
        alertSuccessTemplate = $.get('/template/alert-success.html');
    }
    var bindEvents = function(){
        $saleDateInput.on('change', function(){
            var date = new Date($(this).val());

            if(!moment(date).isValid()){
                displayTechnicianListError('Sale date does not have the correct format. Please try again');
            }
            else{
                saleDate = moment(date).format('YYYY-MM-DD');
                options = {method:'get', url:'/api/technician-sale/all', data: {saleDate: saleDate}, dataType:'json',
                    contentType: 'application/json; charset=UTF-8'};
                var technicians = $.ajax(options);
                technicians.done(displayTechnicianList);
                technicians.fail(function(jqXHR){
                    var errorList = '';
                    var errors = jqXHR.responseJSON;
                    $.each(errors.message,function(index, value){
                        errorList += '<li>' + value + '</li>';
                    });
                    displayTechnicianListError(errorList);
                });
            }
        })
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
            options = {method:'PUT', url:'/api/technician-sale/change', data:$('#change-sale-form').serializeArray(),
                dataType:'json'
            }
            $.ajax(options).done(function(response){
                console.log(response);
                if(response.success){
                    $modalSaleTxt.text(response.sale).addClass('text-danger');
                    $modalAdditionalSaleTxt.text(response.additionalSale).addClass('text-danger');
                    alertSuccessTemplate.done(function(template){
                        $template = $(template);
                        $template.find('.message').html(response.message);
                        displayAlert($template,$saleChangeConfirmation);
                    });
                }
            }).fail(function(jqXHR){
                var errors = $.parseJSON(jqXHR.responseText);
                var list = '';
                $.each(errors.message,function(index, value){
                    list += '<li>' + value + '</li>';
                });
                alertDangerTemplate.done(function(template){
                    $template = template;
                    $template.find('.message').html('<ul>'+ list + '</ul>');
                    displayAlert($template, $saleChangeConfirmation);
                })
            });
            document.getElementById('change-sale-form').reset();
        });
    }
    var displayTechnicianList = function(response){
        var list = '';
        $.each(response.technicians, function(index,technician){
            if(technician.sales_count == 0){
                list += '<a href = "/technician-sale/date/' + response.saleDate + '/technician/' + technician.first_name +
                    '" class = "list-group-item"><i class = "fa fa-user-circle fa-lg"></i> ' + technician.first_name + ' ' + technician.last_name + '</a>';
            }
            else{
                list += '<a href = "/technician-sale/date/' + response.saleDate + '/technician/' + technician.first_name +
                    '" class = "list-group-item list-group-item-success"><i class = "fa fa-user-circle fa-lg"></i> '
                    + technician.first_name + ' ' + technician.last_name + '<i class = "fa fa-dollar fa-lg pull-right"></i></a>';
            }
        });
        $technicianList.html(list);
    }
    var displayTechnicianListError = function(errors){
        alertDangerTemplate.done(function(template){
            $template = $(template);
            $template.find('.message').html(errors);
            //$technicianList.html($template);
            displayAlert($template,$technicianList);
        });
    }
    var displayAlert = function(alert,container){
        container.html(alert);
    }
    return{
        init:init
    }
})();

$(document).ready(app.init())
