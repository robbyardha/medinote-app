@extends('public-blog.layouts.main-landing')

@section('content')
    <!-- Hero Section -->
    <section id="hero" class="hero section">

        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row align-items-center">
                <div class="row">
                    @if ($dataMedicine['message'] == 'OK')
                        <div class="alert alert-success" role="alert">
                            <i class="bi bi-info-circle"></i> Informasi Harga Obat Tersedia
                        </div>
                    @else
                        <div class="alert alert-warning" role="alert">
                            <i class="bi bi-exclamation-triangle"></i> Silahkan konfigurasi aplikasi terlebih dahulu di
                            pengaturan.
                        </div>
                    @endif
                </div>
            </div>

            <div class="row stats-row gy-4 mt-5" data-aos="fade-up" data-aos-delay="500">
                @if ($dataMedicine['message'] == 'OK')
                    @foreach ($dataMedicine['med']['medicines'] as $med)
                        <div class="col-md-4">
                            <div class="card shadow-lg border-light rounded-3">
                                <div class="card-body">
                                    <h5 class="card-title text-center text-uppercase font-weight-bold mb-3">
                                        {{ $med['name'] }}
                                    </h5>

                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <span class="badge bg-primary text-white px-3 py-2 rounded-pill">Obat</span>
                                        <span class="badge bg-info text-white px-3 py-2 rounded-pill">Stok Tersedia</span>
                                    </div>

                                    @if ($med['valid_price'] !== null)
                                        <div class="text-center">
                                            <h4 class="text-success">
                                                Harga:
                                                <strong>Rp. {{ number_format($med['valid_price'], 0, ',', '.') }}</strong>
                                            </h4>
                                        </div>
                                    @else
                                        <div class="text-center">
                                            <h5 class="text-danger">Harga Tidak Tersedia</h5>
                                        </div>
                                    @endif

                                    <div class="text-center mt-4">
                                        <button class="btn btn-outline-primary w-100"
                                            onclick="showMedicineDetail({{ json_encode($med) }})">
                                            Lihat Detail
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

        </div>

    </section>

    <script>
        function showMedicineDetail(med) {
            let validPriceText = med.valid_price ?
                `<span class="text-success">${new Intl.NumberFormat().format(med.valid_price)}</span>` :
                '<span class="text-danger">Harga Tidak Tersedia</span>';

            Swal.fire({
                title: `${med.name} - Detail`,
                html: `
                    <p><strong>Nama Obat:</strong> ${med.name}</p>
                    <p><strong>Deskripsi:</strong> <em>${med.description || 'Tidak ada deskripsi'}</em></p>
                    <p><strong>Kategori:</strong> ${med.category || 'N/A'}</p>
                    <p><strong>Harga Valid:</strong>Rp. ${validPriceText}</p>
                `,
                icon: 'info',
                confirmButtonText: 'Tutup',
                customClass: {
                    popup: 'border-radius-10'
                }
            });
        }
    </script>
@endsection
