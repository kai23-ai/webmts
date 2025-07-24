/**
 * Page User List
 */

'use strict';

console.log('app-user-list.js loaded');

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
  var dt_user_table = $('.datatables-users'),
    select2 = $('.select2'),
    userView = baseUrl + 'app/user/view/account',
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
  if (dt_user_table.length) {
    var dt_user = dt_user_table.DataTable({
      ajax: {
        url: baseUrl + 'app/user/list'
      },
      columns: [
        { data: null }, // 0: expand
        { data: 'id' }, // 1: checkbox
        { data: 'nama' },
        { data: 'role' },
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
              return '<input type="checkbox" class="form-check-input user-checkbox" value="' + full.id + '" />';
            }
            return '';
          }
        },
        {
          // Nama
          targets: 2,
          responsivePriority: 4,
          render: function (data, type, full, meta) {
            return '<span class="fw-medium">' + full.nama + '</span>';
          }
        },
        {
          // Role
          targets: 3,
          render: function (data, type, full, meta) {
            return '<span>' + full.role + '</span>';
          }
        },
        {
          // Status
          targets: 4,
          render: function (data, type, full, meta) {
            var statusObj = {
              'aktif': { title: 'Aktif', class: 'bg-label-success' },
              'tidak': { title: 'Tidak Aktif', class: 'bg-label-secondary' }
            };
            var s = statusObj[full.status] || { title: full.status, class: 'bg-label-warning' };
            return '<span class="badge ' + s.class + '">' + s.title + '</span>';
          }
        },
        {
          // Aksi
          targets: 5,
          orderable: false,
          searchable: false,
          render: function (data, type, full, meta) {
            return (
              '<div class="d-inline-block">' +
                '<a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></a>' +
                '<div class="dropdown-menu dropdown-menu-end m-0">' +
                  '<a href="javascript:;" class="dropdown-item btn-detail-user" data-id="' + full.id + '">Detail</a>' +
                  '<a href="javascript:;" class="dropdown-item btn-edit-user" data-id="' + full.id + '">Edit</a>' +
                  '<div class="dropdown-divider"></div>' +
                  '<a href="javascript:;" class="dropdown-item text-danger btn-hapus-user" data-id="' + full.id + '" data-nama="' + full.nama + '">Hapus</a>' +
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
          text: '<i class="ti ti-plus me-0 me-sm-1"></i><span class="d-none d-sm-inline-block">Tambah User</span>',
          className: 'add-new btn btn-primary waves-effect waves-light',
          attr: {
            'data-bs-toggle': 'modal',
            'data-bs-target': '#modalAddUser'
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
        // Gabungkan filter Status di .user_status jika diperlukan
      },
    });

    // Tambahkan filter status di kiri, sejajar dengan 'Show entries' (sama seperti guru)
    dt_user_table.on('init.dt', function() {
      if ($('#filterStatusUser').length === 0) {
        var filterHtml = '<select id="filterStatusUser" class="form-select me-2" style="width:180px; display:inline-block;">' +
          '<option value="">Semua</option>' +
          '<option value="aktif">Aktif</option>' +
          '<option value="tidak">Tidak Aktif</option>' +
        '</select>';
        $('.dataTables_length label').append(filterHtml);
        $('#filterStatusUser').addClass('ms-2 d-inline-block').css('width', '180px');
        $('.dataTables_filter').removeClass('me-2 ms-2');
        $(document).on('change', '#filterStatusUser', function() {
          var val = $(this).val();
          dt_user_table.DataTable().column(3).search(val ? '^' + val + '$' : '', true, false).draw();
        });
      }
    });

    // Tambah select all checkbox di header setelah DataTable selesai inisialisasi
    dt_user.on('draw', function () {
      if ($('.datatables-users thead th:eq(1) input[type="checkbox"].select-all-user').length === 0) {
        $('.datatables-users thead th:eq(1)').html('<input type="checkbox" class="form-check-input select-all-user" />');
        // Hapus class sorting dan event sort di header checkbox
        $('.datatables-users thead th:eq(1)')
          .removeClass('sorting sorting_asc sorting_desc')
          .off('click');
      }
      $('.select-all-user').prop('checked', false).prop('indeterminate', false);
    });
    // Event: select all
    $(document).on('change', '.select-all-user', function () {
      var checked = $(this).is(':checked');
      $('.datatables-users tbody input.user-checkbox').prop('checked', checked);
    });
    // Event: update select all jika ada perubahan di checkbox baris
    $(document).on('change', '.datatables-users tbody input.user-checkbox', function () {
      var all = $('.datatables-users tbody input.user-checkbox').length;
      var checked = $('.datatables-users tbody input.user-checkbox:checked').length;
      $('.select-all-user')
        .prop('checked', all === checked && all > 0)
        .prop('indeterminate', checked > 0 && checked < all);
    });
  }

  // Delete Record
  $('.datatables-users tbody').on('click', '.delete-record', function () {
    dt_user.row($(this).parents('tr')).remove().draw();
  });

  // Filter form control to default size
  // ? setTimeout used for multilingual table initialization
  setTimeout(() => {
    $('.dataTables_filter .form-control').removeClass('form-control-sm');
    $('.dataTables_length .form-select').removeClass('form-select-sm');
  }, 300);
});

