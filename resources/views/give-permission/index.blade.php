@extends('layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span> {{ $title }}</h4>

        <!-- Basic Bootstrap Table -->
        <div class="card">
            <h5 class="card-header">List {{ $title }}</h5>

            <div class="card-body">
                <div class="table-responsive text-nowrap py-2 px-2">
                    <table class="table table-striped dt-responsive nowrap py-1 px-1" id="myTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
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
                ajax: "{{ url('/access/give-permission/getDataAjax') }}",
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


            // Edit
            function saveEditData(id) {
                let formData = new FormData($('#edit-form-client')[0]);

                var table = $('#myTable').DataTable();

                toggleButton('.btn-save-edit', true, 'Loading...');

                $.ajax({
                    url: `/access/give-permission/update`,
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
                    url: `/access/give-permission/edit/${id}`,

                    success: function(response) {

                        $('#permissions-table').html(response.view);

                        $("input[name='permission_collection[]']").each(function() {
                            const checkboxValue = $(this).val();
                            if (response.role_permissions.includes(checkboxValue)) {
                                $(this).prop('checked', true);
                            } else {
                                $(this).prop('checked', false);
                            }
                        });
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
