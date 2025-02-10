<a href="/cms/post/edit/{{ Crypt::encrypt($data->id) }}" data-id="{{ $data->id }}" class="btn btn-sm btn-warning"
    data-form="update"><i class='bx bxs-edit-alt text-white'></i></a>

<a data-id="{{ $data->id }}" class="btn btn-sm btn-danger btn-modal btn-show-modal-delete" type="button"
    data-form="delete"><i class='bx bxs-trash-alt text-white'></i></a>

@if ($data->is_published == 0)
    <a data-id="{{ $data->id }}" class="btn btn-sm color-sky-500 btn-modal btn-show-modal-publish" type="button"
        data-form="publish"><i class='bx bx-trending-up text-white'></i></a>
@else
    <a data-id="{{ $data->id }}" class="btn btn-sm color-rose-500 btn-modal btn-show-modal-unpublish" type="button"
        data-form="publish"><i class='bx bx-trending-down text-white'></i></a>
@endif
