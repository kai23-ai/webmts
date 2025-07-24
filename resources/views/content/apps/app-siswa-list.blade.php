@extends('layouts/layoutMaster')

@section('title', 'Siswa List - Pages')

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
  @vite('resources/assets/js/app-siswa-list.js')
@endsection

@section('content')
<h4 class="py-3 mb-4"><span class="text-muted fw-light">Data Master /</span> Siswa</h4>
<div class="card">
  <div class="card-datatable table-responsive">
    <table class="datatables-siswa table">
      <thead class="border-top">
        <tr>
          <th></th>
          <th>Nama</th>
          <th>NIS</th>
          <th>Jenis Kelamin</th>
          <th>Alamat</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
    </table>
  </div>
  <!-- Modal Add/Edit Siswa -->
  <div class="modal fade" id="modalAddSiswa" tabindex="-1" aria-labelledby="modalAddSiswaLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form id="formAddSiswa" class="modal-content" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title" id="modalAddSiswaLabel">Tambah Siswa</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Nama</label>
              <input type="text" name="nama" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">NIS</label>
              <input type="text" name="nis" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">NISN</label>
              <input type="text" name="nisn" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Jenis Kelamin</label>
              <select name="jenis_kelamin" class="form-select" required>
                <option value="">Pilih</option>
                <option value="L">Laki-laki</option>
                <option value="P">Perempuan</option>
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Status</label>
              <select name="status" class="form-select" required>
                <option value="aktif">Aktif</option>
                <option value="tidak">Tidak Aktif</option>
                <option value="lulus">Lulus</option>
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">No Induk</label>
              <input type="text" name="no_induk" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Tempat Lahir</label>
              <input type="text" name="tempat_lahir" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Tanggal Lahir</label>
              <input type="date" name="tanggal_lahir" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">No. Telepon</label>
              <input type="text" name="notelp" class="form-control">
            </div>
            <div class="col-12 mb-3">
              <label class="form-label">Alamat</label>
              <textarea name="alamat" class="form-control" required></textarea>
            </div>
            <div class="col-12 mb-3">
              <label class="form-label">Foto</label>
              <input type="file" name="foto" class="form-control" accept="image/*">
              <small class="form-text text-muted">Foto opsional, boleh dikosongkan.</small>
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
  <!-- Modal Konfirmasi Hapus Siswa -->
  <div class="modal fade" id="modalHapusSiswa" tabindex="-1" aria-labelledby="modalHapusSiswaLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form id="formHapusSiswa" class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title text-danger" id="modalHapusSiswaLabel">Konfirmasi Hapus Siswa</h4>
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
                <td id="hapusSiswaNama"></td>
              </tr>
              <tr>
                <td>NIS:</td>
                <td id="hapusSiswaNis"></td>
              </tr>
            </tbody>
          </table>
          <input type="hidden" name="id" id="hapusSiswaId">
        </div>
        <div class="modal-footer justify-content-center">
          <button type="submit" class="btn btn-danger">Hapus</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
  <!-- Modal Detail Siswa -->
  <div class="modal fade" id="modalDetailSiswa" tabindex="-1" aria-labelledby="modalDetailSiswaLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="modalDetailSiswaLabel">Details of <span id="detailSiswaNamaTitle">Siswa</span></h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <table class="table">
            <tbody>
              <tr>
                <td>Nama:</td>
                <td id="detailSiswaNama"></td>
              </tr>
              <tr>
                <td>NIS:</td>
                <td id="detailSiswaNis"></td>
              </tr>
              <tr>
                <td>Jenis Kelamin:</td>
                <td id="detailSiswaJK"></td>
              </tr>
              <tr>
                <td>Alamat:</td>
                <td id="detailSiswaAlamat"></td>
              </tr>
              <tr>
                <td>Status:</td>
                <td><span class="badge" id="detailSiswaStatus"></span></td>
              </tr>
              <tr>
                <td>Actions:</td>
                <td>
                  <div class="d-inline-block">
                    <a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></a>
                    <div class="dropdown-menu dropdown-menu-end m-0">
                      <a href="javascript:;" class="dropdown-item btn-edit-siswa" data-id="" data-nama="">Edit</a>
                      <div class="dropdown-divider"></div>
                      <a href="javascript:;" class="dropdown-item text-danger btn-hapus-siswa" data-id="" data-nama="">Delete</a>
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
<div id="siswaToast" class="bs-toast toast fade position-fixed top-0 end-0 m-3" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="2000" style="z-index: 1100;">
  <div class="toast-header">
    <i class="ti ti-bell ti-xs me-2"></i>
    <div class="me-auto fw-medium">Notifikasi</div>
    <small class="text-muted">Baru saja</small>
    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
  </div>
  <div class="toast-body" id="siswaToastBody">
    Hello, world! This is a toast message.
  </div>
</div>
@endsection 