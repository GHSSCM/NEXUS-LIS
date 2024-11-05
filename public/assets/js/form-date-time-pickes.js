$(function() {
	"use strict";

    $('.datepicker').pickadate({
        selectMonths: true,
        selectYears: true
    }),
    $('.timepicker').pickatime()


   
        $('.date-time-picker').bootstrapMaterialDatePicker({
            format: 'YYYY-MM-DD HH:mm'
        });
        $('.date-picker').bootstrapMaterialDatePicker({
            time: false
        });
        $('.time-picker').bootstrapMaterialDatePicker({
            date: false,
            format: 'HH:mm'
        });
   


});