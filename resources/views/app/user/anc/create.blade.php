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
                                <input class="form-control @error('visit_abbreviation') is-invalid @enderror"
                                    value="{{ $checkVisit->visit->abbreviation }}" id="visit_abbreviation"
                                    name="visit_abbreviation" readonly>
                                @error('visit_abbreviation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal Pemeriksaan </label>
                                <input class="form-control @error('schedule_date') is-invalid @enderror"
                                    value="{{ $checkVisit->formatted_schedule_date }}" id="schedule_date"
                                    name="schedule_date" readonly>
                                @error('schedule_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Usia Ibu</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control @error('age') is-invalid @enderror"
                                        value="{{ $checkVisit->user->age }}" id="age" name="age" readonly>
                                    <span class="input-group-text">Tahun</span>
                                    @error('age')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Usia Kehamilan</label>
                                <div class="input-group mb-3">
                                    <input type="text"
                                        class="form-control @error('gestational_age') is-invalid @enderror"
                                        value="{{ $checkVisit->user->pregnantHistory->first()->gestational_age_in_weeks }}"
                                        id="gestational_age" name="gestational_age" readonly>
                                    <span class="input-group-text">Minggu</span>
                                    @error('gestational_age')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Berat Badan</label>
                                <div class="input-group mb-3">
                                    <input type="number" class="form-control @error('weight') is-invalid @enderror"
                                        name="weight" id="weight">
                                    <span class="input-group-text">Kg</span>
                                    @error('weight')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tinggi Badan</label>
                                <div class="input-group mb-3">
                                    <input type="number" class="form-control @error('height') is-invalid @enderror"
                                        name="height" id="height">
                                    <span class="input-group-text">cm</span>
                                    @error('height')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Lingkar Lengan Atas (LILA)
                                    <span class="badge bg-danger text-danger-fg d-none" id="alert-lila">
                                        Resiko Hamil KEK (Kurang Energi Kronik)
                                    </span>
                                </label>
                                <div class="input-group mb-3">
                                    <input type="number" class="form-control @error('lila') is-invalid @enderror"
                                        name="lila" id="lila">
                                    <span class="input-group-text">cm</span>
                                    @error('lila')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tekanan Darah
                                    <span class="badge bg-danger text-danger-fg" id="alert-td">
                                        Resiko Preklamsia
                                    </span>
                                </label>
                                <div class="input-group">
                                    <input type="number"
                                        class="form-control  @error('sistolik_diastolik') is-invalid @enderror"
                                        placeholder="Sistolik" id="sistolik_diastolik" name="sistolik_diastolik[]">
                                    <span class="input-group-text">
                                        /
                                    </span>
                                    <input type="number"
                                        class="form-control  @error('sistolik_diastolik') is-invalid @enderror"
                                        placeholder="Diastolik" id="sistolik_diastolik" name="sistolik_diastolik[]">
                                    <span class="input-group-text">
                                        mmHg
                                    </span>
                                    @error('sistolik_diastolik')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kadar HB
                                    <span class="badge bg-danger text-danger-fg d-none" id="alert-hb">Resiko
                                        Anemia</span>
                                </label>
                                <div class="input-group">
                                    <input type="number"
                                        class="form-control @error('hemoglobin_level') is-invalid @enderror"
                                        name="hemoglobin_level" id="hemoglobin_level">
                                    <span class="input-group-text">
                                        mg/dl
                                    </span>
                                    @error('hemoglobin_level')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-label">Tetanus Toksoid (TT)</div>
                                <div>
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input @error('tetanus_toxoid') is-invalid @enderror"
                                            type="radio" name="tetanus_toxoid" value="1">
                                        <span class="form-check-label">Sudah</span>
                                    </label>
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input @error('tetanus_toxoid') is-invalid @enderror"
                                            type="radio" name="tetanus_toxoid" value="0">
                                        <span class="form-check-label">Belum</span>
                                    </label>
                                    @error('tetanus_toxoid')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-label">
                                    Letak Janin
                                </div>
                                <select class="form-select @error('fetal_position') is-invalid @enderror"
                                    id="fetal_position" name="fetal_position">
                                    <option selected>Pilih Posisi Janin</option>
                                    <option value="1">Posisi Kepala Di Bawah</option>
                                    <option value="2">Posisi Posterior</option>
                                    <option value="3">Posisi Melintang</option>
                                    <option value="4">Posisi Sungsang</option>
                                </select>
                                @error('fetal_position')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <div class="form-label">Detak Jantung Janin (DJJ)</div>
                                <div class="input-group">
                                    <input type="number"
                                        class="form-control  @error('fetal_heartbeat') is-invalid @enderror"
                                        name="fetal_heartbeat" id="fetal_heartbeat">
                                    <span class="input-group-text">
                                        bpm
                                    </span>
                                    @error('fetal_heartbeat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    @if ($checkVisit->visit->abbreviation === 'K1' || $checkVisit->visit->abbreviation === 'K5')
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
                                        class="img-thumbnail" id="img-riview"
                                        style="max-width: 500px; max-height: 300px">
                                </div>
                            </div>
                        </div>
                    @endif
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
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('style')
@endpush

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            $('#usg_image').change(function() {
                var img = document.getElementById('img-riview');
                if (this.files && this.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        img.src = e.target.result;
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });

            $('#lila').on('input', function(e) {
                var lilaValue = parseFloat($(this).val()); // Ambil nilai input dan ubah menjadi float
                var alertLila = $('#alert-lila');

                // Tampilkan badge alert-lila jika nilai input lebih kecil dari 23.5, sebaliknya sembunyikan
                if (lilaValue < 23.5) {
                    alertLila.removeClass('d-none');
                } else {
                    alertLila.addClass('d-none');
                }
            });

            $('#alert-td').addClass('d-none');

            $('#sistolik, #diastolik').on('input', function(e) {
                var sistolikValue = parseInt($('#sistolik').val());
                var diastolikValue = parseInt($('#diastolik').val());
                var alertTD = $('#alert-td');

                if (sistolikValue > 140 || diastolikValue > 90) {
                    alertTD.removeClass('d-none');
                } else {
                    alertTD.addClass('d-none');
                }
            });

            $('#hemoglobin_level').on('input', function(e) {
                var hbValue = parseFloat($('#hemoglobin_level').val());
                var alertHB = $('#alert-hb');

                if (hbValue < 11) {
                    alertHB.removeClass('d-none');
                } else {
                    alertHB.addClass('d-none');
                }
            });

        });
    </script>
@endpush
