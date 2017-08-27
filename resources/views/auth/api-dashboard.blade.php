@extends('layouts.main')
@section('pageTitle', $pageTitle)
@push('scripts')
<script src = "{{ asset('js/api-dashboard.js') }}"></script>
<script>
window.csrfToken =  <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
</script>
@endpush
@include('partials.main-navbar')
@section('content')
    <div class = "main-content" id = "root">
        <div class = "container">
            <div class = "row" style = "margin-top: 25px;">
                <div class = "col-md-6">
                    <passport-clients></passport-clients>
                    <passport-authorized-clients></passport-authorized-clients>
                    <personal-access-tokens></personal-access-tokens>
                </div>
            </div>
        </div>
    </div>
@endsection