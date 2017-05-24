<form id = "sale-entry-form" method = "post" action = "/technician-sale" class = "form-horizontal">
    <input type = "hidden" name = "_token" id = "_token" value = "{{ csrf_token() }}">
    <input type = "hidden" name = "technicianID" id = "technicianID" value = "{{ $technicianID }}">
    <input type = "hidden" name = "sale-date" value = "{{ $saleDate }}">
    <div class = "form-group">
        <label for = "sale-date" class = "form-label col-md-2">Sale Date:</label>
        <div class = "col-md-4">
            <p>{{ \Carbon\Carbon::createFromFormat('Y-m-d',$saleDate)->format('m/d/Y') }}</p>
        </div>
    </div>
    <div class = "form-group @if($errors->has('sale')) has-error @endif">
        <label for = "sale" class = "form-label col-md-2">Sale:</label>
        <div class = "col-md-4">
            <div class = "input-group">
                <div class = "input-group-addon"><i class = "fa fa-dollar fa-lg"></i></div>
                <input type = "text" id = "sale" class = "form-control" name = "sale">
            </div>
            @if($errors->has('sale')) <p class = "help-block">{{ $errors->first('sale') }}</p> @endif
        </div>
    </div>
    <div class = "form-group @if($errors->has('additional-sale')) has-error @endif">
        <label for = "additional-sale"  class = "form-label col-md-2">Tip:</label>
        <div class = "col-md-4">
            <div class = "input-group">
                <div class = "input-group-addon"><i class = "fa fa-dollar fa-lg"></i></div>
                <input type = "text" id = "additional-sale" class = "form-control" name = "additional-sale">
            </div>
            @if($errors->has('additional-sale')) <p class = "help-block">{{ $errors->first('additional-sale') }}</p> @endif
        </div>
    </div>
    <div class = "form-group">
        <div class = "col-md-4 col-md-offset-2">
            <button type = "submit" class = "btn btn-primary btn-submit">Enter</button>
        </div>
    </div>
</form>