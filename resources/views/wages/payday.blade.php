@extends('layouts.main')
@section('pageTitle', $pageTitle)
@push('styles')
    <link rel = "stylesheet" href = "{{ asset('/css/payday.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
@endpush
@section('content')
    @component('partials.header')
        <h1>Pay Day</h1>
        <p>Pay technicians at the end of each pay period</p>
    @endcomponent
    <div class = "main-content">
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
            <div class = "row">
                @if(Session::has('success-pay'))
                    <div class = "top-alert">
                        @component('alert.alert-success')
                            @slot('message')
                                <strong>Complete</strong> {{ Session::get('success-pay') }}
                            @endslot
                        @endcomponent
                    </div>
                @endif
            </div>
            <div class = "row sale-container-row">
                @foreach($technicians as $technician)
                    @include('partials.wage-container')
                @endforeach
            </div>

        </div>
    </div>

@endsection