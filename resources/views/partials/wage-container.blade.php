<div class = "col-md-3">
    <div class = "panel panel-default wage-container">
        <div class = "panel-heading clearfix">
            <h3 class = "panel-title">{{ $technician->full_name }}
                <span class = "pull-right">
                    <a href = "/wages/pay/{{$technician->first_name}}" class = "btn btn-primary">Pay</a>
                </span>
            </h3>
        </div>
        <div class = "panel-body">
            <table class = "table table-bordered table-condensed sales-listing-table">
                <tr>
                    <th>Date</th>
                    <th>Sales</th>
                    <th>Tips</th>
                </tr>
                @foreach($technician->dailySales as $dailySale)
                    <tr>
                        <td>{{ $dailySale->date }}</td>
                        <td>{{ $dailySale->sales_amount }}</td>
                        <td>{{ $dailySale->additional_sales_amount }}</td>
                    </tr>
                @endforeach
            </table>
            <hr>
            <table class = "table table-bordered table-condensed sales-breakdown-table">
                <tr>
                    <th>Sub Total:</th>
                    @foreach($technician->totalSales as $totalSale)
                        <td>$ {{ $totalSale->subTotal }}</td>
                    @endforeach
                    @foreach($technician->totalTips as $totalTip)
                        <td>$ {{ $totalTip->subTotalTip }}</td>
                    @endforeach
                </tr>
                <tr>
                    <th>Earned:</th>
                    @foreach($technician->totalSales as $totalSale)
                        <td>$ {{ $totalSale->earnedTotal }}</td>
                    @endforeach
                </tr>
                <tr>
                    <th>Tip Deduction:</th>
                    @foreach($technician->totalTips as $totalTip)
                        <td>$ {{ $totalSale->earnedTip }}</td>
                    @endforeach
                </tr>
                <tr>
                    <th>Total:</th>
                    {{--<td>$ {{$technician->totalSales - $technician->totalTips }}</td></td>--}}
                </tr>
            </table>
        </div>
    </div>
</div>