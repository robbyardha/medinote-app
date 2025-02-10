@foreach ($roles as $role)
    <div class="form-group">
        <input type="checkbox" name="roles[]" @if (in_array($role->name, $current_roles)) @checked(true) @endif
            value="{{ $role->name }}">
        <label class="fw-bold">{{ $role->name }}</label>
    </div>
@endforeach
