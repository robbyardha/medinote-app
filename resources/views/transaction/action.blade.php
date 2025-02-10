@if (!$examination)
@else
    <a data-id="{{ $examination->id }}" class="btn btn-sm color-sky-500 text-white btn-modal btn-show-modal-detail"
        type="button" data-form="detail" data-bs-target="#detail_modal">
        <i class='bx bx-search'></i>
        Detail
    </a>

    @if ($transaction == null)
        <a data-id="{{ $examination->id }}" class="btn btn-sm color-teal-500 text-white btn-modal btn-show-modal-payment"
            type="button" data-form="payment" data-bs-target="#payment_modal">
            <i class='bx bx-money'></i>
            Pembayaran
        </a>
    @else
        <a href="/invoice/payment/print/{{ Crypt::encrypt($examination->id) }}" data-patient_id="{{ $examination->id }}"
            class="btn btn-sm color-rose-500" data-form="cetak-struk">
            <i class='bx bxs-file-pdf'></i>
            Cetak Struk
        </a>
    @endif

    @if ($prescription->status == 'process')
        <a data-id="{{ $examination->id }}"
            class="btn btn-sm color-indigo-600 text-white btn-modal btn-show-modal-pick-medicine" type="button"
            data-form="pick-medicine">
            <i class='bx bxs-hand'></i>
            Sudah Ambil Obat
        </a>
    @endif
@endif
