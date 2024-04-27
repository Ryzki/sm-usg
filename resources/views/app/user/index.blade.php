@extends('layouts.app.main')

@section('title', 'Dashboard')

@section('content')
    <div class="page-header">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">Home</div>
                    <div class="page-title">Dashboard</div>
                </div>
                <div class="col-auto ms-auto">
                    <div class="btn-list">
                        <!-- Menyetting Hari Pertama Haid Terakhir -->
                        @if (!isset($pregnantHistoryFormatted))
                            <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal"
                                data-bs-target="#modal-hpht">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M12 5l0 14"></path>
                                    <path d="M5 12l14 0"></path>
                                </svg>
                                Setting HPHT
                            </a>
                            <a href="#" class="btn btn-primary d-sm-none " data-bs-toggle="modal"
                                data-bs-target="#modal-hpht">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M12 5l0 14"></path>
                                    <path d="M5 12l14 0"></path>
                                </svg>
                                HPHT
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            @if (session()->has('success'))
                <div class="row">
                    <div class="alert alert-important alert-success alert-dismissible" role="alert">
                        <div class="d-flex">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24"
                                    height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M5 12l5 5l10 -10"></path>
                                </svg>
                            </div>
                            <div>
                                {{ session('success') }}
                            </div>
                        </div>
                        <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                    </div>
                </div>
            @endif
            <div class="card p-3 mb-3">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <!-- Jika sudah ada gambar -->
                        {{-- <span class="avatar avatar-xl rounded"
                            style="background-image: url('../assets/static/avatars/000f.jpg');"></span> --}}
                        <!-- Jika belum ada gambar -->
                        <span class="avatar avatar-xl rounded">
                            {{ implode('', array_map(fn($part) => strtoupper(substr($part, 0, 1)), explode(' ', Auth::user()->full_name))) }}
                        </span>
                    </div>
                    <div class="col">
                        <h3 class="fw-bolder mb-1">{{ $user->full_name }}</h3>
                        @if ($user->midwife->full_name)
                            <!-- Jika Sudah ada Dokter PJ -->
                            <div class="penanggung-jawab">
                                <a href="#">
                                    <span class="btn btn-sm btn-pill btn-primary">
                                        Bidan {{ $user->midwife->full_name }}
                                    </span>
                                </a>
                            </div>
                        @else
                            <!-- Jika Belum ada Dokter PJ -->
                            <div class="penanggung-jawab">
                                <a href="#">
                                    <span class="btn btn-sm btn-pill btn-danger">
                                        Belum ditentukan
                                    </span>
                                </a>
                            </div>
                        @endif
                        <div id="stat-verified">
                            @if ($user->verified)
                                <!-- Jika Sudah verifikasi -->
                                <div id="status">
                                    <span class="status status-success mt-2 fs-6">
                                        <span class="status-dot status-dot-animated"></span>
                                        Verifikasi
                                    </span>
                                </div>
                            @else
                                <div id="status">
                                    <!-- Jika Belum verifikasi -->
                                    <span class="status status-danger mt-2 fs-6">
                                        <span class="status-dot status-dot-animated"></span>
                                        Belum Terverifikasi
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-auto">
                        <!-- Jika sudah ada Dokternya atau sudah verifikasi muncul tanda chat ini -->
                        <a href="https://wa.me/{{ $user->midwife->phone_number }}" target="_blank"
                            class="btn btn-outline-blue d-none d-sm-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-user-scan">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M10 9a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                <path d="M4 8v-2a2 2 0 0 1 2 -2h2" />
                                <path d="M4 16v2a2 2 0 0 0 2 2h2" />
                                <path d="M16 4h2a2 2 0 0 1 2 2v2" />
                                <path d="M16 20h2a2 2 0 0 0 2 -2v-2" />
                                <path d="M8 16a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2" />
                            </svg>
                            Konsultasi
                        </a>
                        <a href="https://wa.me/{{ $user->midwife->phone_number }}" target="_blank"
                            class="btn btn-icon btn-outline-blue d-sm-none">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-message">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M8 9h8" />
                                <path d="M8 13h6" />
                                <path
                                    d="M18 4a3 3 0 0 1 3 3v8a3 3 0 0 1 -3 3h-5l-5 3v-3h-2a3 3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3h12z" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card p-3 mb-3">
                <h5 class="card-title fw-bolder">STATUS KESEHATAN IBU HAMIL</h5>
                <div class="row">
                    <div class="col">
                        <div class="datagrid-item">
                            <div class="datagrid-content">
                                @if ($conditionUser && $conditionUser->stat_skrining_preklampsia === 1)
                                    <span class="status status-success mt-2 fs-6">
                                        <span class="status-dot status-dot-animated"></span>
                                        {{ $conditionUser->stat_skrining_preklampsia_label }}
                                    </span>
                                @elseif ($conditionUser && $conditionUser->stat_skrining_preklampsia === 2)
                                    <span class="status status-warning mt-2 fs-6">
                                        <span class="status-dot status-dot-animated"></span>
                                        {{ $conditionUser->stat_skrining_preklampsia_label }}
                                    </span>
                                @elseif ($conditionUser && $conditionUser->stat_skrining_preklampsia === 3)
                                    <span class="status status-danger mt-2 fs-6">
                                        <span class="status-dot status-dot-animated"></span>
                                        {{ $conditionUser->stat_skrining_preklampsia_label }}
                                    </span>
                                @elseif(empty($conditionUser))
                                    <span class="status status-success mt-2 fs-6">
                                        <span class="status-dot status-dot-animated"></span>
                                        Sehat
                                    </span>
                                @endif

                                @if ($conditionUser && $conditionUser->stat_risk_pregnancy_of_ced)
                                    <span class="status status-danger mt-2 fs-6">
                                        <span class="status-dot status-dot-animated"></span>
                                        Resiko Kehamilan KEK
                                    </span>
                                @endif

                                @if ($conditionUser && $conditionUser->stat_risk_preeclamsia)
                                    <span class="status status-danger mt-2 fs-6">
                                        <span class="status-dot status-dot-animated"></span>
                                        Resiko Preklamsia
                                    </span>
                                @endif

                                @if ($conditionUser && $conditionUser->stat_risk_anemia)
                                    <span class="status status-danger mt-2 fs-6">
                                        <span class="status-dot status-dot-animated"></span>
                                        Resiko Anemia
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card p-3 mb-3">
                <h5 class="card-title fw-bolder">INFORMASI KEHAMILAN</h5>
                <div class="row">
                    <div class="col">
                        <div class="datagrid-item">
                            <div class="datagrid-title">
                                Usia Kehamilan saat ini
                            </div>
                            @if (!empty($gestationalAge))
                                <div class="datagrid-content">
                                    <strong>{{ $gestationalAge }}</strong>
                                </div>
                            @else
                                <div class="datagrid-content">
                                    <strong>-</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col">
                        <div class="datagrid-item">
                            <div class="datagrid-title text-end">
                                Perkiraan Persalinan
                            </div>
                            @if (!empty($pregnantHistoryFormatted))
                                <div class="datagrid-content text-end">
                                    <strong>{{ $pregnantHistoryFormatted }}</strong>
                                </div>
                            @else
                                <div class="datagrid-content text-end">
                                    <strong>-</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="card p-3 mb-3">
                <h5 class="card-title fw-bolder">KUNJUNGAN ANC</h5>
                @if (isset($scheduleUser))
                    <div class="row">
                        <div class="col-12 mb-2">
                            <div class="card {{ $scheduleUser->status == 0 ? 'bg-primary-lt' : 'bg-success-lt' }}">
                                <div class="card-body">
                                    <div class="datagrid-title">
                                        {{ $scheduleUser->visit->name }}
                                    </div>
                                    <div class="datagrid-content mb-3">
                                        <strong>
                                            {{ \Carbon\Carbon::parse($scheduleUser->schedule_date)->format('d F Y') }}
                                        </strong>
                                    </div>
                                    <div class="text-right">
                                        @if ($scheduleUser->status == 0)
                                            <a class="btn btn-primary"
                                                href="{{ route('user.check-anc.create', ['name_anc' => $scheduleUser->visit->abbreviation, 'schedule_date' => $scheduleUser->schedule_date->format('d-m-Y')]) }}">
                                                Masuk
                                            </a>
                                        @elseif($scheduleUser->status == 1)
                                            <a class="btn btn-success"
                                                href="{{ route('user.check-anc.show', ['name_anc' => $scheduleUser->visit->abbreviation, 'schedule_date' => $scheduleUser->schedule_date->format('d-m-Y')]) }}">
                                                Detail
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="row">
                        <div class="col-12 mb-2">
                            <div class="card bg-muted-lt">
                                <div class="card-body">
                                    <div class="datagrid-title">
                                        Tidak Ada Jadwal Kunjungan
                                    </div>
                                    <div class="datagrid-content mb-3">
                                        <strong>-</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="card p-3 mb-3">
                <h5 class="card-title fw-bold">RIWAYAT MINUM TTD</h5>
                @if (!isset($permissionBloodSupplement))
                    <div class="row mb-2">
                        <div class="card card-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <span class="bg-primary text-white avatar">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-pill">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M4.5 12.5l8 -8a4.94 4.94 0 0 1 7 7l-8 8a4.94 4.94 0 0 1 -7 -7">
                                                </path>
                                                <path d="M8.5 8.5l7 7"></path>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="col">
                                        <div class="font-weight-medium">
                                            30x (Minum Obat Tambah Darah)
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="card card-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <span class="bg-danger text-white avatar">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-pill">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M4.5 12.5l8 -8a4.94 4.94 0 0 1 7 7l-8 8a4.94 4.94 0 0 1 -7 -7">
                                                </path>
                                                <path d="M8.5 8.5l7 7"></path>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="col">
                                        <div class="font-weight-medium">
                                            5x (Terlewat Minum Obat)
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="alert alert-warning" role="alert">
                        <div class="d-flex">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24"
                                    height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M12 9v4"></path>
                                    <path
                                        d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.871h16.214a1.914 1.914 0 0 0 1.636 -2.87l-8.106 -13.536a1.914 1.914 0 0 0 -3.274 0z">
                                    </path>
                                    <path d="M12 16h.01"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="alert-title">Fitur ini di Non-Aktifkan Sementara</h4>
                                <div class="text-secondary">
                                    <p>Fitur akan Aktif ketika <strong>Usia Kandungan > 16 Minggu</strong>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
    <div class="modal modal-blur fade" id="modal-hpht">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Seting HPHT</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mt-1">
                        <label class="form-label">Hari Pertama Haid Terakhir</label>
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Pilih Tanggal" id="setHPHT">
                        <span class="input-group-text">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z">
                                </path>
                                <path d="M16 3v4"></path>
                                <path d="M8 3v4"></path>
                                <path d="M4 11h16"></path>
                                <path d="M11 15h1"></path>
                                <path d="M12 15v3"></path>
                            </svg>
                        </span>
                    </div>
                    <div class="mt-3">
                        <label class="form-label">Hari Perkiraan Lahir</label>
                    </div>
                    <div class="input-group">
                        <input class="form-control" placeholder="Pilih Tanggal" id="estimatedDue">
                        <span class="input-group-text">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z">
                                </path>
                                <path d="M16 3v4"></path>
                                <path d="M8 3v4"></path>
                                <path d="M4 11h16"></path>
                                <path d="M11 15h1"></path>
                                <path d="M12 15v3"></path>
                            </svg>
                        </span>
                    </div>
                    <span class="form-hint">
                        * Sistem otomatis mengisi <strong>Perkiraan Lahir</strong> referensi perhitungan dari <strong>Rumus
                            Neagele</strong>.Anda juga bisa mengubahnya sesuai dengan saran tenaga kesehatan.
                    </span>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-primary ms-auto" id="btnSave">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M12 5l0 14"></path>
                            <path d="M5 12l14 0"></path>
                        </svg>
                        Simpan
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="/assets/main/css/libs/bootstrap-datepicker3.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.7/dist/sweetalert2.min.css">
@endpush

