@extends('layouts.app.main')

@section('title', 'Konsultasi')

@section('content')
    <div class="page-header">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-title">Konsultasi</div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl d-flex flex-column justify-content-center">
            <div class="row g-2 mb-3">
                <div class="col">
                    <input type="text" class="form-control" placeholder="Search by name...">
                </div>
                <div class="col-auto">
                    <a href="#" class="btn btn-icon" aria-label="Button">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                            <path d="M21 21l-6 -6"></path>
                        </svg>
                    </a>
                </div>
            </div>
            <div class="card">
                <table class="table table-vcenter table-mobile-md card-table">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Profesi</th>
                            <th>No Handphone</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td data-label="Nama">
                                <div class="d-flex py-1 align-items-center">
                                    <span class="avatar avatar-md me-2">
                                        BA
                                    </span>
                                    <div class="flex-fill">
                                        <div class="font-weight-medium">Bidan Aning</div>
                                    </div>
                                </div>
                            </td>
                            <td data-label="Profesi">
                                <div>Bidan</div>
                            </td>
                            <td data-label="No Handphone">
                                <div>08138483973</div>
                            </td>
                            <td>
                                <div class="btn-list flex-nowrap">
                                    <a class="btn btn-outline-success" href="https://wa.me/628123456789">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-send">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M10 14l11 -11" />
                                            <path
                                                d="M21 3l-6.5 18a.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a.55 .55 0 0 1 0 -1l18 -6.5" />
                                        </svg>
                                        Chat
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td data-label="Nama">
                                <div class="d-flex py-1 align-items-center">
                                    <span class="avatar avatar-md me-2">
                                        AW
                                    </span>
                                    <div class="flex-fill">
                                        <div class="font-weight-medium">Dr. Anis Witaniasih</div>
                                    </div>
                                </div>
                            </td>
                            <td data-label="Profesi">
                                <div>Dokter Gigi</div>
                            </td>
                            <td data-label="No Handphone">
                                <div>081234567891</div>
                            </td>
                            <td>
                                <div class="btn-list flex-nowrap">
                                    <a class="btn btn-outline-success" href="https://wa.me/628123456789">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-send">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M10 14l11 -11" />
                                            <path
                                                d="M21 3l-6.5 18a.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a.55 .55 0 0 1 0 -1l18 -6.5" />
                                        </svg>
                                        Chat
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td data-label="Nama">
                                <div class="d-flex py-1 align-items-center">
                                    <span class="avatar avatar-md me-2">
                                        SW
                                    </span>
                                    <div class="flex-fill">
                                        <div class="font-weight-medium">Dr. Roro Widiowati</div>
                                    </div>
                                </div>
                            </td>
                            <td data-label="Profesi">
                                <div>Ahli Gizi</div>
                            </td>
                            <td data-label="No Handphone">
                                <div>08127273291</div>
                            </td>
                            <td>
                                <div class="btn-list flex-nowrap">
                                    <a class="btn btn-outline-success" href="https://wa.me/628123456789">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-send">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M10 14l11 -11" />
                                            <path
                                                d="M21 3l-6.5 18a.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a.55 .55 0 0 1 0 -1l18 -6.5" />
                                        </svg>
                                        Chat
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td data-label="Nama">
                                <div class="d-flex py-1 align-items-center">
                                    <span class="avatar avatar-md me-2">
                                        DS
                                    </span>
                                    <div class="flex-fill">
                                        <div class="font-weight-medium">Dr. Sutrisno</div>
                                    </div>
                                </div>
                            </td>
                            <td data-label="Profesi">
                                <div>Dokter Umum</div>
                            </td>
                            <td data-label="No Handphone">
                                <div>08197397291</div>
                            </td>
                            <td>
                                <div class="btn-list flex-nowrap">
                                    <a class="btn btn-outline-success" href="https://wa.me/628123456789">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-send">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M10 14l11 -11" />
                                            <path
                                                d="M21 3l-6.5 18a.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a.55 .55 0 0 1 0 -1l18 -6.5" />
                                        </svg>
                                        Chat
                                    </a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
