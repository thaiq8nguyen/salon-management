<div class = "salon-sales-form-container">
    <form class = "form salon-sales-form">
        <div class = "form-group">
            <label for = "gross-sale" class = "form-label">Gross Sales:</label>
            <div class = "input-group">
                <div class = "input-group-addon"><i class = "fa fa-dollar"></i></div>
                <input type = "text" class = "form-control" name = "gross-sale" v-model="grossSale">
            </div>
        </div>
        <div class = "form-group">
            <label for = "gift-card-sold" class = "form-label">Gift Card Sold:</label>
            <div class = "input-group">
                <div class = "input-group-addon"><i class = "fa fa-dollar"></i></div>
                <input type = "text" class = "form-control" name = "gift-card-sold" v-model="giftCardSold">
            </div>
        </div>
        <div class = "form-group">
            <label for = "gift-card-redeemed" class = "form-label">Gift Card Redeemed:</label>
            <div class = "input-group">
                <div class = "input-group-addon"><i class = "fa fa-dollar"></i></div>
                <input type = "text" class = "form-control" name = "gift-card-redeemed" v-model="giftCardRedeemed">
            </div>
        </div>
        <div class = "form-group">
            <label for = "convenience-fee" class = "form-label">Convenience Fees:</label>
            <div class = "input-group">
                <div class = "input-group-addon"><i class = "fa fa-dollar"></i></div>
                <input type = "text" class = "form-control" name = "convenience-fee" v-model="convenienceFee">
            </div>
        </div>
        <div class = "form-group">
            <label for = "tip" class = "form-label">Tips:</label>
            <div class = "input-group">
                <div class = "input-group-addon"><i class = "fa fa-dollar"></i></div>
                <input type = "text" class = "form-control" name = "tip" v-model="tip">
            </div>
        </div>
        <div class = "form-group">
            <button @click="addSales" type = "button" class = "btn btn-primary">Submit</button>
        </div>
    </form>
</div>