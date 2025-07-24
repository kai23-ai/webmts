@extends('layouts.contentNavbarLayout')

@section('title', 'Mata Pelajaran')

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

@section('content')
<h4 class="py-3 mb-4"><span class="text-muted fw-light">Data Master /</span> Mata Pelajaran</h4>
<!-- Mata Pelajaran List Table -->
<div class="card">
  <div class="card-datatable table-responsive">
    <table class="datatables-mata-pelajaran table">
      <thead class="border-top">
        <tr>
          <th>Kode Mapel</th>
          <th>Nama Mapel</th>
          <th>Jenis Mapel</th>
          <th>Urutan</th>
          <th>Aksi</th>
        </tr>
      </thead>
    </table>
  </div>
</div>

<!-- Modal Tambah/Edit Mata Pelajaran -->
<div class="modal fade" id="modalAddMataPelajaran" tabindex="-1" aria-labelledby="modalAddMataPelajaranLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form class="modal-content" id="formAddMataPelajaran">
      <div class="modal-header">
        <h5 class="modal-title" id="modalAddMataPelajaranLabel">Tambah Mata Pelajaran</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="kodeMapel" class="form-label">Kode Mapel</label>
          <input type="text" class="form-control text-uppercase" id="kodeMapel" name="kode_mapel" maxlength="10" required />
        </div>
        <div class="mb-3">
          <label for="namaMapel" class="form-label">Nama Mapel</label>
          <input type="text" class="form-control" id="namaMapel" name="nama_mapel" required />
        </div>
        <div class="mb-3">
          <label for="jenisMapel" class="form-label">Jenis Mapel</label>
          <select class="form-select" id="jenisMapel" name="jenis_mapel" required>
            <option value="PAI">PAI</option>
            <option value="UMUM">Umum</option>
            <option value="MULOK">Muatan Lokal</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="urutanMapel" class="form-label">Urutan</label>
          <input type="number" class="form-control" id="urutanMapel" name="urutan" required />
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Detail Mata Pelajaran -->
<div class="modal fade" id="modalDetailMataPelajaran" tabindex="-1" aria-labelledby="modalDetailMataPelajaranLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="modalDetailMataPelajaranLabel">Details of <span id="detailMataPelajaranNamaTitle">Mata Pelajaran</span></h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table class="table">
          <tbody>
            <tr>
              <td>Kode Mapel:</td>
              <td id="detailMataPelajaranKode"></td>
            </tr>
            <tr>
              <td>Nama Mapel:</td>
              <td id="detailMataPelajaranNama"></td>
            </tr>
            <tr>
              <td>Jenis Mapel:</td>
              <td id="detailMataPelajaranJenis"></td>
            </tr>
            <tr>
              <td>Urutan:</td>
              <td id="detailMataPelajaranUrutan"></td>
            </tr>
            <tr>
              <td>Actions:</td>
              <td>
                <div class="d-inline-block">
                  <a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></a>
                  <div class="dropdown-menu dropdown-menu-end m-0">
                    <a href="javascript:;" class="dropdown-item btn-edit-mata-pelajaran" data-id="">Edit</a>
                    <a href="javascript:;" class="dropdown-item text-danger btn-hapus-mata-pelajaran" data-id="">Hapus</a>
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

<!-- Modal Hapus Mata Pelajaran -->
<div class="modal fade" id="modalHapusMataPelajaran" tabindex="-1" aria-labelledby="modalHapusMataPelajaranLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form class="modal-content" id="formHapusMataPelajaran">
      <div class="modal-header">
        <h4 class="modal-title text-danger" id="modalHapusMataPelajaranLabel">Konfirmasi Hapus Mata Pelajaran</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-danger mb-3" role="alert">
          Yakin ingin menghapus data berikut?
        </div>
        <table class="table mb-0">
          <tbody>
            <tr>
              <td>Kode Mapel:</td>
              <td id="hapusMataPelajaranKode"></td>
            </tr>
            <tr>
              <td>Nama Mapel:</td>
              <td id="hapusMataPelajaranNama"></td>
            </tr>
            <tr>
              <td>Urutan:</td>
              <td id="hapusMataPelajaranUrutan"></td>
            </tr>
          </tbody>
        </table>
        <input type="hidden" id="hapusMataPelajaranId" name="id" />
      </div>
      <div class="modal-footer justify-content-center">
        <button type="submit" class="btn btn-danger">Hapus</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
      </div>
    </form>
  </div>
</div>

<!-- Toast Notifikasi -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999">
  <div id="mataPelajaranToast" class="toast align-items-center text-bg-white border-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header">
      <i class="ti ti-info-circle me-2"></i>
      <strong class="me-auto">Notifikasi</strong>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body" id="mataPelajaranToastBody"></div>
  </div>
</div>
@endsection

@section('page-script')
  @vite('resources/assets/js/app-mata-pelajaran-list.js')
@endsection 