// resources/assets/js/pages-dashboard-guru.js
'use strict';

$(function () {
  var dt_siswa_table = $('.datatables-projects');

  if (dt_siswa_table.length) {
    dt_siswa_table.DataTable({
      order: [[1, 'asc']],
      dom: '<"card-header pb-0 pt-sm-0"<"head-label text-center"><"d-flex justify-content-center justify-content-md-end"f>>t<"row mx-2"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
      displayLength: 7,
      lengthMenu: [7, 10, 25, 50, 75, 100],
      responsive: true
    });
    // Ambil data kelas dan tahun ajaran dari attribute tabel
    var $table = dt_siswa_table;
    var kelas = $table.data('kelas') || '';
    var tahun = $table.data('tahun') || '';
    var judul = '<h5 class="card-title mb-0">Daftar Siswa ' +
      (kelas ? '<span class="badge bg-label-primary ms-1">' + kelas + '</span>' : '') +
      (tahun ? '<span class="badge bg-label-info ms-1">' + tahun + '</span>' : '') +
      '</h5>';
    $('div.head-label').html(judul);
  }

  setTimeout(() => {
    $('.dataTables_filter .form-control').removeClass('form-control-sm');
    $('.dataTables_length .form-select').removeClass('form-select-sm');
  }, 300);
}); 