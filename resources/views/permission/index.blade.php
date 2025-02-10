@extends('layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span> {{ $title }}</h4>

        <!-- Basic Bootstrap Table -->
        <div class="card">
            <h5 class="card-header">List {{ $title }}</h5>

            <div class="card-header d-flex justify-content-between align-items-center">
                <button class="btn btn-sm btn-primary btn-modal btn-show-modal-add" type="button" data-bs-toggle="modal"
                    data-bs-target="#add_modal" data-form="create"><i class='bx bxs-plus-circle text-white'></i></button>
            </div>

            <div class="card-body">
                <div class="table-responsive text-nowrap py-2 px-2">
                    <table class="table table-striped dt-responsive nowrap py-1 px-1" id="myTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Guard Name</th>
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

    @include('permission.modal_add')
    @include('permission.modal_edit')





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
                ajax: "{{ url('/access/permission/getDataAjax') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'No',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'name',
                        Nama: 'Nama',
                    },
                    {
                        data: 'guard_name',
                        Nama: 'Guard',
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


            //add
            function saveData() {
                let formData = new FormData($('#add-form-client')[0]);

                var table = $('#myTable').DataTable();

                toggleButton('.btn-save-add', true, 'Loading...');

                $.ajax({
                    url: "{{ url('/access/permission/create') }}",
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
                                $('#add_modal').modal('hide');
                                // table.ajax.reload(null, false);
                                location.reload();
                                $('#add-form-client')[0].reset();
                                $('.text-danger').empty();
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

                        alert(`${errorMessages}`);
                    }
                });
            }


            $('body').on('click', '.btn-show-modal-add', function(e) {
                e.preventDefault();
                $('#add_modal').modal('show');

                $('#add-form-client').keypress(function(e) {
                    if (e.which === 13) {
                        e.preventDefault();
                        saveData();
                    }
                });

                $('.btn-save-add').click(function() {
                    saveData();
                });

            });





            // Edit
            function saveEditData(id) {
                let formData = new FormData($('#edit-form-client')[0]);

                var table = $('#myTable').DataTable();

                toggleButton('.btn-save-edit', true, 'Loading...');

                $.ajax({
                    url: `/access/permission/update/${id}`,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response, textStatus, xhr) {
                        toggleButton('.btn-save-edit', false, 'Simpan');

                        if (xhr.status === 200) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.success,
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $('#edit_modal').modal('hide');
                                    // table.ajax.reload(null, false);
                                    location.reload();
                                    $('#edit-form-client')[0].reset();
                                    $('.text-danger').empty();
                                    $('#name_edit').val('');
                                }
                            });
                        } else {
                            toggleButton('.btn-save-edit', false, 'Update');

                            let errors = xhr.responseJSON.errors;

                            $('.text-danger').empty();

                            let errorMessages = '';
                            if (errors) {
                                for (let field in errors) {
                                    $('#' + field + '_error').text(errors[field][
                                        0
                                    ]);

                                    errorMessages += errors[field][0] + '<br>';
                                }
                            }

                            Swal.fire({
                                icon: 'error',
                                title: 'Validation Error',
                                html: errorMessages,
                                confirmButtonText: 'OK'
                            });
                        }



                    },
                    error: function(xhr) {
                        toggleButton('.btn-save-edit', false, 'Update');

                        let errors = xhr.responseJSON.errors;

                        $('.text-danger').empty();

                        let errorMessages = '';
                        if (errors) {
                            for (let field in errors) {
                                $('#' + field + '_error').text(errors[field][0]);

                                errorMessages += errors[field][0] + '<br>';
                            }
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Validation Error',
                            html: errorMessages,
                            confirmButtonText: 'OK'
                        });
                    }
                });
            }

            $('body').on('click', '.btn-show-modal-edit', function() {
                let id = $(this).attr('data-id');
                $.ajax({
                    type: "GET",
                    url: `/access/permission/edit/${id}`,

                    success: function(response) {

                        $('#name_edit').val(response.result.name);
                    }
                });


                //jika simpan edit
                $('.btn-save-edit').click(function() {
                    saveEditData(id);
                });

                $('#edit-form-client').keypress(function(e) {
                    if (e.which === 13) {
                        e.preventDefault();
                        saveEditData(id);
                    }
                });

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
                            type: "DELETE",
                            url: `/access/permission/delete/${id}`,
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


        });
    </script>
@endsection
