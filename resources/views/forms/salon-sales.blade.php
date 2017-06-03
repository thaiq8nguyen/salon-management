<!--NOTES-->
<!--This form makes use of Vue library and component-->

<form class = "form salon-sales-form" @submit.prevent="addSales">
    @component('forms.datepicker')@endcomponent
    <div class = "form-group">
        <label for = "gross-sale" class = "form-label">Gross Sales:</label>
        <div class = "input-group">
            <div class = "input-group-addon"><i class = "fa fa-dollar"></i></div>
            <input type = "text" class = "form-control" name = "gross-sales" v-model="grossSales" v-on:keydown="errors.clear('grossSales')">
        </div>
        <p class = "text-danger" v-show="errors.has('grossSales')"  v-text="errors.get('grossSales')" ></p>
    </div>
    <div class = "form-group">
        <label for = "gift-card-sold" class = "form-label">Gift Card Sold:</label>
        <div class = "input-group">
            <div class = "input-group-addon"><i class = "fa fa-dollar"></i></div>
            <input type = "text" class = "form-control" name = "gift-card-solds" v-model="giftCardSolds">
        </div>
    </div>
    <div class = "form-group">
        <label for = "gift-card-redeemed" class = "form-label">Gift Card Redeemed:</label>
        <div class = "input-group">
            <div class = "input-group-addon"><i class = "fa fa-dollar"></i></div>
            <input type = "text" class = "form-control" name = "gift-card-redeemeds" v-model="giftCardRedeemeds">
        </div>
    </div>
    <div class = "form-group">
        <label for = "convenience-fee" class = "form-label">Convenience Fees:</label>
        <div class = "input-group">
            <div class = "input-group-addon"><i class = "fa fa-dollar"></i></div>
            <input type = "text" class = "form-control" name = "convenience-fee" v-model="convenienceFees">
        </div>
    </div>
    <div class = "form-group">
        <label for = "tip" class = "form-label">Tips:</label>
        <div class = "input-group">
            <div class = "input-group-addon"><i class = "fa fa-dollar"></i></div>
            <input type = "text" class = "form-control" name = "tips" v-model="tips">
        </div>
    </div>
    <div class = "form-group">
        <button type = "submit" class = "btn btn-primary" v-bind:disabled="errors.any()">Submit</button>
    </div>
    <div class = "form-group">
        <entry-alert v-bind:message= "alertMessage" :class="[alertClass]"
                     v-on:close="showEntryAlert = false" v-show="showEntryAlert"></entry-alert>
    </div>
</form>

