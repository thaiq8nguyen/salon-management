/**
 * Created by Thai Nguyen on 5/8/2017.
 */


var app = (function(){
    var init = function(){
        var $saleDate = $('#sale-date');
        var date = moment();
        $saleDate.val(date.format('MM/DD/YYYY'));
        $saleDate.datepicker({
            format:'mm/dd/yyyy',
            setDate: date,
            todayBtn: true,
            todayHighlight: true,
            autoclose:true
        });

    }
    return{
        init:init
    }
})();

$(document).ready(app.init())
