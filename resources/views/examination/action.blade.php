@if (!$examination)
    <a href="/exam/examination/select-patient/{{ Crypt::encrypt($data->id) }}" data-appointment_id="{{ $data->id }}"
        class="btn btn-sm btn-primary" data-form="select-patient">
        Pilih Pasien
    </a>
@else
    <a href="/exam/examination/detail-examination/{{ Crypt::encrypt($examination->id) }}"
        data-patient_id="{{ $examination->id }}" class="btn btn-sm color-teal-500" data-form="detail-examination">
        Detail Pemeriksaan
    </a>

    <a href="/exam/examination/modify-prescriptions/{{ Crypt::encrypt($examination->id) }}"
        data-patient_id="{{ $examination->id }}" class="btn btn-sm color-orange-500" data-form="modify-prescription">
        Ubah Resep
    </a>
@endif


{{-- <a data-id="{{ $data->id }}" class="btn btn-sm btn-danger btn-modal btn-show-modal-delete" type="button"
    data-form="delete"><i class='bx bxs-trash-alt text-white'></i></a>

<a data-id="{{ $data->id }}" class="btn btn-sm color-sky-500 btn-modal btn-show-modal-call" type="button"
    data-form="call"><i class='bx bxs-phone-call text-white'></i></a> --}}
