@extends('layouts.app.main')

@section('title', 'Detail')

@section('content')
    <div class="page-header">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-title">
                        {{ $detailVisit->name }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="card mb-2">
                <div class="card-header">
                    <h3 class="card-title">Detail Cek Kesehatan</h3>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col">
                            <div class="datagrid-item">
                                <div class="datagrid-title">
                                    Tanggal Berkunjung
                                </div>
                                <div class="datagrid-content">
                                    <strong>{{ $detailVisit->scheduleAncs->first()->formatted_schedule_date }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <div class="datagrid-item">
                                <div class="datagrid-title">
                                    Usia Janin
                                </div>
                                <div class="datagrid-content">
                                    <strong>{{ $detailVisit->historyAncs->first()->gestational_age }} Minggu</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="datagrid-item">
                                <div class="datagrid-title">
                                    Umur Ibu Hamil
                                </div>
                                <div class="datagrid-content">
                                    <strong>{{ $detailVisit->historyAncs->first()->age }} Tahun</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <div class="datagrid-item">
                                <div class="datagrid-title ">
                                    Berat Badan
                                </div>
                                <div class="datagrid-content ">
                                    <strong>{{ $detailVisit->historyAncs->first()->weight }} Kg</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="datagrid-item">
                                <div class="datagrid-title ">
                                    Tinggi Badan
                                </div>
                                <div class="datagrid-content ">
                                    <strong>{{ $detailVisit->historyAncs->first()->height }} cm</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <div class="datagrid-item">
                                <div class="datagrid-title ">
                                    Lingkar Lengan Badan
                                </div>
                                <div class="datagrid-content ">
                                    <strong>{{ $detailVisit->historyAncs->first()->lila }} cm</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="datagrid-item">
                                <div class="datagrid-title ">
                                    Tekanan Darah
                                </div>
                                <div class="datagrid-content ">
                                    <strong>{{ $detailVisit->historyAncs->first()->sistolik }} /
                                        {{ $detailVisit->historyAncs->first()->diastolik }} mmHg</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <div class="datagrid-item">
                                <div class="datagrid-title ">
                                    Lingkar Lengan Badan
                                </div>
                                <div class="datagrid-content ">
                                    <strong>{{ $detailVisit->historyAncs->first()->hemoglobin_level }} mg/dl</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="datagrid-item">
                                <div class="datagrid-title ">
                                    Tekanan Darah
                                </div>
                                <div class="datagrid-content ">
                                    <strong>{{ $detailVisit->historyAncs->first()->fetal_heartbeat }} bpm</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <div class="datagrid-item">
                                <div class="datagrid-title ">
                                    Tetanus Toxoid (TT)
                                </div>
                                <div class="datagrid-content ">
                                    <span
                                        class="status {{ $detailVisit->historyAncs->first()->tetanus_toxoid ? 'status-green' : 'status-danger' }}">
                                        {{ $detailVisit->historyAncs->first()->tetanus_toxoid ? 'Sudah' : 'Belum' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="datagrid-item">
                                <div class="datagrid-title ">
                                    Letak Posisi Janin
                                </div>
                                <div class="datagrid-content ">
                                    @if ($detailVisit->historyAncs->first()->fetal_position == 1)
                                        <strong>Posisi Kepala Di Bawah</strong>
                                    @elseif($detailVisit->historyAncs->first()->fetal_position == 2)
                                        <strong>Posisi Melintang</strong>
                                    @elseif($detailVisit->historyAncs->first()->fetal_position == 3)
                                        <strong>Posisi Sunsang</strong>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <div class="datagrid-item">
                                <div class="datagrid-title">
                                    Status Kesehatan Ibu Hamil
                                </div>
                                <div class="datagrid-content">
                                    <div class="col-auto">
                                        @if ($detailVisit->historyAncs->first()->stat_risk_pregnancy_of_ced)
                                            <span class="status status-danger mt-2 fs-6">
                                                <span class="status-dot status-dot-animated"></span>
                                                Resiko Kehamilan KEK
                                            </span>
                                        @endif
                                        @if ($detailVisit->historyAncs->first()->stat_risk_preeclamsia)
                                            <span class="status status-danger mt-2 fs-6">
                                                <span class="status-dot status-dot-animated"></span>
                                                Resiko Preklamsia
                                            </span>
                                        @endif
                                        @if ($detailVisit->historyAncs->first()->stat_risk_anemia)
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
                    <div class="row mb-3">
                        <div class="col">
                            <div class="datagrid-item">
                                <div class="datagrid-title">
                                    Catatan
                                </div>
                                @if ($detailVisit->historyAncs->first()->note)
                                    <p>{{ $detailVisit->historyAncs->first()->note }}</p>
                                @else
                                    <p>-</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if ($detailVisit->historyAncs->first()->usg_img)
                <div class="card mb-2">
                    <div class="card-header">
                        <h3 class="card-title">Hasil Cek USG</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="datagrid-title">
                                    Foto USG
                                </div>
                                <div class="datagrid-content">
                                    <a href="{{ asset('storage/usg/' . $detailVisit->historyAncs->first()->usg_img) }}"
                                        class="d-block glightbox" data-glightbox="gallery">
                                        <img src="{{ asset('storage/usg/' . $detailVisit->historyAncs->first()->usg_img) }}"
                                            class="img-fluid" alt="" style="max-width: 350px;">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="card mb-2">
                <div class="card-header">
                    <h3 class="card-title">Hasil Faktor Resiko Preklamsia</h3>
                </div>
                <table class="table table-vcenter card-table">
                    <thead>
                        <tr>
                            <th>Nama Kategori Preklamsia</th>
                            <th class="text-center">Kategori Resiko</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!$detailVisit->historyAncs->first()->listPreclamsiaScreen->isEmpty())
                            @foreach ($detailVisit->historyAncs->first()->listPreclamsiaScreen as $listPreclamsiaScreen)
                                <tr>
                                    <td class="fw-medium">
                                        {{ $listPreclamsiaScreen->preeclamsiaScreenings->screening_name }}</td>
                                    @if ($listPreclamsiaScreen->preeclamsiaScreenings->risk_category == 1)
                                        <td class="text-center"><span class="badge bg-yellow text-yellow-fg">Resiko
                                                Sedang</span></td>
                                    @elseif($listPreclamsiaScreen->preeclamsiaScreenings->risk_category == 2)
                                        <td class="text-center"><span class="badge bg-danger text-danger-fg">Resiko
                                                Tinggi</span></td>
                                    @endif
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="2" class="text-center fw-bold">Tidak ada hasil skreaning</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col">
                            <div class="datagrid-item">
                                <div class="datagrid-title">
                                    Status Faktor Resiko Preklamsia
                                </div>
                                <div class="datagrid-content">
                                    @if ($detailVisit->historyAncs->first()->stat_skrining_preklampsia === 1)
                                        <div class="col-auto">
                                            <div id="stat-health">
                                                <span class="status status-success mt-2 fs-6">
                                                    <span class="status-dot status-dot-animated"></span>
                                                    {{ $detailVisit->historyAncs->first()->stat_skrining_preklampsia_label }}
                                                </span>
                                            </div>
                                        </div>
                                    @elseif($detailVisit->historyAncs->first()->stat_skrining_preklampsia === 2)
                                        <div class="col-auto">
                                            <div id="stat-health">
                                                <span class="status status-warning mt-2 fs-6">
                                                    <span class="status-dot status-dot-animated"></span>
                                                    {{ $detailVisit->historyAncs->first()->stat_skrining_preklampsia_label }}
                                                </span>
                                            </div>
                                        </div>
                                    @elseif($detailVisit->historyAncs->first()->stat_skrining_preklampsia === 3)
                                        <div class="col-auto">
                                            <div id="stat-health">
                                                <span class="status status-danger mt-2 fs-6">
                                                    <span class="status-dot status-dot-animated"></span>
                                                    {{ $detailVisit->historyAncs->first()->stat_skrining_preklampsia_label }}
                                                </span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <div class="datagrid-item">
                                <div class="datagrid-title">
                                    Keterangan Faktor Resiko
                                </div>
                                <div class="datagrid-content">
                                    Ibu Hamil dilakukan <strong>Rujukan</strong> bila ditemukan sedikitnya
                                    <li class="mb-2">
                                        2 <span class="badge bg-yellow text-yellow-fg">Resiko Sedang</span> dan atau,
                                    </li>
                                    <li>
                                        1 <span class="badge bg-danger text-danger-fg">Resiko Tinggi</span>
                                    </li>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" rel="stylesheet">
@endpush

@push('script')
    <script src="https://cdn.jsdelivr.net/gh/mcstudios/glightbox/dist/js/glightbox.min.js"></script>
    <script>
        const lightbox = GLightbox({
            selector: '.glightbox'
        });
    </script>
@endpush
