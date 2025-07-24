// File JS DataTable Semester
'use strict';

$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

$(function () {
  var dt_semester_table = $('.datatables-semester');

  if (dt_semester_table.length) {
    var dt_semester = dt_semester_table.DataTable({
      ajax: {
        url: baseUrl + 'app/semester/data'
      },
      columns: [
        { data: '' },
        { data: 'nama' },
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
          // Nama Semester dengan avatar-initial
          targets: 1,
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
          targets: 2,
          render: function (data, type, full, meta) {
            var status = full['status'];
            var statusObj = {
              'aktif': { title: 'Aktif', class: 'bg-label-success' },
              'tidak': { title: 'Tidak Aktif', class: 'bg-label-secondary' }
            };
            var s = statusObj[status] || { title: status, class: 'bg-label-warning' };
            return '<span class="badge ' + s.class + '">' + s.title + '</span>';
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
                  '<a href="javascript:;" class="dropdown-item btn-detail-semester" data-id="' + full.id + '">Detail</a>' +
                  '<a href="javascript:;" class="dropdown-item btn-edit-semester" data-id="' + full.id + '" data-nama="' + full.nama + '">Edit</a>' +
                  '<div class="dropdown-divider"></div>' +
                  '<a href="javascript:;" class="dropdown-item text-danger btn-hapus-semester" data-id="' + full.id + '" data-nama="' + full.nama + '">Delete</a>' +
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
                columns: [1],
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
                columns: [1],
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
                columns: [1],
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
                columns: [1],
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
                columns: [1],
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
          text: '<i class="ti ti-plus me-0 me-sm-1"></i><span class="d-none d-sm-inline-block">Tambah Semester</span>',
          className: 'add-new btn btn-primary waves-effect waves-light',
          attr: {
            'data-bs-toggle': 'modal',
            'data-bs-target': '#modalAddSemester'
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

  // Handler: tampilkan modal tambah semester
  $(document).on('click', '[data-bs-target="#modalAddSemester"]', function() {
    $('#formAddSemester')[0].reset();
    $('#formAddSemester input[name=id]').remove();
    $('#modalAddSemesterLabel').text('Tambah Semester');
    $('#formAddSemester button[type=submit]').text('Simpan');
    $('#formAddSemester').data('mode', 'add');
  });

  // Handler: toggle status aktif label pada form semester
  $(document).on('change', '#statusAktifSemesterSwitch', function() {
    var label = $('#statusAktifSemesterLabel');
    if ($(this).is(':checked')) {
      label.text('Aktif');
      $(this).val('aktif');
    } else {
      label.text('Tidak Aktif');
      $(this).val('tidak');
    }
  });

  // Saat edit, set toggle dan label status sesuai data
  $(document).on('click', '.btn-edit-semester', function() {
    var id = $(this).data('id');
    $.get(baseUrl + 'app/semester/getbyid/' + id, function(res) {
      if (res.success) {
        $('#editSemesterId').val(res.data.id);
        $('#formAddSemester input[name=nama]').val(res.data.nama);
        var isAktif = res.data.status === 'aktif';
        $('#statusAktifSemesterSwitch').prop('checked', isAktif);
        $('#statusAktifSemesterLabel').text(isAktif ? 'Aktif' : 'Tidak Aktif');
        $('#modalAddSemesterLabel').text('Edit Semester');
        $('#formAddSemester button[type=submit]').text('Simpan Perubahan');
        $('#formAddSemester').data('mode', 'edit');
        $('#modalAddSemester').modal('show');
      } else {
        showSemesterToast(res.error || 'Gagal mengambil data', 'danger');
      }
    });
  });

  // Handler: submit form tambah/edit semester
  $(document).on('submit', '#formAddSemester', function(e) {
    e.preventDefault();
    var mode = $(this).data('mode');
    var url = mode === 'edit' ? baseUrl + 'app/semester/updatebyid' : baseUrl + 'app/semester/store';
    var formData = $(this).serialize();
    $.ajax({
      url: url,
      method: 'POST',
      data: formData,
      success: function(res) {
        $('#modalAddSemester').modal('hide');
        if (res.success) {
          showSemesterToast('Data berhasil disimpan!', 'success');
          $('.datatables-semester').DataTable().ajax.reload();
        } else {
          showSemesterToast(res.error || 'Gagal menyimpan data', 'danger');
        }
      },
      error: function(xhr) {
        $('#modalAddSemester').modal('hide');
        showSemesterToast(xhr.responseJSON?.error || 'Gagal menyimpan data', 'danger');
      },
      complete: function() {
        $('#formAddSemester')[0].reset();
        $('#formAddSemester input[name=id]').remove();
        $('#modalAddSemesterLabel').text('Tambah Semester');
        $('#formAddSemester button[type=submit]').text('Simpan');
        $('#formAddSemester').data('mode', 'add');
      }
    });
  });

  // Saat submit, pastikan value status sesuai toggle
  $(document).on('submit', '#formAddSemester', function(e) {
    var status = $('#statusAktifSemesterSwitch').is(':checked') ? 'aktif' : 'tidak';
    $('#statusAktifSemesterSwitch').val(status);
  });

  // Handler: tampilkan modal detail semester
  $(document).on('click', '.btn-detail-semester', function() {
    var id = $(this).data('id');
    $.get(baseUrl + 'app/semester/getbyid/' + id, function(res) {
      if (res.success) {
        $('#detailSemesterNama').text(res.data.nama);
        var statusText = res.data.status === 'aktif' ? 'Aktif' : 'Tidak Aktif';
        var statusClass = res.data.status === 'aktif' ? 'bg-label-success' : 'bg-label-secondary';
        $('#detailSemesterStatus').text(statusText).removeClass('bg-label-success bg-label-secondary').addClass(statusClass);
        $('#modalDetailSemester .btn-edit-semester').data('id', res.data.id).data('nama', res.data.nama);
        $('#modalDetailSemester .btn-hapus-semester').data('id', res.data.id).data('nama', res.data.nama);
        $('#modalDetailSemester').modal('show');
      } else {
        showSemesterToast(res.error || 'Gagal mengambil data', 'danger');
      }
    });
  });

  // Handler: hapus semester
  $(document).on('click', '.btn-hapus-semester', function () {
    var id = $(this).data('id');
    var nama = $(this).data('nama');
    $('#hapusSemesterId').val(id);
    $('#hapusSemesterNama').text(nama);

    if ($('#modalDetailSemester').hasClass('show')) {
      $('#modalDetailSemester').modal('hide');
      $('#modalDetailSemester').one('hidden.bs.modal', function() {
        $('#modalHapusSemester').modal('show');
      });
    } else {
      $('#modalHapusSemester').modal('show');
    }
  });

  // Handler: submit form hapus via AJAX
  $(document).on('submit', '#formHapusSemester', function(e) {
    e.preventDefault();
    var id = $('#hapusSemesterId').val();
    $.ajax({
      url: baseUrl + 'app/semester/deletebyid',
      method: 'POST',
      data: { id: id },
      success: function(res) {
        $('#modalHapusSemester').modal('hide');
        if (res.success) {
          showSemesterToast('Data berhasil dihapus!', 'success');
          $('.datatables-semester').DataTable().ajax.reload();
        } else {
          showSemesterToast(res.error || 'Gagal menghapus data', 'danger');
        }
      },
      error: function(xhr) {
        $('#modalHapusSemester').modal('hide');
        showSemesterToast(xhr.responseJSON?.error || 'Gagal menghapus data', 'danger');
      }
    });
  });

  setTimeout(() => {
    $('.dataTables_filter .form-control').removeClass('form-control-sm');
    $('.dataTables_length .form-select').removeClass('form-select-sm');
  }, 300);
});

function showSemesterToast(message, type) {
  var icon = $('#semesterToast .toast-header i');
  $('#semesterToastBody').text(message);

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

  var toast = new bootstrap.Toast(document.getElementById('semesterToast'));
  toast.show();
} 