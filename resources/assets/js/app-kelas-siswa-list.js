/**
 * Page Kelas Siswa List
 */

'use strict';

// Setup CSRF token untuk semua AJAX request
$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

$(function () {
  var dt_kelas_siswa_table = $('.datatables-kelas-siswa');

  // Inisialisasi filter kelas dan tahun ajaran
  function initFilterKelasTahunAjaran() {
    // Kelas
    $.get('/app/kelas/data', function(res) {
      var select = $('#filterKelasSiswa');
      select.empty().append('<option value="">Semua Kelas</option>');
      if (res.data) {
        res.data.forEach(function(kelas) {
          select.append('<option value="' + kelas.nama_kelas + '">' + kelas.nama_kelas + '</option>');
        });
      }
    });
    // Tahun Ajaran
    $.get('/app/tahun-ajaran/data', function(res) {
      var select = $('#filterTahunAjaranSiswa');
      select.empty().append('<option value="">Semua TA</option>');
      if (res.data) {
        res.data.forEach(function(ta) {
          select.append('<option value="' + ta.tahun + '">' + ta.tahun + '</option>');
        });
      }
    });
  }

  if (dt_kelas_siswa_table.length) {
    var dt_kelas_siswa = dt_kelas_siswa_table.DataTable({
      ajax: {
        url: '/app/kelas-siswa/data'
      },
      columns: [
        { data: null }, // expand
        { data: 'kelas_nama' },
        { data: 'siswa_nama' },
        { data: 'tahun_ajaran_nama' },
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
          targets: 1,
          render: function (data, type, full, meta) {
            return '<span class="fw-medium">' + (full.kelas_nama || '-') + '</span>';
          }
        },
        {
          targets: 2,
          render: function (data, type, full, meta) {
            return '<span>' + (full.siswa_nama || '-') + '</span>';
          }
        },
        {
          targets: 3,
          render: function (data, type, full, meta) {
            return '<span>' + (full.tahun_ajaran_nama || '-') + '</span>';
          }
        },
        {
          targets: 4,
          render: function (data, type, full, meta) {
            var $status = full['status'];
            var statusObj = {
              'aktif': { title: 'Aktif', class: 'bg-label-success' },
              'tidak': { title: 'Tidak Aktif', class: 'bg-label-secondary' }
            };
            var s = statusObj[$status] || { title: $status, class: 'bg-label-warning' };
            return '<span class="badge ' + s.class + '">' + s.title + '</span>';
          }
        },
        {
          targets: 5,
          title: 'Aksi',
          searchable: false,
          orderable: false,
          render: function (data, type, full, meta) {
            return (
              '<div class="d-inline-block">' +
                '<a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></a>' +
                '<div class="dropdown-menu dropdown-menu-end m-0">' +
                  '<a href="javascript:;" class="dropdown-item btn-detail-kelas-siswa" data-id="' + full.id + '">Detail</a>' +
                  '<a href="javascript:;" class="dropdown-item btn-edit-kelas-siswa" data-id="' + full.id + '">Edit</a>' +
                  '<div class="dropdown-divider"></div>' +
                  '<a href="javascript:;" class="dropdown-item text-danger btn-hapus-kelas-siswa" data-id="' + full.id + '" data-nama="' + full.siswa_nama + '">Hapus</a>' +
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
              exportOptions: { columns: [2, 3, 4] }
            },
            {
              extend: 'csv',
              text: '<i class="ti ti-file-text me-2" ></i>Csv',
              className: 'dropdown-item',
              exportOptions: { columns: [2, 3, 4] }
            },
            {
              extend: 'excel',
              text: '<i class="ti ti-file-spreadsheet me-2"></i>Excel',
              className: 'dropdown-item',
              exportOptions: { columns: [2, 3, 4] }
            },
            {
              extend: 'pdf',
              text: '<i class="ti ti-file-code-2 me-2"></i>Pdf',
              className: 'dropdown-item',
              exportOptions: { columns: [2, 3, 4] }
            },
            {
              extend: 'copy',
              text: '<i class="ti ti-copy me-2" ></i>Copy',
              className: 'dropdown-item',
              exportOptions: { columns: [2, 3, 4] }
            }
          ]
        },
        {
          text: '<i class="ti ti-plus me-0 me-sm-1"></i><span class="d-none d-sm-inline-block">Tambah Kelas Siswa</span>',
          className: 'add-new btn btn-primary waves-effect waves-light',
          attr: {
            'data-bs-toggle': 'modal',
            'data-bs-target': '#modalAddKelasSiswa'
          }
        }
      ],
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (row) {
              var data = row.data();
              return 'Details of ' + data['siswa_nama'];
            }
          }),
          type: 'column',
          target: 0
        }
      }
    });

    // Tambahkan filter ke dalam .dataTables_length label setelah DataTable selesai inisialisasi
    dt_kelas_siswa_table.on('init.dt', function() {
      if ($('#filterKelasSiswa').length === 0) {
        var filterHtml = '<select id="filterKelasSiswa" class="form-select me-2" style="width:180px; display:inline-block;">' +
          '<option value="">Semua Kelas</option>' +
          '</select>' +
          '<select id="filterTahunAjaranSiswa" class="form-select" style="width:180px; display:inline-block;">' +
          '<option value="">Semua TA</option>' +
          '</select>';
        // Sisipkan ke .dataTables_length, bukan ke label
        $('.dataTables_length').css('display', 'flex').append(filterHtml);
        $('#filterKelasSiswa').addClass('ms-2 d-inline-block').css('width', '180px');
        $('#filterTahunAjaranSiswa').addClass('ms-2 d-inline-block').css('width', '180px');
        // Patch CSS agar select bisa di-klik
        $('#filterKelasSiswa, #filterTahunAjaranSiswa').css({'pointer-events':'auto','z-index':10,'position':'relative'});
        $('.dataTables_length').css({'position':'relative','z-index':10});
        // Hilangkan margin pada search bar
        $('.dataTables_filter').removeClass('me-2 ms-2');
        // Isi data
        initFilterKelasTahunAjaran();
      }
    });

    // Handler filter kelas
    $(document).on('change', '#filterKelasSiswa', function() {
      var val = $(this).val();
      dt_kelas_siswa.column(1).search(val ? '^' + val + '$' : '', true, false).draw();
    });
    // Handler filter tahun ajaran
    $(document).on('change', '#filterTahunAjaranSiswa', function() {
      var val = $(this).val();
      dt_kelas_siswa.column(3).search(val ? '^' + val + '$' : '', true, false).draw();
    });

    // Inisialisasi filter saat halaman siap
    initFilterKelasTahunAjaran();
  }

  // Samakan tinggi filter dan select show dengan tombol (seperti wali kelas)
  setTimeout(() => {
    $('.dataTables_filter .form-control').removeClass('form-control-sm');
    $('.dataTables_length .form-select').removeClass('form-select-sm');
  }, 300);
});

