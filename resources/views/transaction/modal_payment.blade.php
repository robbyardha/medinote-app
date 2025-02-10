<div class="modal fade" id="payment_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg bounceIn  animated">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah {{ $title }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data" id="add-form-client">
                    @csrf

                    <div class="row">
                        <div class="col">
                            <label for="total_pay" class="form-label">{!! requiredFieldLabel('Nominal Pembayaran') !!}</label>
                            <input type="number" class="form-control" name="total_pay" id="total_pay">
                            <input type="hidden" readonly class="form-control" name="examination_id"
                                id="examination_id_payment">
                            <input type="hidden" readonly class="form-control" name="total_invoice" id="total_invoice">
                        </div>
                        <div class="col">
                            <label for="payment_date" class="form-label">{!! requiredFieldLabel('Tanggal Pembayaran') !!}</label>
                            <input type="text" class="form-control dateTimePickr" name="payment_date"
                                id="payment_date">
                        </div>
                    </div>

                    <br>
                    <h5>
                        Rincian Item
                    </h5>
                    <table class="table table-bordered" id="medicine_table_payment">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Obat</th>
                                <th>Dosis</th>
                                <th>Qty</th>
                                <th>Harga</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody id="medicine_table_payment_body">
                        </tbody>
                    </table>

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
