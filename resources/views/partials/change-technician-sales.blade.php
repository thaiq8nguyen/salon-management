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
                                <p class = "current-sale"></p>
                            </div>
                            <div class = "col-md-6">
                                <h3>Additional Sale</h3>
                                <p class = "current-additional-sale"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <form id = "change-sale-form">
                    {{ csrf_field() }}
                    <input type = "hidden" id = "sale-id" name = "sale-id">
                    <div class = "form-group ">
                        <label for = "sale">New Sale:</label>
                        <input type = "text" id = "sale" class = "form-control" name = "sale">
                    </div>
                    <div class = "form-group ">
                        <label for = "additional-sale">New Additional Sale:</label>
                        <input type = "text" id = "additional-sale" class = "form-control" name = "additional-sale">
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
