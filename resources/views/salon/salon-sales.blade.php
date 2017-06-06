@extends('layouts.main')
@section('pageTitle',$pageTitle)
@push('styles')
<link rel = "stylesheet" href = "{{ asset('css/salon-sales.css') }}">
@endpush
@push('scripts')
<script src = "{{ asset('js/salon-sales.js') }}"></script>
@endpush
@section('content')
    @component('partials.header')
        <h1>Salon Daily Sales</h1>
    @endcomponent
    <div class = "main-content" id = "root">
        <div class = "container-fluid">
            <div class = "row top-buffer">
                <div class = "col-md-6 col-md-offset-3">
                    @component('panels.charcoal')
                        @slot('title')
                            Sales Metric
                        @endslot
                        @slot('body')
                            <div class = "form-group">
                                <div class = "input-group">
                                    <div class = "input-group-addon"><i class = "fa fa-calendar"></i></div>
                                    <datepicker v-model="date" :format="dateFormat"
                                                :bootstrap-styling="bootstrapStyling" :selected=" getSales()">
                                    </datepicker>
                                </div>
                            </div>
                            <div class = "top-buffer">
                                @component('tables.salon-sales')@endcomponent
                            </div>
                            <alert :class="{'alert-warning':noSale}" v-if="showAlert" :alert-message="alertMessage"></alert>
                        @endslot
                    @endcomponent
                </div>
            </div>
        </div>
    </div>
@endsection