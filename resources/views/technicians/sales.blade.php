@extends('layouts.main')
@section('pageTitle','Technician Sales')
@push('styles')
    <link rel = "stylesheet" href = "/css/technician-sales.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
@endpush
@section('content')
    @component('partials.header')
        <h1>Technician Sales</h1>
        <p>Enter and edit technician sales</p>
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
                        <a href = "{{ url('/wages/pay')}}" class = "btn btn-primary btn-nav-pay">Making Payments</a>
                    </div>
                    <div class = "col-md-3">
                        <h4>Pay Date</h4><p>{{ $payDate }}<p>
                    </div>
                </div>
            </div>
            <div class = "row technician-list-container">
                <div class = "col-md-6 col-md-offset-3">
                    <table class = "table table-bordered">
                        <tr>
                            <th>Technician</th>
                            <th>Sales</th>
                        </tr>
                        @foreach($technicians as $technician)
                            <tr>
                                <td><i class = "fa fa-user-circle"></i> {{ $technician->full_name}}</td>
                                <td><a href = "/technician-sale/create/{{ $technician->first_name }}">Add Sale</a></td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection