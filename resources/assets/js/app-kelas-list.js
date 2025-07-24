// File ini hasil adaptasi dari app-guru-list.js untuk entitas Kelas

'use strict';

// Setup CSRF token untuk semua AJAX request
$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

// Datatable (jquery)
$(function () {
  let borderColor, bodyBg, headingColor;

  if (isDarkStyle) {
    borderColor = config.colors_dark.borderColor;
    bodyBg = config.colors_dark.bodyBg;
    headingColor = config.colors_dark.headingColor;
  } else {
    borderColor = config.colors.borderColor;
    bodyBg = config.colors.bodyBg;
    headingColor = config.colors.headingColor;
  }

  // Variable declaration for table
  var dt_kelas_table = $('.datatables-kelas'),
    select2 = $('.select2');

  if (select2.length) {
    var $this = select2;
    $this.wrap('<div class="position-relative"></div>').select2({
      placeholder: 'Select Option',
      dropdownParent: $this.parent()
    });
  }

  // Kelas datatable
  if (dt_kelas_table.length) {
    var dt_kelas = dt_kelas_table.DataTable({
      ajax: {
        url: baseUrl + 'app/kelas/list'
      },
      columns: [
        { data: 'nama_kelas' },
        { data: 'action' }
      ],
      columnDefs: [
        {
          // Nama Kelas
          targets: 0,
          render: function (data, type, full, meta) {
            return '<span class="fw-medium">' + full['nama_kelas'] + '</span>';
          }
        },
        {
          // Kolom aksi (action) pakai dropdown titik 3, tanpa icon, label Indonesia
          targets: 1,
          title: 'Aksi',
          searchable: false,
          orderable: false,
          render: function (data, type, full, meta) {
            return (
              '<div class="d-inline-block">' +
                '<a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></a>' +
                '<div class="dropdown-menu dropdown-menu-end m-0">' +
                  '<a href="javascript:;" class="dropdown-item btn-detail-kelas" data-id="' + full.id + '">Detail</a>' +
                  '<a href="javascript:;" class="dropdown-item btn-edit-kelas" data-id="' + full.id + '">Edit</a>' +
                  '<a href="javascript:;" class="dropdown-item text-danger btn-hapus-kelas" data-id="' + full.id + '" data-nama="' + full.nama_kelas + '">Hapus</a>' +
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
              exportOptions: {
                columns: [1, 2, 3, 4],
                format: {
                  body: function (inner, coldex, rowdex) {
                    return inner;
                  }
                }
              }
            },
            {
              extend: 'csv',
              text: '<i class="ti ti-file-text me-2" ></i>Csv',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4],
                format: {
                  body: function (inner, coldex, rowdex) {
                    return inner;
                  }
                }
              }
            },
            {
              extend: 'excel',
              text: '<i class="ti ti-file-spreadsheet me-2"></i>Excel',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4],
                format: {
                  body: function (inner, coldex, rowdex) {
                    return inner;
                  }
                }
              }
            },
            {
              extend: 'pdf',
              text: '<i class="ti ti-file-code-2 me-2"></i>Pdf',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4],
                format: {
                  body: function (inner, coldex, rowdex) {
                    return inner;
                  }
                }
              }
            },
            {
              extend: 'copy',
              text: '<i class="ti ti-copy me-2" ></i>Copy',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4],
                format: {
                  body: function (inner, coldex, rowdex) {
                    return inner;
                  }
                }
              }
            }
          ]
        },
        {
          text: '<i class="ti ti-plus me-0 me-sm-1"></i><span class="d-none d-sm-inline-block">Tambah Kelas</span>',
          className: 'add-new btn btn-primary waves-effect waves-light',
          attr: {
            'data-bs-toggle': 'modal',
            'data-bs-target': '#modalAddKelas'
          }
        }
      ],
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (row) {
              var data = row.data();
              return 'Details of ' + data['nama_kelas'];
            }
          }),
          type: 'column',
          renderer: function (api, rowIdx, columns) {
            var data = $.map(columns, function (col, i) {
              return col.title !== ''
                ? '<tr data-dt-row="' +
                    col.rowIndex +
                    '" data-dt-column="' +
                    col.columnIndex +
                    '">' +
                    '<td>' +
                    col.title +
                    ':' +
                    '</td> ' +
                    '<td>' +
                    col.data +
                    '</td>' +
                    '</tr>'
                : '';
            }).join('');

            return data ? $('<table class="table"/><tbody />').append(data) : false;
          }
        }
      }
    });
  }

  // Handler: tampilkan modal tambah kelas (mode tambah)
  $(document).on('click', '[data-bs-target="#modalAddKelas"]', function() {
    $('#formAddKelas')[0].reset();
    $('#formAddKelas input[name=id]').remove();
    $('#modalAddKelasLabel').text('Tambah Kelas');
    $('#formAddKelas button[type=submit]').text('Simpan');
    $('#formAddKelas').data('mode', 'add');
  });

  // Handler: tampilkan modal edit kelas (pakai modal tambah)
  $(document).on('click', '.btn-edit-kelas', function() {
    // Tutup modal detail jika sedang terbuka
    $('#modalDetailKelas').modal('hide');
    var id = $(this).data('id');
    $.get(baseUrl + 'app/kelas/getbyid/' + id, function(res) {
      if (res.success) {
        // Isi field
        $('#formAddKelas')[0].reset();
        if ($('#formAddKelas input[name=id]').length === 0) {
          $('#formAddKelas').prepend('<input type="hidden" name="id" id="editKelasId">');
        }
        $('#editKelasId').val(res.data.id);
        $('#formAddKelas input[name=nama_kelas]').val(res.data.nama_kelas);
        // Ubah judul dan tombol
        $('#modalAddKelasLabel').text('Edit Kelas');
        $('#formAddKelas button[type=submit]').text('Simpan Perubahan');
        $('#formAddKelas').data('mode', 'edit');
        $('#modalAddKelas').modal('show');
      } else {
        showKelasToast(res.error || 'Gagal mengambil data', 'danger');
      }
    });
  });

  // Handler: submit form tambah/edit kelas
  $(document).on('submit', '#formAddKelas', function(e) {
    e.preventDefault();
    var mode = $(this).data('mode');
    var url = mode === 'edit' ? baseUrl + 'app/kelas/updatebyid' : baseUrl + 'app/kelas/store';
    var formData = $(this).serialize();
    $.ajax({
      url: url,
      method: 'POST',
      data: formData,
      success: function(res) {
        $('#modalAddKelas').modal('hide');
        if (res.success) {
          showKelasToast('Data berhasil disimpan!', 'success');
          $('.datatables-kelas').DataTable().ajax.reload();
        } else {
          showKelasToast(res.error || 'Gagal menyimpan data', 'danger');
        }
      },
      error: function(xhr) {
        $('#modalAddKelas').modal('hide');
        showKelasToast(xhr.responseJSON?.error || 'Gagal menyimpan data', 'danger');
      },
      complete: function() {
        $('#formAddKelas')[0].reset();
        $('#formAddKelas input[name=id]').remove();
        $('#modalAddKelasLabel').text('Tambah Kelas');
        $('#formAddKelas button[type=submit]').text('Simpan');
        $('#formAddKelas').data('mode', 'add');
      }
    });
  });

  // Handler: tampilkan modal detail saat tombol detail diklik
  $(document).on('click', '.btn-detail-kelas', function() {
    var id = $(this).data('id');
    $.get(baseUrl + 'app/kelas/getbyid/' + id, function(res) {
      if (res.success) {
        $('#detailKelasNama').text(res.data.nama_kelas);
        $('#detailKelasNamaTitle').text(res.data.nama_kelas);
        $('#detailKelasStatus').text(res.data.status);
        // Set data-id dan data-nama pada tombol edit dan hapus di modal detail
        $('#modalDetailKelas .btn-edit-kelas').data('id', res.data.id).data('nama', res.data.nama_kelas);
        $('#modalDetailKelas .btn-hapus-kelas').data('id', res.data.id).data('nama', res.data.nama_kelas);
        $('#modalDetailKelas').modal('show');
      } else {
        showKelasToast(res.error || 'Gagal mengambil data', 'danger');
      }
    });
  });

  // Handler: hapus kelas
  $(document).on('click', '.btn-hapus-kelas', function () {
    $('#modalDetailKelas').modal('hide');
    var id = $(this).data('id');
    var nama = $(this).data('nama');
    // Tampilkan modal hapus setelah modal detail benar-benar tertutup
    $('#modalDetailKelas').one('hidden.bs.modal', function() {
      $('#hapusKelasId').val(id);
      $('#hapusKelasNama').text(nama);
      $('#modalHapusKelas').modal('show');
    });
  });

  // Handler: submit form hapus via AJAX
  $(document).on('submit', '#formHapusKelas', function(e) {
    e.preventDefault();
    var id = $('#hapusKelasId').val();
    $.ajax({
      url: baseUrl + 'app/kelas/deletebyid',
      method: 'POST',
      data: { id: id },
      success: function(res) {
        $('#modalHapusKelas').modal('hide');
        if (res.success) {
          showKelasToast('Data berhasil dihapus!', 'success');
          $('.datatables-kelas').DataTable().ajax.reload();
        } else {
          showKelasToast(res.error || 'Gagal menghapus data', 'danger');
        }
      },
      error: function(xhr) {
        $('#modalHapusKelas').modal('hide');
        showKelasToast(xhr.responseJSON?.error || 'Gagal menghapus data', 'danger');
      }
    });
  });

  setTimeout(() => {
    $('.dataTables_filter .form-control').removeClass('form-control-sm');
    $('.dataTables_length .form-select').removeClass('form-select-sm');
  }, 300);
});

function showKelasToast(message, type) {
  var icon = $('#kelasToast .toast-header i');
  $('#kelasToastBody').text(message);

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

  var toast = new bootstrap.Toast(document.getElementById('kelasToast'));
  toast.show();
} 