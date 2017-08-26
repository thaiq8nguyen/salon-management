@extends('layouts.main')
@section('pageTitle', $pageTitle)
@push('styles')
    <link rel = "stylesheet" href = "{{ asset('css/vuetify.min.css') }}">
    <link rel = "stylesheet" href = "{{ asset('/css/payday.css') }}">
    <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons' rel="stylesheet" type="text/css">
@endpush
@push('scripts')
    <script src = "{{ asset('js/salon/payday.js') }}"></script>
@endpush
@include('partials.main-navbar')
@section('content')

    <div class = "main-content" id = "root">
        <pay-period-header v-on:id="setPayPeriod"></pay-period-header>
        <pay-day></pay-day>
    </div>

@endsection