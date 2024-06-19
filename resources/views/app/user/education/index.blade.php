@extends('layouts.app.main')

@section('title', 'Edukasi')

@section('content')
    <div class="page-header">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-title">Materi Ibu Hamil</div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            @if (session('message'))
                <div class="alert alert-important alert-warning alert-dismissible" role="alert">
                    <div class="d-flex">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path>
                                <path d="M12 8v4"></path>
                                <path d="M12 16h.01"></path>
                            </svg>
                        </div>
                        <div>
                            {{ session('message') }}
                        </div>
                    </div>
                    <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                </div>
            @endif

            <div class="row">
                @foreach ($educations as $education)
                    <div class="col-md-12 col-lg-6 mb-2">
                        <div class="card">
                            <div class="card-body">
                                <div class="row g-2 align-items-center">
                                    <div class="col-auto">
                                        <span class="avatar avatar-xl"
                                            style="background-image: url('{{ asset('storage/edu_thumb/' . $education->thumbnail) }}')"></span>
                                    </div>
                                    <div class="col">
                                        <h4 class="card-title m-0">
                                            <a href="{{ route('user.education.show', ['education' => $education->slug]) }}"
                                                class="text-decoration-none">{{ $education->title }}</a>
                                        </h4>
                                        <div class="text-secondary">
                                            {{ $education->category_id == 1 ? 'Edukasi' : 'Materi' }}
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <a href="{{ route('user.education.show', ['education' => $education->slug]) }}"
                                            class="btn btn-primary">
                                            Lihat Materi
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @if ($educations->hasPages())
                <div class="card">
                    <div class="card-body">
                        <div class="pagination justify-content-center">
                            {{ $educations->links('vendor.pagination.custom') }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
