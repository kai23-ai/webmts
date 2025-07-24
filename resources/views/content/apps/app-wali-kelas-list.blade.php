@extends('layouts/layoutMaster')

@section('title', 'Wali Kelas List - Pages')

@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss',
  'resources/assets/vendor/libs/select2/select2.scss',
  'resources/assets/vendor/libs/@form-validation/form-validation.scss',
])
@endsection

@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/moment/moment.js',
  'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
  'resources/assets/vendor/libs/select2/select2.js',
  'resources/assets/vendor/libs/@form-validation/popular.js',
  'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
  'resources/assets/vendor/libs/@form-validation/auto-focus.js',
  'resources/assets/vendor/libs/cleavejs/cleave.js',
  'resources/assets/vendor/libs/cleavejs/cleave-phone.js',
])
@endsection

@section('page-script')
  @vite('resources/assets/js/app-wali-kelas-list.js')
@endsection

@section('content')
<h4 class="py-3 mb-4"><span class="text-muted fw-light">Data Master /</span> Wali Kelas</h4>
<div class="card">
  <div class="card-datatable table-responsive">
    <table class="datatables-wali-kelas table">
      <thead class="border-top">
        <tr>
          <th></th>
          <th>Nama Wali</th>
          <th>NIP</th>
          <th>Kelas</th>
          <th>Tahun Ajaran</th>
          <th>Status</th>
          <th style="display:none"></th> <!-- Hidden th for kelas_id -->
          <th>Aksi</th>
        </tr>
      </thead>
    </table>
  </div>
  <!-- Modal Add/Edit Wali Kelas -->
  <div class="modal fade" id="modalAddWaliKelas" tabindex="-1" aria-labelledby="modalAddWaliKelasLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form id="formAddWaliKelas" class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalAddWaliKelasLabel">Tambah Wali Kelas</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Guru</label>
            <select name="guru_id" class="form-select" id="selectGuruWali" required>
              <option value="">Pilih Guru</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Kelas</label>
            <select name="kelas_id" class="form-select" id="selectKelasWali" required>
              <option value="">Pilih Kelas</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Tahun Ajaran</label>
            <select name="tahun_ajaran_id" class="form-select" id="selectTahunAjaranWali" required>
              <option value="">Pilih Tahun Ajaran</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label me-3">Status Aktif</label>
            <div class="form-check form-switch d-inline-block align-middle">
              <input class="form-check-input" type="checkbox" id="statusAktifWaliSwitch" name="status" value="aktif" checked>
              <label class="form-check-label" for="statusAktifWaliSwitch" id="statusAktifWaliLabel">Aktif</label>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-center">
          <button type="submit" class="btn btn-primary">Simpan</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
  <!-- Modal Konfirmasi Hapus Wali Kelas -->
  <div class="modal fade" id="modalHapusWaliKelas" tabindex="-1" aria-labelledby="modalHapusWaliKelasLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form id="formHapusWaliKelas" class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title text-danger" id="modalHapusWaliKelasLabel">Konfirmasi Hapus Wali Kelas</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="alert alert-danger mb-3" role="alert">
            Yakin ingin menghapus data berikut?
          </div>
          <table class="table mb-0">
            <tbody>
              <tr>
                <td>Nama Wali:</td>
                <td id="hapusWaliKelasNama"></td>
              </tr>
              <tr>
                <td>NIP:</td>
                <td id="hapusWaliKelasNip"></td>
              </tr>
              <tr>
                <td>Kelas:</td>
                <td id="hapusWaliKelasKelas"></td>
              </tr>
            </tbody>
          </table>
          <input type="hidden" name="id" id="hapusWaliKelasId">
        </div>
        <div class="modal-footer justify-content-center">
          <button type="submit" class="btn btn-danger">Hapus</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
  <!-- Modal Detail Wali Kelas -->
  <div class="modal fade" id="modalDetailWaliKelas" tabindex="-1" aria-labelledby="modalDetailWaliKelasLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="modalDetailWaliKelasLabel">Details of <span id="detailWaliKelasNamaTitle">Wali Kelas</span></h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <table class="table">
            <tbody>
              <tr>
                <td>Nama Wali:</td>
                <td id="detailWaliKelasNama"></td>
              </tr>
              <tr>
                <td>NIP:</td>
                <td id="detailWaliKelasNip"></td>
              </tr>
              <tr>
                <td>Kelas:</td>
                <td id="detailWaliKelasKelas"></td>
              </tr>
              <tr>
                <td>Status:</td>
                <td><span class="badge" id="detailWaliKelasStatus"></span></td>
              </tr>
              <tr>
                <td>Actions:</td>
                <td>
                  <div class="d-inline-block">
                    <a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></a>
                    <div class="dropdown-menu dropdown-menu-end m-0">
                      <a href="javascript:;" class="dropdown-item btn-edit-wali-kelas" data-id="" data-nama="">Edit</a>
                      <div class="dropdown-divider"></div>
                      <a href="javascript:;" class="dropdown-item text-danger btn-hapus-wali-kelas" data-id="" data-nama="">Delete</a>
                    </div>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Toast Notifikasi -->
<div id="waliKelasToast" class="bs-toast toast fade position-fixed top-0 end-0 m-3" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="2000" style="z-index: 1100;">
  <div class="toast-header">
    <i class="ti ti-bell ti-xs me-2"></i>
    <div class="me-auto fw-medium">Notifikasi</div>
    <small class="text-muted">Baru saja</small>
    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
  </div>
  <div class="toast-body" id="waliKelasToastBody">
    Hello, world! This is a toast message.
  </div>
</div>
@endsection 