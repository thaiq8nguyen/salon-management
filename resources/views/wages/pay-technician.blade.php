@extends('layouts.main')
@push('styles')
    <link rel = "stylesheet" href = "{{ asset('/css/pay-technician.css') }}">
@endpush
@push('scripts')
    <script src = "{{ asset('/js/pay-technician.js') }}"></script>
@endpush
@section('content')
    <section class = "tech-name">
        <div class = "container-fluid">
            <h1>{{ $technician->full_name }}</h1>
            <hr>
        </div>
    </section>
    <section class = "sales-container">
        <div class = "container-fluid">
            <div class = "row">
                <div class = "col-md-3">
                    <div class = "panel panel-default">
                        <div class = "panel-heading"><h2 class = "panel-title">Sales</h2></div>
                        <div class = "panel-body">
                            <table class = "table table-condensed">
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Sales</th>
                                    <th>Tips</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($technician->dailySales as $dailySale)
                                        <tr>
                                            <td>{{ $dailySale->date }}</td>
                                            <td>{{ $dailySale->sales_amount }}</td>
                                            <td>{{ $dailySale->additional_sales_amount }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <table class = "table table-condensed">
                               <tr>
                                    <th>Sub Total:</th>
                                    <td>$ {{ $technician->totalSales[0]->subTotal}}</td>
                                    <td>$ {{ $technician->totalTips[0]->subTotalTip }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class = "col-md-3">
                    <div class = "panel panel-default">
                        <div class = "panel-heading"><h2 class = "panel-title">Wages</h2></div>
                        <div class  = "panel-body">
                            <table class = "table table-condensed">
                                <tr>
                                    <th>Earned Total: </th>
                                    <td>$ {{ $technician->totalSales[0]->earnedTotal}}</td>
                                </tr>
                                <tr>
                                    <th>Tip Reduction: </th>
                                    <td>$ {{ $technician->totalTips[0]->earnedTip }} </td>
                                </tr>
                                <tr>
                                    <th>Pay: </th>
                                    <td>$ {{ round($technician->totalSales[0]->earnedTotal-$technician->totalTips[0]->earnedTip) }} </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class = "col-md-5">
                    <div class = "well">
                        <h2>Make Payments</h2>
                        <hr>
                        <form class = "form form-horizontal payment-form" method = "post" action = "/wages/pay/{{ $technician->first_name }}">
                            {{ csrf_field() }}
                            <div class = "form-group">
                                <label for = "payment" class = "form-label col-md-2">Amount:</label>
                                <div class = "col-md-2">
                                    <div class = "input-group">
                                        <div class = "input-group-addon">$</div>
                                        <input type = "text" class = "form-control payment-amount" name = "payments[1][amount]">
                                    </div>
                                </div>
                                <label for = "payment-reference" class = "form-label col-md-1">Ref:</label>
                                <div class = "col-md-2">
                                    <input type = "text" class = "form-control payment-reference" name = "payments[1][reference]">
                                </div>
                                <label for = "payment-method" class = "form-label col-md-1">Method:</label>
                                <div class = "col-md-2">
                                    <select class = "form-control payment-method" name = "payments[1][method]">
                                        <option selected disabled>Select</option>
                                        <option value = "check">Check</option>
                                        <option value = "other">Other</option>
                                    </select>
                                </div>
                                <div class = "col-md-1">
                                    <a href = "#" class = "add-button">Add</a>
                                </div>
                            </div>
                            <div class = "form-group btn-pay ">
                                <div class = "col-md-2 col-md-offset-2">
                                    <button type = "submit" class = "btn btn-primary">Pay</button>
                                </div>
                            </div>
                            @if(Session::has('paymentsNumberError'))
                                <div class = "alert alert-danger">
                                    <strong>Errors</strong>
                                    <p>{{Session::get('paymentsNumberError')}}</p>
                                </div>
                            @endif
                            @if(count($errors) > 0)
                                @component('partials.alert-danger')
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                @endcomponent
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class = "pay-container">
    </div>
@endsection
<template id = "additional-payment-template">
    @include('partials.additional-payment')
</template>
