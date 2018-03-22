@extends('layouts.main')
@section('pageTitle',$pageTitle)
@push('styles')

    <link rel = "stylesheet" href = "{{ asset('css/quick-sale-entry.css') }}">

@endpush
@push('scripts')
    <script src = "{{ asset('js/salon/quick-sale-entry.js') }}"></script>
@endpush
@section('content')
    <div class = "main-content" id = "root">
        <quick-sale-entry></quick-sale-entry>
    </div>
@endsection