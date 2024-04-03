@extends('layouts.app.main')

@section('content')
    <div class="page-header">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-title">Jadwal TTD</div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal modal-blur fade" id="modalAbsen" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-title">
                        {{ date('d M Y') }}
                    </div>
                    <div>
                        Apakah kamu sudah meminum Obat Penambah Darah?
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link link-secondary text-decoration-none me-auto"
                        data-bs-dismiss="modal" id="btnCancel">Belum</button>
                    <button type="button" class="btn btn-success" id="btnConfirm" data-bs-dismiss="modal">Ya,
                        sudah</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="/assets/main/css/custom-fullcalendar.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.7/dist/sweetalert2.min.css">
@endpush

@push('script')
    <script src="/assets/main/js/libs/fullcalender/index.global.min.js"></script>
    <script src="/assets/main/js/libs/fullcalender/locale/id.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.7/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            var calendarEl = $('#calendar');
            var calendar = new FullCalendar.Calendar(calendarEl[0], {
                initialView: 'dayGridMonth',
                locale: 'id',
                showNonCurrentDates: false,
                titleFormat: {
                    month: 'long',
                    year: 'numeric',
                },
                headerToolbar: {
                    left: 'title',
                    right: 'prev,next btnAbsen'
                },
                customButtons: {
                    btnAbsen: {
                        text: 'Absen',
                        click: function(start) {
                            $('#modalAbsen').modal('show');
                        }
                    }
                },
                events: function(info, successCallback, failureCallback) {
                    // Lakukan permintaan Ajax ke endpoint server-side Anda
                    $.ajax({
                        url: "{{ route('user.schedule-supplement.index') }}",
                        type: 'GET',
                        dataType: 'JSON',
                        data: {
                            start: formateDate(info.startStr),
                            end: formateDate(info.endStr)
                        },
                        success: function(response) {
                            // console.log(response);
                            // return;
                            // Proses data acara dari respons server
                            var events = response.datas.map(function(event) {
                                return {
                                    title: event.status === 1 ? 'MINUM' :
                                        'TERLEWAT',
                                    start: event.start_end,
                                    end: event.start_end,
                                    color: event.status === 1 ? '#2FB344' :
                                        '#D63939'
                                };
                            });
                            // Panggil successCallback dengan data acara yang diterima
                            successCallback(events);
                        },
                        error: function(xhr, status, error) {
                            // Panggil failureCallback jika terjadi kesalahan
                            failureCallback(error);
                        }
                    });
                }
            });

            calendar.render();

            $('#btnConfirm').click(function() {
                const data = {
                    'date': "{{ date('Y-m-d') }}"
                }

                $.ajax({
                    url: "{{ route('user.schedule-supplement.store') }}",
                    method: 'POST',
                    data: data,
                    dataType: 'json',
                    success: function(response) {
                        $('#modalAbsen').modal('hide');
                        if (response.status) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: response.message,
                                showConfirmButton: false,
                                timer: 1500
                            })
                            calendar.refetchEvents();
                        } else {
                            Swal.fire({
                                position: 'center',
                                icon: 'error',
                                title: response.message,
                                showConfirmButton: false,
                                timer: 1500
                            })
                        }
                    },
                    error: function(xhr, status, error) {

                    }
                });
            });

            function formateDate(date) {
                var startDate = new Date(date);
                var day = startDate.getDate();
                var month = startDate.getMonth() + 1; // Ingat bahwa bulan dimulai dari 0, sehingga perlu ditambah 1
                var year = startDate.getFullYear();
                var formattedDate = year + '-' + (month < 10 ? '0' + month : month) + '-' + (day < 10 ? '0' + day :
                    day);
                return formattedDate;
            }
        });
    </script>
@endpush
