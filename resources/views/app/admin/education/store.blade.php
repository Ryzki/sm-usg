@extends('layouts.app.main')

@section('title', 'Tambah Materi')

@section('content')
    <div class="page-header">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-title">Tambah Materi</div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-cards">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">
                                Tambah Materi
                            </h4>
                        </div>
                        <div class="card-body">
                            <form id="formEducation">
                                <div class="mb-3">
                                    <label class="form-label">Judul</label>
                                    <input type="text" class="form-control" id="title" name="title">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Slug</label>
                                    <input type="text" class="form-control" id="slug" name="slug" readonly>
                                </div>
                                <div class="mb-3">
                                    <div class="form-label">Thumbnail</div>
                                    <input type="file" class="form-control" id="thumbnail" name="thumbnail">
                                </div>
                                <div class="mb-3">
                                    <img src="https://placehold.co/200" class="img-thumbnail" alt="alt-image"
                                        id="previewThumbnailImage" style="max-height: 200px">
                                </div>
                                <div class="mb-3">
                                    <div class="form-label">Konten</div>
                                    <input type="file" class="form-control" id="contentImage" name="contentImage">
                                </div>
                                <div class="mb-3">
                                    <img src="https://placehold.co/400" class="img-thumbnail" alt="alt-image"
                                        id="previewContentImage" style="max-height: 400px">
                                </div>
                            </form>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-primary" id="btnInsert">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
@endpush

@push('script')
    <script src="/assets/main/libs/datatables/datatables.min.js"></script>
    <script src="/assets/main/libs/sweetalert2/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            const title = document.querySelector('#title');
            const slug = document.querySelector('#slug');

            title.addEventListener('change', function() {
                fetch('/education/checkSlug?title=' + title.value)
                    .then(response => response.json())
                    .then(data => slug.value = data.slug)
            });

            $('#thumbnail').on('change', function() {
                previewImage('#thumbnail', '#previewThumbnailImage');
            });

            $('#contentImage').on('change', function() {
                previewImage('#contentImage', '#previewContentImage');
            });

            $('#btnInsert').on('click', function(e) {
                e.preventDefault();

                $('input').removeClass('is-invalid');
                $('.custon-invalid-feedback').remove();

                var thumbnail = document.getElementById("thumbnail").files[0];
                var content = document.getElementById("contentImage").files[0];

                var formData = new FormData();
                formData.append('title', $('#title').val());
                formData.append('slug', $('#slug').val());
                formData.append('thumbnail', thumbnail);
                formData.append('content', content);

                $.ajax({
                    url: "{{ route('education.store') }}",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#formEducation').trigger('reset');
                        resetImage('#previewThumbnailImage', 'https://placehold.co/200');
                        resetImage('#previewContentImage', 'https://placehold.co/400');

                        $('input').removeClass('is-invalid');
                        $('.custon-invalid-feedback').remove();

                        if (response.status) {
                            Swal.fire({
                                icon: "success",
                                title: response.message,
                                showConfirmButton: false,
                                timer: 1500
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: response.message,
                                timer: 1500
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        var response = xhr.responseJSON.errors
                        if (response.title) {
                            $('#title').addClass('is-invalid');

                            var invalidFeedback =
                                '<div class="custon-invalid-feedback text-danger d-block mb-2"><small>' +
                                response.title[0] + '</small></div>';
                            $('#title').after(invalidFeedback);
                        }

                        if (response.slug) {
                            $('#slug').addClass('is-invalid');

                            var invalidFeedback =
                                '<div class="custon-invalid-feedback text-danger d-block mb-2"><small>' +
                                response.slug[0] + '</small></div>';
                            $('#slug').after(invalidFeedback);
                        }

                        if (response.thumbnail) {
                            $('#thumbnail').addClass('is-invalid');

                            var invalidFeedback =
                                '<div class="custon-invalid-feedback text-danger d-block mb-2"><small>' +
                                response.thumbnail[0] + '</small></div>';
                            $('#thumbnail').after(invalidFeedback);
                        }

                        if (response.content) {
                            $('#contentImage').addClass('is-invalid');

                            var invalidFeedback =
                                '<div class="custon-invalid-feedback text-danger d-block mb-2"><small>' +
                                response.content[0] + '</small></div>';
                            $('#contentImage').after(invalidFeedback);
                        }
                    },
                });
            });

            function previewImage(selectorImg, selectorPreImg) {
                const image = document.querySelector(selectorImg);
                const imgPreview = document.querySelector(selectorPreImg);

                imgPreview.style.display = 'block';

                const ofReader = new FileReader();

                ofReader.readAsDataURL(image.files[0]);

                ofReader.onload = function(oFREvent) {
                    imgPreview.src = oFREvent.target.result;
                }

            }

            function resetImage(selectorPreImg, defaultSrc) {
                const imgPreview = document.querySelector(selectorPreImg);
                imgPreview.src = defaultSrc;
                imgPreview.style.display = 'block';
            }
        });
    </script>
@endpush