// Validation & Phone mask
(function () {
  const addUserForm = document.getElementById('formAddUser');
  if (addUserForm) {
    FormValidation.formValidation(addUserForm, {
      fields: {
        role: {
          validators: {
            notEmpty: {
              message: 'Role wajib dipilih'
            }
          }
        },
        password: {
          validators: {
            callback: {
              message: 'Password wajib diisi saat tambah user',
              callback: function(input) {
                const isEdit = addUserForm.getAttribute('data-editing') === 'true';
                if (isEdit) {
                  return true;
                }
                return input.value.length > 0;
              }
            },
            stringLength: {
              min: 8,
              message: 'Password minimal 8 karakter'
            }
          }
        },
        password_confirmation: {
          validators: {
            identical: {
              compare: function() {
                return addUserForm.querySelector('[name="password"]').value;
              },
              message: 'Konfirmasi password harus sama dengan password'
            }
          }
        }
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          eleValidClass: '',
          rowSelector: '.mb-3'
        }),
        submitButton: new FormValidation.plugins.SubmitButton(),
        autoFocus: new FormValidation.plugins.AutoFocus()
      }
    })
    .on('core.form.valid', function() {
      // Submit AJAX jika form valid
      const form = $(addUserForm);
      var isEdit = form.attr('data-editing') === 'true';
      var url = isEdit ? '/app/user/update' : '/app/user/store';
      var method = 'POST';
      var formData = form.serializeArray();
      if (isEdit) {
        formData = formData.filter(function(item) {
          if (item.name === 'password' || item.name === 'password_confirmation') {
            return form.find('[name="password"]').val().length > 0;
          }
          return true;
        });
      }
      $.ajax({
        url: url,
        method: method,
        data: formData,
        success: function(res) {
          if (res.success) {
            $('#modalAddUser').modal('hide');
            $('.datatables-users').DataTable().ajax.reload();
            showUserToast('Data berhasil disimpan!', 'success');
            form[0].reset();
          } else if (res.error) {
            showUserToast(res.error, 'danger');
          }
        },
        error: function(xhr) {
          showUserToast(xhr.responseJSON?.error || 'Terjadi kesalahan.', 'danger');
        }
      });
    });
  }
})();

// Handle open modal for add/edit user
$(document).on('click', '.add-new', function() {
  // Reset form and set mode tambah
  const form = document.getElementById('formAddUser');
  form.reset();
  form.setAttribute('data-editing', 'false');
  $('#userPassword').attr('required', true);
});