function loadSelectOptionsKelasSiswa(selectedKelasId, selectedSiswaId, selectedTahunAjaranId) {
  // Kelas
  $.get('/app/kelas/data', function(res) {
    var select = $('#selectKelasKelasSiswa');
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
      dropdownParent: $('#modalAddKelasSiswa'),
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
  // Siswa
  $.get('/app/siswa/list-all', function(res) {
    var select = $('#selectSiswaKelasSiswa');
    select.empty().append('<option value="">Pilih Siswa</option>');
    if (res) {
      res.forEach(function(siswa) {
        select.append('<option value="' + siswa.id + '">' + siswa.text + '</option>');
      });
    }
    if (select.hasClass('select2-hidden-accessible')) {
      select.select2('destroy');
    }
    select.select2({
      dropdownParent: $('#modalAddKelasSiswa'),
      width: '100%',
      placeholder: 'Pilih Siswa',
      allowClear: true
    });
    if (selectedSiswaId) {
      setTimeout(function() {
        select.val(selectedSiswaId.toString()).trigger('change');
      }, 0);
    }
  });
  // Tahun Ajaran
  $.get('/app/tahun-ajaran/data', function(res) {
    var select = $('#selectTahunAjaranKelasSiswa');
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
      dropdownParent: $('#modalAddKelasSiswa'),
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

$(document).on('show.bs.modal', '#modalAddKelasSiswa', function() {
  if ($('#formAddKelasSiswa').data('mode') !== 'edit') {
    loadSelectOptionsKelasSiswa();
  }
});

$(document).on('click', '.btn-edit-kelas-siswa', function() {
  $('#modalDetailKelasSiswa').modal('hide'); // Tutup modal detail jika terbuka
  var id = $(this).data('id');
  $.get('/app/kelas-siswa/getbyid/' + id, function(res) {
    if (res.success) {
      if ($('#formAddKelasSiswa input[name=id]').length === 0) {
        $('#formAddKelasSiswa').prepend('<input type="hidden" name="id" id="editKelasSiswaId">');
      }
      $('#editKelasSiswaId').val(res.data.id);
      $('#modalAddKelasSiswaLabel').text('Edit Kelas Siswa');
      $('#formAddKelasSiswa button[type=submit]').text('Simpan Perubahan');
      $('#formAddKelasSiswa').data('mode', 'edit');
      $('#modalAddKelasSiswa').modal('show');
      loadSelectOptionsKelasSiswa(
        res.data.kelas ? res.data.kelas.id : null,
        res.data.siswa ? res.data.siswa.id : null,
        res.data.tahunAjaran ? res.data.tahunAjaran.id : null
      );
    } else {
      showKelasSiswaToast(res.error || 'Gagal mengambil data', 'danger');
    }
  });
});

$(document).on('click', '.add-new', function() {
  $('#formAddKelasSiswa')[0].reset();
  $('#formAddKelasSiswa').data('mode', 'add');
  $('#modalAddKelasSiswaLabel').text('Tambah Kelas Siswa');
  $('#formAddKelasSiswa button[type=submit]').text('Simpan');
  loadSelectOptionsKelasSiswa();
});

$(document).on('change', '#statusAktifKelasSiswaSwitch', function() {
  var label = $('#statusAktifKelasSiswaSwitch').next('label');
  if ($(this).is(':checked')) {
    label.text('Aktif');
  } else {
    label.text('Tidak Aktif');
  }
});

function showKelasSiswaToast(message, type) {
  var icon = $('#kelasSiswaToast .toast-header i');
  $('#kelasSiswaToastBody').text(message);
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
  var toast = new bootstrap.Toast(document.getElementById('kelasSiswaToast'));
  toast.show();
}

// Handler: detail kelas siswa
$(document).on('click', '.btn-detail-kelas-siswa', function() {
  var id = $(this).data('id');
  $.get('/app/kelas-siswa/getbyid/' + id, function(res) {
    if (res.success) {
      $('#detailKelasSiswaNamaTitle').text(res.data.siswa ? res.data.siswa.nama : '-');
      $('#detailKelasSiswaKelas').text(res.data.kelas ? res.data.kelas.nama_kelas : '-');
      $('#detailKelasSiswaNama').text(res.data.siswa ? res.data.siswa.nama : '-');
      $('#detailKelasSiswaTahunAjaran').text(res.data.tahunAjaran ? res.data.tahunAjaran.tahun : '-');
      // Perbaiki badge status
      var status = res.data.status || '-';
      var statusObj = {
        'aktif': { title: 'Aktif', class: 'bg-label-success' },
        'tidak': { title: 'Tidak Aktif', class: 'bg-label-secondary' }
      };
      var s = statusObj[status] || { title: status, class: 'bg-label-warning' };
      $('#detailKelasSiswaStatus')
        .text(s.title)
        .removeClass('bg-label-success bg-label-secondary bg-label-warning')
        .addClass(s.class);
      // Set data-id dan data-nama pada tombol aksi di modal detail
      $('#modalDetailKelasSiswa .btn-edit-kelas-siswa').attr('data-id', res.data.id).attr('data-nama', res.data.siswa ? res.data.siswa.nama : '');
      $('#modalDetailKelasSiswa .btn-hapus-kelas-siswa').attr('data-id', res.data.id).attr('data-nama', res.data.siswa ? res.data.siswa.nama : '');
      $('#modalDetailKelasSiswa').modal('show');
    } else {
      showKelasSiswaToast(res.error || 'Gagal mengambil data', 'danger');
    }
  });
});

// Handler: hapus kelas siswa
$(document).on('click', '.btn-hapus-kelas-siswa', function() {
  $('#modalDetailKelasSiswa').modal('hide'); // Tutup modal detail jika terbuka
  var id = $(this).data('id');
  $.get('/app/kelas-siswa/getbyid/' + id, function(res) {
    if (res.success) {
      $('#hapusKelasSiswaId').val(res.data.id);
      $('#hapusKelasSiswaKelas').text(res.data.kelas ? res.data.kelas.nama_kelas : '-');
      $('#hapusKelasSiswaNama').text(res.data.siswa ? res.data.siswa.nama : '-');
      $('#hapusKelasSiswaTahunAjaran').text(res.data.tahunAjaran ? res.data.tahunAjaran.tahun : '-');
      $('#modalHapusKelasSiswa').modal('show');
    } else {
      showKelasSiswaToast(res.error || 'Gagal mengambil data', 'danger');
    }
  });
});

// Handler: submit form hapus kelas siswa
$(document).on('submit', '#formHapusKelasSiswa', function(e) {
  e.preventDefault();
  var id = $('#hapusKelasSiswaId').val();
  $.ajax({
    url: '/app/kelas-siswa/delete',
    method: 'POST',
    data: { id: id },
    success: function(res) {
      $('#modalHapusKelasSiswa').modal('hide');
      if (res.success) {
        showKelasSiswaToast('Data berhasil dihapus!', 'success');
        $('.datatables-kelas-siswa').DataTable().ajax.reload();
      } else {
        showKelasSiswaToast(res.error || 'Gagal menghapus data', 'danger');
      }
    },
    error: function(xhr) {
      $('#modalHapusKelasSiswa').modal('hide');
      showKelasSiswaToast(xhr.responseJSON?.error || 'Gagal menghapus data', 'danger');
    }
  });
}); 