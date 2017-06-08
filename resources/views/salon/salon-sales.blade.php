@extends('layouts.main')
@section('pageTitle',$pageTitle)
@push('styles')
<link rel = "stylesheet" href = "{{ asset('css/salon-sales.css') }}">
@endpush
@push('scripts')
<script src = "{{ asset('js/salon-sales.js') }}"></script>
@endpush
@section('content')
    @component('partials.header')
        <h1>Salon Daily Sales</h1>
    @endcomponent
    <div class = "main-content" id = "root">
        <div class = "container-fluid">
            <div class = "row top-buffer">
                <div class = "col-md-6 col-md-offset-3">
                    @component('panels.charcoal')
                        @slot('title')
                            Sales Metric
                        @endslot
                        @slot('body')
                            <div class = "row">
                                <div class = "col-md-3">
                                    <div class = "form-group">
                                        <div class = "input-group">
                                            <div class = "input-group-addon"><i class = "fa fa-calendar"></i></div>
                                            <datepicker v-model="date" :format="dateFormat"
                                                        :bootstrap-styling="bootstrapStyling" :selected.prevent=" getSales"
                                                        :disabled="option.disabled">
                                            </datepicker>
                                        </div>
                                    </div>
                                </div>
                                <div class = "col-md-9">
                                    <gift-card-redeemed-form :date="date" :reset="resetGCRedeemed"
                                                             v-on:redeemed="giftCardRedeemed">
                                    </gift-card-redeemed-form>
                                </div>
                            </div>
                            <div class = "top-buffer">
                                <div class = "row">
                                    <div class = "col-md-6">
                                        <daily-sale-table class = "table table-bordered" :sales="sales" v-show="showTable"></daily-sale-table>
                                    </div>
                                    <div class = "col-md-6">
                                        <daily-tip-table class = "table table-bordered" :tips="tips" v-show="showTable"></daily-tip-table>
                                    </div>
                                </div>
                            </div>
                        @endslot
                    @endcomponent
                </div>
            </div>
        </div>
    </div>
@endsection