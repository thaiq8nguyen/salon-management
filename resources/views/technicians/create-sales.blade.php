@extends('layouts.main')
@push('styles')
    <link rel = "stylesheet" href = "{{ asset('css/bootstrap-datepicker3.css') }}">
    <link rel = "stylesheet" href = "{{ asset('css/create-sales.css') }}">
@endpush
@push('scripts')
    <script src = "{{ asset('js/bootstrap-datepicker.js')}}"></script>
    <script src = "{{ asset('js/technicians/create-sales.js')}}"></script>
@endpush
@if(Session::has('confirm-sale'))
    @component('partials.alert-success')
        <p>{{ Session::get('confirm-sale') }}</p>
    @endcomponent
@endif
@section('content')
    @component('partials.header')
        <div class = "row">
            <div class = "col-md-3">
                <div class = "col-md-3">
                    <i class = "fa fa-user fa-3x"></i>
                </div>
                <div class = "col-md-8 pull-right">
                    <h1>{{ $technician->full_name }}</h1>
                </div>
            </div>
        </div>
    @endcomponent
    <div class = 'main-content'>
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
            <div class = "row sale-entry-container">
                <div class = "col-md-4">
                    <div class = "panel panel-default">
                        <div class = "panel-heading">
                            <h3 class = "panel-title">Add New Sale</h3>
                        </div>
                        <div class = "panel-body">
                            <form id = "sale-entry-form" method = "post" action = "/technician-sale">
                                <input type = "hidden" name = "_token" id = "_token" value = "{{ csrf_token() }}">
                                <input type = "hidden" name = "technicianID" id = "technicianID" value = "{{ $technician->id }}">
                                <div class = "form-group @if($errors->has('sale-date')) has-error @endif">
                                    <label for = "sale-date">Date:</label>
                                    <input type = "text" id = "sale-date" class = "form-control" name = "sale-date">
                                    @if($errors->has('sale-date')) <p class = "help-block">{{ $errors->first('sale-date') }}</p> @endif
                                </div>
                                <div class = "form-group @if($errors->has('sale')) has-error @endif">
                                    <label for = "sale">Sale:</label>
                                    <input type = "text" id = "sale" class = "form-control" name = "sale">
                                    @if($errors->has('sale')) <p class = "help-block">{{ $errors->first('sale') }}</p> @endif
                                </div>
                                <div class = "form-group @if($errors->has('additional-sale')) has-error @endif">
                                    <label for = "additional-sale">Additional Sale:</label>
                                    <input type = "text" id = "additional-sale" class = "form-control" name = "additional-sale">
                                    @if($errors->has('additional-sale')) <p class = "help-block">{{ $errors->first('additional-sale') }}</p> @endif
                                </div>
                                <button type = "submit" class = "btn btn-primary btn-submit">Enter</button>
                                <a href = "/technician-sale" class = "btn btn-default">Cancel</a>
                            </form>
                            <p class = "alert" id = "alert-new-sale"></p>
                        </div>
                    </div>
                </div>
                <div class = "col-md-5">
                    <div class = "panel panel-default">
                        <div class = "panel-heading">
                            <h3 class = "panel-title">Daily Sales</h3>
                        </div>
                        <div class = "panel-body">
                            <table class = "table table-bordered">
                                <thead>
                                <tr>
                                    <th>Sale Date</th>
                                    <th>Sale</th>
                                    <th>Tip</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($technician->dailySales as $dailySale)
                                    <tr>
                                        <td>{{ $dailySale->sale_date_mdy }}</td>
                                        <td>{{ $dailySale->sales_amount }}</td>
                                        <td>{{ $dailySale->additional_sales_amount }}</td>
                                        <td><a href = ""
                                               data-toggle="modal"
                                               data-target = "#change-sale-modal"
                                               data-sale-id = " {{ $dailySale->id }}"
                                               data-sales = "{{ $dailySale->sales_amount }}"
                                               data-additional-sales = "{{ $dailySale->additional_sales_amount }}"
                                               class = "change-sale-link">Change</a></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@include('partials.change-technician-sales')