@push('script')
    <script src="/assets/main/js/libs/datepicker/bootstrap-datepicker.min.js"></script>
    <script src="/assets/main/js/libs/datepicker/locale/bootstrap-datepicker.id.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.7/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#setHPHT').datepicker({
                language: "id",
                clearBtn: true
            });

            $('#estimatedDue').datepicker({
                language: "id",
                clearBtn: true
            });

            $('#setHPHT').on('change', function(e) {
                var tanggalHaidTerakhir = $(this).val();
                var tanggalPerkiraan = perkiraanTanggalLahir(tanggalHaidTerakhir);
                $('#estimatedDue').val(tanggalPerkiraan);
            });

            $('#btnSave').on('click', function(e) {
                e.preventDefault();

                $('input').removeClass('is-invalid');
                $('.custon-invalid-feedback').remove();

                const data = {
                    'idUser': {{ Auth::user()->id }},
                    'setHPHT': $('#setHPHT').val(),
                    'estimatedDue': $('#estimatedDue').val()
                }

                $.ajax({
                    type: "POST",
                    url: "{{ route('user.create-hpht') }}",
                    data: data,
                    dataType: "JSON",
                    success: function(response) {
                        if (response.status) {
                            $('#modal-hpht').hide();
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: response.message,
                                showConfirmButton: false,
                                timer: 1500
                            }).then(function() {
                                // Setelah pengguna menutup pesan sukses, memperbarui nilai input
                                $('#setHPHT').val('');
                                $('#estimatedDue').val('');
                                // Kemudian reload halaman
                                location.reload();
                            });
                        } else {
                            $('#modal-hpht').hide();

                            Swal.fire({
                                position: 'center',
                                icon: 'error',
                                title: response.message,
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        var response = xhr.responseJSON.errors
                        if (response.setHPHT) {
                            $('#setHPHT').addClass('is-invalid');

                            var invalidFeedback =
                                '<div class="custon-invalid-feedback text-danger d-block mb-2"><small>' +
                                response.setHPHT[0] + '</small></div>';
                            $('#setHPHT').closest('.input-group').after(invalidFeedback);
                        }
                        if (response.estimatedDue) {
                            $('#estimatedDue').addClass('is-invalid');

                            var invalidFeedback =
                                '<div class="custon-invalid-feedback text-danger d-block mb-2"><small>' +
                                response.estimatedDue[0] + '</small></div>';
                            $('#estimatedDue').closest('.input-group').after(invalidFeedback);
                        }
                    }
                });
            });

            function perkiraanTanggalLahir(tanggalHaidTerakhir) {
                // Memisahkan tanggal, bulan, dan tahun dari string input
                var tanggalBulanTahun = tanggalHaidTerakhir.split("-");
                var tanggal = parseInt(tanggalBulanTahun[0]);
                var bulan = parseInt(tanggalBulanTahun[1]);
                var tahun = parseInt(tanggalBulanTahun[2]);

                // Menambahkan 7 hari
                var tanggalHPL = tanggal + 7;
                // Mengurangi 3 bulan
                var bulanHPL = bulan - 3;
                // Menambahkan 1 tahun
                var tahunHPL = tahun + 1;

                // Jika bulan HPL menjadi 0 atau negatif, kurangkan 1 tahun dan tambahkan 12 bulan
                if (bulanHPL <= 0) {
                    tahunHPL--;
                    bulanHPL += 12;
                }

                // Jika tanggal HPL lebih dari jumlah hari dalam bulan yang dipilih, atur tanggal dan bulan yang sesuai
                var maxTanggal = new Date(tahunHPL, bulanHPL, 0).getDate();
                if (tanggalHPL > maxTanggal) {
                    tanggalHPL -= maxTanggal;
                    bulanHPL++;
                    if (bulanHPL > 12) {
                        bulanHPL = 1;
                        tahunHPL++;
                    }
                }

                // Mengembalikan tanggal perkiraan lahir dalam format yang sesuai
                return ('0' + tanggalHPL).slice(-2) + '-' + ('0' + bulanHPL).slice(-2) + '-' + tahunHPL;
            }
        });
    </script>
@endpush
