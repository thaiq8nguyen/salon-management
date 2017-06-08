<table class = "table table-bordered">
    <tr>
        <th></th>
        <th>Square</th>
        <th>Manual</th>
        <th class  = "text-danger" v-show="isDiscrepancy">Difference</th>
    </tr>
    <tr>
        <th>Gross Sales</th>
        <td :sqGrossSales="sqGrossSales">$ @{{ sqGrossSales }}</td>
        <td :grossSales="grossSales">$ @{{ grossSales }}</td>
        <td v-show="isDiscrepancy" :grossSalesDelta="grossSalesDelta">@{{ grossSalesDelta }}</td>
    </tr>
    <tr>
        <th>Tips on Card</th>
        <td :sqTipsOnCard="sqTipsOnCard">$ @{{ sqTipsOnCard }}</td>
        <td :tipsOnCard="tipsOnCard">$ @{{ tipsOnCard }}</td>
        <td v-show="isDiscrepancy" :tipsOnCardDelta="tipsOnCardDelta">@{{ tipsOnCardDelta }}</td>
    </tr>
    <tr>
        <th>Gift Certificate Sold</th>
        <td :giftCertificateSolds="giftCertificateSolds">$ @{{ giftCertificateSolds }}</td>
    </tr>
    <tr>
        <th>Gift Certificate Redeemed</th>
        <td :giftCertificateRedeemeds="giftCertificateRedeemeds">$ @{{ giftCertificateRedeemeds }}</td>
    </tr>
    <tr>
        <th>Convenience Fee</th>
        <td :sqConvenienceFees="sqConvenienceFees">$ @{{ sqConvenienceFees }}</td>
    </tr>
    <tr>
        <th>Processing Fee</th>
        <td :sqProcessingFees="sqProcessingFees">$ @{{ sqProcessingFees }}</td>
    </tr>

</table>
