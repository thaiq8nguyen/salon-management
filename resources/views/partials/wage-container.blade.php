<div class = "panel panel-default wage-container">
    <div class = "panel-heading">
        <h3 class = "panel-title">{{ $datum->first_name . ' ' . $datum->last_name }}</h3>
    </div>
    <div class = "panel-body">
        <table class = "table table-bordered table-condensed">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Sale</th>
                    <th>Tip</th>
                </tr>
            </thead>
            <tbody>
                @foreach($datum->sales as $sale)
                    <tr>
                        <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$sale->sale_date)->format('l, m/d/Y') }}</td>
                        <td>$ {{ $sale->sales }}</td>
                        <td>$ {{ $sale->additional_sales }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <table class = "table table-bordered table-condensed">
                <tr>
                    <th>Sub Total:</th>
                    <td>$ </td>
                    <td>$ </td>
                </tr>
                <tr>
                    <th>Earned</th>
                    <td>$ </td>
                    <td>$ </td>
                </tr>
                <tr>
                    <th>Prev. Balance</th>
                    <td>$ </td>
                    <td>$ </td>
                </tr>
                <tr>
                    <th>Total:</th>
                    <td>$ </td>
                    <td>$ </td>
                </tr>
        </table>
        <form class = "form form-inline">
            <div class = "form-group">
                <label for = "check-payment-input">Pay:</label>
                <input type = "number" class = "form-control" name = "check-payment-input">
            </div>
            <div class = "form-group">
                <label for = "additional-pay-input">Additional Pay:</label>
                <input type = "number" class = "form-control" name = "addition-pay-input">
            </div>
            <button type = "button" class = "btn btn-primary">Pay</button>
        </form>
    </div>
</div>