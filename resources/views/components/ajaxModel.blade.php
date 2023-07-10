@props(['size'])
<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog {{ $size }}">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="ajaxForm" name="ajaxForm" class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="hidden_id" id="hidden_id">
                    {{ $slot }}
                    <div class="form-group">
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary btn-sm" id="saveBtn" value="create">Simpan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
