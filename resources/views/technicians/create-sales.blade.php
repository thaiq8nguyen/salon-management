@extends('layouts.main')
@push('styles')
    <link rel = "stylesheet" href = "{{ asset('css/bootstrap-datepicker3.css') }}">
    <link rel = "stylesheet" href = "{{ asset('css/create-sales.css') }}">
@endpush
@push('scripts')
    <script src = "{{ asset('js/bootstrap.js')}}"></script>
    <script src = "{{ asset('js/bootstrap-datepicker.js')}}"></script>
    <script src = "{{ asset('js/technician-sales.js') }}"></script>
@endpush
@section('content')
    <div class = "container">
        <div class = "row">
            <div class = "col-md-6">
                <section id = "tech-name">
                    <h1>{{ $technician['firstName'] }} {{ $technician['lastName'] }}</h1>
                </section>
            </div>
        </div>
        <div class = "row">
            <div class = "col-md-4">
                <div class = "panel panel-default">
                    <div class = "panel-body">
                        <form id = "sale-entry-form" method = "post" action = "/technician-sale">
                            {{ csrf_field() }}
                            <input type = "hidden" name = "technicianID" value = "{{ $technician['id'] }}">
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
                            <button type = "submit" class = "btn btn-primary">Enter</button>
                            <a href = "/technician-sale/show" class = "btn btn-default">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
            <div class = "col-md-5">
                <div class = "panel panel-default">
                    <div class = "panel-body">
                        <table class = "table table-bordered">
                            <thead>
                                <tr>
                                    <th>Sale Date</th>
                                    <th>Sale</th>
                                    <th>Additional Sale</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($sales as $sale)
                                <tr>
                                    <td>{{ $sale->sale_date->format('m/d/Y') }}</td>
                                    <td>$ {{ $sale->sales }}</td>
                                    <td>$ {{ $sale->additional_sales }}</td>
                                    <td><a href = ""
                                           data-toggle="modal"
                                           data-target = "#change-sale-modal"
                                           data-sale-id = " {{ $sale->id }}"
                                           data-sales = "{{ $sale->sales }}"
                                           data-additional-sales = "{{ $sale->additional_sales }}"
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
@endsection
@include('partials.change-technician-sales')