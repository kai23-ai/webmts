// File JS DataTable Muatan Lokal
'use strict';

$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

$(function () {
  var dt_muatan_lokal_table = $('.datatables-muatan-lokal');

  if (dt_muatan_lokal_table.length) {
    var dt_muatan_lokal = dt_muatan_lokal_table.DataTable({
      ajax: {
        url: baseUrl + 'app/muatan-lokal/list'
      },
      columns: [
        { data: 'nama_muatan' },
        { data: 'kelompok_muatan' },
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
                  '<a href="javascript:;" class="dropdown-item btn-detail-muatan-lokal" data-id="' + full.id + '">Detail</a>' +
                  '<a href="javascript:;" class="dropdown-item btn-edit-muatan-lokal" data-id="' + full.id + '">Edit</a>' +
                  '<a href="javascript:;" class="dropdown-item text-danger btn-hapus-muatan-lokal" data-id="' + full.id + '" data-nama_muatan="' + full.nama_muatan + '" data-kelompok_muatan="' + full.kelompok_muatan + '" data-urutan="' + full.urutan + '">Hapus</a>' +
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
          text: '<i class="ti ti-plus me-0 me-sm-1"></i><span class="d-none d-sm-inline-block">Tambah Muatan Lokal</span>',
          className: 'add-new btn btn-primary waves-effect waves-light',
          attr: {
            'data-bs-toggle': 'modal',
            'data-bs-target': '#modalAddMuatanLokal'
          }
        }
      ],
      initComplete: function () {
        // Tidak perlu filter status, hapus kode ini
      }
    });
  }

  // Handler: tampilkan modal tambah muatan lokal
  $(document).on('click', '[data-bs-target="#modalAddMuatanLokal"]', function() {
    $('#formAddMuatanLokal')[0].reset();
    $('#formAddMuatanLokal input[name=id]').remove();
    $('#modalAddMuatanLokalLabel').text('Tambah Muatan Lokal');
    $('#formAddMuatanLokal button[type=submit]').text('Simpan');
    $('#formAddMuatanLokal').data('mode', 'add');
  });

  // Handler: tampilkan modal edit muatan lokal
  $(document).on('click', '.btn-edit-muatan-lokal', function() {
    // Tutup modal detail jika sedang terbuka
    $('#modalDetailMuatanLokal').modal('hide');
    var id = $(this).data('id');
    $.get(baseUrl + 'app/muatan-lokal/getbyid/' + id, function(res) {
      if (res.success) {
        $('#formAddMuatanLokal')[0].reset();
        if ($('#formAddMuatanLokal input[name=id]').length === 0) {
          $('#formAddMuatanLokal').prepend('<input type="hidden" name="id" id="editMuatanLokalId">');
        }
        $('#editMuatanLokalId').val(res.data.id);
        $('#namaMuatan').val(res.data.nama_muatan);
        $('#kelompokMuatan').val(res.data.kelompok_muatan).trigger('change');
        $('#urutanMuatan').val(res.data.urutan);
        $('#modalAddMuatanLokalLabel').text('Edit Muatan Lokal');
        $('#formAddMuatanLokal button[type=submit]').text('Simpan Perubahan');
        $('#formAddMuatanLokal').data('mode', 'edit');
        $('#modalAddMuatanLokal').modal('show');
      } else {
        showMuatanLokalToast(res.error || 'Gagal mengambil data', 'danger');
      }
    });
  });

  // Handler: submit form tambah/edit muatan lokal
  $(document).on('submit', '#formAddMuatanLokal', function(e) {
    e.preventDefault();
    var mode = $(this).data('mode');
    var url = mode === 'edit' ? baseUrl + 'app/muatan-lokal/updatebyid' : baseUrl + 'app/muatan-lokal/store';
    var formData = $(this).serialize();
    $.ajax({
      url: url,
      method: 'POST',
      data: formData,
      success: function(res) {
        $('#modalAddMuatanLokal').modal('hide');
        if (res.success) {
          showMuatanLokalToast('Data berhasil disimpan!', 'success');
          $('.datatables-muatan-lokal').DataTable().ajax.reload();
        } else {
          showMuatanLokalToast(res.error || 'Gagal menyimpan data', 'danger');
        }
      },
      error: function(xhr) {
        $('#modalAddMuatanLokal').modal('hide');
        showMuatanLokalToast(xhr.responseJSON?.error || 'Gagal menyimpan data', 'danger');
      },
      complete: function() {
        $('#formAddMuatanLokal')[0].reset();
        $('#formAddMuatanLokal input[name=id]').remove();
        $('#modalAddMuatanLokalLabel').text('Tambah Muatan Lokal');
        $('#formAddMuatanLokal button[type=submit]').text('Simpan');
        $('#formAddMuatanLokal').data('mode', 'add');
        $('#kelompokMuatan').val('').trigger('change');
      }
    });
  });

  // Handler: tampilkan modal detail muatan lokal
  $(document).on('click', '.btn-detail-muatan-lokal', function() {
    var id = $(this).data('id');
    $.get(baseUrl + 'app/muatan-lokal/getbyid/' + id, function(res) {
      if (res.success) {
        $('#detailMuatanLokalNama').text(res.data.nama_muatan);
        $('#detailMuatanLokalNamaTitle').text(res.data.nama_muatan);
        $('#detailMuatanLokalKelompok').text(res.data.kelompok_muatan);
        $('#detailMuatanLokalUrutan').text(res.data.urutan);
        // Set data-id dan data-nama_muatan pada tombol edit dan hapus di modal detail
        $('#modalDetailMuatanLokal .btn-edit-muatan-lokal')
          .data('id', res.data.id)
          .data('nama_muatan', res.data.nama_muatan);
        $('#modalDetailMuatanLokal .btn-hapus-muatan-lokal')
          .data('id', res.data.id)
          .data('nama_muatan', res.data.nama_muatan)
          .data('kelompok_muatan', res.data.kelompok_muatan)
          .data('urutan', res.data.urutan);
        $('#modalDetailMuatanLokal').modal('show');
      } else {
        showMuatanLokalToast(res.error || 'Gagal mengambil data', 'danger');
      }
    });
  });

  // Toast helper
  function showMuatanLokalToast(message, type) {
    var toast = new bootstrap.Toast(document.getElementById('muatanLokalToast'));
    $('#muatanLokalToastBody').text(message);
    toast.show();
  }
}); 