@extends('layouts.main')
@section('pageTitle', $pageTitle)
@push('scripts')
<script src = "{{ asset('js/api-dashboard.js') }}"></script>
<script>
window.csrfToken = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
</script>
@endpush

@section('content')
    <div id = "root">

       <api-dashboard></api-dashboard>


    </div>
@endsection