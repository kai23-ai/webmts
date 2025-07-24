@extends('layouts/layoutMaster')

@section('title', 'Kelas Siswa List - Pages')

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
  @vite('resources/assets/js/app-kelas-siswa-list.js')
@endsection

@section('content')
<h4 class="py-3 mb-4"><span class="text-muted fw-light">Data Master /</span> Kelas Siswa</h4>
<div class="card">
  <div class="card-datatable table-responsive">
    <table class="datatables-kelas-siswa table">
      <thead class="border-top">
        <tr>
          <th></th> <!-- expand -->
          <th>Kelas</th>
          <th>Siswa</th>
          <th>Tahun Ajaran</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
    </table>
  </div>
  <!-- Modal Add/Edit Kelas Siswa -->
  <div class="modal fade" id="modalAddKelasSiswa" tabindex="-1" aria-labelledby="modalAddKelasSiswaLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form id="formAddKelasSiswa" class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalAddKelasSiswaLabel">Tambah Kelas Siswa</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Kelas</label>
            <select name="kelas_id" id="selectKelasKelasSiswa" class="form-select" required></select>
          </div>
          <div class="mb-3">
            <label class="form-label">Siswa</label>
            <select name="siswa_id" id="selectSiswaKelasSiswa" class="form-select" required></select>
          </div>
          <div class="mb-3">
            <label class="form-label">Tahun Ajaran</label>
            <select name="tahun_ajaran_id" id="selectTahunAjaranKelasSiswa" class="form-select" required></select>
          </div>
          <div class="mb-3">
            <label class="form-label me-3">Status Aktif</label>
            <div class="form-check form-switch d-inline-block align-middle">
              <input class="form-check-input" type="checkbox" id="statusAktifKelasSiswaSwitch" name="status" value="aktif" checked>
              <label class="form-check-label" for="statusAktifKelasSiswaSwitch">Aktif</label>
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
  <!-- Modal Konfirmasi Hapus Kelas Siswa -->
  <div class="modal fade" id="modalHapusKelasSiswa" tabindex="-1" aria-labelledby="modalHapusKelasSiswaLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form id="formHapusKelasSiswa" class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title text-danger" id="modalHapusKelasSiswaLabel">Konfirmasi Hapus Kelas Siswa</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="alert alert-danger mb-3" role="alert">
            Yakin ingin menghapus data berikut?
          </div>
          <table class="table mb-0">
            <tbody>
              <tr>
                <td>Kelas:</td>
                <td id="hapusKelasSiswaKelas"></td>
              </tr>
              <tr>
                <td>Siswa:</td>
                <td id="hapusKelasSiswaNama"></td>
              </tr>
              <tr>
                <td>Tahun Ajaran:</td>
                <td id="hapusKelasSiswaTahunAjaran"></td>
              </tr>
            </tbody>
          </table>
          <input type="hidden" name="id" id="hapusKelasSiswaId">
        </div>
        <div class="modal-footer justify-content-center">
          <button type="submit" class="btn btn-danger">Hapus</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
  <!-- Modal Detail Kelas Siswa -->
  <div class="modal fade" id="modalDetailKelasSiswa" tabindex="-1" aria-labelledby="modalDetailKelasSiswaLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="modalDetailKelasSiswaLabel">Details of <span id="detailKelasSiswaNamaTitle">Kelas Siswa</span></h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <table class="table">
            <tbody>
              <tr>
                <td>Kelas:</td>
                <td id="detailKelasSiswaKelas"></td>
              </tr>
              <tr>
                <td>Siswa:</td>
                <td id="detailKelasSiswaNama"></td>
              </tr>
              <tr>
                <td>Tahun Ajaran:</td>
                <td id="detailKelasSiswaTahunAjaran"></td>
              </tr>
              <tr>
                <td>Status:</td>
                <td><span class="badge" id="detailKelasSiswaStatus">Aktif</span></td>
              </tr>
              <tr>
                <td>Actions:</td>
                <td>
                  <div class="d-inline-block">
                    <a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></a>
                    <div class="dropdown-menu dropdown-menu-end m-0">
                      <a href="javascript:;" class="dropdown-item btn-edit-kelas-siswa" data-id="" data-nama="">Edit</a>
                      <div class="dropdown-divider"></div>
                      <a href="javascript:;" class="dropdown-item text-danger btn-hapus-kelas-siswa" data-id="" data-nama="">Delete</a>
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
<div id="kelasSiswaToast" class="bs-toast toast fade position-fixed top-0 end-0 m-3" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="2000" style="z-index: 1100;">
  <div class="toast-header">
    <i class="ti ti-bell ti-xs me-2"></i>
    <div class="me-auto fw-medium">Notifikasi</div>
    <small class="text-muted">Baru saja</small>
    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
  </div>
  <div class="toast-body" id="kelasSiswaToastBody">
    Hello, world! This is a toast message.
  </div>
</div>
@endsection 