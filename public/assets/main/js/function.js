$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function togglePasswordVisibility(idPassword, idToggle) {
    $(idPassword).on('click', function (e) {
        var passwordInput = $(idToggle);
        if (passwordInput.length > 0) {
            if (passwordInput.attr('type') === 'password') {
                passwordInput.attr('type', 'text');
                $(this).html(
                    `<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye-off" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.585 10.587a2 2 0 0 0 2.829 2.828" /><path d="M16.681 16.673a8.717 8.717 0 0 1 -4.681 1.327c-3.6 0 -6.6 -2 -9 -6c1.272 -2.12 2.712 -3.678 4.32 -4.674m2.86 -1.146a9.055 9.055 0 0 1 1.82 -.18c3.6 0 6.6 2 9 6c-.666 1.11 -1.379 2.067 -2.138 2.87" /><path d="M3 3l18 18" />
                    </svg>`
                );
            } else {
                passwordInput.attr('type', 'password');
                $(this).html(
                    `<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                    </svg>`
                );


            }
        }
    });
}

function formatDate(inputDate) {
    // Memisahkan tanggal, bulan, dan tahun dari inputDate
    var parts = inputDate.split('-');

    // Membuat objek Date baru dengan tahun, bulan, dan tanggal yang diambil dari inputDate
    var formattedDate = new Date(parts[2], parts[1] - 1, parts[0]);

    // Mengembalikan tanggal dalam format yang diinginkan (YYYY-MM-DD)
    return formattedDate.getFullYear() + '-' +
        ('0' + (formattedDate.getMonth() + 1)).slice(-2) + '-' +
        ('0' + formattedDate.getDate()).slice(-2);
}

function perkiraanTanggalLahir(tanggalHaidTerakhir) {
    // Memisahkan tanggal, bulan, dan tahun dari string input
    var tanggalBulanTahun = tanggalHaidTerakhir.split("-");
    var tanggal = parseInt(tanggalBulanTahun[0]);
    var bulan = parseInt(tanggalBulanTahun[1]) -
        1; // Penambahan -1 karena bulan dimulai dari 0 di JavaScript
    var tahun = parseInt(tanggalBulanTahun[2]);

    // Membuat objek Date dengan tanggal, bulan, dan tahun yang diperoleh
    var tanggalHaid = new Date(tahun, bulan, tanggal);

    // Menambahkan 280 hari (sekitar 40 minggu) ke tanggal haid
    tanggalHaid.setDate(tanggalHaid.getDate() + 280);

    // Mengembalikan tanggal perkiraan lahir dalam format yang sesuai
    var tahunPerkiraan = tanggalHaid.getFullYear();
    var bulanPerkiraan = ('0' + (tanggalHaid.getMonth() + 1)).slice(-2);
    var tanggalPerkiraan = ('0' + tanggalHaid.getDate()).slice(-2);

    return tanggalPerkiraan + '-' + bulanPerkiraan + '-' + tahunPerkiraan;
}