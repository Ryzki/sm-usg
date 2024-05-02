@extends('layouts.app.main')

@section('title', 'Jadwal ANC')

@section('content')
    <div class="page-header">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-title">Penjadwalan ANC</div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-cards">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between py-2">
                            <h3 class="card-title">Penjadwalan ANC</h3>
                            <a href="#" target="_blank" class="btn btn-outline-blue d-none d-sm-inline-block">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 5l0 14" />
                                    <path d="M5 12l14 0" />
                                </svg>
                                Tambah Jadwal
                            </a>
                            <button target="_blank" class="btn btn-blue d-sm-none">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 5l0 14" />
                                    <path d="M5 12l14 0" />
                                </svg>
                                Tambah
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row g-2 mb-3">
                        <form action="{{ route('midwife.schedule-users.index') }}" method="GET">
                            <div class="col">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control"
                                        placeholder="Cari by Nama, Kunjungan dan Tanggal"
                                        value="{{ request()->query('search') }}">
                                    <button type="submit" class="btn btn-icon" aria-label="Button">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                            <path d="M21 21l-6 -6"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card">
                        <table class="table table-vcenter table-mobile-md card-table" id="table-schedules">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Kunjungan</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Dibuat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($schedules as $schedule)
                                    <tr>
                                        <td data-label="Nama">
                                            <div class="d-flex py-1 align-items-center">
                                                <div class="flex-fill">
                                                    <div class="font-weight-medium">{{ $schedule->user->full_name }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-secondary" data-label="Kunjungan">
                                            <div>{{ $schedule->visit->name }}</div>
                                        </td>
                                        <td data-label="Tanggal">
                                            <div>
                                                {{ \Carbon\Carbon::parse($schedule->schedule_date)->translatedFormat('l, j F Y') }}
                                            </div>
                                        </td>
                                        <td data-label="Status">
                                            @if ($schedule->status === 1)
                                                <span class="status status-success mt-2 fs-6">
                                                    <span class="status-dot status-dot-animated"></span>
                                                    Sudah Berkunjung
                                                </span>
                                            @else
                                                <span class="status status-danger mt-2 fs-6">
                                                    <span class="status-dot status-dot-animated"></span>
                                                    Belum Berkunjung
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-secondary" data-label="Dibuat">
                                            {{ \Carbon\Carbon::parse($schedule->created_at)->diffForHumans() }}
                                        </td>
                                        <td data-label="Aksi">
                                            @if ($schedule->status === 1)
                                                -
                                            @else
                                                <button class="btn btn-danger" id="btnDelete">
                                                    Hapus
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($schedules->lastPage() > 1)
                    <div class="card align-items-center mt-2">
                        <ul class="pagination mt-3">
                            {{ $schedules->links('vendor.pagination.custom') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('styles')
@endpush

@push('script')
    <script src="https://cdn.datatables.net/v/bs5/dt-2.0.2/datatables.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.2/js/dataTables.bootstrap5.js"></script>
@endpush
