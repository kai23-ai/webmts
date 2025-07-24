@extends('layouts/layoutMaster')

@section('title', 'User List - Pages')

@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss',
  'resources/assets/vendor/libs/select2/select2.scss',
  'resources/assets/vendor/libs/@form-validation/form-validation.scss'
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
  'resources/assets/vendor/libs/cleavejs/cleave-phone.js'
])
@endsection

@section('page-script')
@vite('resources/assets/js/app-user-list.js')
@endsection

@section('content')

<style>
  .datatables-users td:nth-child(2), .datatables-users th:nth-child(2) {
    text-align: center;
    width: 40px;
  }
  .datatables-users td:nth-child(1), .datatables-users th:nth-child(1) {
    width: 32px;
  }
</style>

<h4 class="py-3 mb-4"><span class="text-muted fw-light">Data Master /</span> User</h4>
<!-- Users List Table -->
<div class="card">
  <div class="card-datatable table-responsive">
    <table class="datatables-users table">
      <thead class="border-top">
        <tr>
          <th></th> <!-- expand -->
          <th></th> <!-- checkbox -->
          <th>Nama</th>
          <th>Role</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
    </table>
  </div>
  <!-- Modal Add/Edit User -->
  <div class="modal fade" id="modalAddUser" tabindex="-1" aria-labelledby="modalAddUserLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form id="formAddUser" class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalAddUserLabel">Tambah User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
        <div class="modal-body">
        <div class="mb-3">
            <label class="form-label">Role</label>
            <select name="role" class="form-select" required>
              <option value="">Pilih</option>
              <option value="admin">Admin</option>
              <option value="guru">Guru</option>
              <option value="siswa">Siswa</option>
            </select>
        </div>
        <div class="mb-3" id="userRefContainer" style="display:none">
          <label class="form-label" id="userRefLabel"></label>
          <select id="userRefSelect" name="ref_id" class="form-select"></select>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" id="userPassword" class="form-control" autocomplete="new-password">
        </div>
        <div class="mb-3">
            <label class="form-label">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" id="userPasswordConfirmation" class="form-control" autocomplete="new-password">
        </div>
        </div>
        <div class="modal-footer justify-content-center">
          <button type="submit" class="btn btn-primary">Simpan</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
  <!-- Modal Konfirmasi Hapus User -->
  <div class="modal fade" id="modalHapusUser" tabindex="-1" aria-labelledby="modalHapusUserLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form id="formHapusUser" class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title text-danger" id="modalHapusUserLabel">Konfirmasi Hapus User</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="alert alert-danger mb-3" role="alert">
            Yakin ingin menghapus data berikut?
          </div>
          <table class="table mb-0">
            <tbody>
              <tr>
                <td>Nama:</td>
                <td id="hapusUserNama"></td>
              </tr>
            </tbody>
          </table>
          <input type="hidden" name="id" id="hapusUserId">
        </div>
        <div class="modal-footer justify-content-center">
          <button type="submit" class="btn btn-danger">Hapus</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
  <!-- Modal Detail User -->
  <div class="modal fade" id="modalDetailUser" tabindex="-1" aria-labelledby="modalDetailUserLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="modalDetailUserLabel">Details of <span id="detailUserNamaTitle">User</span></h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <table class="table">
            <tbody>
              <tr>
                <td>Nama:</td>
                <td id="detailUserNama"></td>
              </tr>
              <tr>
                <td>Role:</td>
                <td id="detailUserRole">-</td>
              </tr>
              <tr>
                <td>Status:</td>
                <td><span class="badge" id="detailUserStatus">Aktif</span></td>
              </tr>
              <tr>
                <td>Actions:</td>
                <td>
                  <div class="d-inline-block">
                    <a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></a>
                    <div class="dropdown-menu dropdown-menu-end m-0">
                      <a href="javascript:;" class="dropdown-item btn-edit-user" data-id="" data-nama="">Edit</a>
                      <div class="dropdown-divider"></div>
                      <a href="javascript:;" class="dropdown-item text-danger btn-hapus-user" data-id="" data-nama="">Delete</a>
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
<div id="userToast" class="bs-toast toast fade position-fixed top-0 end-0 m-3" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="2000" style="z-index: 1100;">
  <div class="toast-header">
    <i class="ti ti-bell ti-xs me-2"></i>
    <div class="me-auto fw-medium">Notifikasi</div>
    <small class="text-muted">Baru saja</small>
    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
  </div>
  <div class="toast-body" id="userToastBody">
    Hello, world! This is a toast message.
  </div>
</div>

@endsection
