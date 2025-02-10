{{-- MODAL TAMBAH --}}
<div class="modal fade" id="add_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg bounceIn  animated">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah {{ $title }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data" id="add-form-client">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">{!! requiredFieldLabel('Nama') !!}</label>
                        <input type="text" class="form-control" name="name" id="name">
                        <small class="text-muted">Contoh : /access/give-permission (sesuaikan dengan uri segment dari
                            menu dan url submenu)</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn-save-add">
                    <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    Simpan
                </button>
            </div>
        </div>
    </div>
</div>
