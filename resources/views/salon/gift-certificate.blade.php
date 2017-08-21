@extends('layouts.main')
@section('pageTitle',$pageTitle)
@push('styles')
    <link rel = "stylesheet" href = "{{ asset('css/vuetify.min.css') }}">
@endpush
@push('scripts')
    <script src = "{{ asset('js/salon/gift-certificate.js') }}"></script>
@endpush
@section('content')
    <div class = "main-content" id = "root">
        <app></app>

    </div>
@endsection
