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
                    @component('panels.charcoal')
                        @slot('title')
                            Sale Entry
                        @endslot
                        @slot('body')
                            @component('forms.salon-sales')@endcomponent
                        @endslot
                    @endcomponent
                </div>
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
<template id = "entry-alert">
    <div class = "alert" role = "alert">
        <button type = "button" class = "close" v-on:click="$emit('close')">X</button>
        @{{ message }}
    </div>
</template>

