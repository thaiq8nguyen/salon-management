@extends('layouts.main')
@section('pageTitle','Salon Sales Entry')
@push('styles')
    <link rel = "stylesheet" href = "{{ asset('css/bootstrap-datepicker3.css') }}">
    <link rel = "stylesheet" href = "{{ asset('css/salon-sales-entry.css') }}">
@endpush
@push('scripts')
    <script src = "{{ asset('js/axios.js') }}"></script>
    <script src = "{{ asset('js/vue.js') }}"></script>
    <script src = "{{ asset('js/bootstrap-datepicker.js')}}"></script>
    <script src = "{{ asset('js/salon/sales-entry.js') }}"></script>
@endpush
@section('content')
    @component('partials.header')
        <h1>Salon Daily Sales</h1>
    @endcomponent
    <div class = "main-content">
        <div class = "container-fluid">
            <div class = "row">
                <div class = "col-md-4">
                    @component('forms.salon-sales')
                    @endcomponent
                    <div class = "alert alert-success">
                        <p v-text = "confirmation"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
