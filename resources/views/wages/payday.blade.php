@extends('layouts.main')
@push('styles')
    <link rel = "stylesheet" href = "/css/payday.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
@endpush
@if(Session::has('success-pay'))
    @component('partials.alert-success')
        <p>{{ Session::get('success-pay') }}</p>
    @endcomponent
@endif
@section('content')
    @component('partials.header')
        <h1>Pay Day</h1>
        <p>Pay technicians at the end of each pay period</p>
    @endcomponent
    <div class = "main-content">
        <div class = "container-fluid">
            <div class = "row pay-period-row">
                <div class = "col-md-3">
                    <div class = "panel panel-primary">
                        <div class = "panel-heading">
                            <div class = "row">
                                <div class = "col-md-6">
                                    <h4>Pay Period</h4><p>{{ $payPeriod }}</p>
                                </div>
                                <div class = "col-md-6">
                                    <h4>Pay Date</h4><p>{{ $payDate }}<p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class = "row sale-container-row">
                @foreach($technicians as $technician)
                    @include('partials.wage-container')
                @endforeach
            </div>

        </div>
    </div>

@endsection