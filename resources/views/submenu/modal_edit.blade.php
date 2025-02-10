{{-- MODAL EDIT --}}
<div class="modal fade" id="edit_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg bounceIn  animated">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Client</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data" id="edit-form-client">
                    @csrf
                    <div class="mb-3">
                        <label for="menu_id_edit" class="form-label">{!! requiredFieldLabel('Menu') !!}</label>
                        <select name="menu_id_edit" id="menu_id_edit" class="form-control">
                            <option value="">PILIH MENU</option>
                            @foreach ($menus as $menu)
                                <option value="{{ $menu->id }}">{{ $menu->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="name_edit" class="form-label">{!! requiredFieldLabel('Nama Sub Menu') !!}</label>
                        <input type="text" class="form-control" name="name_edit" id="name_edit">
                        <small class="text-muted">Contoh : Tag</small>
                    </div>
                    <div class="mb-3">
                        <label for="url_edit" class="form-label">{!! requiredFieldLabel('URI Segment Sub Menu') !!}</label>
                        <input type="text" class="form-control" name="url_edit" id="url_edit">
                        <small class="text-muted">Contoh : /tag</small>
                    </div>
                    <div class="mb-3">
                        <label for="order_edit" class="form-label">{!! requiredFieldLabel('Urutan Sub Menu') !!}</label>
                        <input type="text" class="form-control" name="order_edit" id="order_edit">
                        <small class="text-muted">Contoh : 1</small>
                    </div>
                    <div class="mb-3">
                        <input checked type="checkbox" class="form-check-input" name="is_show_edit" id="is_show_edit"
                            value="1">
                        <label class="form-check-label" for="is_show_edit">Tampilkan Menu</label>
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
