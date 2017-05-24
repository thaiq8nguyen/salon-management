<table class = "table">
    <thead>
    <tr>
        <th>Sale Date</th>
        <th>Sale</th>
        <th>Tip</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    @foreach($tech->dailySales as $dailySale)
        <tr>
            <td>{{ $dailySale->sale_date_mdyd }}</td>
            <td>{{ $dailySale->sales_amount }}</td>
            <td>{{ $dailySale->additional_sales_amount }}</td>
            <td><a href = ""
                   data-toggle="modal"
                   data-target = "#change-sale-modal"
                   data-sale-id = " {{ $dailySale->id }}"
                   data-sales = "{{ $dailySale->sales_amount }}"
                   data-additional-sales = "{{ $dailySale->additional_sales_amount }}"
                   class = "change-sale-link"><i class = "fa fa-edit fa-lg"></i>Change</a></td>
        </tr>
    @endforeach
    </tbody>
</table>