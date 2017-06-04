@extends('layouts.main')
@section('pageTitle','Salon Sales')
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
                <div class = "col-md-6">
                    @component('panels.charcoal')
                        @slot('title')
                            Sales Metric
                        @endslot
                        @slot('body')
                            @component('forms.datepicker')@endcomponent
                            @component('tables.salon-sales')@endcomponent
                        @endslot
                    @endcomponent
                </div>
            </div>
        </div>
    </div>
@endsection