<div class =  "modal fade" id = "change-sale-modal" tabindex= "-1" role ="dialog">
    <div class = "modal-dialog" role = "document">
        <div class ="modal-content">
            <div class = "modal-header">
                <h2 class = "modal-title">Change Sale</h2>
            </div>
            <div class = "modal-body">
                <p class = "current-sale">Current Sale: $ <span></span> </p>
                <p class = "current-additional-sale"> Current Additional Sale: $ <span></span></p>
                <form id = "change-sale-form">
                    {{ csrf_field() }}
                    <input type = "hidden" id = "sale-id" name = "sale-id">
                    <div class = "form-group @if($errors->has('sale')) has-error @endif">
                        <label for = "sale">New Sale:</label>
                        <input type = "text" id = "sale" class = "form-control" name = "sale">
                        @if($errors->has('sale')) <p class = "help-block">{{ $errors->first('sale') }}</p> @endif
                    </div>
                    <div class = "form-group @if($errors->has('additional-sale')) has-error @endif">
                        <label for = "additional-sale">New Additional Sale:</label>
                        <input type = "text" id = "additional-sale" class = "form-control" name = "additional-sale">
                        @if($errors->has('additional-sale')) <p class = "help-block">{{ $errors->first('additional-sale') }}</p> @endif
                    </div>
                </form>
            </div>
            <div class = "modal-footer">
                <div class = "row">
                    <div class = "col-md-6">
                        <p class = "text-left change-confirmation"></p>
                    </div>
                    <div class = "col-md-6">
                        <button type = "button" class = "btn btn-primary btn-submit" >Save</button>
                        <button type = "button" class = "btn btn-default" data-dismiss = "modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
