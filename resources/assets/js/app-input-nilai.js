'use strict';

document.addEventListener('DOMContentLoaded', function () {
  console.log('DOM Content Loaded - Initializing app-input-nilai.js');

  // Status pengisian nilai per mata pelajaran
  let mapelStatus = {};

  // Inisialisasi DataTable
  const tableInputNilai = $('#table-input-nilai');
  if (tableInputNilai.length) {
    tableInputNilai.DataTable({
      responsive: true,
      language: {
        url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
      }
    });
  }

  // Format tampilan mata pelajaran di dropdown dengan indikator status
  function formatMataPelajaran(mapel) {
    if (!mapel.id) {
      return mapel.text;
    }

    let status = '';
    if (mapelStatus[mapel.id]) {
      const statusData = mapelStatus[mapel.id];
      if (statusData.total === statusData.filled) {
        status = '<span class="badge bg-success ms-2">Lengkap</span>';
      } else if (statusData.filled > 0) {
        status = `<span class="badge bg-warning ms-2">Sebagian (${statusData.filled}/${statusData.total})</span>`;
      } else {
        status = '<span class="badge bg-secondary ms-2">Belum diisi</span>';
      }
    }

    return $(`<span>${mapel.text} ${status}</span>`);
  }

  // Format tampilan mata pelajaran saat dipilih
  function formatMataPelajaranSelection(mapel) {
    if (!mapel.id) {
      return mapel.text;
    }

    let status = '';
    if (mapelStatus[mapel.id]) {
      const statusData = mapelStatus[mapel.id];
      if (statusData.total === statusData.filled) {
        status = '<span class="badge bg-success ms-2">Lengkap</span>';
      } else if (statusData.filled > 0) {
        status = `<span class="badge bg-warning ms-2">Sebagian</span>`;
      } else {
        status = '<span class="badge bg-secondary ms-2">Belum diisi</span>';
      }
    }

    return $(`<span>${mapel.text} ${status}</span>`);
  }

  // Inisialisasi Select2 untuk semua dropdown dengan template kustom untuk mata pelajaran
  $('#mata_pelajaran').select2({
    placeholder: 'Pilih Mata Pelajaran',
    allowClear: true,
    templateResult: formatMataPelajaran,
    templateSelection: formatMataPelajaranSelection,
    width: '100%'
  });

  $('#tahun_ajaran').select2({
    placeholder: 'Pilih Tahun Ajaran',
    allowClear: true,
    width: '100%'
  });

  $('#semester').select2({
    placeholder: 'Pilih Semester',
    allowClear: true,
    width: '100%'
  });

  // Tambahkan CSS untuk memperbaiki posisi dropdown
  $('<style>')
    .prop('type', 'text/css')
    .html(`
      .select2-container {
        z-index: 9999 !important;
      }
      .select2-dropdown {
        z-index: 9999 !important;
      }
      .select2-container--open {
        z-index: 9999 !important;
      }
      body.select2-open {
        overflow: visible !important;
      }
      .modal-open .select2-container {
        z-index: 1056 !important;
      }
    `)
    .appendTo('head');

  // Tampilkan pesan & animasi saat awal buka halaman
  $('#not-selected-message').show();
  $('#form-nilai').hide();

  // Buat panel status jika belum ada
  if ($('#nilai-status-panel').length === 0) {
    const statusPanel = $(`
      <div id="nilai-status-panel" class="alert d-flex align-items-center mb-3" style="display: none;">
        <i class="status-icon ti me-2 fs-3"></i>
        <div class="status-text"></div>
      </div>
    `);

    // Tambahkan panel status sebelum form nilai
    $('#form-nilai').before(statusPanel);
  }

  // Fungsi untuk memperbarui status pengisian nilai
  function updateNilaiStatus() {
    const totalSiswa = $('#table-input-nilai tbody tr').length;
    let filledCount = 0;

    $('#table-input-nilai tbody tr').each(function () {
      const nilai = $(this).find('input[name^="nilai["]').val();
      if (nilai !== undefined && nilai !== null && nilai !== '') {
        filledCount++;
      }
    });

    const statusPanel = $('#nilai-status-panel');
    const statusIcon = statusPanel.find('.status-icon');
    const statusText = statusPanel.find('.status-text');

    // Update status panel
    if (filledCount === 0) {
      statusPanel.removeClass('alert-success alert-warning').addClass('alert-secondary');
      statusIcon.removeClass().addClass('status-icon ti ti-info-circle me-2 fs-3');
      statusText.html(`<strong>Belum ada nilai yang diinput</strong> - Silakan masukkan nilai untuk ${totalSiswa} siswa.`);
    } else if (filledCount < totalSiswa) {
      statusPanel.removeClass('alert-success alert-secondary').addClass('alert-warning');
      statusIcon.removeClass().addClass('status-icon ti ti-alert-triangle me-2 fs-3');
      statusText.html(`<strong>Pengisian sebagian</strong> - ${filledCount} dari ${totalSiswa} nilai siswa telah diisi. Masih ada ${totalSiswa - filledCount} nilai yang belum diinput.`);
    } else {
      statusPanel.removeClass('alert-warning alert-secondary').addClass('alert-success');
      statusIcon.removeClass().addClass('status-icon ti ti-check-circle me-2 fs-3');
      statusText.html(`<strong>Pengisian lengkap</strong> - Semua nilai untuk ${totalSiswa} siswa telah diisi.`);
    }

    statusPanel.show();

    // Simpan status untuk mata pelajaran ini
    const mataPelajaranId = $('#mata_pelajaran').val();
    if (mataPelajaranId) {
      mapelStatus[mataPelajaranId] = {
        total: totalSiswa,
        filled: filledCount
      };
    }

    // Update tombol simpan
    const submitBtn = $('#form-batch-nilai button[type="submit"]');
    if (filledCount === 0) {
      submitBtn.prop('disabled', true);
    } else {
      submitBtn.prop('disabled', false);
      if (filledCount < totalSiswa) {
        submitBtn.html('<i class="ti ti-device-floppy me-1"></i> Simpan Nilai yang Sudah Diisi');
      } else {
        submitBtn.html('<i class="ti ti-device-floppy me-1"></i> Simpan Semua Nilai');
      }
    }
  }

  // Event listener untuk perubahan dropdown
  $('#mata_pelajaran, #tahun_ajaran, #semester').on('change', function () {
    const mataPelajaranId = $('#mata_pelajaran').val();
    const tahunAjaranId = $('#tahun_ajaran').val();
    const semesterId = $('#semester').val();

    // Tampilkan tabel hanya jika semua dropdown sudah dipilih
    if (mataPelajaranId && tahunAjaranId && semesterId) {
      $('#form-nilai').show();
      $('#not-selected-message').hide();

      // Reset status panel
      $('#nilai-status-panel').hide();

      // Ambil nilai siswa yang sudah ada
      $.ajax({
        url: '/input-nilai/get-nilai',
        method: 'POST',
        contentType: 'application/json',
        processData: false,
        data: JSON.stringify({
          mapel_id: mataPelajaranId,
          semester_id: semesterId,
          tahun_ajaran_id: tahunAjaranId,
          _token: $('meta[name="csrf-token"]').attr('content')
        }),
        success: function (response) {
          if (response.success) {
            // Reset semua input nilai
            $('#table-input-nilai tbody tr').each(function () {
              $(this).find('input[name^="nilai["]').val('');
            });
            // Isi input nilai sesuai data
            response.data.forEach(function (item) {
              const kelasSiswaId = item.kelas_siswa_id;
              const nilaiAkhir = item.nilai_akhir;
              const row = $(`tr[data-kelas-siswa-id="${kelasSiswaId}"]`);
              row.find('input[name^="nilai["]').val(nilaiAkhir);
            });

            // Update status pengisian nilai
            updateNilaiStatus();
          }
        }
      });
    } else {
      $('#form-nilai').hide();
      $('#not-selected-message').show();
      $('#nilai-status-panel').hide();
      // Reset semua input nilai jika dropdown tidak lengkap
      $('#table-input-nilai tbody tr').each(function () {
        $(this).find('input[name^="nilai["]').val('');
      });
    }
  });

  // Lottie animasi untuk pesan belum memilih mata pelajaran
  if (window.lottie) {
    lottie.loadAnimation({
      container: document.getElementById('lottie-not-found'),
      renderer: 'svg',
      loop: true,
      autoplay: true,
      path: '/assets/lottie/data-not-found.json'
    });
  }

  // Event listener untuk input nilai angka (untuk update status)
  $(document).on('input', '.nilai-angka', function () {
    updateNilaiStatus();
  });

  // Fungsi untuk memuat status pengisian nilai untuk semua mata pelajaran
  function loadAllMapelStatus() {
    const tahunAjaranId = $('#tahun_ajaran').val();
    const semesterId = $('#semester').val();

    if (!tahunAjaranId || !semesterId) {
      console.log('Missing required parameters for loadAllMapelStatus');
      return;
    }

    // Ambil data status pengisian nilai dari server
    $.ajax({
      url: '/input-nilai/get-mapel-status',
      method: 'POST',
      contentType: 'application/json',
      processData: false,
      data: JSON.stringify({
        semester_id: semesterId,
        tahun_ajaran_id: tahunAjaranId,
        _token: $('meta[name="csrf-token"]').attr('content')
      }),
      success: function (response) {
        if (response.success && response.data) {
          // Simpan data status untuk semua mata pelajaran
          mapelStatus = {};
          response.data.forEach(function (item) {
            mapelStatus[item.mapel_id] = {
              total: item.total_siswa,
              filled: item.nilai_terisi
            };
          });

          // Perbarui tampilan dropdown
          $('#mata_pelajaran').trigger('change.select2');
          console.log('Status loaded from server:', mapelStatus);
        }
      },
      error: function (xhr, status, error) {
        console.log('Error loading status:', error);
      }
    });
  }

  // Fungsi untuk memastikan nilai default dipilih
  function ensureDefaultValuesSelected() {
    let changed = false;

    // Pilih tahun ajaran default jika belum dipilih
    if (!$('#tahun_ajaran').val()) {
      // Coba pilih opsi dengan teks "(Aktif)"
      const defaultTahunAjaran = $('#tahun_ajaran option:contains("(Aktif)")');
      if (defaultTahunAjaran.length) {
        $('#tahun_ajaran').val(defaultTahunAjaran.val());
        changed = true;
      } else {
        // Jika tidak ada yang aktif, pilih opsi pertama yang bukan placeholder
        const firstTahunAjaran = $('#tahun_ajaran option[value!=""]').first();
        if (firstTahunAjaran.length) {
          $('#tahun_ajaran').val(firstTahunAjaran.val());
          changed = true;
        }
      }
    }

    // Pilih semester default jika belum dipilih
    if (!$('#semester').val()) {
      // Coba pilih opsi dengan teks "(Aktif)"
      const defaultSemester = $('#semester option:contains("(Aktif)")');
      if (defaultSemester.length) {
        $('#semester').val(defaultSemester.val());
        changed = true;
      } else {
        // Jika tidak ada yang aktif, pilih opsi pertama yang bukan placeholder
        const firstSemester = $('#semester option[value!=""]').first();
        if (firstSemester.length) {
          $('#semester').val(firstSemester.val());
          changed = true;
        }
      }
    }

    // Trigger change event jika ada perubahan
    if (changed) {
      $('#tahun_ajaran, #semester').trigger('change.select2');
    }

    return changed;
  }

  // Inisialisasi saat halaman dimuat
  $(document).ready(function () {
    console.log('Document ready - Setting up default values and status');

    // Pastikan nilai default dipilih
    ensureDefaultValuesSelected();

    // Muat status mata pelajaran
    if ($('#tahun_ajaran').val() && $('#semester').val()) {
      loadAllMapelStatus();
    }
  });

  // Load status mata pelajaran saat tahun ajaran atau semester berubah
  $('#tahun_ajaran, #semester').on('change', function () {
    loadAllMapelStatus();
  });

  // Validasi input nilai
  $(document).on('input', 'input[type="number"]', function () {
    const value = parseInt($(this).val());
    const min = parseInt($(this).attr('min'));
    const max = parseInt($(this).attr('max'));

    if (value < min) {
      $(this).val(min);
    } else if (value > max) {
      $(this).val(max);
    }
  });

  // Batch simpan semua nilai
  $(document).on('submit', '#form-batch-nilai', function (e) {
    e.preventDefault();
    const mataPelajaranId = $('#mata_pelajaran').val();
    const tahunAjaranId = $('#tahun_ajaran').val();
    const semesterId = $('#semester').val();
    const _token = $('meta[name="csrf-token"]').attr('content');

    // Ambil semua nilai siswa
    let dataNilai = [];
    $('#table-input-nilai tbody tr').each(function () {
      const kelasSiswaId = $(this).data('kelas-siswa-id');
      const nilai = $(this).find('input[name^="nilai["]').val();
      if (kelasSiswaId && nilai !== undefined && nilai !== null && nilai !== '') {
        dataNilai.push({
          kelas_siswa_id: kelasSiswaId,
          nilai_akhir: nilai
        });
      }
    });

    // Validasi
    if (!mataPelajaranId || !tahunAjaranId || !semesterId) {
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'Pilih mata pelajaran, tahun ajaran, dan semester terlebih dahulu'
      });
      return;
    }
    if (dataNilai.length === 0) {
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'Tidak ada nilai yang diinputkan'
      });
      return;
    }

    // Show loading spinner
    if (typeof showLoadingSpinner === 'function') {
      showLoadingSpinner();
    }

    // Kirim data batch ke server
    $.ajax({
      url: '/input-nilai/batch-store',
      method: 'POST',
      contentType: 'application/json',
      processData: false,
      data: JSON.stringify({
        mapel_id: mataPelajaranId,
        semester_id: semesterId,
        nilai: dataNilai,
        _token: _token
      }),
      success: function (response) {
        // Hide loading spinner
        if (typeof hideLoadingSpinner === 'function') {
          hideLoadingSpinner();
        }

        if (response.success) {
          Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: response.message,
            timer: 2000,
            showConfirmButton: false
          });

          // Update status mata pelajaran setelah berhasil menyimpan
          loadAllMapelStatus();
        }
      },
      error: function (xhr) {
        // Hide loading spinner
        if (typeof hideLoadingSpinner === 'function') {
          hideLoadingSpinner();
        }

        let errorMessage = 'Terjadi kesalahan';
        if (xhr.responseJSON && xhr.responseJSON.errors) {
          const errors = xhr.responseJSON.errors;
          errorMessage = Object.values(errors).flat().join('\n');
        }
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: errorMessage
        });
      }
    });
  });
});