@extends('layouts.main')
@section('pageTitle','Salon Sales Entry')
@push('styles')
    <link rel = "stylesheet" href = "{{ asset('css/bootstrap-datepicker3.css') }}">
    <link rel = "stylesheet" href = "{{ asset('css/salon-sales-entry.css') }}">
@endpush
@push('scripts')
    <script src = "{{ asset('js/sales-entry.js') }}"></script>
@endpush
@section('content')
    @component('partials.header')
        <h1>Salon Daily Sales</h1>
    @endcomponent
    <div class = "main-content">
        <div class = "container-fluid">
            <div class = "row top-buffer">
                <div class = "col-md-4">
                    @component('forms.salon-sales')
                    @endcomponent

                </div>
                <div class = "col-md-4">

                </div>
            </div>
        </div>
    </div>
@endsection
<template id = "confirmation-alert">
    <div class = "alert alert-success" role = "alert">
        <button type = "button" class = "close" v-on:click="$emit('close')">X</button>
        @{{ message }}
    </div>
</template>
<template id = "failure-alert">
    <div class = "alert alert-danger" role = "alert">
        <button type = "button" class = "close" v-on:click="$emit('close')">X</button>
        @{{ message }}
    </div>
</template>
