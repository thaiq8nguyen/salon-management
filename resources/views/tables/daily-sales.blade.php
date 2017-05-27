<table class = "table table-bordered table-condensed daily-sales-table">
    <tr>
        <th>Date</th>
        <th>Sales</th>
        <th>Tips</th>
    </tr>
    @foreach($technician->dailySales as $dailySale)
        <tr>
            <td>{{ $dailySale->sale_date_mdyd }}</td>
            <td>{{ $dailySale->sales_amount }}</td>
            <td>{{ $dailySale->additional_sales_amount }}</td>
        </tr>
    @endforeach
</table>