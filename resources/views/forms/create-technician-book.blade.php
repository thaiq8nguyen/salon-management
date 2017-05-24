<form method = "post" action = "/technician-book/create">
    {{csrf_field()}}
    <div class = "form-group @if($errors->has('technician-id')) has-error @endif">
        <label for = "technician-list" class = "form-label">Technicians:</label>
        <div class = "input-group">
            <div class = "input-group-addon"><i class = "fa fa-user"></i></div>
            <select class = "form-control select-technician" name = "technician-id">
                <option selected disabled>--Select a technician--</option>
                @foreach($technicians as $technician)
                    <option value = "{{ $technician->id }}">{{ $technician->full_name }}</option>
                @endforeach
            </select>
        </div>
        @if($errors->has('technician-id')) <p class = "help-block">{{ $errors->first('technician-id') }}</p> @endif
    </div>
    <div class = "form-group @if($errors->has('opening-balance')) has-error @endif">
        <label for = "opening-balance" class = "form-label">Opening Balance:</label>
        <div class = "input-group">
            <div class = "input-group-addon"><i class = "fa fa-dollar fa-lg"></i></div>
            <input type = "text" class = "form-control" name = "opening-balance">
        </div>
        @if($errors->has('opening-balance')) <p class = "help-block">{{ $errors->first('opening-balance') }}</p> @endif
    </div>
    <div class = "form-group">
        <button type = "submit" class = "btn btn-primary pull-right">Create</button>
    </div>

</form>