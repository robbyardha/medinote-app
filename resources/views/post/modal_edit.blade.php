{{-- MODAL EDIT --}}
<div class="modal fade" id="edit_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg bounceIn  animated">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit {{ $title }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data" id="edit-form-client">
                    @csrf
                    <div class="mb-3">
                        <label for="name_edit" class="form-label">{!! requiredFieldLabel('Nama') !!}</label>
                        <input type="text" class="form-control" name="name_edit" id="name_edit">
                        <small class="text-muted">Contoh : Programming, Digital</small>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn-save-edit">
                    <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    Update
                </button>
            </div>
        </div>
    </div>
</div>