$(document).on('click', '.btn-edit-user', function() {
  // Set mode edit
  const form = document.getElementById('formAddUser');
  form.setAttribute('data-editing', 'true');
  $('#userPassword').removeAttr('required');
  // Kosongkan field password
  $('#userPassword').val('');
  $('#userPasswordConfirmation').val('');
  // TODO: Populate form with user data (AJAX/fill fields)
});

$(document).on('change', 'select[name=role]', function() {
  var role = $(this).val();
  var $container = $('#userRefContainer');
  var $select = $('#userRefSelect');
  var $label = $('#userRefLabel');
  $select.empty().val(null).trigger('change');
  $container.hide();

  if (role === 'guru' || role === 'admin') {
    $label.text('Pilih Guru');
    $container.show();
    $select.select2({
      placeholder: 'Pilih Guru',
      dropdownParent: $container,
      ajax: {
        url: '/app/guru/list-all',
        dataType: 'json',
        processResults: function (data) {
          return { results: data };
        }
      }
    });
  } else if (role === 'siswa') {
    $label.text('Pilih Siswa');
    $container.show();
    $select.select2({
      placeholder: 'Pilih Siswa',
      dropdownParent: $container,
      ajax: {
        url: '/app/siswa/list-all',
        dataType: 'json',
        processResults: function (data) {
          return { results: data };
        }
      }
    });
  } else {
    $container.hide();
    $select.select2('destroy');
  }
});

function showUserToast(message, type) {
  var icon = $('#userToast .toast-header i');
  $('#userToastBody').text(message);
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
  var toast = new bootstrap.Toast(document.getElementById('userToast'));
  toast.show();
}

// Handle submit form tambah/edit user
$(document).on('submit', '#formAddUser', function(e) {
  e.preventDefault();
  var form = $(this);
  var isEdit = form.attr('data-editing') === 'true';
  var url = isEdit ? '/app/user/update' : '/app/user/store';
  var method = 'POST';
  var formData = form.serializeArray();

  // Jika edit dan password kosong, hapus dari formData
  if (isEdit) {
    formData = formData.filter(function(item) {
      if (item.name === 'password' || item.name === 'password_confirmation') {
        return $(form).find('[name="password"]').val().length > 0;
      }
      return true;
    });
  }

  $.ajax({
    url: url,
    method: method,
    data: formData,
    success: function(res) {
      if (res.success) {
        $('#modalAddUser').modal('hide');
        $('.datatables-users').DataTable().ajax.reload();
        showUserToast('Data berhasil disimpan!', 'success');
        form[0].reset();
      } else if (res.error) {
        showUserToast(res.error, 'danger');
      }
    },
    error: function(xhr) {
      showUserToast(xhr.responseJSON?.error || 'Terjadi kesalahan.', 'danger');
    }
  });
});

// Jika pakai FormValidation.js, log saat form valid
$('#formAddUser').on('core.form.valid', function() {
  console.log('Form valid, will submit via AJAX');
});

// Handler: detail user
$(document).on('click', '.btn-detail-user', function() {
  var id = $(this).data('id');
  $.get('/app/user/getbyid/' + id, function(res) {
    if (res.success) {
      $('#detailUserNama').text(res.data.nama || '-');
      $('#detailUserNamaTitle').text(res.data.nama || '-');
      $('#detailUserRole').text(res.data.role || '-');
      $('#detailUserStatus').text(res.data.status || '-');
      $('#modalDetailUser').modal('show');
    } else {
      showUserToast(res.error || 'Gagal mengambil data', 'danger');
    }
  });
});

