<div class = "col-md-3">
<div class = "panel panel-default wage-container">
    <div class = "panel-heading">
        <h3 class = "panel-title">{{ $datum->first_name . ' ' . $datum->last_name }}</h3>
    </div>
    <div class = "panel-body">
        <table class = "table table-bordered table-condensed">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Sales</th>
                    <th>Tips</th>
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
        <table class = "table table-bordered table-condensed sales-breakdown-table">
                <tr>
                    <th>Sub Total:</th>
                    <td>$ </td>
                    <td>$ </td>
                </tr>
                <tr>
                    <th>Earned:</th>
                    <td>$ </td>
                    <td>$ </td>
                </tr>
                <tr>
                    <th>Previous Balance:</th>
                    <td>$ </td>
                    <td>$ </td>
                </tr>
                <tr>
                    <th>Total:</th>
                    <td>$ </td>
                    <td>$ </td>
                </tr>
        </table>
        <form class = "form-horizontal">
            <div class = "form-group">
                <label for = "check-payment-input" class = "control-label col-xs-2">Pay:</label>
                <div class = "col-xs-4">
                    <div class = "input-group">
                        <div class = "input-group-addon">$</div>
                        <input type = "number" class = "form-control " name = "check-payment-input">
                    </div>

                </div>
                <label for = "check-ref-input" class = "control-label col-xs-2">Ref:</label>
                <div class = "col-xs-3">
                    <input type = "text" class = "form-control " name = "check-ref-input">
                </div>
            </div>
            <div class = "form-group">
                <label for = "additional-pay-input" class = "control-label col-xs-2">Xtra Pay:</label>
                <div class = "col-xs-4">
                    <div class = "input-group">
                        <div class = "input-group-addon">$</div>
                        <input type = "number" class = "form-control" name = "addition-pay-input">
                    </div>

                </div>
                <label for = "xtra-ref-input" class = "control-label col-xs-2">X Ref:</label>
                <div class = "col-xs-3">
                    <input type = "text" class = "form-control " name = "xtra-ref-input">
                </div>
            </div>
            <div class = "form-group">
                <div class = "col-xs-10 col-xs-offset-2">
                    <button type = "button" class = "btn btn-primary">Pay</button>
                </div>
            </div>

        </form>
    </div>
</div>
</div>