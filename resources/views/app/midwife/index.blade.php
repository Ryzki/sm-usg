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
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl d-flex flex-column justify-content-center">
            <div class="card p-3 mb-3">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <span class="avatar avatar-xl rounded">
                            {{ implode('', array_map(fn($part) => strtoupper(substr($part, 0, 1)), explode(' ', Auth::user()->full_name))) }}
                        </span>
                    </div>
                    <div class="col">
                        <h2 class="fw-bolder mb-1">{{ Auth::user()->full_name }}</h2>
                        <div class="penanggung-jawab">
                            <span class="btn btn-sm btn-pill btn-primary">
                                {{ Auth::user()->role->name }}
                            </span>
                        </div>
                        @if (Auth::user()->verified)
                            <div id="status">
                                <span class="status status-success mt-2 fs-6">
                                    <span class="status-dot status-dot-animated"></span>
                                    Verifikasi
                                </span>
                            </div>
                        @else
                            <div id="status">
                                <span class="status status-danger mt-2 fs-6">
                                    <span class="status-dot status-dot-animated"></span>
                                    Belum Terverifikasi
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card p-3 mb-3">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <span class="bg-azure text-white avatar">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                                <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                            </svg>
                        </span>
                    </div>
                    <div class="col">
                        <span class="fw-bolder fs-3">{{ $countUser }}</span>
                        <div class="text-secondary">
                            Ibu Hamil
                        </div>
                    </div>
                    <div class="col-auto">
                        <a aria-label="Create new report" class="btn btn-primary"
                            href="{{ route('midwife.control-users.index') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-search">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                <path d="M21 21l-6 -6"></path>
                            </svg>
                            Lihat
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
