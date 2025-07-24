// File JS DataTable Wali Kelas
'use strict';

$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

$(function () {
  var dt_wali_kelas_table = $('.datatables-wali-kelas');

  if (dt_wali_kelas_table.length) {
    // Tambahkan filter status di kiri tombol export
    dt_wali_kelas_table.on('init.dt', function() {
      if ($('#filterStatusWaliKelas').length === 0) {
        var filterHtml = '<select id="filterStatusWaliKelas" class="form-select me-2" style="width:200px; display:inline-block;">' +
          '<option value="">Semua</option>' +
          '<option value="aktif">Aktif</option>' +
          '<option value="tidak">Tidak Aktif</option>' +
          '</select>';
        $('.dataTables_length label').append(filterHtml);
        $('#filterStatusWaliKelas').addClass('ms-2 d-inline-block').css('width', '180px');
        $('.dataTables_filter').removeClass('me-2 ms-2');
        $(document).on('change', '#filterStatusWaliKelas', function() {
          var val = $(this).val();
          if (val) {
            dt_wali_kelas_table.DataTable().column(5).search('^' + val + '$', true, false).draw();
          } else {
            dt_wali_kelas_table.DataTable().column(5).search('', true, false).draw();
          }
        });
      }
    });

    var dt_wali_kelas = dt_wali_kelas_table.DataTable({
      ajax: {
        url: (baseUrl ? baseUrl.replace(/\/$/, '') : '') + '/app/wali-kelas/data'
      },
      columns: [
        { data: '' },
        { data: 'nama' },
        { data: 'nip' },
        { data: 'kelas', render: function(data, type, full, meta) { return full.kelas ? full.kelas.nama_kelas : '-'; } },
        { data: 'tahun_ajaran' }, // plain text only
        { data: 'status' },
        { data: 'kelas_id', visible: false },
        { data: 'action' }
      ],
      columnDefs: [
        {
          className: 'control',
          searchable: false,
          orderable: false,
          responsivePriority: 2,
          targets: 0,
          render: function (data, type, full, meta) {
            return '';
          }
        },
        {
          targets: 1,
          responsivePriority: 4,
          render: function (data, type, full, meta) {
            var $name = full['nama'] || '';
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
          targets: 4,
          render: function (data, type, full, meta) {
            return full['tahun_ajaran'] || '-';
          }
        },
        {
          targets: 5,
          render: function (data, type, full, meta) {
            if (type === 'display') {
              var $status = full['status'];
              var statusObj = {
                'aktif': { title: 'Aktif', class: 'bg-label-success' },
                'tidak': { title: 'Tidak Aktif', class: 'bg-label-secondary' }
              };
              var s = statusObj[$status] || { title: $status, class: 'bg-label-warning' };
              return '<span class="badge ' + s.class + '" text-capitalized>' + s.title + '</span>';
            }
            // Untuk search/filter, kembalikan data mentah
            return full['status'];
          }
        },
        {
          targets: -1,
          title: 'Aksi',
          searchable: false,
          orderable: false,
          render: function (data, type, full, meta) {
            return (
              '<div class="d-inline-block">' +
                '<a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></a>' +
                '<div class="dropdown-menu dropdown-menu-end m-0">' +
                  '<a href="javascript:;" class="dropdown-item btn-detail-wali-kelas" data-id="' + full.id + '">Detail</a>' +
                  '<a href="javascript:;" class="dropdown-item btn-edit-wali-kelas" data-id="' + full.id + '" data-nama="' + full.nama + '">Edit</a>' +
                  '<div class="dropdown-divider"></div>' +
                  '<a href="javascript:;" class="dropdown-item text-danger btn-hapus-wali-kelas" data-id="' + full.id + '" data-nama="' + full.nama + '" data-nip="' + full.nip + '">Delete</a>' +
                '</div>' +
              '</div>'
            );
          }
        }
      ],
      order: [[1, 'asc']],
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
                columns: [1,2,3,4],
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
                $(win.document.body)
                  .css('color', '#697a8d')
                  .css('border-color', '#d9dee3')
                  .css('background-color', '#fff');
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
              exportOptions: { columns: [1,2,3,4] }
            },
            {
              extend: 'excel',
              text: '<i class="ti ti-file-spreadsheet me-2"></i>Excel',
              className: 'dropdown-item',
              exportOptions: { columns: [1,2,3,4] }
            },
            {
              extend: 'pdf',
              text: '<i class="ti ti-file-code-2 me-2"></i>Pdf',
              className: 'dropdown-item',
              exportOptions: { columns: [1,2,3,4] }
            },
            {
              extend: 'copy',
              text: '<i class="ti ti-copy me-2" ></i>Copy',
              className: 'dropdown-item',
              exportOptions: { columns: [1,2,3,4] }
            }
          ]
        },
        {
          text: '<i class="ti ti-plus me-0 me-sm-1"></i><span class="d-none d-sm-inline-block">Tambah Wali Kelas</span>',
          className: 'add-new btn btn-primary waves-effect waves-light',
          attr: {
            'data-bs-toggle': 'modal',
            'data-bs-target': '#modalAddWaliKelas'
          }
        }
      ],
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (row) {
              var data = row.data();
              return 'Details of ' + data['nama'];
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
                    '"><td>' +
                    col.title +
                    ':</td> <td>' +
                    col.data +
                    '</td></tr>'
                : '';
            }).join('');
            return data ? $('<table class="table"/><tbody />').append(data) : false;
          }
        }
      }
    });
  }

  // Handler: tampilkan modal tambah wali kelas
  $(document).on('click', '[data-bs-target="#modalAddWaliKelas"]', function() {
    $('#formAddWaliKelas')[0].reset();
    $('#formAddWaliKelas input[name=id]').remove();
    $('#modalAddWaliKelasLabel').text('Tambah Wali Kelas');
    $('#formAddWaliKelas button[type=submit]').text('Simpan');
    $('#formAddWaliKelas').data('mode', 'add');
    // Isi dropdown kelas
    $.get((baseUrl ? baseUrl.replace(/\/$/, '') : '') + '/app/kelas/data', function(res) {
      var select = $('#modalAddWaliKelas #selectKelasWali');
      select.empty().append('<option value="">Pilih Kelas</option>');
      if (res.data) {
        res.data.forEach(function(kelas) {
          select.append('<option value="' + kelas.id + '">' + kelas.nama_kelas + '</option>');
        });
      }
      select.select2({
        dropdownParent: $('#modalAddWaliKelas'),
        width: '100%',
        placeholder: 'Pilih Kelas',
        allowClear: true
      });
    });
  });

  // Handler: tampilkan modal edit wali kelas
  $(document).on('click', '.btn-edit-wali-kelas', function() {
    $('#modalDetailWaliKelas').modal('hide');
    var id = $(this).data('id');
    $.get((baseUrl ? baseUrl.replace(/\/$/, '') : '') + '/app/wali-kelas/getbyid/' + id, function(resWali) {
      if (resWali.success) {
        $('#formAddWaliKelas')[0].reset();
        if ($('#formAddWaliKelas input[name=id]').length === 0) {
          $('#formAddWaliKelas').prepend('<input type="hidden" name="id" id="editWaliKelasId">');
        }
        $('#editWaliKelasId').val(resWali.data.id);
        $('#formAddWaliKelas input[name=nama]').val(resWali.data.nama);
        $('#formAddWaliKelas input[name=nip]').val(resWali.data.nip);
        // Set status toggle dan label
        var isAktif = resWali.data.status === 'aktif';
        $('#statusAktifWaliSwitch').prop('checked', isAktif);
        $('#statusAktifWaliLabel').text(isAktif ? 'Aktif' : 'Tidak Aktif');
        $('#modalAddWaliKelasLabel').text('Edit Wali Kelas');
        $('#formAddWaliKelas button[type=submit]').text('Simpan Perubahan');
        $('#formAddWaliKelas').data('mode', 'edit');
        $('#modalAddWaliKelas').modal('show');
        // Isi dropdown kelas
        $.get((baseUrl ? baseUrl.replace(/\/$/, '') : '') + '/app/kelas/data', function(resKelas) {
          var select = $('#modalAddWaliKelas #selectKelasWali');
          select.empty().append('<option value="">Pilih Kelas</option>');
          if (resKelas.data) {
            resKelas.data.forEach(function(kelas) {
              select.append('<option value="' + kelas.id + '">' + kelas.nama_kelas + '</option>');
            });
          }
          if (select.hasClass('select2-hidden-accessible')) {
            select.select2('destroy');
          }
          select.select2({
            dropdownParent: $('#modalAddWaliKelas'),
            width: '100%',
            placeholder: 'Pilih Kelas',
            allowClear: true
          });
          setTimeout(function() {
            select.val(resWali.data.kelas_id ? resWali.data.kelas_id.toString() : '').trigger('change');
          }, 0);
        });
      } else {
        showWaliKelasToast(resWali.error || 'Gagal mengambil data', 'danger');
      }
    });
  });

  // Handler: submit form tambah/edit wali kelas
  $(document).on('submit', '#formAddWaliKelas', function(e) {
    e.preventDefault();
    var mode = $(this).data('mode');
    var url = (baseUrl ? baseUrl.replace(/\/$/, '') : '') + (mode === 'edit' ? '/app/wali-kelas/updatebyid' : '/app/wali-kelas/store');
    var formData = $(this).serialize();
    $.ajax({
      url: url,
      method: 'POST',
      data: formData,
      success: function(res) {
        $('#modalAddWaliKelas').modal('hide');
        if (res.success) {
          showWaliKelasToast('Data berhasil disimpan!', 'success');
          $('.datatables-wali-kelas').DataTable().ajax.reload();
        } else {
          showWaliKelasToast(res.error || 'Gagal menyimpan data', 'danger');
        }
      },
      error: function(xhr) {
        $('#modalAddWaliKelas').modal('hide');
        showWaliKelasToast(xhr.responseJSON?.error || 'Gagal menyimpan data', 'danger');
      },
      complete: function() {
        $('#formAddWaliKelas')[0].reset();
        $('#formAddWaliKelas input[name=id]').remove();
        $('#modalAddWaliKelasLabel').text('Tambah Wali Kelas');
        $('#formAddWaliKelas button[type=submit]').text('Simpan');
        $('#formAddWaliKelas').data('mode', 'add');
      }
    });
  });

  // Handler: tampilkan modal detail wali kelas
  $(document).on('click', '.btn-detail-wali-kelas', function() {
    var id = $(this).data('id');
    $.get(baseUrl + 'app/wali-kelas/getbyid/' + id, function(res) {
      if (res.success) {
        $('#detailWaliKelasNama').text(res.data.nama);
        $('#detailWaliKelasNamaTitle').text(res.data.nama);
        $('#detailWaliKelasNip').text(res.data.nip);
        $('#detailWaliKelasKelas').text(res.data.kelas && res.data.kelas.nama_kelas ? res.data.kelas.nama_kelas : '-');
        var statusText = res.data.status === 'aktif' ? 'Aktif' : 'Tidak Aktif';
        var statusClass = res.data.status === 'aktif' ? 'bg-label-success' : 'bg-label-danger';
        $('#detailWaliKelasStatus').text(statusText).removeClass('bg-label-success bg-label-danger').addClass(statusClass);
        $('#modalDetailWaliKelas .btn-edit-wali-kelas').data('id', res.data.id).data('nama', res.data.nama);
        $('#modalDetailWaliKelas .btn-hapus-wali-kelas').data('id', res.data.id).data('nama', res.data.nama).data('nip', res.data.nip);
        $('#modalDetailWaliKelas').modal('show');
      } else {
        showWaliKelasToast(res.error || 'Gagal mengambil data', 'danger');
      }
    });
  });

  // Handler: hapus wali kelas
  $(document).on('click', '.btn-hapus-wali-kelas', function () {
    var id = $(this).data('id');
    var nama = $(this).data('nama');
    var nip = $(this).data('nip');
    $('#hapusWaliKelasId').val(id);
    $('#hapusWaliKelasNama').text(nama);
    $('#hapusWaliKelasNip').text(nip);
    // Kelas dihapus di detail modal
    if ($('#modalDetailWaliKelas').hasClass('show')) {
      $('#modalDetailWaliKelas').modal('hide');
      $('#modalDetailWaliKelas').one('hidden.bs.modal', function() {
        $('#modalHapusWaliKelas').modal('show');
      });
    } else {
      $('#modalHapusWaliKelas').modal('show');
    }
  });

  // Handler: submit form hapus via AJAX
  $(document).on('submit', '#formHapusWaliKelas', function(e) {
    e.preventDefault();
    var id = $('#hapusWaliKelasId').val();
    $.ajax({
      url: (baseUrl ? baseUrl.replace(/\/$/, '') : '') + '/app/wali-kelas/deletebyid',
      method: 'POST',
      data: { id: id },
      success: function(res) {
        $('#modalHapusWaliKelas').modal('hide');
        if (res.success) {
          showWaliKelasToast('Data berhasil dihapus!', 'success');
          $('.datatables-wali-kelas').DataTable().ajax.reload();
        } else {
          showWaliKelasToast(res.error || 'Gagal menghapus data', 'danger');
        }
      },
      error: function(xhr) {
        $('#modalHapusWaliKelas').modal('hide');
        showWaliKelasToast(xhr.responseJSON?.error || 'Gagal menghapus data', 'danger');
      }
    });
  });

  setTimeout(() => {
    $('.dataTables_filter .form-control').removeClass('form-control-sm');
    $('.dataTables_length .form-select').removeClass('form-select-sm');
  }, 300);
});

