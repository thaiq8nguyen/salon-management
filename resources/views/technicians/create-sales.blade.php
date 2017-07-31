@extends('layouts.main')
@section('pageTitle','Create Technician Sale')
@push('styles')
    <link rel = "stylesheet" href = "{{ asset('css/vuetify.min.css') }}">
    <link rel = "stylesheet" href = "{{ asset('css/create-sales.css') }}">
    <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons' rel="stylesheet" type="text/css">
@endpush
@push('scripts')
    <script src = "{{ asset('js/technicians/create-sales.js')}}"></script>
@endpush
@section('content')
    <div class = 'main-content' id = "root">
        <technician-header :full-name="technicianName"></technician-header>
        <pay-period-header v-on:id="setPayPeriod"></pay-period-header>
        <new-technician-sale v-on:name="getTechnician" :period-id="periodID"></new-technician-sale>
    </div>

@endsection


