/**
 * Page User List
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
  var dt_guru_table = $('.datatables-guru'),
    select2 = $('.select2'),
    guruView = baseUrl + 'app/guru/view/account',
    statusObj = {
      1: { title: 'Pending', class: 'bg-label-warning' },
      2: { title: 'Active', class: 'bg-label-success' },
      3: { title: 'Inactive', class: 'bg-label-secondary' }
    };

  if (select2.length) {
    var $this = select2;
    $this.wrap('<div class="position-relative"></div>').select2({
      placeholder: 'Select Country',
      dropdownParent: $this.parent()
    });
  }

  // Users datatable
  if (dt_guru_table.length) {
    var dt_guru = dt_guru_table.DataTable({
      ajax: {
        url: baseUrl + 'app/guru/list'
      }, // JSON file to add data
      columns: [
        { data: null }, // 0: expand
        { data: 'nip' }, // 1: checkbox
        { data: 'nama' },
        { data: 'jenis_kelamin' },
        { data: 'alamat' },
        { data: 'status' },
        { data: 'action' }
      ],
      columnDefs: [
        {
          // For Responsive (expand)
          className: 'control',
          searchable: false,
          orderable: false,
          responsivePriority: 1,
          targets: 0,
          render: function() { return ''; }
        },
        {
          // For Checkboxes
          orderable: false,
          searchable: false,
          targets: 1,
          render: function(data, type, full, meta) {
            if (type === 'display') {
              return '<input type="checkbox" class="form-check-input guru-checkbox" value="' + full.nip + '" />';
            }
            return '';
          }
        },
        {
          // Nama guru
          targets: 2,
          responsivePriority: 4,
          render: function (data, type, full, meta) {
            var $name = full['nama'];
            var stateNum = Math.floor(Math.random() * 6);
            var states = ['success', 'danger', 'warning', 'info', 'primary', 'secondary'];
            var $state = states[stateNum],
              $initials = $name.match(/\b\w/g) || [];
            $initials = (($initials.shift() || '') + ($initials.pop() || '')).toUpperCase();
            var $output = '<span class="avatar-initial rounded-circle bg-label-' + $state + '">' + $initials + '</span>';
            var $row_output =
              '<div class="d-flex justify-content-start align-items-center user-name">' +
              '<div class="avatar-wrapper">' +
              '<div class="avatar me-3">' +
              $output +
              '</div>' +
              '</div>' +
              '<div class="d-flex flex-column">' +
              '<span class="fw-medium">' + $name + '</span>' +
              '</div>' +
              '</div>';
            return $row_output;
          }
        },
        {
          // Jenis Kelamin
          targets: 3,
          render: function (data, type, full, meta) {
            var $jk = full['jenis_kelamin'];
            var jkLabel = $jk === 'L' ? 'Laki-laki' : ($jk === 'P' ? 'Perempuan' : '-');
            var roleBadgeObj = {
              'L': '<span class="badge badge-center rounded-pill bg-label-primary w-px-30 h-px-30 me-2"><i class="ti ti-gender-male ti-sm text-primary"></i></span>',
              'P': '<span class="badge badge-center rounded-pill bg-label-primary w-px-30 h-px-30 me-2"><i class="ti ti-gender-female ti-sm text-primary"></i></span>'
            };
            return "<span class='text-truncate d-flex align-items-center'>" + (roleBadgeObj[$jk] || '') + jkLabel + '</span>';
          }
        },
        {
          // Alamat
          targets: 4,
          render: function (data, type, full, meta) {
            var $alamat = full['alamat'];
            return '<span>' + $alamat + '</span>';
          }
        },
        {
          // Status
          targets: 5,
          render: function (data, type, full, meta) {
            var $status = full['status'];
            var statusObj = {
              'aktif': { title: 'Aktif', class: 'bg-label-success' },
              'tidak': { title: 'Tidak Aktif', class: 'bg-label-secondary' },
              'lulus': { title: 'Lulus', class: 'bg-label-info' }
            };
            var s = statusObj[$status] || { title: $status, class: 'bg-label-warning' };
            return '<span class="badge ' + s.class + '" text-capitalized>' + s.title + '</span>';
          }
        },
        {
          // Kolom aksi (action)
          targets: 6,
          title: 'Aksi',
          searchable: false,
          orderable: false,
          render: function (data, type, full, meta) {
            return (
              '<div class="d-inline-block">' +
                '<a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></a>' +
                '<div class="dropdown-menu dropdown-menu-end m-0">' +
                  '<a href="javascript:;" class="dropdown-item btn-detail-guru" data-nip="' + full.nip + '">Detail</a>' +
                  '<a href="javascript:;" class="dropdown-item btn-edit-guru" data-nip="' + full.nip + '">Edit</a>' +
                  '<div class="dropdown-divider"></div>' +
                  '<a href="javascript:;" class="dropdown-item text-danger btn-hapus-guru" data-nip="' + full.nip + '" data-nama="' + full.nama + '">Hapus</a>' +
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
      // Buttons with Dropdown
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
                columns: [1, 2, 3, 4, 5],
                // prevent avatar to be print
                format: {
                  body: function (inner, coldex, rowdex) {
                    if (inner.length <= 0) return inner;
                    var el = $.parseHTML(inner);
                    var result = '';
                    $.each(el, function (index, item) {
                      if (item.classList !== undefined && item.classList.contains('user-name')) {
                        result = result + item.lastChild.firstChild.textContent;
                      } else if (item.innerText === undefined) {
                        result = result + item.textContent;
                      } else result = result + item.innerText;
                    });
                    return result;
                  }
                }
              },
              customize: function (win) {
                //customize print view for dark
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
                columns: [1, 2, 3, 4, 5],
                // prevent avatar to be display
                format: {
                  body: function (inner, coldex, rowdex) {
                    if (inner.length <= 0) return inner;
                    var el = $.parseHTML(inner);
                    var result = '';
                    $.each(el, function (index, item) {
                      if (item.classList !== undefined && item.classList.contains('user-name')) {
                        result = result + item.lastChild.firstChild.textContent;
                      } else if (item.innerText === undefined) {
                        result = result + item.textContent;
                      } else result = result + item.innerText;
                    });
                    return result;
                  }
                }
              }
            },
            {
              extend: 'excel',
              text: '<i class="ti ti-file-spreadsheet me-2"></i>Excel',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4, 5],
                // prevent avatar to be display
                format: {
                  body: function (inner, coldex, rowdex) {
                    if (inner.length <= 0) return inner;
                    var el = $.parseHTML(inner);
                    var result = '';
                    $.each(el, function (index, item) {
                      if (item.classList !== undefined && item.classList.contains('user-name')) {
                        result = result + item.lastChild.firstChild.textContent;
                      } else if (item.innerText === undefined) {
                        result = result + item.textContent;
                      } else result = result + item.innerText;
                    });
                    return result;
                  }
                }
              }
            },
            {
              extend: 'pdf',
              text: '<i class="ti ti-file-code-2 me-2"></i>Pdf',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4, 5],
                // prevent avatar to be display
                format: {
                  body: function (inner, coldex, rowdex) {
                    if (inner.length <= 0) return inner;
                    var el = $.parseHTML(inner);
                    var result = '';
                    $.each(el, function (index, item) {
                      if (item.classList !== undefined && item.classList.contains('user-name')) {
                        result = result + item.lastChild.firstChild.textContent;
                      } else if (item.innerText === undefined) {
                        result = result + item.textContent;
                      } else result = result + item.innerText;
                    });
                    return result;
                  }
                }
              }
            },
            {
              extend: 'copy',
              text: '<i class="ti ti-copy me-2" ></i>Copy',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4, 5],
                // prevent avatar to be display
                format: {
                  body: function (inner, coldex, rowdex) {
                    if (inner.length <= 0) return inner;
                    var el = $.parseHTML(inner);
                    var result = '';
                    $.each(el, function (index, item) {
                      if (item.classList !== undefined && item.classList.contains('user-name')) {
                        result = result + item.lastChild.firstChild.textContent;
                      } else if (item.innerText === undefined) {
                        result = result + item.textContent;
                      } else result = result + item.innerText;
                    });
                    return result;
                  }
                }
              }
            }
          ]
        },
        {
          text: '<i class="ti ti-plus me-0 me-sm-1"></i><span class="d-none d-sm-inline-block">Tambah Guru</span>',
          className: 'add-new btn btn-primary waves-effect waves-light',
          attr: {
            'data-bs-toggle': 'modal',
            'data-bs-target': '#modalAddGuru'
          }
        }
      ],
      // For responsive popup
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (row) {
              var data = row.data();
              return 'Details of ' + data['full_name'];
            }
          }),
          type: 'column',
          renderer: function (api, rowIdx, columns) {
            var data = $.map(columns, function (col, i) {
              return col.title !== '' // ? Do not show row in modal popup if title is blank (for check box)
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
        // Gabungkan filter Jenis Kelamin dan Status di .user_role
        this.api()
          .columns([5])
          .every(function (colIdx) {
            var column = this;
            // Filter Status
            var selectStatus = $(
              '<select id="GuruStatus" class="form-select text-capitalize d-inline-block" style="width:auto; display:inline-block;"><option value=""> Pilih Status </option><option value="aktif">Aktif</option><option value="tidak">Tidak Aktif</option></select>'
            )
              .appendTo('.user_status')
              .on('change', function () {
                var val = $(this).val();
                column.search(val ? '^' + val + '$' : '', true, false).draw();
              });
          });
        // HAPUS: Adding plan filter once table initialized
        // this.api()
        //   .columns(3)
        //   .every(function () {
        //     var column = this;
        //     var select = $(
        //       '<select id="GuruPlan" class="form-select text-capitalize"><option value=""> Select Plan </option></select>'
        //     )
        //       .appendTo('.user_plan')
        //       .on('change', function () {
        //         var val = $.fn.dataTable.util.escapeRegex($(this).val());
        //         column.search(val ? '^' + val + '$' : '', true, false).draw();
        //       });
        //
        //     column
        //       .data()
        //       .unique()
        //       .sort()
        //       .each(function (d, j) {
        //         select.append('<option value="' + d + '">' + d + '</option>');
        //       });
        //   });
        // Adding status filter once table initialized
        // this.api()
        //   .columns(5)
        //   .every(function () {
        //     var column = this;
        //     var select = $(
        //       '<select id="GuruStatus" class="form-select text-capitalize"><option value=""> Select Status </option></select>'
        //     )
        //       .appendTo('.user_status')
        //       .on('change', function () {
        //         var val = $.fn.dataTable.util.escapeRegex($(this).val());
        //         column.search(val ? '^' + val + '$' : '', true, false).draw();
        //       });
        //
        //     column
        //       .data()
        //       .unique()
        //       .sort()
        //       .each(function (d, j) {
        //         select.append(
        //           '<option value="' +
        //             statusObj[d].title +
        //             '" class="text-capitalize">' +
        //             statusObj[d].title +
        //             '</option>'
        //         );
        //       });
        //   });
      }
    });

    // Tambahkan filter status di kiri, sejajar dengan 'Show entries'
    dt_guru_table.on('init.dt', function() {
      if ($('#filterStatusGuru').length === 0) {
        // Buat select filter status dengan opsi default 'Semua'
        var filterHtml = '<select id="filterStatusGuru" class="form-select me-2" style="width:180px; display:inline-block;">' +
          '<option value="">Semua</option>' +
          '<option value="aktif">Aktif</option>' +
          '<option value="tidak">Tidak Aktif</option>' +
        '</select>';
        // Sisipkan ke dalam .dataTables_length agar sejajar
        $('.dataTables_length label').append(filterHtml);
        $('#filterStatusGuru').addClass('ms-2 d-inline-block').css('width', '180px');
        // Hilangkan margin pada search bar
        $('.dataTables_filter').removeClass('me-2 ms-2');
      // Handler filter
        $(document).on('change', '#filterStatusGuru', function() {
        var val = $(this).val();
          dt_guru_table.DataTable().column(5).search(val ? '^' + val + '$' : '', true, false).draw();
      });
    }
    });
  }

  // Tambah select all checkbox di header setelah DataTable selesai inisialisasi
  dt_guru.on('draw', function () {
    // Hanya tambahkan sekali
    if ($('.datatables-guru thead th:eq(1) input[type="checkbox"].select-all-guru').length === 0) {
      $('.datatables-guru thead th:eq(1)').html('<input type="checkbox" class="form-check-input select-all-guru" />');
      // Hapus class sorting dan event sort di header checkbox
      $('.datatables-guru thead th:eq(1)')
        .removeClass('sorting sorting_asc sorting_desc')
        .off('click');
    }
    // Reset select all jika ada perubahan halaman
    $('.select-all-guru').prop('checked', false);
  });

  // Event: select all
  $(document).on('change', '.select-all-guru', function () {
    var checked = $(this).is(':checked');
    $('.datatables-guru tbody input.guru-checkbox').prop('checked', checked);
  });

  // Event: update select all jika ada perubahan di checkbox baris
  $(document).on('change', '.datatables-guru tbody input.guru-checkbox', function () {
    var all = $('.datatables-guru tbody input.guru-checkbox').length;
    var checked = $('.datatables-guru tbody input.guru-checkbox:checked').length;
    $('.select-all-guru')
      .prop('checked', all === checked && all > 0)
      .prop('indeterminate', checked > 0 && checked < all);
  });

  // Delete Record
  $('.datatables-guru tbody').on('click', '.delete-record', function () {
    dt_guru.row($(this).parents('tr')).remove().draw();
  });

  // Update render kolom aksi agar tombol hapus punya class dan data-id
  // (Pastikan di render kolom aksi, tombol hapus seperti ini:)
  // '<button class="btn btn-sm btn-danger btn-hapus-guru" data-id="'+full.id+'">Hapus</button>'

  // Handler: tampilkan modal konfirmasi saat tombol hapus diklik
  $(document).on('click', '.btn-hapus-guru', function() {
    // Tutup modal detail jika sedang terbuka
    $('#modalDetailGuru').modal('hide');
    var nip = $(this).data('nip');
    var nama = $(this).data('nama');
    $('#hapusGuruNip').text(nip); // <-- fix: gunakan .text() agar tampil di tabel
    $('#hapusGuruNama').text(nama);
    $('#modalHapusGuru').modal('show');
  });

  // Handler: submit form hapus via AJAX
  $(document).on('submit', '#formHapusGuru', function(e) {
    e.preventDefault();
    var nip = $('#hapusGuruNip').val();
    $.ajax({
      url: baseUrl + 'app/guru/deletebynip',
      method: 'POST',
      data: { nip: nip },
      success: function(res) {
        $('#modalHapusGuru').modal('hide');
        if (res.success) {
          showGuruToast('Data berhasil dihapus!', 'success');
          $('.datatables-guru').DataTable().ajax.reload();
        } else {
          showGuruToast(res.error || 'Gagal menghapus data', 'danger');
        }
      },
      error: function(xhr) {
        $('#modalHapusGuru').modal('hide');
        showGuruToast(xhr.responseJSON?.error || 'Gagal menghapus data', 'danger');
      }
    });
  });

  // Handler: tampilkan modal tambah guru (mode tambah)
  $(document).on('click', '[data-bs-target="#modalAddGuru"]', function() {
    // Reset form
    $('#formAddGuru')[0].reset();
    $('#formAddGuru input[name=id]').remove();
    $('#modalAddGuruLabel').text('Tambah Guru');
    $('#formAddGuru button[type=submit]').text('Simpan');
    $('#formAddGuru').data('mode', 'add');
  });

  // Handler: tampilkan modal edit guru (pakai modal tambah)
  $(document).on('click', '.btn-edit-guru', function() {
    // Tutup modal detail jika sedang terbuka
    $('#modalDetailGuru').modal('hide');
    var nip = $(this).data('nip');
    $.get(baseUrl + 'app/guru/getbynip/' + nip, function(res) {
      if (res.success) {
        // Isi field
        $('#formAddGuru')[0].reset();
        // Tambah/isi hidden id
        if ($('#formAddGuru input[name=id]').length === 0) {
          $('#formAddGuru').prepend('<input type="hidden" name="id" id="editGuruId">');
        }
        $('#editGuruId').val(res.data.id);
        $('#formAddGuru input[name=nip]').val(res.data.nip);
        $('#formAddGuru input[name=nama]').val(res.data.nama);
        $('#formAddGuru input[name=tempat_lahir]').val(res.data.tempat_lahir);
        $('#formAddGuru input[name=tanggal_lahir]').val(res.data.tanggal_lahir);
        $('#formAddGuru select[name=jenis_kelamin]').val(res.data.jenis_kelamin);
        $('#formAddGuru textarea[name=alamat]').val(res.data.alamat);
        $('#formAddGuru input[name=status]').prop('checked', res.data.status === 'aktif');
        // Ubah judul dan tombol
        $('#modalAddGuruLabel').text('Edit Guru');
        $('#formAddGuru button[type=submit]').text('Simpan Perubahan');
        $('#formAddGuru').data('mode', 'edit');
        $('#modalAddGuru').modal('show');
      } else {
        showGuruToast(res.error || 'Gagal mengambil data', 'danger');
      }
    });
  });

  // Handler: submit form tambah/edit guru
  $(document).on('submit', '#formAddGuru', function(e) {
    e.preventDefault();
    var mode = $(this).data('mode');
    var url = mode === 'edit' ? baseUrl + 'app/guru/update' : baseUrl + 'app/guru/store';
    var formData = $(this).serialize();
    $.ajax({
      url: url,
      method: 'POST',
      data: formData,
      success: function(res) {
        $('#modalAddGuru').modal('hide');
        if (res.success) {
          showGuruToast('Data berhasil disimpan!', 'success');
          $('.datatables-guru').DataTable().ajax.reload();
        } else {
          showGuruToast(res.error || 'Gagal menyimpan data', 'danger');
        }
      },
      error: function(xhr) {
        $('#modalAddGuru').modal('hide');
        showGuruToast(xhr.responseJSON?.error || 'Gagal menyimpan data', 'danger');
      },
      complete: function() {
        // Reset ke mode tambah
        $('#formAddGuru')[0].reset();
        $('#formAddGuru input[name=id]').remove();
        $('#modalAddGuruLabel').text('Tambah Guru');
        $('#formAddGuru button[type=submit]').text('Simpan');
        $('#formAddGuru').data('mode', 'add');
      }
    });
  });

  // Handler: tampilkan modal detail saat tombol detail diklik
  $(document).on('click', '.btn-detail-guru', function() {
    var nip = $(this).data('nip');
    $.get(baseUrl + 'app/guru/getbynip/' + nip, function(res) {
      if (res.success) {
        // Nama
        $('#detailGuruNama').text(res.data.nama);
        $('#detailGuruNamaTitle').text(res.data.nama);
        // NIP
        $('#detailGuruNip').text(res.data.nip);
        // Tempat & Tanggal Lahir
        var tgl = res.data.tanggal_lahir ? res.data.tanggal_lahir : '-';
        $('#detailGuruTanggalLahir').text(res.data.tempat_lahir + ', ' + tgl);
        // Jenis Kelamin
        var jk = res.data.jenis_kelamin === 'L' ? 'Laki-laki' : (res.data.jenis_kelamin === 'P' ? 'Perempuan' : '-');
        $('#detailGuruJenisKelamin').text(jk);
        // Alamat
        $('#detailGuruAlamat').text(res.data.alamat);
        // Status
        var statusText = res.data.status === 'aktif' ? 'Aktif' : (res.data.status === 'tidak' ? 'Tidak Aktif' : 'Lulus');
        var statusClass = res.data.status === 'aktif' ? 'bg-label-success' : (res.data.status === 'tidak' ? 'bg-label-danger' : 'bg-label-warning');
        $('#detailGuruStatus').text(statusText).removeClass('bg-label-success bg-label-danger bg-label-warning').addClass(statusClass);
        // Avatar Initial
        var initials = (res.data.nama || '').split(' ').map(function(n){return n[0];}).join('').substring(0,2).toUpperCase();
        $('#detailGuruInitial').text(initials);
        // Set data-nip dan data-nama pada tombol edit dan hapus di modal detail
        $('#modalDetailGuru .btn-edit-guru').data('nip', res.data.nip).data('nama', res.data.nama);
        $('#modalDetailGuru .btn-hapus-guru').data('nip', res.data.nip).data('nama', res.data.nama);
        // Show modal
        $('#modalDetailGuru').modal('show');
      } else {
        showGuruToast(res.error || 'Gagal mengambil data', 'danger');
      }
    });
  });

  // Filter form control to default size
  // ? setTimeout used for multilingual table initialization
  setTimeout(() => {
    $('.dataTables_filter .form-control').removeClass('form-control-sm');
    $('.dataTables_length .form-select').removeClass('form-select-sm');
  }, 300);
});

function showGuruToast(message, type) {
  var icon = $('#guruToast .toast-header i');
  $('#guruToastBody').text(message);

  // Reset warna icon
  icon.removeClass('text-success text-danger text-warning text-info');

  // Tambah warna sesuai status
  if (type === 'danger') {
    icon.addClass('text-danger');
  } else if (type === 'warning') {
    icon.addClass('text-warning');
  } else if (type === 'info') {
    icon.addClass('text-info');
  } else {
    icon.addClass('text-success');
  }

  var toast = new bootstrap.Toast(document.getElementById('guruToast'));
  toast.show();
}

// Handler submit form tambah Guru via modal
$(document).on('submit', '#formAddGuru', function(e) {
  e.preventDefault();
  var form = $(this);
  $.ajax({
    url: baseUrl + 'app/guru/store',
    method: 'POST',
    data: form.serialize(),
    success: function(res) {
      if (res.success) {
        $('#modalAddGuru').modal('hide');
        $('.datatables-guru').DataTable().ajax.reload();
        form[0].reset();
        showGuruToast('Data berhasil disimpan!', 'success');
      } else {
        showGuruToast(res.error || 'Gagal menambah data', 'danger');
      }
    },
    error: function(xhr) {
      showGuruToast(xhr.responseJSON?.error || 'Gagal menambah data', 'danger');
    }
  });
});

// Validation & Phone mask
(function () {
  const phoneMaskList = document.querySelectorAll('.phone-mask'),
    addNewGuruForm = document.getElementById('addNewGuruForm');

  // Phone Number
  if (phoneMaskList) {
    phoneMaskList.forEach(function (phoneMask) {
      new Cleave(phoneMask, {
        phone: true,
        phoneRegionCode: 'US'
      });
    });
  }
  // Add New User Form Validation
  if (addNewGuruForm) {
    const fv = FormValidation.formValidation(addNewGuruForm, {
      fields: {
        userFullname: {
          validators: {
            notEmpty: {
              message: 'Please enter fullname '
            }
          }
        },
        userEmail: {
          validators: {
            notEmpty: {
              message: 'Please enter your email'
            },
            emailAddress: {
              message: 'The value is not a valid email address'
            }
          }
        }
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          // Use this for enabling/changing valid/invalid class
          eleValidClass: '',
          rowSelector: function (field, ele) {
            // field is the field name & ele is the field element
            return '.mb-3';
          }
        }),
        submitButton: new FormValidation.plugins.SubmitButton(),
        // Submit the form when all fields are valid
        // defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
        autoFocus: new FormValidation.plugins.AutoFocus()
      }
    });
  } else {
    console.warn('addNewGuruForm not found in DOM!');
  }
})();
