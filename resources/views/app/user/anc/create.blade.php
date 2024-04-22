@extends('layouts.app.main')

@section('title', 'Cek ANC ' . $checkVisit->visit->first()->name)

@section('content')
    <div class="page-header">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-title">Cek ANC</div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl d-flex flex-column justify-content-center">
            {{-- <div class="card mb-2">
                <div class="card-body">
                    <ul class="steps steps-primary steps-counter my-4">
                        <li class="step-item active" id="1"></li>
                        <li class="step-item" id="2"></li>
                        <li class="step-item" id="3"></li>
                        <li class="step-item" id="4"></li>
                    </ul>
                </div>
            </div> --}}
            <div id="form-check-anc">
                <form action="{{ route('user.check-anc.store') }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    <div class="card mb-2" id="check-health">
                        <div class="card-header">
                            <h3 class="card-title">Cek Kesehatan</h3>
                        </div>
                        <div class="card-body">
                            <input type="hidden" name="visit_id" id="visit_id" value="{{ $checkVisit->visit->id }}">
                            <input type="hidden" name="schedule_id" id="schedule_id" value="{{ $checkVisit->id }}">
                            <div class="mb-3">
                                <label class="form-label">Kunjungan</label>
                                <input class="form-control" value="{{ $checkVisit->visit->abbreviation }}"
                                    id="visit_abbreviation" name="visit_abbreviation" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal Pemeriksaan </label>
                                <input class="form-control" value="{{ $checkVisit->formatted_schedule_date }}"
                                    id="schedule_date" name="schedule_date" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Usia Ibu</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" value="{{ $checkVisit->user->age }}"
                                        id="age" name="age" readonly>
                                    <span class="input-group-text">Tahun</span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Usia Kehamilan</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control"
                                        value="{{ $checkVisit->user->pregnantHistory->first()->gestational_age_in_weeks }}"
                                        id="gestational_age" name="gestational_age" readonly>
                                    <span class="input-group-text">Minggu</span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Berat Badan</label>
                                <div class="input-group mb-3">
                                    <input type="number" class="form-control" name="weight" id="weight">
                                    <span class="input-group-text">Kg</span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tinggi Badan</label>
                                <div class="input-group mb-3">
                                    <input type="number" class="form-control" name="height" id="height">
                                    <span class="input-group-text">cm</span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Lingkar Lengan Atas (LILA)</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="lila" id="lila">
                                    <span class="input-group-text">cm</span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tekanan Darah</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Sistolik">
                                    <span class="input-group-text">
                                        /
                                    </span>
                                    <input type="text" class="form-control" placeholder="Diastolik">
                                    <span class="input-group-text">
                                        mmHg
                                    </span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kadar HB</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="hemoglobin_level"
                                        id="hemoglobin_level">
                                    <span class="input-group-text">
                                        mg/dl
                                    </span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-label">Tetanus Toxoid (TT)</div>
                                <div>
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="radios-inline"
                                            value="1">
                                        <span class="form-check-label">Sudah</span>
                                    </label>
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="radios-inline"
                                            value="0">
                                        <span class="form-check-label">Belum</span>
                                    </label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-label">
                                    Letak Janin
                                </div>
                                <select class="form-select" id="position" name="position-">
                                    <option value="0" selected>Pilih Posisi Janin</option>
                                    <option value="1">Posisi Kepala Di Bawah</option>
                                    <option value="2">Posisi Posterior</option>
                                    <option value="3">Posisi Melintang</option>
                                    <option value="4">Posisi Sungsang</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <div class="form-label">Detak Jantung Janin (DJJ)</div>
                                <div>
                                    <input type="text" class="form-control" name="fetal-heartbeat"
                                        id="fetal-heartbeat">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-2" id="upload-image-usg">
                        <div class="card-header">
                            <h3 class="card-title">Cek USG</h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Foto USG</label>
                                <input type="file" class="form-control" name="usg_image" id="usg_image">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Priview Foto</label>
                                <img src="https://placehold.co/500x300?text=Foto+USG" alt=""
                                    class="img-thumbnail" style="max-width: 500px">
                            </div>
                        </div>
                    </div>
                    <div class="card mb-2" id="preklamsia-screening">
                        <div class="card-header">
                            <h3 class="card-title">Faktor Resiko Preklamsia</h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <div>
                                    @foreach ($categoriesPreeclamsia as $category)
                                        <label class="form-check">
                                            <input type="checkbox" class="form-check-input" name="category_preeclamsia[]"
                                                value="{{ $category->id }}">
                                            <span class="form-check-label">
                                                {{ $category->screening_name }}
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-2" id="note">
                        <div class="card-header">
                            <h3 class="card-title">Note</h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Catatan Kesehatan</label>
                                <textarea class="form-control" rows="5" name="note" id="note"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">KIRIM DATA</button>
                            {{-- <a class="btn btn-primary" href="">KIRIM DATA</a> --}}
                        </div>
                    </div>
                </form>
            </div>

            {{-- <div class="card">
                <div class="card-body">
                    <ul class="pagination ">
                        <li class="page-item page-prev">
                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true" id="prevBtn">
                                <div class="page-item-title">Previous</div>
                            </a>
                        </li>
                        <li class="page-item page-next">
                            <a class="page-link" href="#" id="nextBtn">
                                <div class="page-item-title">Next</div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div> --}}
        </div>
    </div>
@endsection

@push('style')
@endpush

@push('script')
    <script>
        // document.addEventListener("DOMContentLoaded", function() {
        //     const steps = document.querySelectorAll('.step-item');
        //     const forms = document.querySelectorAll('.card.mb-2');

        //     let currentStep = 0;

        //     // Function to show current step and hide others
        //     function showStep(stepIndex) {
        //         steps.forEach(step => step.classList.remove('active'));
        //         forms.forEach(form => form.style.display = 'none');

        //         steps[stepIndex].classList.add('active');
        //         forms[stepIndex].style.display = 'block';

        //         // Enable or disable previous button based on current step
        //         const prevBtn = document.getElementById('prevBtn');
        //         if (stepIndex === 0) {
        //             prevBtn.setAttribute('disabled', 'true');
        //         } else {
        //             prevBtn.removeAttribute('disabled');
        //         }

        //         // Show note section if it's the last step
        //         const noteSection = document.getElementById('note');
        //         if (stepIndex === forms.length - 1) {
        //             noteSection.style.display = 'block';
        //         } else {
        //             noteSection.style.display = 'none';
        //         }
        //     }

        //     // Show the initial step
        //     showStep(currentStep);

        //     // Function to handle next button click
        //     function nextStep() {
        //         if (currentStep < steps.length - 1) {
        //             currentStep++;
        //             showStep(currentStep);
        //         }
        //     }

        //     // Function to handle previous button click
        //     function prevStep() {
        //         if (currentStep > 0) {
        //             currentStep--;
        //             showStep(currentStep);
        //         }
        //     }

        //     // Add event listener for next button
        //     document.getElementById('nextBtn').addEventListener('click', nextStep);

        //     // Add event listener for previous button
        //     document.getElementById('prevBtn').addEventListener('click', prevStep);
        // });
    </script>
@endpush
