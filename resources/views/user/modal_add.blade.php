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
                        <small class="text-muted">Contoh : Jono</small>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">{!! requiredFieldLabel('Email') !!}</label>
                        <input type="email" class="form-control" name="email" id="email">
                        <small class="text-muted">Contoh : jono@gmail.com</small>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">{!! requiredFieldLabel('Username') !!}</label>
                        <input type="text" class="form-control" name="username" id="username">
                        <small class="text-muted">Contoh : jonoss0092</small>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">{!! requiredFieldLabel('Password') !!}</label>
                        <input type="password" class="form-control" name="password" id="password">
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">{!! requiredFieldLabel('Password Confirmation') !!}</label>
                        <input type="password" class="form-control" name="password_confirmation"
                            id="password_confirmation">
                    </div>
                    <div class="mb-3">
                        <label for="roles" class="form-label">{!! requiredFieldLabel('Role') !!}</label>
                        @foreach ($roles as $role)
                            <div class="form-group">
                                <input type="checkbox" name="roles[]" value="{{ $role->name }}">
                                <label class="fw-bold">{{ $role->name }}</label>
                            </div>
                        @endforeach
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
