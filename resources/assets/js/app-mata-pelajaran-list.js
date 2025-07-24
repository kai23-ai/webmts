// File JS DataTable Mata Pelajaran
'use strict';

$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

$(function () {
  var dt_mata_pelajaran_table = $('.datatables-mata-pelajaran');

  if (dt_mata_pelajaran_table.length) {
    var dt_mata_pelajaran = dt_mata_pelajaran_table.DataTable({
      ajax: {
        url: baseUrl + 'app/mata-pelajaran/list',
        data: function(d) {
          d.jenis_mapel = $('#filterJenisMapel').val();
        }
      },
      columns: [
        { data: 'kode_mapel' },
        { data: 'nama_mapel' },
        { data: 'jenis_mapel' },
        { data: 'urutan' },
        { data: 'action' }
      ],
      columnDefs: [
        {
          targets: 3,
          title: 'Aksi',
          searchable: false,
          orderable: false,
          render: function (data, type, full, meta) {
            return (
              '<div class="d-inline-block">' +
                '<a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></a>' +
                '<div class="dropdown-menu dropdown-menu-end m-0">' +
                  '<a href="javascript:;" class="dropdown-item btn-detail-mata-pelajaran" data-id="' + full.id + '">Detail</a>' +
                  '<a href="javascript:;" class="dropdown-item btn-edit-mata-pelajaran" data-id="' + full.id + '">Edit</a>' +
                  '<a href="javascript:;" class="dropdown-item text-danger btn-hapus-mata-pelajaran" data-id="' + full.id + '" data-nama_mapel="' + full.nama_mapel + '" data-kelompok_mapel="' + full.kelompok_mapel + '" data-urutan="' + full.urutan + '">Hapus</a>' +
                '</div>' +
              '</div>'
            );
          }
        }
      ],
      order: [[2, 'asc']],
      dom:
        '<"row me-2"' +
        '<"col-md-2"<"me-3"l>>' +
        '<"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0"fB>>' +
        '>t' +
        '<"row mx-2"' +
        '<"col-sm-12 col-md-6"i>' +
        '<"col-sm-12 col-md-6"p>' +
        '>',
      language: {
        sLengthMenu: '_MENU_',
        search: '',
        searchPlaceholder: 'Search..'
      },
      buttons: [
        {
          extend: 'collection',
          className: 'btn btn-label-secondary dropdown-toggle mx-3 waves-effect waves-light',
          text: '<i class="ti ti-screen-share me-1 ti-xs"></i>Export',
          buttons: [
            {
              extend: 'print',
              text: '<i class="ti ti-printer me-2" ></i>Print',
              className: 'dropdown-item',
              exportOptions: { columns: [0, 1, 2] }
            },
            {
              extend: 'csv',
              text: '<i class="ti ti-file-text me-2" ></i>Csv',
              className: 'dropdown-item',
              exportOptions: { columns: [0, 1, 2] }
            },
            {
              extend: 'excel',
              text: '<i class="ti ti-file-spreadsheet me-2"></i>Excel',
              className: 'dropdown-item',
              exportOptions: { columns: [0, 1, 2] }
            },
            {
              extend: 'pdf',
              text: '<i class="ti ti-file-code-2 me-2"></i>Pdf',
              className: 'dropdown-item',
              exportOptions: { columns: [0, 1, 2] }
            },
            {
              extend: 'copy',
              text: '<i class="ti ti-copy me-2" ></i>Copy',
              className: 'dropdown-item',
              exportOptions: { columns: [0, 1, 2] }
            }
          ]
        },
        {
          text: '<i class="ti ti-plus me-0 me-sm-1"></i><span class="d-none d-sm-inline-block">Tambah Mata Pelajaran</span>',
          className: 'add-new btn btn-primary waves-effect waves-light',
          attr: {
            'data-bs-toggle': 'modal',
            'data-bs-target': '#modalAddMataPelajaran'
          }
        }
      ],
      initComplete: function () {
        // Tidak perlu filter status, hapus kode ini
      }
    });

    dt_mata_pelajaran_table.on('init.dt', function() {
      if ($('#filterJenisMapel').length === 0) {
        var filterHtml = '<select id="filterJenisMapel" class="form-select ms-2" style="width:160px; display:inline-block;">' +
          '<option value="">Semua</option>' +
          '<option value="umum">Umum</option>' +
          '<option value="muatan_lokal">Muatan Lokal</option>' +
        '</select>';
        $('.dataTables_length label').append(filterHtml);
        $('#filterJenisMapel').addClass('ms-2 d-inline-block').css('width', '160px');
        $('.dataTables_filter').removeClass('me-2 ms-2');
        $('#filterJenisMapel').on('change', function() {
          dt_mata_pelajaran.ajax.reload();
        });
      }
    });
  }

  // Handler: tampilkan modal tambah mata pelajaran
  $(document).on('click', '[data-bs-target="#modalAddMataPelajaran"]', function() {
    $('#formAddMataPelajaran')[0].reset();
    $('#formAddMataPelajaran input[name=id]').remove();
    $('#modalAddMataPelajaranLabel').text('Tambah Mata Pelajaran');
    $('#formAddMataPelajaran button[type=submit]').text('Simpan');
    $('#formAddMataPelajaran').data('mode', 'add');
  });

  // Handler: tampilkan modal edit mata pelajaran
  $(document).on('click', '.btn-edit-mata-pelajaran', function() {
    // Tutup modal detail jika sedang terbuka
    $('#modalDetailMataPelajaran').modal('hide');
    var id = $(this).data('id');
    $.get(baseUrl + 'app/mata-pelajaran/getbyid/' + id, function(res) {
      if (res.success) {
        $('#formAddMataPelajaran')[0].reset();
        if ($('#formAddMataPelajaran input[name=id]').length === 0) {
          $('#formAddMataPelajaran').prepend('<input type="hidden" name="id" id="editMataPelajaranId">');
        }
        $('#editMataPelajaranId').val(res.data.id);
        $('#kodeMapel').val(res.data.kode_mapel);
        $('#namaMapel').val(res.data.nama_mapel);
        $('#kelompokMapel').val(res.data.kelompok_mapel);
        $('#jenisMapel').val(res.data.jenis_mapel);
        $('#urutanMapel').val(res.data.urutan);
        $('#modalAddMataPelajaranLabel').text('Edit Mata Pelajaran');
        $('#formAddMataPelajaran button[type=submit]').text('Simpan Perubahan');
        $('#formAddMataPelajaran').data('mode', 'edit');
        $('#modalAddMataPelajaran').modal('show');
      } else {
        showMataPelajaranToast(res.error || 'Gagal mengambil data', 'danger');
      }
    });
  });

  // Handler: submit form tambah/edit mata pelajaran
  $(document).on('submit', '#formAddMataPelajaran', function(e) {
    e.preventDefault();
    var mode = $(this).data('mode');
    var url = mode === 'edit' ? baseUrl + 'app/mata-pelajaran/updatebyid' : baseUrl + 'app/mata-pelajaran/store';
    var formData = $(this).serialize();
    $.ajax({
      url: url,
      method: 'POST',
      data: formData,
      success: function(res) {
        $('#modalAddMataPelajaran').modal('hide');
        if (res.success) {
          showMataPelajaranToast('Data berhasil disimpan!', 'success');
          $('.datatables-mata-pelajaran').DataTable().ajax.reload();
        } else {
          showMataPelajaranToast(res.error || 'Gagal menyimpan data', 'danger');
        }
      },
      error: function(xhr) {
        $('#modalAddMataPelajaran').modal('hide');
        showMataPelajaranToast(xhr.responseJSON?.error || 'Gagal menyimpan data', 'danger');
      },
      complete: function() {
        $('#formAddMataPelajaran')[0].reset();
        $('#formAddMataPelajaran input[name=id]').remove();
        $('#modalAddMataPelajaranLabel').text('Tambah Mata Pelajaran');
        $('#formAddMataPelajaran button[type=submit]').text('Simpan');
        $('#formAddMataPelajaran').data('mode', 'add');
      }
    });
  });

  // Handler: tampilkan modal detail mata pelajaran
  $(document).on('click', '.btn-detail-mata-pelajaran', function() {
    var id = $(this).data('id');
    $.get(baseUrl + 'app/mata-pelajaran/getbyid/' + id, function(res) {
      if (res.success) {
        $('#detailMataPelajaranNama').text(res.data.nama_mapel);
        $('#detailMataPelajaranNamaTitle').text(res.data.nama_mapel);
        $('#detailMataPelajaranKelompok').text(res.data.kelompok_mapel);
        $('#detailMataPelajaranUrutan').text(res.data.urutan);
        $('#detailMataPelajaranJenis').text(res.data.jenis_mapel === 'umum' ? 'Umum' : 'Muatan Lokal');
        $('#detailMataPelajaranKode').text(res.data.kode_mapel);
        // Set data-id dan data-nama_mapel pada tombol edit dan hapus di modal detail
        $('#modalDetailMataPelajaran .btn-edit-mata-pelajaran')
          .data('id', res.data.id)
          .data('nama_mapel', res.data.nama_mapel);
        $('#modalDetailMataPelajaran .btn-hapus-mata-pelajaran')
          .data('id', res.data.id)
          .data('nama_mapel', res.data.nama_mapel)
          .data('kelompok_mapel', res.data.kelompok_mapel)
          .data('urutan', res.data.urutan);
        $('#modalDetailMataPelajaran').modal('show');
      } else {
        showMataPelajaranToast(res.error || 'Gagal mengambil data', 'danger');
      }
    });
  });

  // Handler: tampilkan modal konfirmasi saat tombol hapus diklik
  $(document).on('click', '.btn-hapus-mata-pelajaran', function() {
    // Tutup modal detail jika sedang terbuka
    $('#modalDetailMataPelajaran').modal('hide');
    var id = $(this).data('id');
    var nama_mapel = $(this).data('nama_mapel');
    var kelompok_mapel = $(this).data('kelompok_mapel');
    var urutan = $(this).data('urutan');
    var kode_mapel = $(this).data('kode_mapel'); // Added kode_mapel
    $('#hapusMataPelajaranId').val(id);
    $('#hapusMataPelajaranNama').text(nama_mapel);
    $('#hapusMataPelajaranKelompok').text(kelompok_mapel);
    $('#hapusMataPelajaranUrutan').text(urutan);
    $('#hapusMataPelajaranKode').text(kode_mapel); // Added kode_mapel
    $('#modalHapusMataPelajaran').modal('show');
  });

  // Handler: submit form hapus via AJAX
  $(document).on('submit', '#formHapusMataPelajaran', function(e) {
    e.preventDefault();
    var id = $('#hapusMataPelajaranId').val();
    $.ajax({
      url: baseUrl + 'app/mata-pelajaran/deletebyid',
      method: 'POST',
      data: { id: id },
      success: function(res) {
        $('#modalHapusMataPelajaran').modal('hide');
        if (res.success) {
          showMataPelajaranToast('Data berhasil dihapus!', 'success');
          $('.datatables-mata-pelajaran').DataTable().ajax.reload();
        } else {
          showMataPelajaranToast(res.error || 'Gagal menghapus data', 'danger');
        }
      },
      error: function(xhr) {
        $('#modalHapusMataPelajaran').modal('hide');
        showMataPelajaranToast(xhr.responseJSON?.error || 'Gagal menghapus data', 'danger');
      }
    });
  });

  setTimeout(() => {
    $('.dataTables_filter .form-control').removeClass('form-control-sm');
    $('.dataTables_length .form-select').removeClass('form-select-sm');
  }, 300);
});

function showMataPelajaranToast(message, type) {
  var icon = $('#mataPelajaranToast .toast-header i');
  $('#mataPelajaranToastBody').text(message);

  icon.removeClass('text-success text-danger text-warning text-info');

  if (type === 'danger') {
    icon.addClass('text-danger');
  } else if (type === 'warning') {
    icon.addClass('text-warning');
  } else if (type === 'info') {
    icon.addClass('text-info');
  } else {
    icon.addClass('text-success');
  }

  var toast = new bootstrap.Toast(document.getElementById('mataPelajaranToast'));
  toast.show();
} 