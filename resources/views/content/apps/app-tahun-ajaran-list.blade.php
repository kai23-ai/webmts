@extends('layouts/layoutMaster')

@section('title', 'Tahun Ajaran - Pages')

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
  @vite('resources/assets/js/app-tahun-ajaran-list.js')
@endsection

@section('content')
<h4 class="py-3 mb-4"><span class="text-muted fw-light">Data Master /</span> Tahun Ajaran</h4>
<div class="card">
  <div class="card-datatable table-responsive">
    <table class="datatables-tahun-ajaran table">
      <thead class="border-top">
        <tr>
          <th>Tahun</th>
          <th>Aktif</th>
          <th>Aksi</th>
        </tr>
      </thead>
    </table>
  </div>
  <!-- Modal Add/Edit Tahun Ajaran -->
  <div class="modal fade" id="modalAddTahunAjaran" tabindex="-1" aria-labelledby="modalAddTahunAjaranLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form id="formAddTahunAjaran" class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalAddTahunAjaranLabel">Tambah Tahun Ajaran</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Tahun</label>
            <input type="text" name="tahun" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label me-3">Aktif</label>
            <div class="form-check form-switch d-inline-block align-middle">
              <input class="form-check-input" type="checkbox" id="statusAktifTahunAjaranSwitch" name="aktif" value="1">
              <label class="form-check-label" for="statusAktifTahunAjaranSwitch">Aktif</label>
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
  <!-- Modal Konfirmasi Hapus Tahun Ajaran -->
  <div class="modal fade" id="modalHapusTahunAjaran" tabindex="-1" aria-labelledby="modalHapusTahunAjaranLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form id="formHapusTahunAjaran" class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title text-danger" id="modalHapusTahunAjaranLabel">Konfirmasi Hapus Tahun Ajaran</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="alert alert-danger mb-3" role="alert">
            Yakin ingin menghapus data berikut?
          </div>
          <table class="table mb-0">
            <tbody>
              <tr>
                <td>Tahun:</td>
                <td id="hapusTahunAjaranTahun"></td>
              </tr>
            </tbody>
          </table>
          <input type="hidden" name="id" id="hapusTahunAjaranId">
        </div>
        <div class="modal-footer justify-content-center">
          <button type="submit" class="btn btn-danger">Hapus</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
  <!-- Modal Detail Tahun Ajaran -->
  <div class="modal fade" id="modalDetailTahunAjaran" tabindex="-1" aria-labelledby="modalDetailTahunAjaranLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="modalDetailTahunAjaranLabel">Detail Tahun Ajaran</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <table class="table">
            <tbody>
              <tr>
                <td>Tahun:</td>
                <td id="detailTahunAjaranTahun"></td>
              </tr>
              <tr>
                <td>Aktif:</td>
                <td><span class="badge" id="detailTahunAjaranAktif"></span></td>
              </tr>
              <tr>
                <td>Actions:</td>
                <td>
                  <div class="d-inline-block">
                    <a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></a>
                    <div class="dropdown-menu dropdown-menu-end m-0">
                      <a href="javascript:;" class="dropdown-item btn-edit-tahun-ajaran" data-id="">Edit</a>
                      <a href="javascript:;" class="dropdown-item text-danger btn-hapus-tahun-ajaran" data-id="">Hapus</a>
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
<div id="tahunAjaranToast" class="bs-toast toast fade position-fixed top-0 end-0 m-3" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="2000" style="z-index: 1100;">
  <div class="toast-header">
    <i class="ti ti-bell ti-xs me-2"></i>
    <div class="me-auto fw-medium">Bootstrap</div>
    <small class="text-muted">Baru saja</small>
    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
  </div>
  <div class="toast-body" id="tahunAjaranToastBody">
    Hello, world! This is a toast message.
  </div>
</div>
@endsection 