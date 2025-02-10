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
                        <label for="icon" class="form-label">{!! requiredFieldLabel('Icon') !!}</label>
                        <input type="text" class="form-control" name="icon" id="icon">
                        <small class="text-muted">Contoh : bxs-key</small>
                        <br>
                        <small class="text-muted">Dokumentasi Icon : <a href="https://boxicons.com/">Box
                                Icon</a></small>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">{!! requiredFieldLabel('Nama') !!}</label>
                        <input type="text" class="form-control" name="name" id="name">
                        <small class="text-muted">Contoh : Dashboard</small>
                    </div>
                    <div class="mb-3">
                        <label for="url" class="form-label">{!! requiredFieldLabel('URI Segment') !!}</label>
                        <input type="text" class="form-control" name="url" id="url">
                        <small class="text-muted">Contoh : /access</small>
                    </div>
                    <div class="mb-3">
                        <label for="order" class="form-label">{!! requiredFieldLabel('Urutan Menu') !!}</label>
                        <input type="text" class="form-control" name="order" id="order">
                        <small class="text-muted">Contoh : 1</small>
                    </div>
                    <div class="mb-3">
                        <input type="checkbox" class="form-check-input" name="is_single" id="is_single" value="1">
                        <label class="form-check-label" for="is_single">Single Page</label>
                    </div>
                    <div class="mb-3">
                        <input checked type="checkbox" class="form-check-input" name="is_show" id="is_show"
                            value="1">
                        <label class="form-check-label" for="is_show">Tampilkan Menu</label>
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
