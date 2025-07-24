@extends('layouts/layoutMaster')

@section('title', 'Pengumuman - Pages')

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
  @vite('resources/assets/js/app-pengumuman-list.js')
@endsection

@section('content')
<h4 class="py-3 mb-4"><span class="text-muted fw-light">Data Master /</span> Pengumuman</h4>
<!-- Pengumuman List Table -->
<div class="card">
  <div class="card-datatable table-responsive">
    <table class="datatables-pengumuman table">
      <thead class="border-top">
        <tr>
          <th></th>
          <th></th>
          <th>Judul</th>
          <th>Isi</th>
          <th>Role</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
    </table>
  </div>
  <!-- Modal Add Pengumuman -->
  <div class="modal fade" id="modalAddPengumuman" tabindex="-1" aria-labelledby="modalAddPengumumanLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form id="formAddPengumuman" class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalAddPengumumanLabel">Tambah Pengumuman</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Judul</label>
            <input type="text" name="judul" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Isi</label>
            <textarea name="isi" class="form-control" required></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Role</label>
            <select name="role" class="form-select" required>
              <option value="admin">Admin</option>
              <option value="guru">Guru</option>
              <option value="siswa">Siswa</option>
              <option value="semua">Semua</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label me-3">Status Aktif</label>
            <div class="form-check form-switch d-inline-block align-middle">
              <input class="form-check-input" type="checkbox" id="statusAktifSwitch" name="status" value="aktif" checked>
              <label class="form-check-label" for="statusAktifSwitch">Aktif</label>
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
  <!-- Modal Konfirmasi Hapus Pengumuman -->
  <div class="modal fade" id="modalHapusPengumuman" tabindex="-1" aria-labelledby="modalHapusPengumumanLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form id="formHapusPengumuman" class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title text-danger" id="modalHapusPengumumanLabel">Konfirmasi Hapus Pengumuman</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="alert alert-danger mb-3" role="alert">
            Yakin ingin menghapus data berikut?
          </div>
          <table class="table mb-0">
            <tbody>
              <tr>
                <td>Judul:</td>
                <td id="hapusPengumumanJudul"></td>
              </tr>
              <tr>
                <td>Role:</td>
                <td id="hapusPengumumanRole"></td>
              </tr>
            </tbody>
          </table>
          <input type="hidden" name="id" id="hapusPengumumanId">
        </div>
        <div class="modal-footer justify-content-center">
          <button type="submit" class="btn btn-danger">Hapus</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
  <!-- Modal Detail Pengumuman -->
  <div class="modal fade" id="modalDetailPengumuman" tabindex="-1" aria-labelledby="modalDetailPengumumanLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="modalDetailPengumumanLabel">Detail Pengumuman</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <table class="table">
            <tbody>
              <tr>
                <td>Judul:</td>
                <td>
                  <div class="d-flex justify-content-left align-items-center">
                    <div class="avatar-wrapper">
                      <div class="avatar me-2">
                        <span class="avatar-initial rounded-circle bg-label-primary" id="detailPengumumanInitial">PN</span>
                      </div>
                    </div>
                    <div class="d-flex flex-column">
                      <span class="text-truncate fw-medium" id="detailPengumumanJudul"></span>
                    </div>
                  </div>
                </td>
              </tr>
              <tr>
                <td>Isi:</td>
                <td id="detailPengumumanIsi"></td>
              </tr>
              <tr>
                <td>Role:</td>
                <td id="detailPengumumanRole"></td>
              </tr>
              <tr>
                <td>Status:</td>
                <td>
                  <label class="switch switch-primary mb-0">
                    <input type="checkbox" class="switch-input toggle-status-detail-pengumuman" id="toggleStatusDetailPengumuman" data-id="" />
                    <span class="switch-toggle-slider"></span>
                    <span class="switch-label" id="labelStatusDetailPengumuman">Aktif</span>
                  </label>
                </td>
              </tr>
              <tr>
                <td>Aksi:</td>
                <td>
                  <div class="d-inline-block">
                    <a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></a>
                    <div class="dropdown-menu dropdown-menu-end m-0">
                      <a href="javascript:;" class="dropdown-item btn-edit-pengumuman" data-id="">Edit</a>
                      <div class="dropdown-divider"></div>
                      <a href="javascript:;" class="dropdown-item text-danger btn-hapus-pengumuman" data-id="" data-judul="">Hapus</a>
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
<!-- Toast -->
<div id="pengumumanToast" class="bs-toast toast fade position-fixed top-0 end-0 m-3" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="2000" style="z-index: 1100;">
  <div class="toast-header">
    <i class="ti ti-bell ti-xs me-2"></i>
    <div class="me-auto fw-medium">Notifikasi</div>
    <small class="text-muted">Baru saja</small>
    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
  </div>
  <div class="toast-body" id="pengumumanToastBody">
    Pengumuman berhasil diproses.
  </div>
</div>
@endsection 