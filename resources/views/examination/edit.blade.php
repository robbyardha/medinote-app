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

        <!-- Edit Form -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <a href="/exam/registration-examination" class="btn btn-sm color-slate-500 text-white"> <i
                        class='bx bx-arrow-back'></i>
                    Back</a>
            </div>
            <h5 class="card-header">Pemeriksaan Pasien - <b>{{ $patient->name }}</b></h5>


            <div class="card-body">
                <form method="POST" action="/exam/examination/create-examination" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="patient_id" class="form-label">{!! requiredFieldLabel('Pasien') !!}</label>
                        <input type="text" name="patient_name" id="patient_name" class="form-control"
                            value="{{ old('patient_name', $patient->name) }}" readonly>

                        <input type="hidden" name="patient_id" id="patient_id" class="form-control"
                            value="{{ old('patient_name', $patient->id) }}" readonly>

                        {{-- Dokter --}}
                        <input type="hidden" name="user_id" id="user_id" class="form-control"
                            value="{{ old('user_id', $appointment->user_id) }}" readonly>

                        {{-- Pendaftaran --}}
                        <input type="hidden" name="appointment_id" id="appointment_id" class="form-control"
                            value="{{ old('appointment_id', $appointment->id) }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="examination_date" class="form-label">{!! requiredFieldLabel('Tanggal Pemeriksaan') !!}</label>
                        <input type="text" class="form-control defaultDatePickrResponsiveWithTime"
                            name="examination_date" id="examination_date" required>
                    </div>

                    <div class="mb-3">
                        <label for="height" class="form-label">{!! requiredFieldLabel('Tinggi Badan (cm)') !!}</label>
                        <input type="number" step="0.01" class="form-control" name="height" id="height" required>
                        <span class="text-muted">Contoh: 170.5</span>
                    </div>

                    <div class="mb-3">
                        <label for="weight" class="form-label">{!! requiredFieldLabel('Berat Badan (kg)') !!}</label>
                        <input type="number" step="0.01" class="form-control" name="weight" id="weight" required>
                        <span class="text-muted">Contoh: 65.5</span>
                    </div>

                    <div class="mb-3">
                        <label for="systolic" class="form-label">{!! requiredFieldLabel('Tekanan Darah Sistolik (mmHg)') !!}</label>
                        <input type="number" class="form-control" name="systolic" id="systolic" required>
                        <span class="text-muted">Contoh: 120</span>
                    </div>

                    <div class="mb-3">
                        <label for="diastolic" class="form-label">{!! requiredFieldLabel('Tekanan Darah Diastolik (mmHg)') !!}</label>
                        <input type="number" class="form-control" name="diastolic" id="diastolic" required>
                        <span class="text-muted">Contoh: 80</span>
                    </div>

                    <div class="mb-3">
                        <label for="heart_rate" class="form-label">{!! requiredFieldLabel('Denyut Jantung (bpm)') !!}</label>
                        <input type="number" class="form-control" name="heart_rate" id="heart_rate" required>
                        <span class="text-muted">Contoh: 75</span>
                    </div>

                    <div class="mb-3">
                        <label for="respiration_rate" class="form-label">{!! requiredFieldLabel('Frekuensi Pernapasan (rpm)') !!}</label>
                        <input type="number" class="form-control" name="respiration_rate" id="respiration_rate"
                            required>
                        <span class="text-muted">Contoh: 16</span>
                    </div>

                    <div class="mb-3">
                        <label for="body_temperature" class="form-label">{!! requiredFieldLabel('Suhu Tubuh (°C)') !!}</label>
                        <input type="number" step="0.01" class="form-control" name="body_temperature"
                            id="body_temperature" required>
                        <span class="text-muted">Contoh: 36.5</span>
                    </div>


                    <div class="mb-3">
                        <label for="examination_results" class="form-label">{!! requiredFieldLabel('Hasil Pemeriksaan') !!}</label>
                        <textarea class="form-control" name="examination_results" id="editor" required></textarea>
                        @error('examination_results')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="file_upload" class="form-label">Upload File (Optional)</label>
                        <input type="file" class="form-control dropify" name="file_upload" id="file_upload">
                    </div>

                    <div class="mb-3">
                        <label for="medicines" class="form-label">{!! requiredFieldLabel('Obat yang Diberikan') !!}</label>

                        <div id="medicineFields">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="">Pilih Obat</label>
                                    <select class="form-control" name="medicines[0][medicine_id]" id="medicine_id_0"
                                        required onchange="fetchMedicinePrice(0)">
                                        <option value="">Pilih Obat</option>
                                        @foreach ($medicine['medicines'] as $med)
                                            <option value="{{ $med['id'] }}" data-name="{{ $med['name'] }}">
                                                {{ $med['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Dosis</label>
                                    <input type="text" name="medicines[0][dose]" class="form-control"
                                        placeholder="Dosis" required>
                                </div>
                                <div class="col-md-2">
                                    <label for="">Qty</label>
                                    <input type="number" name="medicines[0][qty]" class="form-control"
                                        placeholder="Qty" required>
                                </div>
                                <div class="col-md-2">
                                    <label for="">Harga Satuan</label>
                                    <input type="text" name="medicines[0][price]" class="form-control"
                                        placeholder="Harga" id="price_0" readonly>
                                </div>
                                <div class="col-md-2">
                                    <label for="">Nama Obat</label>
                                    <input type="text" name="medicines[0][medicine_name]" class="form-control"
                                        id="medicine_name_0" readonly>
                                </div>



                                <div class="col-md-2">
                                    <button type="button" class="btn btn-danger removeMedicine">Hapus</button>
                                </div>
                            </div>
                        </div>

                        <button type="button" class="btn btn-sm btn-info mt-2" id="addMedicineField">Tambah
                            Obat</button>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan Pemeriksaan</button>
                </form>

            </div>
        </div>
        <!--/ Edit Form -->

    </div>
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script>
        let medicineIndex = 1;

        function fetchMedicinePrice(index) {
            let medicineId = document.getElementById(`medicine_id_${index}`).value;

            // let medicinessss = @json($medicine['medicines']);
            // console.log(medicinessss);

            if (medicineId) {
                getMedicinePrice(medicineId, index);

                let selectedOption = document.querySelector(`#medicine_id_${index} option[value='${medicineId}']`);
                let medicineName = selectedOption ? selectedOption.getAttribute('data-name') : '';
                document.getElementById(`medicine_name_${index}`).value = medicineName;

            } else {
                document.getElementById(`price_${index}`).value = '';
                document.getElementById(`medicine_name_${index}`).value = '';
                // calculateTotalPrice(index);
            }
        }

        function getMedicinePrice(medicineId, index) {
            $.ajax({
                url: `/exam/examination/getMedicineDetail/${medicineId}`,
                type: 'GET',
                success: function(response) {
                    if (response.unit_price) {
                        document.getElementById(`price_${index}`).value = response.unit_price;
                        // calculateTotalPrice(index);
                    } else {
                        document.getElementById(`price_${index}`).value = 'Harga tidak tersedia';
                        // calculateTotalPrice(index);
                    }
                },
                error: function() {
                    document.getElementById(`price_${index}`).value = 'Terjadi kesalahan';
                    calculateTotalPrice(index);
                }
            });
        }

        function calculateTotalPrice(index) {
            let qty = parseFloat(document.getElementById(`medicines[${index}][qty]`).value) ||
                0;
            let price = parseFloat(document.getElementById(`medicines[${index}][price]`).value) ||
                0;

            let totalPrice = qty * price;

            document.getElementById(`medicines[${index}][total_price]`).value = totalPrice.toFixed(2);
        }



        document.getElementById('medicineFields').addEventListener('input', function(e) {
            if (e.target && (e.target.classList.contains('form-control') && (e.target.name.includes('qty') || e
                    .target.name.includes('price')))) {
                let index = e.target.name.split('[')[1].split(']')[0];
                calculateTotalPrice(index);
            }
        });



        document.getElementById('addMedicineField').addEventListener('click', function() {
            const medicineFieldHTML = `
                <div class="row mt-2">
                    <div class="col-md-3">
                        <label for="">Pilih Obat</label>
                        <select class="form-control" name="medicines[${medicineIndex}][medicine_id]" id="medicine_id_${medicineIndex}" required onchange="fetchMedicinePrice(${medicineIndex})">
                            <option value="">Pilih Obat</option>
                            @foreach ($medicine['medicines'] as $med)
                                <option value="{{ $med['id'] }}" data-name="{{ $med['name'] }}">{{ $med['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="">Dosis</label>
                        <input type="text" name="medicines[${medicineIndex}][dose]" class="form-control" placeholder="Dosis" required>
                    </div>
                    <div class="col-md-2">
                        <label for="">Qty</label>
                        <input type="number" name="medicines[${medicineIndex}][qty]" class="form-control" placeholder="Qty" id="qty_${medicineIndex}" required>
                    </div>

                    <div class="col-md-2">
                        <label for="">Harga Satuan</label>
                        <input type="text" name="medicines[${medicineIndex}][price]" class="form-control" placeholder="Harga" id="price_${medicineIndex}" readonly>
                    </div>
                   
                    <div class="col-md-2">
                        <label for="">Nama Obat</label>
                        <input type="text" name="medicines[${medicineIndex}][medicine_name]" class="form-control" placeholder="Nama Obat" id="medicine_name_${medicineIndex}" readonly>
                    </div>
                   

                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger removeMedicine">Hapus</button>
                    </div>
                </div>
            `;
            document.getElementById('medicineFields').insertAdjacentHTML('beforeend', medicineFieldHTML);
            medicineIndex++;
        });


        document.getElementById('medicineFields').addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('removeMedicine')) {
                e.target.closest('.row').remove();
            }
        });
    </script>
@endsection
