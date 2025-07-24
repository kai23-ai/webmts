// File JS DataTable Tahun Ajaran
'use strict';

$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

$(function () {
  var dt_tahun_ajaran_table = $('.datatables-tahun-ajaran');

  if (dt_tahun_ajaran_table.length) {
    var dt_tahun_ajaran = dt_tahun_ajaran_table.DataTable({
      ajax: {
        url: baseUrl + 'app/tahun-ajaran/list'
      },
      columns: [
        { data: 'tahun' },
        { data: 'aktif' },
        { data: 'action' }
      ],
      columnDefs: [
        {
          targets: 1,
          render: function (data, type, full, meta) {
            if (type === 'filter' || type === 'sort') {
              return data; // biar search dan sort pakai raw data '1'/'0'
            }
            if (data === '1') {
              return '<span class="badge bg-label-success">Aktif</span>';
            } else {
              return '<span class="badge bg-label-secondary">Tidak Aktif</span>';
            }
          }
        },
        {
          targets: 2,
          title: 'Aksi',
          searchable: false,
          orderable: false,
          render: function (data, type, full, meta) {
            return (
              '<div class="d-inline-block">' +
                '<a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></a>' +
                '<div class="dropdown-menu dropdown-menu-end m-0">' +
                  '<a href="javascript:;" class="dropdown-item btn-detail-tahun-ajaran" data-id="' + full.id + '">Detail</a>' +
                  '<a href="javascript:;" class="dropdown-item btn-edit-tahun-ajaran" data-id="' + full.id + '">Edit</a>' +
                  '<a href="javascript:;" class="dropdown-item text-danger btn-hapus-tahun-ajaran" data-id="' + full.id + '" data-tahun="' + full.tahun + '">Hapus</a>' +
                '</div>' +
              '</div>'
            );
          }
        }
      ],
      order: [[0, 'desc']],
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
              exportOptions: { columns: [0, 1] }
            },
            {
              extend: 'csv',
              text: '<i class="ti ti-file-text me-2" ></i>Csv',
              className: 'dropdown-item',
              exportOptions: { columns: [0, 1] }
            },
            {
              extend: 'excel',
              text: '<i class="ti ti-file-spreadsheet me-2"></i>Excel',
              className: 'dropdown-item',
              exportOptions: { columns: [0, 1] }
            },
            {
              extend: 'pdf',
              text: '<i class="ti ti-file-code-2 me-2"></i>Pdf',
              className: 'dropdown-item',
              exportOptions: { columns: [0, 1] }
            },
            {
              extend: 'copy',
              text: '<i class="ti ti-copy me-2" ></i>Copy',
              className: 'dropdown-item',
              exportOptions: { columns: [0, 1] }
            }
          ]
        },
        {
          text: '<i class="ti ti-plus me-0 me-sm-1"></i><span class="d-none d-sm-inline-block">Tambah Tahun Ajaran</span>',
          className: 'add-new btn btn-primary waves-effect waves-light',
          attr: {
            'data-bs-toggle': 'modal',
            'data-bs-target': '#modalAddTahunAjaran'
          }
        }
      ],
      initComplete: function () {
        // Filter status aktif
        if ($('.dataTables_filter').length) {
          var selectStatus = $(
            '<select id="TahunAjaranStatus" class="form-select text-capitalize d-inline-block ms-2" style="width:auto; display:inline-block; max-width:150px;">' +
              '<option value="">Pilih Status</option>' +
              '<option value="1">Aktif</option>' +
              '<option value="0">Tidak Aktif</option>' +
            '</select>'
          );
          $('.dataTables_filter label').append(selectStatus);
          selectStatus.on('change', function () {
            var val = $(this).val();
            dt_tahun_ajaran.column(1).search(val !== '' ? '^' + val + '$' : '', true, false).draw();
          });
        }
      }
    });
  }

  // Handler: tampilkan modal tambah tahun ajaran
  $(document).on('click', '[data-bs-target="#modalAddTahunAjaran"]', function() {
    $('#formAddTahunAjaran')[0].reset();
    $('#formAddTahunAjaran input[name=id]').remove();
    $('#modalAddTahunAjaranLabel').text('Tambah Tahun Ajaran');
    $('#formAddTahunAjaran button[type=submit]').text('Simpan');
    $('#formAddTahunAjaran').data('mode', 'add');
  });

  // Handler: tampilkan modal edit tahun ajaran (pakai modal tambah)
  $(document).on('click', '.btn-edit-tahun-ajaran', function() {
    // Tutup modal detail jika sedang terbuka
    $('#modalDetailTahunAjaran').modal('hide');
    var id = $(this).data('id');
    $.get(baseUrl + 'app/tahun-ajaran/getbyid/' + id, function(res) {
      if (res.success) {
        // Isi field
        $('#formAddTahunAjaran')[0].reset();
        if ($('#formAddTahunAjaran input[name=id]').length === 0) {
          $('#formAddTahunAjaran').prepend('<input type="hidden" name="id" id="editTahunAjaranId">');
        }
        $('#editTahunAjaranId').val(res.data.id);
        $('#formAddTahunAjaran input[name=tahun]').val(res.data.tahun);
        $('#formAddTahunAjaran input[name=aktif]').prop('checked', res.data.aktif == 1);
        // Ubah judul dan tombol
        $('#modalAddTahunAjaranLabel').text('Edit Tahun Ajaran');
        $('#formAddTahunAjaran button[type=submit]').text('Simpan Perubahan');
        $('#formAddTahunAjaran').data('mode', 'edit');
        $('#modalAddTahunAjaran').modal('show');
      } else {
        showTahunAjaranToast(res.error || 'Gagal mengambil data', 'danger');
      }
    });
  });

  // Handler: submit form tambah/edit tahun ajaran
  $(document).on('submit', '#formAddTahunAjaran', function(e) {
    e.preventDefault();
    var mode = $(this).data('mode');
    var url = mode === 'edit' ? baseUrl + 'app/tahun-ajaran/updatebyid' : baseUrl + 'app/tahun-ajaran/store';
    var formData = $(this).serialize();
    $.ajax({
      url: url,
      method: 'POST',
      data: formData,
      success: function(res) {
        $('#modalAddTahunAjaran').modal('hide');
        if (res.success) {
          showTahunAjaranToast('Data berhasil disimpan!', 'success');
          $('.datatables-tahun-ajaran').DataTable().ajax.reload();
        } else {
          showTahunAjaranToast(res.error || 'Gagal menyimpan data', 'danger');
        }
      },
      error: function(xhr) {
        $('#modalAddTahunAjaran').modal('hide');
        showTahunAjaranToast(xhr.responseJSON?.error || 'Gagal menyimpan data', 'danger');
      },
      complete: function() {
        $('#formAddTahunAjaran')[0].reset();
        $('#formAddTahunAjaran input[name=id]').remove();
        $('#modalAddTahunAjaranLabel').text('Tambah Tahun Ajaran');
        $('#formAddTahunAjaran button[type=submit]').text('Simpan');
        $('#formAddTahunAjaran').data('mode', 'add');
      }
    });
  });

  // Handler: tampilkan modal detail tahun ajaran
  $(document).on('click', '.btn-detail-tahun-ajaran', function() {
    var id = $(this).data('id');
    $.get(baseUrl + 'app/tahun-ajaran/getbyid/' + id, function(res) {
      if (res.success) {
        $('#detailTahunAjaranTahun').text(res.data.tahun);
        $('#detailTahunAjaranAktif').text(res.data.aktif == 1 ? 'Aktif' : 'Tidak Aktif');
        // Set data-id dan data-tahun pada tombol edit dan hapus di modal detail
        $('#modalDetailTahunAjaran .btn-edit-tahun-ajaran').data('id', res.data.id).data('tahun', res.data.tahun);
        $('#modalDetailTahunAjaran .btn-hapus-tahun-ajaran').data('id', res.data.id).data('tahun', res.data.tahun);
        $('#modalDetailTahunAjaran').modal('show');
      } else {
        showTahunAjaranToast(res.error || 'Gagal mengambil data', 'danger');
      }
    });
  });

  // Handler: tampilkan modal konfirmasi saat tombol hapus diklik
  $(document).on('click', '.btn-hapus-tahun-ajaran', function() {
    // Tutup modal detail jika sedang terbuka
    $('#modalDetailTahunAjaran').modal('hide');
    var id = $(this).data('id');
    var tahun = $(this).data('tahun');
    $('#hapusTahunAjaranId').val(id);
    $('#hapusTahunAjaranTahun').text(tahun);
    $('#modalHapusTahunAjaran').modal('show');
  });

  // Handler: submit form hapus via AJAX
  $(document).on('submit', '#formHapusTahunAjaran', function(e) {
    e.preventDefault();
    var id = $('#hapusTahunAjaranId').val();
    $.ajax({
      url: baseUrl + 'app/tahun-ajaran/deletebyid',
      method: 'POST',
      data: { id: id },
      success: function(res) {
        $('#modalHapusTahunAjaran').modal('hide');
        if (res.success) {
          showTahunAjaranToast('Data berhasil dihapus!', 'success');
          $('.datatables-tahun-ajaran').DataTable().ajax.reload();
        } else {
          showTahunAjaranToast(res.error || 'Gagal menghapus data', 'danger');
        }
      },
      error: function(xhr) {
        $('#modalHapusTahunAjaran').modal('hide');
        showTahunAjaranToast(xhr.responseJSON?.error || 'Gagal menghapus data', 'danger');
      }
    });
  });

  setTimeout(() => {
    $('.dataTables_filter .form-control').removeClass('form-control-sm');
    $('.dataTables_length .form-select').removeClass('form-select-sm');
  }, 300);
});

function showTahunAjaranToast(message, type) {
  var icon = $('#tahunAjaranToast .toast-header i');
  $('#tahunAjaranToastBody').text(message);

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

  var toast = new bootstrap.Toast(document.getElementById('tahunAjaranToast'));
  toast.show();
} 