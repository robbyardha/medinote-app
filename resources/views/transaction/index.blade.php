@extends('layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span> {{ $title }}</h4>

        <!-- Basic Bootstrap Table -->

        @if ($errors->has('medicine_error'))
            <div class="alert alert-danger">
                {{ $errors->first('medicine_error') }}
            </div>
        @endif

        <div class="card">
            <h5 class="card-header">List {{ $title }}</h5>

            <div class="card-body">
                <div class="table-responsive text-nowrap py-2 px-2">
                    <table class="table table-striped dt-responsive nowrap py-1 px-1" id="myTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pasien</th>
                                <th>Antrian</th>
                                <th>Deskripsi</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <!--/ Basic Bootstrap Table -->
    </div>
    <!-- / Content -->

    @include('transaction.modal_detail')
    @include('transaction.modal_payment')
    @include('transaction.modal_pick_medicine')





    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    ['10 rows', '25 rows', '50 rows', '100 rows', 'Show all']
                ],
                pageLength: 100,
                processing: true,
                serverside: true,
                ajax: "{{ url('/invoice/payment/getDataAjax') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'No',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'patient_name',
                        name: 'Nama Pasien',
                        render: function(data, type, row) {
                            if (data) {
                                return data
                            } else {
                                return '-';
                            }
                        }
                    },
                    {
                        data: 'queue_number',
                        Nama: 'Antrian',
                    },
                    {
                        data: 'description',
                        Nama: 'Deskripsi',
                    },
                    {
                        data: 'status',
                        Nama: 'Status',
                    },
                    {
                        data: 'action',
                        Nama: 'Aksi',
                    }
                ]
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            $('body').on('click', '.btn-show-modal-delete', function() {
                let id = $(this).attr('data-id');

                var table = $('#myTable').DataTable();

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: `/exam/examination/delete/${id}`,
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire(
                                        'Dihapus!',
                                        'Data telah berhasil dihapus.',
                                        'success'
                                    );
                                    // table.ajax.reload(null, false);
                                    location.reload();
                                }
                            },
                            error: function(error) {
                                Swal.fire(
                                    'Gagal!',
                                    'Ada masalah saat menghapus data.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });


            //modal detail
            $('body').on('click', '.btn-show-modal-detail', function(e) {
                let examinationId = $(this).attr('data-id');
                e.preventDefault();
                $('#detail_modal').modal('show');

                $.ajax({
                    type: "GET",
                    url: `/invoice/payment/detail/${examinationId}`,
                    dataType: "json",
                    success: function(response) {
                        $('#medicine_table_body').empty();

                        if (response.data_items && response.data_items.length > 0) {
                            let totalPrice = 0;
                            $.each(response.data_items, function(index, item) {
                                let medicineName = item.medicine_name;
                                let dose = item.dose;
                                let qty = item.qty;
                                let unitPrice = item.unit_price;
                                let total = qty * unitPrice;

                                $('#medicine_table_body').append(`
                                    <tr>
                                        <td>${index + 1}</td>
                                        <td>${medicineName}</td>
                                        <td>${dose}</td>
                                        <td>${qty}</td>
                                        <td>${formatRupiah(unitPrice)}</td>
                                        <td>${formatRupiah(total)}</td>
                                    </tr>
                                `);

                                totalPrice += total;
                            });

                            $('#medicine_table_body').append(`
                                <tr>
                                    <td colspan="5"><strong>Total Harga</strong></td>
                                    <td><strong>${formatRupiah(totalPrice)}</strong></td>
                                </tr>
                            `);
                        } else {
                            $('#medicine_table_body').append(`
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada data obat.</td>
                                </tr>
                            `);
                        }
                    },
                    error: function() {
                        alert("Terjadi kesalahan saat mengambil data.");
                    }
                });
            });



            // Modal Payment & save payment
            function savePayment() {
                let formData = new FormData($('#add-form-client')[0]);

                var table = $('#myTable').DataTable();

                toggleButton('.btn-save-add', true, 'Loading...');

                $.ajax({
                    url: "{{ url('/invoice/payment/save-payment') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        toggleButton('.btn-save-add', false, 'Simpan');
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.success,
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $('#payment_modal').modal('hide');
                                // table.ajax.reload(null, false);
                                location.reload();
                                $('#add-form-client')[0].reset();
                            }
                        });
                    },
                    error: function(xhr) {
                        toggleButton('.btn-save-add', false, 'Simpan');

                        let errors = xhr.responseJSON.errors;

                        $('.text-danger').empty();

                        let errorMessages = '';
                        if (errors) {
                            for (let field in errors) {
                                $('#' + field + '_error').text(errors[field][0]);

                                errorMessages += errors[field][0] + '<br>';
                            }
                        }

                        if (errors.total_pay) {
                            alert('Nominal pembayaran tidak boleh kurang dari total tagihan.');
                            // Swal.fire({
                            //     icon: 'error',
                            //     title: 'Pembayaran Tidak Valid',
                            //     text: 'Nominal pembayaran tidak boleh kurang dari total tagihan.',
                            //     confirmButtonText: 'OK'
                            // });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Validation Error',
                                html: errorMessages,
                                confirmButtonText: 'OK'
                            });
                        }
                    }
                });
            }

            $('body').on('click', '.btn-show-modal-payment', function(e) {
                let examinationId = $(this).attr('data-id');
                $('#examination_id_payment').val(examinationId);
                e.preventDefault();
                $('#payment_modal').modal('show');
                $.ajax({
                    type: "GET",
                    url: `/invoice/payment/detail/${examinationId}`,
                    data: 'data',
                    dataType: "json",
                    success: function(response) {
                        $('#medicine_table_payment_body').empty();

                        if (response.data_items && response.data_items.length > 0) {
                            let totalPrice = 0;
                            $.each(response.data_items, function(index, item) {
                                let medicineName = item.medicine_name;
                                let dose = item.dose;
                                let qty = item.qty;
                                let unitPrice = item.unit_price;
                                let total = qty * unitPrice;

                                $('#medicine_table_payment_body').append(`
                                    <tr>
                                        <td>${index + 1}</td>
                                        <td>${medicineName}</td>
                                        <td>${dose}</td>
                                        <td>${qty}</td>
                                        <td>${formatRupiah(unitPrice)}</td>
                                        <td>${formatRupiah(total)}</td>
                                    </tr>
                                `);

                                totalPrice += total;
                            });

                            $('#medicine_table_payment_body').append(`
                                <tr>
                                    <td colspan="5"><strong>Total Harga</strong></td>
                                    <td><strong>${formatRupiah(totalPrice)}</strong></td>
                                </tr>
                            `);
                            $('#total_invoice').val(totalPrice);
                        } else {
                            $('#medicine_table_payment_body').append(`
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada data obat.</td>
                                </tr>
                            `);
                        }
                    },
                    error: function() {
                        alert("Terjadi kesalahan saat mengambil data.");
                    }
                });


                $('#total_pay').focus();

                $('#add-form-client').keypress(function(e) {
                    if (e.which === 13) {
                        e.preventDefault();
                        savePayment();
                    }
                });

                $('.btn-save-add').click(function() {
                    savePayment();
                });

            });


        });


        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(angka);
        }
    </script>
@endsection
