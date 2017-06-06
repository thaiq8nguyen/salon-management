<div class = "form-group">
    <div class = "input-group">
        <div class = "input-group-addon"><i class = "fa fa-calendar"></i></div>
        <datepicker v-model="date" :format="dateFormat" :bootstrap-styling="bootstrapStyling"
        v-on:selected="getSales()"></datepicker>
    </div>
</div>
