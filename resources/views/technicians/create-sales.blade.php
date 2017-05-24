@extends('layouts.main')
@section('pageTitle','Add Technician Sale')
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
    @component('header.technician')
        @slot('fullName')
            {{ $tech->full_name }}
        @endslot
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
                <div class = "col-md-3">
                    @component('panels.default')
                        @slot('title')
                            <form class = "form-inline" method = "post" action = "/technician-sale/create">
                                <div class = "form-group">
                                    <div class = "input-group">
                                        <div class = "input-group-addon"><i class = "fa fa-calendar fa-lg"></i></div>
                                        <input type = "text" class = "form-control col-md-3" id = "sale-date-input" name = "sale-date-input"
                                               value = "{{ \Carbon\Carbon::createFromFormat('Y-m-d',$saleDate)->format('m/d/Y') }}">
                                    </div>
                                </div>
                            </form>
                        @endslot
                        @slot('body')
                            <div class = "list-group technician-list-container"></div>
                        @endslot
                    @endcomponent
                </div>
                <div class = "col-md-4">
                    @if($tech->sales_count == 0)
                        @component('panels.default')
                            @slot('title')
                                Add New Sale
                            @endslot
                            @slot('body')
                                @component('forms.add-sales')
                                    @slot('technicianID')
                                        {{ $tech->id }}
                                    @endslot
                                    @slot('saleDate')
                                        {{ $saleDate }}
                                    @endSlot
                                @endcomponent
                                <div class = "new-sale-alert-container"></div>
                            @endslot
                        @endcomponent
                    @endif
                </div>
                <div class = "col-md-4">
                    @if(count($tech->dailySales) > 0)
                        @component('panels.success')
                            @slot('title')
                                Daily Sales
                            @endslot
                            @slot('body')
                                @component('tables.daily-sales-with-change',['tech' => $tech])
                                @endcomponent
                            @endslot
                        @endcomponent
                    @else
                        @component('panels.default')
                            @slot('title')
                                Daily Sales
                            @endslot
                            @slot('body')
                                There are no recorded sales for the pay period
                            @endslot
                        @endcomponent
                    @endif
                </div>
            </div>
        </div>
    </div>
    @include('partials.change-technician-sales')
@endsection