function loadSelectOptionsUser(refRole, selectedId) {
  var $container = $('#userRefContainer');
  var $select = $('#userRefSelect');
  var $label = $('#userRefLabel');
  $select.empty().val(null).trigger('change');
  $container.hide();

  if ($select.data('select2')) {
    $select.select2('destroy');
  }

  if (refRole === 'guru' || refRole === 'admin') {
    $label.text('Pilih Guru');
    $container.show();
    $.get('/app/guru/list-all', function(data) {
      $select.append('<option value="">Pilih Guru</option>');
      data.forEach(function(guru) {
        $select.append('<option value="' + guru.id + '">' + guru.text + '</option>');
      });
      $select.select2({
        dropdownParent: $container,
        width: '100%',
        placeholder: 'Pilih Guru',
        allowClear: true
      });
      if (selectedId) {
        $select.val(String(selectedId)).trigger('change');
      }
    });
  } else if (refRole === 'siswa') {
    $label.text('Pilih Siswa');
    $container.show();
    $.get('/app/siswa/list-all', function(data) {
      $select.append('<option value="">Pilih Siswa</option>');
      data.forEach(function(siswa) {
        $select.append('<option value="' + siswa.id + '">' + siswa.text + '</option>');
      });
      $select.select2({
        dropdownParent: $container,
        width: '100%',
        placeholder: 'Pilih Siswa',
        allowClear: true
      });
      if (selectedId) {
        $select.val(String(selectedId)).trigger('change');
      }
    });
  } else {
    $container.hide();
    if ($select.data('select2')) {
      $select.select2('destroy');
    }
  }
}

// Handler: edit user
$(document).on('click', '.btn-edit-user', function() {
  var id = $(this).data('id');
  const form = document.getElementById('formAddUser');
  form.setAttribute('data-editing', 'true');
  $('#userPassword').removeAttr('required');
  $('#userPassword').val('');
  $('#userPasswordConfirmation').val('');
  // Ubah judul dan tombol
  $('#modalAddUserLabel').text('Edit User');
  $('#formAddUser button[type=submit]').text('Simpan Perubahan');
  $.get('/app/user/getbyid/' + id, function(res) {
    if (res.success) {
      $(form).find('select[name=role]').val(res.data.role).trigger('change');
      var refId = res.data.guru_id || res.data.siswa_id;
      loadSelectOptionsUser(res.data.role, refId);
      $(form).find('input[name=id]').remove();
      $(form).prepend('<input type="hidden" name="id" value="' + id + '">');
      $('#modalAddUser').modal('show');
    } else {
      showUserToast(res.error || 'Gagal mengambil data', 'danger');
    }
  });
});

// Handler: tambah user
$(document).on('click', '.add-new', function() {
  const form = document.getElementById('formAddUser');
  form.reset();
  form.setAttribute('data-editing', 'false');
  $('#userPassword').attr('required', true);
  // Reset judul dan tombol
  $('#modalAddUserLabel').text('Tambah User');
  $('#formAddUser button[type=submit]').text('Simpan');
  loadSelectOptionsUser($('#formAddUser select[name=role]').val(), null);
});

// Handler: ganti role
$(document).on('change', 'select[name=role]', function() {
  loadSelectOptionsUser($(this).val(), null);
});

// Handler: hapus user
$(document).on('click', '.btn-hapus-user', function() {
  var id = $(this).data('id');
  var nama = $(this).data('nama');
  $('#hapusUserId').val(id);
  $('#hapusUserNama').text(nama);
  $('#modalHapusUser').modal('show');
});

$(document).on('submit', '#formHapusUser', function(e) {
  e.preventDefault();
  var id = $('#hapusUserId').val();
  $.ajax({
    url: '/app/user/delete',
    method: 'POST',
    data: { id: id },
    success: function(res) {
      $('#modalHapusUser').modal('hide');
      if (res.success) {
        showUserToast('Data berhasil dihapus!', 'success');
        $('.datatables-users').DataTable().ajax.reload();
      } else {
        showUserToast(res.error || 'Gagal menghapus data', 'danger');
      }
    },
    error: function(xhr) {
      $('#modalHapusUser').modal('hide');
      showUserToast(xhr.responseJSON?.error || 'Gagal menghapus data', 'danger');
    }
  });
});
