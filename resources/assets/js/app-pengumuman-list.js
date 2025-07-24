/**
 * Page Pengumuman List
 */

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
  var dt_pengumuman_table = $('.datatables-pengumuman'),
    select2 = $('.select2'),
    statusObj = {
      'aktif': { title: 'Aktif', class: 'bg-label-success' },
      'nonaktif': { title: 'Nonaktif', class: 'bg-label-secondary' }
    };

  if (select2.length) {
    var $this = select2;
    $this.wrap('<div class="position-relative"></div>').select2({
      placeholder: 'Pilih Role',
      dropdownParent: $this.parent()
    });
  }

  // Pengumuman datatable
  if (dt_pengumuman_table.length) {
    var dt_pengumuman = dt_pengumuman_table.DataTable({
      ajax: {
        url: baseUrl + 'app/pengumuman/data'
      },
      columns: [
        { data: null }, // expand
        { data: 'id' }, // checkbox
        { data: 'judul' },
        { data: 'isi' },
        { data: 'role' },
        { data: 'status' },
        { data: 'action' }
      ],
      columnDefs: [
        {
          className: 'control',
          searchable: false,
          orderable: false,
          responsivePriority: 1,
          targets: 0,
          render: function() { return ''; }
        },
        {
          orderable: false,
          searchable: false,
          targets: 1,
          render: function(data, type, full, meta) {
            if (type === 'display') {
              return '<input type="checkbox" class="form-check-input pengumuman-checkbox" value="' + full.id + '" />';
            }
            return '';
          }
        },
        {
          targets: 2,
          responsivePriority: 4,
          render: function (data, type, full, meta) {
            var $judul = full['judul'];
            return '<span class="fw-medium">' + $judul + '</span>';
          }
        },
        {
          targets: 3,
          render: function (data, type, full, meta) {
            var $isi = full['isi'];
            return '<span>' + $isi + '</span>';
          }
        },
        {
          targets: 4,
          render: function (data, type, full, meta) {
            var $role = full['role'];
            return '<span class="badge bg-label-info">' + $role.charAt(0).toUpperCase() + $role.slice(1) + '</span>';
          }
        },
        {
          targets: 5,
          render: function (data, type, full, meta) {
            var checked = full.status === 'aktif' ? 'checked' : '';
            return `
              <label class="switch switch-primary mb-0">
                <input type="checkbox" class="switch-input toggle-status-pengumuman" data-id="${full.id}" ${checked}>
                <span class="switch-toggle-slider"></span>
                <span class="switch-label">${full.status === 'aktif' ? 'Aktif' : 'Nonaktif'}</span>
              </label>
            `;
          }
        },
        {
          targets: 6,
          title: 'Aksi',
          searchable: false,
          orderable: false,
          render: function (data, type, full, meta) {
            return (
              '<div class="d-inline-block">' +
                '<a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></a>' +
                '<div class="dropdown-menu dropdown-menu-end m-0">' +
                  '<a href="javascript:;" class="dropdown-item btn-detail-pengumuman" data-id="' + full.id + '">Detail</a>' +
                  '<a href="javascript:;" class="dropdown-item btn-edit-pengumuman" data-id="' + full.id + '">Edit</a>' +
                  '<div class="dropdown-divider"></div>' +
                  '<a href="javascript:;" class="dropdown-item text-danger btn-hapus-pengumuman" data-id="' + full.id + '" data-judul="' + full.judul + '" data-role="' + full.role + '">Hapus</a>' +
                '</div>' +
              '</div>'
            );
          }
        }
      ],
      order: [[1, 'desc']],
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
                columns: [2, 3, 4, 5],
                format: {
                  body: function (inner, coldex, rowdex) {
                    return inner;
                  }
                }
              },
              customize: function (win) {
                $(win.document.body)
                  .css('color', headingColor)
                  .css('border-color', borderColor)
                  .css('background-color', bodyBg);
                $(win.document.body)
                  .find('table')
                  .addClass('compact')
                  .css('color', 'inherit')
                  .css('border-color', 'inherit')
                  .css('background-color', 'inherit');
              }
            },
            {
              extend: 'csv',
              text: '<i class="ti ti-file-text me-2" ></i>Csv',
              className: 'dropdown-item',
              exportOptions: {
                columns: [2, 3, 4, 5],
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
                columns: [2, 3, 4, 5],
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
                columns: [2, 3, 4, 5],
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
                columns: [2, 3, 4, 5],
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
          text: '<i class="ti ti-plus me-0 me-sm-1"></i><span class="d-none d-sm-inline-block">Tambah</span>',
          className: 'add-new btn btn-primary waves-effect waves-light',
          attr: {
            'data-bs-toggle': 'modal',
            'data-bs-target': '#modalAddPengumuman'
          }
        }
      ],
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (row) {
              var data = row.data();
              return 'Detail Pengumuman';
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
      },
      initComplete: function () {
        // Tambahkan filter status jika perlu
      }
    });

    // Tambah select all checkbox di header setelah DataTable selesai inisialisasi
    dt_pengumuman.on('draw', function () {
      if ($('.datatables-pengumuman thead th:eq(1) input[type="checkbox"].select-all-pengumuman').length === 0) {
        $('.datatables-pengumuman thead th:eq(1)').html('<input type="checkbox" class="form-check-input select-all-pengumuman" />');
        $('.datatables-pengumuman thead th:eq(1)')
          .removeClass('sorting sorting_asc sorting_desc')
          .off('click');
      }
      $('.select-all-pengumuman').prop('checked', false);
    });

    // Event: select all
    $(document).on('change', '.select-all-pengumuman', function () {
      var checked = $(this).is(':checked');
      $('.datatables-pengumuman tbody input.pengumuman-checkbox').prop('checked', checked);
    });

    // Event: update select all jika ada perubahan di checkbox baris
    $(document).on('change', '.datatables-pengumuman tbody input.pengumuman-checkbox', function () {
      var all = $('.datatables-pengumuman tbody input.pengumuman-checkbox').length;
      var checked = $('.datatables-pengumuman tbody input.pengumuman-checkbox:checked').length;
      $('.select-all-pengumuman')
        .prop('checked', all === checked && all > 0)
        .prop('indeterminate', checked > 0 && checked < all);
    });

    // Handler: tampilkan modal tambah pengumuman
    $(document).on('click', '[data-bs-target="#modalAddPengumuman"]', function() {
      $('#formAddPengumuman')[0].reset();
      $('#formAddPengumuman input[name=id]').remove();
      $('#modalAddPengumumanLabel').text('Tambah Pengumuman');
      $('#formAddPengumuman button[type=submit]').text('Simpan');
      $('#formAddPengumuman').data('mode', 'add');
    });

    // Handler: tampilkan modal edit pengumuman
    $(document).on('click', '.btn-edit-pengumuman', function() {
      var id = $(this).data('id');
      $.get(baseUrl + 'app/pengumuman/' + id, function(res) {
        if (res.success) {
          $('#formAddPengumuman')[0].reset();
          if ($('#formAddPengumuman input[name=id]').length === 0) {
            $('#formAddPengumuman').prepend('<input type="hidden" name="id" id="editPengumumanId">');
          }
          $('#editPengumumanId').val(res.data.id);
          $('#formAddPengumuman input[name=judul]').val(res.data.judul);
          $('#formAddPengumuman textarea[name=isi]').val(res.data.isi);
          $('#formAddPengumuman select[name=role]').val(res.data.role);
          $('#formAddPengumuman input[name=status]').prop('checked', res.data.status === 'aktif');
          $('#modalAddPengumumanLabel').text('Edit Pengumuman');
          $('#formAddPengumuman button[type=submit]').text('Simpan Perubahan');
          $('#formAddPengumuman').data('mode', 'edit');
          $('#modalAddPengumuman').modal('show');
        } else {
          showPengumumanToast(res.error || 'Gagal mengambil data', 'danger');
        }
      });
    });

    // Handler: submit form tambah/edit pengumuman
    $(document).on('submit', '#formAddPengumuman', function(e) {
      e.preventDefault();
      var mode = $(this).data('mode');
      var url = mode === 'edit' ? baseUrl + 'app/pengumuman/update/' + $('#editPengumumanId').val() : baseUrl + 'app/pengumuman/store';
      var formData = $(this).serialize();
      // WAJIB: update harus POST + _method=PUT, JANGAN type PUT!
      // Hapus penambahan _method=PUT pada data saat edit.
      $.ajax({
        url: url,
        type: 'POST', // HARUS POST, JANGAN GANTI KE PUT!
        data: formData,
        success: function(res) {
          $('#modalAddPengumuman').modal('hide');
          if (res.success) {
            showPengumumanToast('Data berhasil disimpan!', 'success');
            $('.datatables-pengumuman').DataTable().ajax.reload();
          } else {
            showPengumumanToast(res.error || 'Gagal menyimpan data', 'danger');
          }
        },
        error: function(xhr) {
          $('#modalAddPengumuman').modal('hide');
          showPengumumanToast(xhr.responseJSON?.error || 'Gagal menyimpan data', 'danger');
        },
        complete: function() {
          $('#formAddPengumuman')[0].reset();
          $('#formAddPengumuman input[name=id]').remove();
          $('#modalAddPengumumanLabel').text('Tambah Pengumuman');
          $('#formAddPengumuman button[type=submit]').text('Simpan');
          $('#formAddPengumuman').data('mode', 'add');
        }
      });
    });

    // Handler: tampilkan modal detail pengumuman
    $(document).on('click', '.btn-detail-pengumuman', function() {
      var id = $(this).data('id');
      $.get(baseUrl + 'app/pengumuman/' + id, function(res) {
        if (res.success) {
          $('#detailPengumumanJudul').text(res.data.judul);
          $('#detailPengumumanIsi').text(res.data.isi);
          $('#detailPengumumanRole').text(res.data.role);
          var statusText = res.data.status === 'aktif' ? 'Aktif' : 'Nonaktif';
          var statusClass = res.data.status === 'aktif' ? 'bg-label-success' : 'bg-label-secondary';
          $('#detailPengumumanStatus').text(statusText).removeClass('bg-label-success bg-label-secondary').addClass(statusClass);
          // Initial avatar
          var initials = (res.data.judul || '').split(' ').map(function(n){return n[0];}).join('').substring(0,2).toUpperCase();
          $('#detailPengumumanInitial').text(initials);
          // Set data-id pada tombol edit dan hapus
          $('#modalDetailPengumuman .btn-edit-pengumuman').data('id', res.data.id);
          // Set data-role pada tombol hapus di modal detail
          $('#modalDetailPengumuman .btn-hapus-pengumuman').data('role', res.data.role);
          // Set toggle status di modal detail
          $('#toggleStatusDetailPengumuman').prop('checked', res.data.status === 'aktif').data('id', res.data.id);
          $('#labelStatusDetailPengumuman').text(res.data.status === 'aktif' ? 'Aktif' : 'Nonaktif');
          $('#detailPengumumanStatus')
            .text(res.data.status === 'aktif' ? 'Aktif' : 'Nonaktif')
            .removeClass('bg-label-success bg-label-secondary')
            .addClass(res.data.status === 'aktif' ? 'bg-label-success' : 'bg-label-secondary');
          $('#modalDetailPengumuman').modal('show');
        } else {
          showPengumumanToast(res.error || 'Gagal mengambil data', 'danger');
        }
      });
    });

    // Handler: klik tombol edit di modal detail
    $(document).on('click', '#modalDetailPengumuman .btn-edit-pengumuman', function() {
      $('#modalDetailPengumuman').modal('hide');
      // Trigger event edit sesuai logic Anda (misal: buka modal tambah/edit, isi data, dsb)
      var id = $(this).data('id');
      $('.btn-edit-pengumuman[data-id="' + id + '"]:not(#modalDetailPengumuman .btn-edit-pengumuman)').trigger('click');
    });
    // Handler: klik tombol hapus di modal detail
    $(document).on('click', '#modalDetailPengumuman .btn-hapus-pengumuman', function() {
      $('#modalDetailPengumuman').modal('hide');
      // Trigger event hapus sesuai logic Anda (misal: buka modal hapus, isi data, dsb)
      var id = $(this).data('id');
      var judul = $(this).data('judul');
      var role = $(this).data('role');
      $('.btn-hapus-pengumuman[data-id="' + id + '"]:not(#modalDetailPengumuman .btn-hapus-pengumuman)').data('judul', judul).data('role', role).trigger('click');
    });

    // Handler: tampilkan modal konfirmasi hapus pengumuman
    $(document).on('click', '.btn-hapus-pengumuman', function() {
      var id = $(this).data('id');
      var judul = $(this).data('judul');
      var role = $(this).data('role');
      $('#hapusPengumumanId').val(id);
      $('#hapusPengumumanJudul').text(judul);
      $('#hapusPengumumanRole').text(role || '-');
      $('#modalHapusPengumuman').modal('show');
    });

    // Handler: submit form hapus pengumuman
    $(document).on('submit', '#formHapusPengumuman', function(e) {
      e.preventDefault();
      var id = $('#hapusPengumumanId').val();
      $.ajax({
        url: baseUrl + 'app/pengumuman/' + id + '/destroy',
        method: 'DELETE',
        data: { id: id },
        success: function(res) {
          $('#modalHapusPengumuman').modal('hide');
          if (res.success) {
            showPengumumanToast('Data berhasil dihapus!', 'success');
            $('.datatables-pengumuman').DataTable().ajax.reload();
          } else {
            showPengumumanToast(res.error || 'Gagal menghapus data', 'danger');
          }
        },
        error: function(xhr) {
          $('#modalHapusPengumuman').modal('hide');
          showPengumumanToast(xhr.responseJSON?.error || 'Gagal menghapus data', 'danger');
        }
      });
    });

    // Tambahkan event handler toggle status
    $(document).on('change', '.toggle-status-pengumuman', function() {
      var id = $(this).data('id');
      var status = $(this).is(':checked') ? 'aktif' : 'nonaktif';
      $.ajax({
        url: baseUrl + 'app/pengumuman/' + id + '/status',
        method: 'POST',
        data: { status: status },
        success: function(res) {
          showPengumumanToast('Status berhasil diupdate!', 'success');
          $('.datatables-pengumuman').DataTable().ajax.reload(null, false);
        },
        error: function() {
          showPengumumanToast('Gagal update status', 'danger');
        }
      });
    });

    // Handler toggle status di modal detail
    $(document).on('change', '#toggleStatusDetailPengumuman', function() {
      var id = $(this).data('id');
      var status = $(this).is(':checked') ? 'aktif' : 'nonaktif';
      $.ajax({
        url: baseUrl + 'app/pengumuman/' + id + '/status',
        method: 'POST',
        data: { status: status },
        success: function(res) {
          $('#labelStatusDetailPengumuman').text(status === 'aktif' ? 'Aktif' : 'Nonaktif');
          $('#detailPengumumanStatus')
            .text(status === 'aktif' ? 'Aktif' : 'Nonaktif')
            .removeClass('bg-label-success bg-label-secondary')
            .addClass(status === 'aktif' ? 'bg-label-success' : 'bg-label-secondary');
          showPengumumanToast('Status berhasil diupdate!', 'success');
          $('.datatables-pengumuman').DataTable().ajax.reload(null, false);
        },
        error: function() {
          showPengumumanToast('Gagal update status', 'danger');
        }
      });
    });

    dt_pengumuman.on('init.dt', function() {
      if ($('#filterRolePengumuman').length === 0) {
        var filterRole = '<select id="filterRolePengumuman" class="form-select ms-2" style="width:140px; display:inline-block;"><option value="">Semua Role</option><option value="admin">Admin</option><option value="guru">Guru</option><option value="siswa">Siswa</option><option value="semua">Semua</option></select>';
        var filterStatus = '<select id="filterStatusPengumuman" class="form-select ms-2" style="width:120px; display:inline-block;"><option value="">Semua Status</option><option value="aktif">Aktif</option><option value="nonaktif">Nonaktif</option></select>';
        // Sisipkan ke .dataTables_length, bukan ke label
        $('.dataTables_length').css('display', 'flex').append(filterRole + filterStatus);
        $('#filterRolePengumuman').addClass('ms-2 d-inline-block').css('width', '140px');
        $('#filterStatusPengumuman').addClass('ms-2 d-inline-block').css('width', '120px');
        // Patch CSS agar select bisa di-klik
        $('#filterRolePengumuman, #filterStatusPengumuman').css({'pointer-events':'auto','z-index':10,'position':'relative'});
        $('.dataTables_length').css({'position':'relative','z-index':10});
        // Handler filter
        $('#filterRolePengumuman').on('change', function() {
          dt_pengumuman.column(4).search(this.value, true, false).draw();
        });
        $('#filterStatusPengumuman').on('change', function() {
          dt_pengumuman.column(5).search(this.value, true, false).draw();
        });
      }
    });
  }

  // Filter form control to default size
  setTimeout(() => {
    $('.dataTables_filter .form-control').removeClass('form-control-sm');
    $('.dataTables_length .form-select').removeClass('form-select-sm');
  }, 300);
});

function showPengumumanToast(message, type) {
  var icon = $('#pengumumanToast .toast-header i');
  $('#pengumumanToastBody').text(message);
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
  var toast = new bootstrap.Toast(document.getElementById('pengumumanToast'));
  toast.show();
} 