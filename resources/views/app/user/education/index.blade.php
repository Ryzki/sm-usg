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
            <div class="row">
                <div class="col-md-12 col-lg-6 mb-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="row g-2 align-items-center">
                                <div class="col-auto">
                                    <span class="avatar avatar-xl"
                                        style="background-image: url(https://cdn.dribbble.com/users/5461628/screenshots/15670259/media/13632f1af02f3ac6bcc6c3644478619c.jpg)"></span>
                                </div>
                                <div class="col">
                                    <h4 class="card-title m-0">
                                        <a href="{{ route('user.education.show', ['education' => 1]) }}"
                                            class="text-decoration-none">Pemeriksaan Kehamilan</a>
                                    </h4>
                                    <div class="text-secondary">
                                        Materi 1
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <a href="{{ route('user.education.show', ['education' => 1]) }}"
                                        class="btn btn-primary">
                                        Lihat Materi
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-6 mb-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="row g-2 align-items-center">
                                <div class="col-auto">
                                    <span class="avatar avatar-xl"
                                        style="background-image: url(https://cdn.dribbble.com/users/5461628/screenshots/15670259/media/13632f1af02f3ac6bcc6c3644478619c.jpg)"></span>
                                </div>
                                <div class="col">
                                    <h4 class="card-title m-0">
                                        <a href="{{ route('user.education.show', ['education' => 2]) }}"
                                            class="text-decoration-none">
                                            Perawatan Sehari Hari untuk Ibu Hamil
                                        </a>
                                    </h4>
                                    <div class="text-secondary">
                                        Materi 2
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <a href="{{ route('user.education.show', ['education' => 2]) }}"
                                        class="btn btn-primary">
                                        Lihat Materi
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-6 mb-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="row g-2 align-items-center">
                                <div class="col-auto">
                                    <span class="avatar avatar-xl"
                                        style="background-image: url(https://cdn.dribbble.com/users/5461628/screenshots/15670259/media/13632f1af02f3ac6bcc6c3644478619c.jpg)"></span>
                                </div>
                                <div class="col">
                                    <h4 class="card-title m-0">
                                        <a href="{{ route('user.education.show', ['education' => 3]) }}"
                                            class="text-decoration-none">
                                            Porsi Makan dan Minum untuk Kebutuhan Sehari
                                        </a>
                                    </h4>
                                    <div class="text-secondary">
                                        Materi 3
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <a href="{{ route('user.education.show', ['education' => 3]) }}"
                                        class="btn btn-primary">
                                        Lihat Materi
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-6 mb-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="row g-2 align-items-center">
                                <div class="col-auto">
                                    <span class="avatar avatar-xl"
                                        style="background-image: url(https://cdn.dribbble.com/users/5461628/screenshots/15670259/media/13632f1af02f3ac6bcc6c3644478619c.jpg)"></span>
                                </div>
                                <div class="col">
                                    <h4 class="card-title m-0">
                                        <a href="{{ route('user.education.show', ['education' => 4]) }}"
                                            class="text-decoration-none">
                                            Tanda Bahaya dan Masalah lain pada Ibu Hamil
                                        </a>
                                    </h4>
                                    <div class="text-secondary">
                                        Materi 4
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <a href="{{ route('user.education.show', ['education' => 4]) }}"
                                        class="btn btn-primary">
                                        Lihat Materi
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-6 mb-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="row g-2 align-items-center">
                                <div class="col-auto">
                                    <span class="avatar avatar-xl"
                                        style="background-image: url(https://cdn.dribbble.com/users/5461628/screenshots/15670259/media/13632f1af02f3ac6bcc6c3644478619c.jpg)"></span>
                                </div>
                                <div class="col">
                                    <h4 class="card-title m-0">
                                        <a href="{{ route('user.education.show', ['education' => 5]) }}"
                                            class="text-decoration-none">
                                            Persiapan Melahirkan (Bersalin)
                                        </a>
                                    </h4>
                                    <div class="text-secondary">
                                        Materi 5
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <a href="{{ route('user.education.show', ['education' => 5]) }}"
                                        class="btn btn-primary">
                                        Lihat Materi
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
