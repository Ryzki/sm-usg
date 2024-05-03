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
                        @if (isset($midwife))
                            <tr>
                                <td data-label="Nama">
                                    <div class="d-flex py-1 align-items-center">
                                        <span class="avatar avatar-md me-2">
                                            {{ implode('', array_map(fn($part) => strtoupper(substr($part, 0, 1)), explode(' ', $midwife->full_name))) }}
                                        </span>
                                        <div class="flex-fill">
                                            <div class="font-weight-medium">{{ $midwife->full_name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td data-label="Profesi">
                                    <div>Bidan</div>
                                </td>
                                <td data-label="No Handphone">
                                    <div>
                                        {{ $midwife->formatted_phone }}
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-list flex-nowrap">
                                        <a class="btn btn-outline-success" href="https://wa.me/{{ $midwife->phone_number }}"
                                            target="_blank">
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
                        @endif
                        @if (isset($doctors))
                            @foreach ($doctors as $doctor)
                                <tr>
                                    <td data-label="Nama">
                                        <div class="d-flex py-1 align-items-center">
                                            <span class="avatar avatar-md me-2">
                                                {{ implode('', array_map(fn($part) => strtoupper(substr($part, 0, 1)), explode(' ', $doctor->full_name))) }}
                                            </span>
                                            <div class="flex-fill">
                                                <div class="font-weight-medium">{{ $doctor->full_name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td data-label="Profesi">
                                        <div>{{ $doctor->determine_role_from_full_name }}</div>
                                    </td>
                                    <td data-label="No Handphone">
                                        <div>{{ $doctor->formatted_phone }}</div>
                                    </td>
                                    <td>
                                        <div class="btn-list flex-nowrap">
                                            <a class="btn btn-outline-success"
                                                href="https://wa.me/{{ $doctor->phone_number }}" target="_blank">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
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
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
