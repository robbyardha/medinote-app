<a href="/exam/registration-examination/edit/{{ Crypt::encrypt($data->id) }}" data-id="{{ $data->id }}"
    class="btn btn-sm btn-warning" data-form="update"><i class='bx bxs-edit-alt text-white'></i></a>

<a data-id="{{ $data->id }}" class="btn btn-sm btn-danger btn-modal btn-show-modal-delete" type="button"
    data-form="delete"><i class='bx bxs-trash-alt text-white'></i></a>

@if ($data->status == 'Waiting')
    <a data-id="{{ $data->id }}" class="btn btn-sm color-sky-500 btn-modal btn-show-modal-call" type="button"
        data-form="call"><i class='bx bxs-phone-call text-white'></i></a>
@endif
