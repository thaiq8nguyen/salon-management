<div class =  "modal fade" id = "change-sale-modal" tabindex= "-1" role ="dialog">
    <div class = "modal-dialog" role = "document">
        <div class ="modal-content">
            <div class = "modal-header">
                <h2 class = "modal-title">Change Sale</h2>
            </div>
            <div class = "modal-body">
                <div class = "panel panel-light-color">
                    <div class = "panel-heading">
                        <div class = "row">
                            <div class = "col-md-6">
                                <h3>Current Sale</h3>
                                <h4 class = "current-sale"></h4>
                            </div>
                            <div class = "col-md-6">
                                <h3>Tip</h3>
                                <h4 class = "current-additional-sale"></h4>
                            </div>
                        </div>
                    </div>
                </div>
                <form id = "change-sale-form" class = "form-horizontal">
                    {{ csrf_field() }}
                    <input type = "hidden" id = "sale-id" name = "sale-id">
                    <div class = "form-group ">
                        <label for = "sale" class = "form-label col-md-3">New Sale:</label>
                        <div class = "col-md-4">
                            <div class = "input-group">
                                <div class = "input-group-addon"><i class = "fa fa-dollar fa-lg"></i></div>
                                <input type = "text" id = "sale" class = "form-control" name = "sale">
                            </div>
                        </div>
                    </div>
                    <div class = "form-group ">
                        <label for = "additional-sale" class = "form-label col-md-3">Tip:</label>
                        <div class = "col-md-4">
                            <div class = "input-group">
                                <div class = "input-group-addon"><i class = "fa fa-dollar fa-lg"></i></div>
                                <input type = "text" id = "additional-sale" class = "form-control" name = "additional-sale">
                        </div>
                    </div>
                </form>
            </div>
            <div class = "modal-footer">
                <div class = "row">
                    <div class = "col-md-6">
                        <div id = "sale-change-confirmation" role = "alert">
                        </div>
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
