@props(['link', 'label'])
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <a href="javascript:void(0)" id="create" class="btn btn-info btn-xs float-right">
                            <i class="fas fa-plus-circle"></i> {{ $label }}</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped data-table">
                            <thead>
                                <tr>
                                    {{ $slot }}
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
