// File JS DataTable Siswa
'use strict';

$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

$(function () {
  var dt_siswa_table = $('.datatables-siswa');

  if (dt_siswa_table.length) {
    // Hapus seluruh blok filter kelas (init.dt, filterKelasSiswa, dsb)

    var dt_siswa = dt_siswa_table.DataTable({
      ajax: {
        url: (baseUrl ? baseUrl.replace(/\/$/, '') : '') + '/app/siswa/data'
      },
      columns: [
        { data: '' },
        { data: 'nama' },
        { data: 'nis' },
        { data: 'jenis_kelamin' },
        { data: 'alamat' },
        { data: 'status' },
        { data: 'action' }
      ],
      columnDefs: [
        {
          // For Responsive
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
          // Nama siswa dengan foto/avatar
          targets: 1,
          responsivePriority: 4,
          render: function (data, type, full, meta) {
            var $name = full['nama'];
            var $foto = full['foto'];
            var $jk = full['jenis_kelamin'];
            var $avatar = '';
            if ($foto && $foto !== '') {
              $avatar = '<img src="/assets/img/avatars/' + $foto + '" alt="Foto Siswa" class="rounded-circle me-2" width="38" height="38">';
            } else {
              var avatarDefault = $jk === 'P' ? '2.png' : '1.png';
              $avatar = '<img src="/assets/img/avatars/' + avatarDefault + '" alt="Avatar Default" class="rounded-circle me-2" width="38" height="38">';
            }
            var $row_output =
              '<div class="d-flex justify-content-start align-items-center user-name">' +
                '<div class="avatar-wrapper">' +
                  '<div class="avatar me-3">' +
                    $avatar +
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
          // Kolom aksi (action) pakai dropdown titik 3
          targets: -1,
          title: 'Aksi',
          searchable: false,
          orderable: false,
          render: function (data, type, full, meta) {
            return (
              '<div class="d-inline-block">' +
                '<a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></a>' +
                '<div class="dropdown-menu dropdown-menu-end m-0">' +
                  '<a href="javascript:;" class="dropdown-item btn-detail-siswa" data-id="' + full.id + '">Detail</a>' +
                  '<a href="javascript:;" class="dropdown-item btn-edit-siswa" data-id="' + full.id + '" data-nama="' + full.nama + '">Edit</a>' +
                  '<div class="dropdown-divider"></div>' +
                  '<a href="javascript:;" class="dropdown-item text-danger btn-hapus-siswa" data-id="' + full.id + '" data-nama="' + full.nama + '" data-nis="' + full.nis + '">Delete</a>' +
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
                columns: [1,2,3,4,5],
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
              exportOptions: {
                columns: [1,2,3,4,5],
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
                columns: [1,2,3,4,5],
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
                columns: [1,2,3,4,5],
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
                columns: [1,2,3,4,5],
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
          text: '<i class="ti ti-plus me-0 me-sm-1"></i><span class="d-none d-sm-inline-block">Tambah Siswa</span>',
          className: 'add-new btn btn-primary waves-effect waves-light',
          attr: {
            'data-bs-toggle': 'modal',
            'data-bs-target': '#modalAddSiswa'
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
                    '">' +
                    '<td>' +
                    col.title +
                    ':</td> ' +
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

  // Handler: tampilkan modal tambah siswa
  $(document).on('click', '[data-bs-target="#modalAddSiswa"]', function() {
    $('#formAddSiswa')[0].reset();
    $('#formAddSiswa input[name=id]').remove();
    $('#modalAddSiswaLabel').text('Tambah Siswa');
    $('#formAddSiswa button[type=submit]').text('Simpan');
    $('#formAddSiswa').data('mode', 'add');
    // Isi dropdown kelas
    $.get((baseUrl ? baseUrl.replace(/\/$/, '') : '') + '/app/kelas/data', function(res) {
      var select = $('#modalAddSiswa #selectKelas');
      select.empty().append('<option value="">Pilih Kelas</option>');
      if (res.data) {
        res.data.forEach(function(kelas) {
          select.append('<option value="' + kelas.id + '">' + kelas.nama_kelas + '</option>');
        });
      }
      select.select2({
        dropdownParent: $('#modalAddSiswa'),
        width: '100%',
        placeholder: 'Pilih Kelas',
        allowClear: true
      });
      // Set value setelah dropdown terisi dan select2 sudah diinisialisasi
      if (res.data && res.data.length && $('#editSiswaId').length) {
        $.get((baseUrl ? baseUrl.replace(/\/$/, '') : '') + '/app/siswa/getbyid/' + $('#editSiswaId').val(), function(siswaRes) {
          if (siswaRes.success) {
            select.val(siswaRes.data.kelas_id).trigger('change');
          }
        });
      }
    });
  });

  // Handler: tampilkan modal edit siswa
  $(document).on('click', '.btn-edit-siswa', function() {
    $('#modalDetailSiswa').modal('hide');
    var id = $(this).data('id');
    $.get((baseUrl ? baseUrl.replace(/\/$/, '') : '') + '/app/siswa/getbyid/' + id, function(resSiswa) {
      if (resSiswa.success) {
        $('#formAddSiswa')[0].reset();
        if ($('#formAddSiswa input[name=id]').length === 0) {
          $('#formAddSiswa').prepend('<input type="hidden" name="id" id="editSiswaId">');
        }
        $('#editSiswaId').val(resSiswa.data.id);
        $('#formAddSiswa input[name=nama]').val(resSiswa.data.nama);
        $('#formAddSiswa input[name=nis]').val(resSiswa.data.nis);
        $('#formAddSiswa select[name=jenis_kelamin]').val(resSiswa.data.jenis_kelamin);
        $('#formAddSiswa textarea[name=alamat]').val(resSiswa.data.alamat);
        $('#formAddSiswa select[name=status]').val(resSiswa.data.status);
        $('#modalAddSiswaLabel').text('Edit Siswa');
        $('#formAddSiswa button[type=submit]').text('Simpan Perubahan');
        $('#formAddSiswa').data('mode', 'edit');
        $('#modalAddSiswa').modal('show');
        // Isi dropdown kelas
        $.get((baseUrl ? baseUrl.replace(/\/$/, '') : '') + '/app/kelas/data', function(resKelas) {
          var select = $('#modalAddSiswa #selectKelas');
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
            dropdownParent: $('#modalAddSiswa'),
            width: '100%',
            placeholder: 'Pilih Kelas',
            allowClear: true
          });
          setTimeout(function() {
            select.val(resSiswa.data.kelas_id ? resSiswa.data.kelas_id.toString() : '').trigger('change');
          }, 0);
        });
      } else {
        showSiswaToast(resSiswa.error || 'Gagal mengambil data', 'danger');
      }
    });
  });

  // Handler: submit form tambah/edit siswa
  $(document).on('submit', '#formAddSiswa', function(e) {
    e.preventDefault();
    var mode = $(this).data('mode');
    var url = (baseUrl ? baseUrl.replace(/\/$/, '') : '') + (mode === 'edit' ? '/app/siswa/updatebyid' : '/app/siswa/store');
    var formData = $(this).serialize();
    $.ajax({
      url: url,
      method: 'POST',
      data: formData,
      success: function(res) {
        $('#modalAddSiswa').modal('hide');
        if (res.success) {
          showSiswaToast('Data berhasil disimpan!', 'success');
          $('.datatables-siswa').DataTable().ajax.reload();
        } else {
          showSiswaToast(res.error || 'Gagal menyimpan data', 'danger');
        }
      },
      error: function(xhr) {
        $('#modalAddSiswa').modal('hide');
        showSiswaToast(xhr.responseJSON?.error || 'Gagal menyimpan data', 'danger');
      },
      complete: function() {
        $('#formAddSiswa')[0].reset();
        $('#formAddSiswa input[name=id]').remove();
        $('#modalAddSiswaLabel').text('Tambah Siswa');
        $('#formAddSiswa button[type=submit]').text('Simpan');
        $('#formAddSiswa').data('mode', 'add');
      }
    });
  });

  // Handler: tampilkan modal detail siswa
  $(document).on('click', '.btn-detail-siswa', function() {
    var id = $(this).data('id');
    $.get(baseUrl + 'app/siswa/getbyid/' + id, function(res) {
      if (res.success) {
        $('#detailSiswaNama').text(res.data.nama);
        $('#detailSiswaNamaTitle').text(res.data.nama);
        $('#detailSiswaNis').text(res.data.nis);
        var jk = res.data.jenis_kelamin === 'L' ? 'Laki-laki' : (res.data.jenis_kelamin === 'P' ? 'Perempuan' : '-');
        $('#detailSiswaJK').text(jk);
        $('#detailSiswaAlamat').text(res.data.alamat);
        var statusText = res.data.status === 'aktif' ? 'Aktif' : (res.data.status === 'tidak' ? 'Tidak Aktif' : 'Lulus');
        var statusClass = res.data.status === 'aktif' ? 'bg-label-success' : (res.data.status === 'tidak' ? 'bg-label-danger' : 'bg-label-warning');
        $('#detailSiswaStatus').text(statusText).removeClass('bg-label-success bg-label-danger bg-label-warning').addClass(statusClass);
        // Set data-id dan data-nama pada tombol edit dan hapus di modal detail
        $('#modalDetailSiswa .btn-edit-siswa').data('id', res.data.id).data('nama', res.data.nama);
        $('#modalDetailSiswa .btn-hapus-siswa').data('id', res.data.id).data('nama', res.data.nama).data('nis', res.data.nis);
        $('#modalDetailSiswa').modal('show');
      } else {
        showSiswaToast(res.error || 'Gagal mengambil data', 'danger');
      }
    });
  });

  // Handler: hapus siswa
  $(document).on('click', '.btn-hapus-siswa', function () {
    var id = $(this).data('id');
    var nama = $(this).data('nama');
    var nis = $(this).data('nis');
    $('#hapusSiswaId').val(id);
    $('#hapusSiswaNama').text(nama);
    $('#hapusSiswaNis').text(nis);
    if ($('#modalDetailSiswa').hasClass('show')) {
      $('#modalDetailSiswa').modal('hide');
      $('#modalDetailSiswa').one('hidden.bs.modal', function() {
        $('#modalHapusSiswa').modal('show');
      });
    } else {
      $('#modalHapusSiswa').modal('show');
    }
  });

  // Handler: submit form hapus via AJAX
  $(document).on('submit', '#formHapusSiswa', function(e) {
    e.preventDefault();
    var id = $('#hapusSiswaId').val();
    $.ajax({
      url: (baseUrl ? baseUrl.replace(/\/$/, '') : '') + '/app/siswa/deletebyid',
      method: 'POST',
      data: { id: id },
      success: function(res) {
        $('#modalHapusSiswa').modal('hide');
        if (res.success) {
          showSiswaToast('Data berhasil dihapus!', 'success');
          $('.datatables-siswa').DataTable().ajax.reload();
        } else {
          showSiswaToast(res.error || 'Gagal menghapus data', 'danger');
        }
      },
      error: function(xhr) {
        $('#modalHapusSiswa').modal('hide');
        showSiswaToast(xhr.responseJSON?.error || 'Gagal menghapus data', 'danger');
      }
    });
  });

  setTimeout(() => {
    $('.dataTables_filter .form-control').removeClass('form-control-sm');
    $('.dataTables_length .form-select').removeClass('form-select-sm');
  }, 300);
});

function showSiswaToast(message, type) {
  var icon = $('#siswaToast .toast-header i');
  $('#siswaToastBody').text(message);

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

  var toast = new bootstrap.Toast(document.getElementById('siswaToast'));
  toast.show();
} 