function showWaliKelasToast(message, type) {
  var icon = $('#waliKelasToast .toast-header i');
  $('#waliKelasToastBody').text(message);

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

  var toast = new bootstrap.Toast(document.getElementById('waliKelasToast'));
  toast.show();
}

// Isi select Guru, Kelas, Tahun Ajaran saat modal tambah/edit dibuka
function loadSelectOptionsWaliKelas(selectedGuruId, selectedKelasId, selectedTahunAjaranId) {
  // Guru
  $.get((baseUrl ? baseUrl.replace(/\/$/, '') : '') + '/app/guru/data', function(res) {
    var select = $('#selectGuruWali');
    select.empty().append('<option value="">Pilih Guru</option>');
    if (res.data) {
      res.data.forEach(function(guru) {
        select.append('<option value="' + guru.id + '">' + guru.nama + ' (' + guru.nip + ')</option>');
      });
    }
    if (select.hasClass('select2-hidden-accessible')) {
      select.select2('destroy');
    }
    select.select2({
      dropdownParent: $('#modalAddWaliKelas'),
      width: '100%',
      placeholder: 'Pilih Guru',
      allowClear: true
    });
    if (selectedGuruId) {
      setTimeout(function() {
        select.val(selectedGuruId.toString()).trigger('change');
      }, 0);
    }
  });
  // Kelas
  $.get((baseUrl ? baseUrl.replace(/\/$/, '') : '') + '/app/kelas/data', function(res) {
    var select = $('#selectKelasWali');
    select.empty().append('<option value="">Pilih Kelas</option>');
    if (res.data) {
      res.data.forEach(function(kelas) {
        select.append('<option value="' + kelas.id + '">' + kelas.nama_kelas + '</option>');
      });
    }
    if (select.hasClass('select2-hidden-accessible')) {
      select.select2('destroy');
    }
    select.select2({
      dropdownParent: $('#modalAddWaliKelas'),
      width: '100%',
      placeholder: 'Pilih Kelas',
      allowClear: true
    });
    if (selectedKelasId) {
      setTimeout(function() {
        select.val(selectedKelasId.toString()).trigger('change');
      }, 0);
    }
  });
  // Tahun Ajaran
  $.get((baseUrl ? baseUrl.replace(/\/$/, '') : '') + '/app/tahun-ajaran/data', function(res) {
    var select = $('#selectTahunAjaranWali');
    select.empty().append('<option value="">Pilih Tahun Ajaran</option>');
    if (res.data) {
      res.data.forEach(function(ta) {
        select.append('<option value="' + ta.id + '">' + ta.tahun + '</option>');
      });
    }
    if (select.hasClass('select2-hidden-accessible')) {
      select.select2('destroy');
    }
    select.select2({
      dropdownParent: $('#modalAddWaliKelas'),
      width: '100%',
      placeholder: 'Pilih Tahun Ajaran',
      allowClear: true
    });
    if (selectedTahunAjaranId) {
      setTimeout(function() {
        select.val(selectedTahunAjaranId.toString()).trigger('change');
      }, 0);
    }
  });
}

