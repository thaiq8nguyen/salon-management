@extends('layouts.main')
@section('pageTitle',$pageTitle)
@push('styles')
    <link rel = "stylesheet" href = "{{ asset('/css/technician-sales.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
@endpush
@section('content')
    @component('partials.header')
        <h1>Technician Sales</h1>
        <p>Enter and edit technician sales</p>
    @endcomponent
    <div class = "main-content">
        <div class = "container-fluid">
            <section class = "row pay-period-container">
                <div class = "col-md-3">
                    <div class = "col-md-3">
                        <i class = "fa fa-calendar fa-3x"></i>
                    </div>
                    <div class = "col-md-6">
                        <h4>Pay Period</h4><p>{{ $payPeriodDates }}</p>
                    </div>
                    <div class = "col-md-3">
                        <h4>Pay Date</h4><p>{{ $payDate }}<p>
                    </div>
                </div>
            </section>
            <div class = "panels-container">
                <section class = "row">
                    <div class = "col-md-3">
                        @component('panels.success')
                            @slot('title')
                                <div class = "row">
                                    <div class = "col-md-4">
                                        <i class = "fa fa-pencil fa-5x"></i>
                                    </div>
                                    <div class = "col-md-6">
                                        <h1>Sales Entry</h1>
                                    </div>
                                </div>
                            @endslot
                            @slot('body')
                                <a href = "/technician-sale/date/{{\Carbon\Carbon::now()->toDateString()}}/technician/{{ $technician->first_name }}">View</a>
                            @endslot
                        @endcomponent
                    </div>
                    <div class = "col-md-3">
                        @component('panels.default')
                            @slot('title')
                                <div class = "row">
                                    <div class = "col-md-4">
                                        <i class = "fa fa-dollar fa-5x"></i>
                                    </div>
                                    <div class = "col-md-6">
                                        <h1>Pay</h1>
                                    </div>
                                </div>
                            @endslot
                            @slot('body')
                                <a href = "{{ route('payday') }}">View</a>
                            @endslot
                        @endcomponent
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection