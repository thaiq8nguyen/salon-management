<table class = "table">
    <tr>
        <th></th>
        <th>Square</th>
        <th>Manual</th>
        <th class  = "text-danger">Difference</th>
    </tr>
    <tr>
        <th>Gross Sales</th>
        <td v-text="sqGrossSales"></td>
        <td v-text="grossSales"></td>
    </tr>
    <tr>
        <th>Tips on Card</th>
        <td v-text="sqTipsOnCard">placeholder</td>
        <td v-text="TipsOnCard"></td>
    </tr>
    <tr>
        <th>Gift Card Sold</th>
        <td v-text="giftCardSolds">placeholder</td>
    </tr>
    <tr>
        <th>Gift Card Redeemed</th>
        <td></td>
    </tr>
    <tr>
        <th>Convenience Fee</th>
        <td v-text="sqConvenienceFees"></td>
    </tr>
    <tr>
        <th>Processing Fee</th>
        <td v-text="sqProcessingFees"></td>
    </tr>

</table>
