<script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
<script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

<script src="{{ asset('assets/vendor/js/menu.js') }}"></script>
<!-- endbuild -->

<!-- Vendors JS -->
<script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>

<!-- Main JS -->
<script src="{{ asset('assets/js/main.js') }}"></script>

<!-- DATATABLES -->
<script src="{{ asset('assets/vendor/libs/datatables/bs5/jquery-3.5.1.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/datatables/bs5/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/datatables/bs5/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/datatables/bs5/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/datatables/bs5/responsive.bootstrap5.min.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/datatablesRowGroup/dataTables.rowGroup.min.js') }}"></script>

<!-- SELECT2 -->
<script src="{{ asset('assets/vendor/libs/select2/js/select2.full.min.js') }}"></script>

<!-- FLATPICKR -->
<script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.min.js') }}"></script>

<!-- DROPIFY -->
<script src="{{ asset('assets/vendor/libs/dropify/js/dropify.js') }}"></script>

<!-- CKEDITOR -->
<script src="{{ asset('assets/vendor/libs/ckeditor/ckeditor.js') }}"></script>

{{-- SWEET ALERT --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Page JS -->
<script src="{{ asset('assets/js/dashboards-analytics.js') }}"></script>

<script async defer src="https://buttons.github.io/buttons.js"></script>

<script>
    function toggleButton(buttonId, disable, buttonText) {
        var button = $(buttonId);
        var spinner = button.find('.spinner-border');

        if (disable) {
            button.prop('disabled', true);
            spinner.removeClass('d-none');
            button.text(buttonText);
        } else {
            button.prop('disabled', false);
            spinner.addClass('d-none');
            button.text(buttonText);
        }
    }
</script>

<script>
    $(document).ready(function() {
        $('.select2').select2();
        $('.select2-multiple').select2();
        $('.select2-tambah-modal').select2({
            dropdownParent: $('#tambah_modal'),
        })
        $('.select2-ubah-modal').select2({
            dropdownParent: $('#ubah_modal'),
        })
        $('.select2-cari-modal').select2({
            dropdownParent: $('#cari_modal'),
        })
        $('.select2-multiple-disabled').select2({
            disabled: true
        });
        $('#mySelect2Modal').select2({
            dropdownParent: $('#myModalSelect2')
        });
        $('.select22').select2({
            dropdownParent: $('#exampleModal')
        });


        $('.modal').on('shown.bs.modal', function() {
            $(this).find('.dateTimePickr').flatpickr({
                enableTime: true,
                dateFormat: "Y-m-d H:i:s",
                disableMobile: true
            });
        });

        $(".dateTimePickrForm").flatpickr({
            enableTime: false,
            dateFormat: "Y-m-d",
            disableMobile: true,
            maxDate: "today"
        })

        $(".dateTimePickrForm2").flatpickr({
            enableTime: false,
            dateFormat: "Y-m-d",
            disableMobile: true,
        })

        $(".timePickrForm").flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
        })

        $(".datePickerWithDefault").flatpickr({
            enableTime: false,
            dateFormat: "Y-m-d",
            maxDate: "today",
            defaultDate: new Date().toISOString().split('T')[0],
        });

        $(".defaultDatePickrResponsive").flatpickr({
            enableTime: false,
            dateFormat: "Y-m-d",
            disableMobile: false
        })
        $(".defaultDatePickrResponsiveWithTime").flatpickr({
            enableTime: true,
            dateFormat: "Y-m-d H:i:s",
            disableMobile: false,
            defaultDate: new Date().toISOString().slice(0, 19).replace('T', ' '),
        })


        $('.dropify').dropify({
            messages: {
                'default': 'Letakkan file disini atau klik untuk memilih file yang diupload',
                'replace': 'Letakkan file disini atau klik untuk mengganti file',
                'remove': 'Hapus',
                'error': 'Ooops, something wrong appended.'
            },
            error: {
                'fileSize': 'File terlalu besar (3 Mb max).'
            }
        });


        if ($("#quote").length) {

            $.ajax({
                type: "GET",
                url: "https://katanime.vercel.app/api/getrandom",
                dataType: "json",
                success: function(response) {

                    if (response.sukses) {

                        $("#quote").html(response.result[0].english)

                    }

                }
            });
        }


        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        CKEDITOR.replace('editor', {
            height: 700,

            filebrowserUploadUrl: '{{ route('ckeditor.upload') }}',
            filebrowserUploadMethod: 'form',
            extraPlugins: 'uploadimage',
            uploadUrl: '{{ route('ckeditor.upload') }}',
            filebrowserUploadParams: {
                _token: '{{ csrf_token() }}'
            },
            filebrowserImageUploadUrl: '{{ route('ckeditor.upload') }}',
            imageUploadUrl: '{{ route('ckeditor.upload') }}',
        });


        $('#menu-select').select2({
            placeholder: 'Pilih Menu',
            ajax: {
                url: '{{ route('menus.select2') }}',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term,
                        page: params.page || 1
                    };
                },
                processResults: function(data, params) {
                    params.page = params.page || 1;
                    return {
                        results: data.results,
                        pagination: {
                            more: data.pagination.more
                        }
                    };
                },
                cache: true
            },
        });

        $('#patient-select').select2({
            placeholder: 'Pilih Pasien',
            ajax: {
                url: '{{ route('patients.select2') }}',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term,
                        page: params.page || 1
                    };
                },
                processResults: function(data, params) {
                    params.page = params.page || 1;
                    return {
                        results: data.results,
                        pagination: {
                            more: data.pagination.more
                        }
                    };
                },
                cache: true
            },
        });

        $('#doctor-select').select2({
            placeholder: 'Pilih Dokter',
            ajax: {
                url: '{{ route('doctors.select2') }}',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term,
                        page: params.page || 1
                    };
                },
                processResults: function(data, params) {
                    params.page = params.page || 1;
                    return {
                        results: data.results,
                        pagination: {
                            more: data.pagination.more
                        }
                    };
                },
                cache: true
            },
        });

        $('#add_modal').on('shown.bs.modal', function() {
            setTimeout(function() {
                $('#menu-select-modal').select2({
                    placeholder: 'Pilih Menu',
                    ajax: {
                        url: '{{ route('menus.select2') }}',
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                q: params.term,
                                page: params.page || 1
                            };
                        },
                        processResults: function(data, params) {
                            params.page = params.page || 1;
                            return {
                                results: data.results,
                                pagination: {
                                    more: data.pagination.more
                                }
                            };
                        },
                        cache: true
                    },
                });
            }, 100);
        });


        $('#tags').select2({
            placeholder: "Pilih tag",
            allowClear: true
        });


    });
</script>