// Panggil saat modal tambah wali kelas dibuka (tanpa parameter)
$(document).on('show.bs.modal', '#modalAddWaliKelas', function() {
  if ($('#formAddWaliKelas').data('mode') !== 'edit') {
    loadSelectOptionsWaliKelas();
  }
});

// Handler: edit wali kelas
$(document).on('click', '.btn-edit-wali-kelas', function() {
  var id = $(this).data('id');
  $.get((baseUrl ? baseUrl.replace(/\/$/, '') : '') + '/app/wali-kelas/getbyid/' + id, function(resWali) {
    if (resWali.success) {
      if ($('#formAddWaliKelas input[name=id]').length === 0) {
        $('#formAddWaliKelas').prepend('<input type="hidden" name="id" id="editWaliKelasId">');
      }
      $('#editWaliKelasId').val(resWali.data.id);
      $('#modalAddWaliKelasLabel').text('Edit Wali Kelas');
      $('#formAddWaliKelas button[type=submit]').text('Simpan Perubahan');
      $('#formAddWaliKelas').data('mode', 'edit');
      $('#modalAddWaliKelas').modal('show');
      // Isi dan set selected pada semua select
      loadSelectOptionsWaliKelas(resWali.data.guru_id, resWali.data.kelas_id, resWali.data.tahun_ajaran_id);
    } else {
      showWaliKelasToast(resWali.error || 'Gagal mengambil data', 'danger');
    }
  });
});

// Handler: toggle status aktif label
$(document).on('change', '#statusAktifWaliSwitch', function() {
  var label = $('#statusAktifWaliLabel');
  if ($(this).is(':checked')) {
    label.text('Aktif');
  } else {
    label.text('Tidak Aktif');
  }
});

// Inisialisasi select2 pada semua select setelah modal tampil
$(document).on('shown.bs.modal', '#modalAddWaliKelas', function() {
  ['#selectGuruWali', '#selectKelasWali', '#selectTahunAjaranWali'].forEach(function(sel) {
    var $el = $(sel);
    if ($el.hasClass('select2-hidden-accessible')) {
      $el.select2('destroy');
    }
    $el.select2({
      dropdownParent: $('#modalAddWaliKelas'),
      width: '100%',
      placeholder: $el.find('option:first').text(),
      allowClear: true
    });
  });
}); 