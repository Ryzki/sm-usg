@extends('layouts.app.main')

@section('title', 'Edukasi')

@section('content')
    <div class="page-header">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-title">Edukasi Ibu Hamil</div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">{{ $education->title }}</div>
                </div>
                <div class="card-body p-0">
                    <a href="{{ asset('storage/edu_content/' . $education->content_img) }}" class="d-block glightbox"
                        data-glightbox="gallery">
                        <img src="{{ asset('storage/edu_content/' . $education->content_img) }}" class="img-fluid"
                            alt="">
                    </a>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-6">
                            <a href="{{ route('user.education.index') }}" class="btn btn-danger">Kembali</a>
                        </div>
                        <div class="col-6 text-end">
                            <button class="btn btn-primary" id="btnConfirm">
                                Ya, Saya sudah paham
                            </button>
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
        $(document).ready(function() {
            const lightbox = GLightbox({
                selector: '.glightbox'
            });

            // $('#btnConfirm').on('click', function(e) {
            //     e.preventDefault();
            //     const slug = '{{ $education->slug }}';
            //     const url = "{{ route('user.education.confirmTask', ':slug') }}".replace(':slug',
            //         slug);
            //     const data = {
            //         'slug': '{{ $education->slug }}'
            //     }

            //     $.ajax({
            //         url: url,
            //         type: "POST",
            //         data: data,
            //         dataType: "JSON",
            //         success: function(response) {
            //             console.log(response);
            //         }
            //     });
            // })
        });
    </script>
@endpush
