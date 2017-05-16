@extends('layouts.main')
@push('styles')
    <link rel = "stylesheet" href = "/css/payday.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
@endpush
@section('content')
    <div class = "main-content">
        <div class = "container-fluid">
            <div class = "row pay-period-row">
                <div class = "col-md-4">
                    <div class = "form-inline">
                        <label for = "pay-period">Pay Period:</label>
                        <input type = "text" class = "form-control" id = "pay-period" name = "pay-period" value = "" disabled>
                    </div>
                </div>
            </div>
            <div class = "row sale-container-row">
                @foreach($technicians as $technician)
                    @include('partials.wage-container')
                @endforeach
            </div>

        </div>
    </div>

@endsection