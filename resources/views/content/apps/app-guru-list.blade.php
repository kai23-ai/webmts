@extends('layouts/layoutMaster')

@section('title', 'User List - Pages')

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
  @vite('resources/assets/js/app-guru-list.js')
@endsection

@section('content')
<h4 class="py-3 mb-4"><span class="text-muted fw-light">Data Master /</span> Guru</h4>
<!-- Users List Table -->
<div class="card">

  <div class="card-datatable table-responsive">
    <table class="datatables-guru table">
      <thead class="border-top">
        <tr>
          <th></th> <!-- expand -->
          <th></th> <!-- checkbox -->
          <th>Nama</th>
          <th>Jenis Kelamin</th>
          <th>Alamat</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
    </table>
  </div>
  <!-- Modal Add Guru -->
  <div class="modal fade" id="modalAddGuru" tabindex="-1" aria-labelledby="modalAddGuruLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form id="formAddGuru" class="modal-content" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title" id="modalAddGuruLabel">Tambah Guru</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">NIP</label>
            <input type="text" name="nip" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" name="nama" class="form-control" required>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">Tempat Lahir</label>
              <input type="text" name="tempat_lahir" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Tanggal Lahir</label>
              <input type="date" name="tanggal_lahir" class="form-control" required>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control">
            </div>
            <div class="col-md-6">
              <label class="form-label">No. Telepon</label>
              <input type="text" name="notelp" class="form-control">
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Foto</label>
            <input type="file" name="foto" class="form-control" accept="image/*">
            <small class="form-text text-muted">Foto opsional, boleh dikosongkan.</small>
          </div>
          <div class="mb-3">
            <label class="form-label">Jenis Kelamin</label>
            <select name="jenis_kelamin" class="form-select" required>
              <option value="">Pilih</option>
              <option value="L">Laki-laki</option>
              <option value="P">Perempuan</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea name="alamat" class="form-control" required></textarea>
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
  <!-- Modal Konfirmasi Hapus Guru -->
  <div class="modal fade" id="modalHapusGuru" tabindex="-1" aria-labelledby="modalHapusGuruLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form id="formHapusGuru" class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title text-danger" id="modalHapusGuruLabel">Konfirmasi Hapus Guru</h4>
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
                <td id="hapusGuruNama"></td>
              </tr>
              <tr>
                <td>NIP:</td>
                <td id="hapusGuruNip"></td>
              </tr>
            </tbody>
          </table>
          <input type="hidden" name="id" id="hapusGuruId">
        </div>
        <div class="modal-footer justify-content-center">
          <button type="submit" class="btn btn-danger">Hapus</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
  <!-- Modal Detail Guru -->
  <div class="modal fade" id="modalDetailGuru" tabindex="-1" aria-labelledby="modalDetailGuruLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="modalDetailGuruLabel">Details of <span id="detailGuruNamaTitle">Guru</span></h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <table class="table">
            <tbody>
              <tr>
                <td>Name:</td>
                <td>
                  <div class="d-flex justify-content-left align-items-center">
                    <div class="avatar-wrapper">
                      <div class="avatar me-2">
                        <span class="avatar-initial rounded-circle bg-label-warning" id="detailGuruInitial">GU</span>
                      </div>
                    </div>
                    <div class="d-flex flex-column">
                      <span class="text-truncate fw-medium" id="detailGuruNama"></span>
                      <small class="text-truncate text-muted" id="detailGuruTanggalLahir">-</small>
                    </div>
                  </div>
                </td>
              </tr>
              <tr>
                <td>NIP:</td>
                <td id="detailGuruNip"></td>
              </tr>
              <tr>
                <td>Jenis Kelamin:</td>
                <td id="detailGuruJenisKelamin">-</td>
              </tr>
              <tr>
                <td>Alamat:</td>
                <td id="detailGuruAlamat">-</td>
              </tr>
              <tr>
                <td>Status:</td>
                <td>
                  <span class="badge bg-label-success" id="detailGuruStatus">Aktif</span>
                </td>
              </tr>
              <tr>
                <td>Actions:</td>
                <td>
                  <div class="d-inline-block">
                    <a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></a>
                    <div class="dropdown-menu dropdown-menu-end m-0">
                      <a href="javascript:;" class="dropdown-item btn-edit-guru" data-nip="" data-nama="">Edit</a>
                      <div class="dropdown-divider"></div>
                      <a href="javascript:;" class="dropdown-item text-danger btn-hapus-guru" data-nip="" data-nama="">Delete</a>
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
<!-- Toast persis demo /ui/toasts -->
<div id="guruToast" class="bs-toast toast fade position-fixed top-0 end-0 m-3" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="2000" style="z-index: 1100;">
  <div class="toast-header">
    <i class="ti ti-bell ti-xs me-2"></i>
    <div class="me-auto fw-medium">Bootstrap</div>
    <small class="text-muted">Baru saja</small>
    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
  </div>
  <div class="toast-body" id="guruToastBody">
    Hello, world! This is a toast message.
  </div>
</div>

@endsection
