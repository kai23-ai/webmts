@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Account settings - Security')

<!-- Vendor Styles -->
@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/select2/select2.scss',
  'resources/assets/vendor/libs/@form-validation/form-validation.scss'
])
@endsection

<!-- Page Styles -->
@section('page-style')
@vite(['resources/assets/vendor/scss/pages/page-account-settings.scss'])
<style>
/* Floating Particles Animation */
.floating-particles {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  pointer-events: none;
  z-index: 1;
}

.particle {
  position: absolute;
  width: 4px;
  height: 4px;
  background: rgba(102, 126, 234, 0.3);
  border-radius: 50%;
  animation: float-particle 15s linear infinite;
}

@keyframes float-particle {
  0% {
    transform: translateY(100vh) rotate(0deg);
    opacity: 0;
  }
  10% {
    opacity: 1;
  }
  90% {
    opacity: 1;
  }
  100% {
    transform: translateY(-100px) rotate(360deg);
    opacity: 0;
  }
}

.particle:nth-child(1) { left: 10%; animation-delay: 0s; }
.particle:nth-child(2) { left: 20%; animation-delay: 2s; }
.particle:nth-child(3) { left: 30%; animation-delay: 4s; }
.particle:nth-child(4) { left: 40%; animation-delay: 6s; }
.particle:nth-child(5) { left: 50%; animation-delay: 8s; }
.particle:nth-child(6) { left: 60%; animation-delay: 10s; }
.particle:nth-child(7) { left: 70%; animation-delay: 12s; }
.particle:nth-child(8) { left: 80%; animation-delay: 14s; }
.particle:nth-child(9) { left: 90%; animation-delay: 16s; }
</style>
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/select2/select2.js',
  'resources/assets/vendor/libs/@form-validation/popular.js',
  'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
  'resources/assets/vendor/libs/@form-validation/auto-focus.js',
  'resources/assets/vendor/libs/cleavejs/cleave.js',
  'resources/assets/vendor/libs/cleavejs/cleave-phone.js'
])
@endsection

<!-- Page Scripts -->
@section('page-script')
@vite([
  'resources/assets/js/pages-account-settings-security.js',
  'resources/assets/js/modal-enable-otp.js'
])
@endsection

@push('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')

<!-- Floating Particles -->
<div class="floating-particles">
  <div class="particle"></div>
  <div class="particle"></div>
  <div class="particle"></div>
  <div class="particle"></div>
  <div class="particle"></div>
  <div class="particle"></div>
  <div class="particle"></div>
  <div class="particle"></div>
  <div class="particle"></div>
</div>

{{-- <h4 class="py-3 mb-4">
  <span class="text-muted fw-light">Account Settings /</span> Security
</h4> --}}

<div class="row">
  <div class="col-md-12">
    <ul class="nav nav-pills flex-column flex-md-row mb-4">
      <li class="nav-item"><a class="nav-link" href="/profile-account"><i class="ti-xs ti ti-users me-1"></i> Akun</a></li>
      <li class="nav-item"><a class="nav-link active" href="/profile-security"><i class="ti-xs ti ti-lock me-1"></i> Keamanan</a></li>
    </ul>
    <!-- Change Password -->
    <div class="card mb-4">
      <h5 class="card-header">Ubah Kata Sandi</h5>
      <div class="card-body">
        <form id="formChangePassword" method="POST" onsubmit="return false">
          <div id="changePassAlert"></div>
          <div class="row">
            <div class="mb-3 col-md-6 form-password-toggle">
              <label class="form-label" for="currentPassword">Kata Sandi Saat Ini</label>
              <div class="input-group input-group-merge">
                <input class="form-control" type="password" name="currentPassword" id="currentPassword" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="mb-3 col-md-6 form-password-toggle">
              <label class="form-label" for="newPassword">Kata Sandi Baru</label>
              <div class="input-group input-group-merge">
                <input class="form-control" type="password" id="newPassword" name="newPassword" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
              </div>
            </div>
            <div class="mb-3 col-md-6 form-password-toggle">
              <label class="form-label" for="newPassword_confirmation">Konfirmasi Kata Sandi Baru</label>
              <div class="input-group input-group-merge">
                <input class="form-control" type="password" name="newPassword_confirmation" id="newPassword_confirmation" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
              </div>
            </div>
            <div class="col-12 mb-4">
              <h6>Kriteria Kata Sandi:</h6>
              <ul class="ps-3 mb-0">
                <li class="mb-1">Minimal 4 karakter - semakin panjang semakin baik</li>
                <li class="mb-1">Setidaknya satu huruf kecil</li>
                <li>Setidaknya satu angka, simbol, atau spasi</li>
              </ul>
            </div>
            <div>
              <button type="submit" class="btn btn-primary me-2">Simpan Perubahan</button>
              <button type="reset" class="btn btn-label-secondary">Batal</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <!--/ Change Password -->
  </div>
</div>
@endsection
