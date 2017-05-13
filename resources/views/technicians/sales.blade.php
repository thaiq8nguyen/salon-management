@extends('layouts.main')
@push('styles')
    <link rel = "stylesheet" href = "/css/technician-sales.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
@endpush
@section('content')
    @if(Session::has('confirm-sale'))
        <header class = "page-heading">
            <div class = "container-fluid">
                <p>{{ Session::get('confirm-sale') }}</p>
            </div>
        </header>
    @endif
    <div class = "main-content">
        <div class = "container-fluid">
            <div class = "row pay-period-container">
                <div class = "col-md-4">
                    <div class = "form-inline">
                        <label for = "pay-period">Pay Period:</label>
                        <input type = "text" class = "form-control" id = "pay-period" name = "pay-period" value = "{{ $paySchedule['payPeriod'] }}">
                    </div>
                </div>
                <div class = "col-md-4">
                    <div class = "form-inline">
                        <label for = "pay-date">Pay Date:</label>
                        <input type = "text" class = "form-control" id = "pay-date" name = "pay-date" value = "{{ $paySchedule['payDate'] }}">
                    </div>
                </div>
                <div class = "col-md-4">
                    <a href = "{{url('/wages/pay')}}" class = "btn btn-primary btn-nav-pay">Pay</a>
                </div>
            </div>
            <div class = "row technician-list-container">
                <div class = "col-md-6 col-md-offset-3">
                    <h1>Technicians</h1>
                    <table class = "table table-bordered">
                        <tr>
                            <th>Technician</th>
                            <th>Action</th>
                        </tr>
                        @foreach($technicians as $technician)
                            <tr>
                                <td>{{ $technician->first_name. ' ' .$technician->last_name}}</td>
                                <td><a href = "create/{{ $technician->first_name }}">Add Sale</a></td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection