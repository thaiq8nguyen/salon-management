@extends('layouts.main')
@section('pageTitle','Pay '.$technician->full_name)
@push('styles')
    <link rel = "stylesheet" href = "{{ asset('/css/pay-technician.css') }}">
@endpush
@push('scripts')
    <script src = "{{ asset('/js/pay-technician.js') }}"></script>
@endpush
@section('content')
    @component('header.technician')
        @slot('fullName')
            {{ $technician->full_name }}
        @endslot
    @endcomponent
    <section class = "main-content">
        <div class = "container-fluid">
            <div class = "row pay-period-container">
                <div class = "col-md-3">
                    <div class = "col-md-3">
                        <i class = "fa fa-calendar fa-3x"></i>
                    </div>
                    <div class = "col-md-6">
                        <h4>Pay Period</h4><p>{{ $payPeriod }}</p>
                    </div>
                    <div class = "col-md-3">
                        <h4>Pay Date</h4><p>{{ $payDate }}</p>
                    </div>
                </div>
            </div>
            <div class = "row pay-container top-buffer">
                <div class = "col-md-3">
                    @component('panels.charcoal')
                        @slot('title')
                            Daily Sales
                        @endslot()
                            @slot('body')
                                @component('tables.daily-sales',['technician' => $technician])
                                @endcomponent
                                @component('tables.sales-subtotal')
                                    @slot('subTotal')
                                        {{ $technician->totalSalesAndTips[0]->subTotal }}
                                    @endslot
                                    @slot('subTotalTip')
                                        {{ $technician->totalSalesAndTips[0]->subTotalTip }}
                                    @endSlot
                                @endcomponent
                            @endslot
                    @endcomponent
                </div>
                <div class = "col-md-3">
                    @component('panels.charcoal')
                        @slot('title')
                            Earnings
                        @endslot
                        @slot('body')
                            @component('tables.earnings')
                                @slot('earnedTotal')
                                    {{ $technician->totalSalesAndTips[0]->earnedTotal }}
                                @endSlot
                                @slot('earnedTip')
                                    {{ $technician->totalSalesAndTips[0]->earnedTip }}
                                @endslot
                                @slot('pay')
                                    {{ $technician->totalSalesAndTips[0]->total }}
                                @endslot
                            @endcomponent
                        @endSlot
                    @endcomponent
                </div>
                <div class = "col-md-5">
                    @component('panels.green')
                        @slot('title')
                            Make Payments
                        @endslot
                        @slot('body')
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
                        @endslot()
                    @endcomponent

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
