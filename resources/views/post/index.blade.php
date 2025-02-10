@extends('layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span> {{ $title }}</h4>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @elseif(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Basic Bootstrap Table -->
        <div class="card">
            <h5 class="card-header">List {{ $title }}</h5>

            <div class="card-header d-flex justify-content-between align-items-center">
                <a href="/cms/post/create" class="btn btn-sm btn-primary"><i class='bx bxs-plus-circle text-white'></i> Buat
                    Post</a>
            </div>

            <div class="card-body">
                <div class="table-responsive text-nowrap py-2 px-2">
                    <table class="table table-striped dt-responsive nowrap py-1 px-1" id="myTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Status</th>
                                <th>Creator</th>
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
                ajax: "{{ url('/cms/post/getDataAjax') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'No',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'title',
                        name: 'Judul',
                        render: function(data, type, row) {
                            if (data) {
                                return data
                            } else {
                                return '-';
                            }
                        }
                    },
                    {
                        data: 'is_published',
                        name: 'Status',
                        render: function(data, type, row) {
                            if (data) {
                                return data
                            } else {
                                return '-';
                            }
                        }
                    },
                    {
                        data: 'created_by',
                        Nama: 'Nama Pembuat',
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
                            url: `/cms/post/delete/${id}`,
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


            $('body').on('click', '.btn-show-modal-publish', function() {
                let id = $(this).attr('data-id');

                var table = $('#myTable').DataTable();

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Mempublikasikan post dapat dibaca oleh kalangan public",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, publish!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: `/cms/post/publish/${id}`,
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire(
                                        'Published!',
                                        'Data telah berhasil dipublikasikan.',
                                        'success'
                                    );
                                    location.reload();
                                }
                            },
                            error: function(error) {
                                Swal.fire(
                                    'Gagal!',
                                    'Ada masalah saat mempublikasikan data.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });


            $('body').on('click', '.btn-show-modal-unpublish', function() {
                let id = $(this).attr('data-id');

                var table = $('#myTable').DataTable();

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Menarik publikasi post berdampak take down dari kalangan umum",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, take down!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: `/cms/post/unpublish/${id}`,
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire(
                                        'Unpublished!',
                                        'Data telah berhasil ditake down.',
                                        'success'
                                    );
                                    location.reload();
                                }
                            },
                            error: function(error) {
                                Swal.fire(
                                    'Gagal!',
                                    'Ada masalah saat take down data.',
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
