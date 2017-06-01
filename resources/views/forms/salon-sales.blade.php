<div class = "panel panel-default">
    <div class = "panel-heading">
        <form>
            <div class = "form-group">

                    {{--<div class = "input-group-addon"><i class = " fa fa-calendar"></i></div>
                    <input type = "text" id = "date" class = "form-control" v-model="date">--}}

                    <datepicker class = "form-control" v-model="date" :format="dateFormat"></datepicker>

            </div>
        </form>

    </div>
    <div class = "panel-body">
        <div class = "salon-sales-form-container">
            <form class = "form salon-sales-form">
                <div class = "form-group">
                    <label for = "gross-sale" class = "form-label">Gross Sales:</label>
                    <div class = "input-group">
                        <div class = "input-group-addon"><i class = "fa fa-dollar"></i></div>
                        <input type = "text" class = "form-control" name = "gross-sales" v-model="grossSales">
                    </div>
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
                    <button @click="addSales" type = "button" class = "btn btn-primary">Submit</button>
                </div>
                <div class = "form-group">
                    <confirmation-alert v-bind:message = "message" v-on:close="showEntryConfirmation = false" v-if="showEntryConfirmation"></confirmation-alert>
                    <failure-alert v-bin:message = "message" v-on:close="showEntryFailure = false" v-if="showFailureAlert"></failure-alert>
                </div>
            </form>
        </div>
    </div>
</div>
