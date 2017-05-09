@extends('layouts.main')
@push('styles')
    <link rel = "stylesheet" href = "{{ asset('css/bootstrap-datepicker3.css') }}">
@endpush
@push('scripts')
    <script src = "{{ asset('js/bootstrap-datepicker.js')}}"></script>
    <script src = "{{ asset('js/technician-sales.js') }}"></script>
@endpush
@section('content')
    <div class = "container">
        <div class = "row">
            <div class = "col-md-6">
                <section id = "tech-name">
                    <h1>{{ $firstName }} {{ $lastName }}</h1>
                </section>
            </div>
        </div>
        <div class = "row">
            <div class = "col-md-6">
                <form id = "sale-entry-form" method = "post" action = "/technician-sale">
                    {{ csrf_field() }}
                    <input type = "hidden" name = "technicianID" value = "{{ $id }}">
                    <div class = "form-group @if($errors->has('sale-date')) has-error @endif">
                        <label for = "sale-date">Date:</label>
                        <input type = "text" id = "sale-date" class = "form-control" name = "sale-date" v-model = "startDate">
                        @if($errors->has('sale-date')) <p class = "help-block">{{ $errors->first('sale-date') }}</p> @endif
                    </div>
                    <div class = "form-group @if($errors->has('sale')) has-error @endif">
                        <label for = "sale">Sale:</label>
                        <input type = "text" id = "sale" class = "form-control" name = "sale">
                        @if($errors->has('sale')) <p class = "help-block">{{ $errors->first('sale') }}</p> @endif
                    </div>
                    <div class = "form-group @if($errors->has('additional-sale')) has-error @endif">
                        <label for = "additional-sale">Additional Sale:</label>
                        <input type = "text" id = "additional-sale" class = "form-control" name = "other-sale">
                        @if($errors->has('additional-sale')) <p class = "help-block">{{ $errors->first('additional-sale') }}</p> @endif
                    </div>
                    <button type = "submit" class = "btn btn-primary">Enter</button>
                </form>
            </div>
        </div>

    </div>
@endsection