@extends('layouts.main')
@section('pageTitle',$pageTitle)
@push('styles')
    <link rel = "stylesheet" href = "{{ asset('css/vuetify.min.css') }}">
    <link rel = "stylesheet" href = "{{ asset('css/salon-sales.css') }}">
@endpush
@push('scripts')
    <script src = "{{ asset('js/salon-sales.js') }}"></script>
@endpush
@section('content')
    <div class = "main-content" id = "root">
        <salon-sale></salon-sale>
    </div>
@endsection

