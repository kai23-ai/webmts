@php
$containerNav = (isset($configData['contentLayout']) && $configData['contentLayout'] === 'compact') ? 'container-xxl' : 'container-fluid';
$navbarDetached = ($navbarDetached ?? '');
@endphp

<!-- Navbar -->
@if(isset($navbarDetached) && $navbarDetached == 'navbar-detached')
<nav class="layout-navbar {{$containerNav}} navbar navbar-expand-xl {{$navbarDetached}} align-items-center bg-navbar-theme" id="layout-navbar">
  @endif
  @if(isset($navbarDetached) && $navbarDetached == '')
  <nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
    <div class="{{$containerNav}}">
      @endif

      <!--  Brand demo (display only for navbar-full and hide on below xl) -->
      @if(isset($navbarFull))
      <div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-4">
        <a href="{{url('/')}}" class="app-brand-link gap-2">
          <span class="app-brand-logo demo">
            @include('_partials.macros',["height"=>20])
          </span>
          <span class="app-brand-text demo menu-text fw-bold">{{config('variables.templateName')}}</span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-xl-none">
          <i class="ti ti-x ti-sm align-middle"></i>
        </a>
      </div>
      @endif

      <!-- ! Not required for layout-without-menu -->
      @if(!isset($navbarHideToggle))
      <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0{{ isset($menuHorizontal) ? ' d-xl-none ' : '' }} {{ isset($contentNavbar) ?' d-xl-none ' : '' }}">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
          <i class="ti ti-menu-2 ti-sm"></i>
        </a>
      </div>
      @endif

      <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">

        @if(!isset($menuHorizontal))
        <!-- Search -->
        <div class="navbar-nav align-items-center">
          <div class="nav-item navbar-search-wrapper mb-0">
            <a class="nav-item nav-link search-toggler d-flex align-items-center px-0" href="javascript:void(0);">
              <i class="ti ti-search ti-md me-2"></i>
              <span class="d-none d-md-inline-block text-muted">Search (Ctrl+/)</span>
            </a>
          </div>
        </div>
        <!-- /Search -->
        @endif
        <ul class="navbar-nav flex-row align-items-center ms-auto">
          @if(isset($menuHorizontal))
          <!-- Search -->
          <li class="nav-item navbar-search-wrapper me-2 me-xl-0">
            <a class="nav-link search-toggler" href="javascript:void(0);">
              <i class="ti ti-search ti-md"></i>
            </a>
          </li>
          <!-- /Search -->
          @endif
          @if($configData['hasCustomizer'] == true)
          <!-- Style Switcher -->
          <li class="nav-item dropdown-style-switcher dropdown me-2 me-xl-0">
            <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
              <i class='ti ti-md'></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end dropdown-styles">
              <li>
                <a class="dropdown-item" href="javascript:void(0);" data-theme="light">
                  <span class="align-middle"><i class='ti ti-sun me-2'></i>Light</span>
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="javascript:void(0);" data-theme="dark">
                  <span class="align-middle"><i class="ti ti-moon me-2"></i>Dark</span>
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="javascript:void(0);" data-theme="system">
                  <span class="align-middle"><i class="ti ti-device-desktop me-2"></i>System</span>
                </a>
              </li>
            </ul>
          </li>
          <!--/ Style Switcher -->
          @endif

          <!-- Notification -->
          <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-2 me-xl-0">
            <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
              <i class="ti ti-bell ti-md @if(isset($notifCount) && $notifCount > 0) bell-animate @endif"></i>
              <span class="badge bg-danger rounded-pill badge-notifications">{{ isset($notifCount) ? $notifCount : 0 }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end py-0">
              <li class="dropdown-menu-header border-bottom">
                <div class="dropdown-header d-flex align-items-center py-3">
                  <h5 class="text-body mb-0 me-auto">Notification</h5>
                  <a href="javascript:void(0)" class="dropdown-notifications-all text-body" data-bs-toggle="tooltip" data-bs-placement="top" title="Mark all as read"><i class="ti ti-mail-opened fs-4"></i></a>
                </div>
              </li>
              <li class="dropdown-notifications-list scrollable-container">
                <ul class="list-group list-group-flush">
                  @if(isset($notifPengumuman) && count($notifPengumuman))
                    @foreach($notifPengumuman as $item)
                      @php
                        $role = strtolower($item->role ?? '');
                        $warna = 'secondary';
                        if($role === 'admin') $warna = 'primary';
                        elseif($role === 'guru') $warna = 'info';
                        elseif($role === 'siswa') $warna = 'success';
                        $inisial = strtoupper(mb_substr($item->judul,0,2));
                      @endphp
                      <li class="list-group-item list-group-item-action dropdown-notifications-item notif-detail-trigger"
                          data-judul="{{ $item->judul }}"
                          data-isi="{{ $item->isi }}"
                          data-waktu="{{ \Carbon\Carbon::parse($item->updated_at ?? $item->created_at)->translatedFormat('d F Y H:i') }}"
                          data-role="{{ $item->role }}"
                          data-status="{{ $item->status }}">
                        <div class="d-flex">
                          <div class="flex-shrink-0 me-3">
                            <div class="avatar">
                              @if(!empty($item->avatar))
                                <img src="{{ $item->avatar }}" alt class="h-auto rounded-circle">
                              @else
                                <span class="avatar-initial rounded-circle bg-label-{{ $warna }}"><i class="ti ti-bell"></i></span>
                              @endif
                            </div>
                          </div>
                          <div class="flex-grow-1">
                            <h6 class="mb-1">{{ $item->judul }}</h6>
                            <p class="mb-0">{{ Str::limit($item->isi, 60) }}</p>
                            <small class="text-muted">{{ \Carbon\Carbon::parse($item->updated_at ?? $item->created_at)->diffForHumans() }}</small>
                          </div>
                          <div class="flex-shrink-0 dropdown-notifications-actions">
                            <a href="javascript:void(0)" class="dropdown-notifications-read"><span class="badge badge-dot"></span></a>
                            <a href="javascript:void(0)" class="dropdown-notifications-archive"><span class="ti ti-x"></span></a>
                          </div>
                        </div>
                      </li>
                    @endforeach
                  @else
                    <li class="list-group-item text-center text-muted small">Tidak ada pengumuman</li>
                  @endif
                </ul>
              </li>
              <li class="dropdown-menu-footer border-top">
                <a href="#" id="lihatSemuaPengumuman" class="dropdown-item d-flex justify-content-center text-primary p-2 h-px-40 mb-1 align-items-center">
                  Lihat semua pengumuman
                </a>
              </li>
            </ul>
          </li>
          <!--/ Notification -->

          <!-- User -->
          <li class="nav-item navbar-dropdown dropdown-user dropdown">
            <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
              <div class="avatar avatar-online">
                @php
                  $user = Auth::user();
                  $avatar = '1.png'; // default laki-laki
                  
                  if ($user) {
                    $jenisKelamin = null;
                    
                    // Cek jenis kelamin dari relasi guru atau siswa
                    if ($user->guru) {
                      $jenisKelamin = strtoupper(trim($user->guru->jenis_kelamin ?? ''));
                    } elseif ($user->siswa) {
                      $jenisKelamin = strtoupper(trim($user->siswa->jenis_kelamin ?? ''));
                    }
                    
                    // Jika jenis kelamin P (Perempuan), gunakan avatar perempuan
                    if ($jenisKelamin === 'P') {
                      $avatar = '2.png';
                    }
                  }
                @endphp
                <img src="{{ asset('assets/img/avatars/' . $avatar) }}" alt class="h-auto rounded-circle">
              </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li>
                <a class="dropdown-item" href="/profile-account">
                  <div class="d-flex">
                    <div class="flex-shrink-0 me-3">
                      <div class="avatar avatar-online">
                        @php
                          $user = Auth::user();
                          $avatar = '1.png'; // default laki-laki
                          
                          if ($user) {
                            $jenisKelamin = null;
                            
                            // Cek jenis kelamin dari relasi guru atau siswa
                            if ($user->guru) {
                              $jenisKelamin = strtoupper(trim($user->guru->jenis_kelamin ?? ''));
                            } elseif ($user->siswa) {
                              $jenisKelamin = strtoupper(trim($user->siswa->jenis_kelamin ?? ''));
                            }
                            
                            // Jika jenis kelamin P (Perempuan), gunakan avatar perempuan
                            if ($jenisKelamin === 'P') {
                              $avatar = '2.png';
                            }
                          }
                        @endphp
                        <img src="{{ asset('assets/img/avatars/' . $avatar) }}" alt class="h-auto rounded-circle">
                      </div>
                    </div>
                    <div class="flex-grow-1">
                      <small class="text-muted">
                        @if (Auth::check() && Auth::user()->role)
                          {{ ucfirst(Auth::user()->role) }}
                        @endif
                      </small>
                      <div class="fw-medium d-block">
                        @if (Auth::check())
                          @php
                            $user = Auth::user();
                            $nama = '-';
                            if ($user->guru) {
                              $nama = $user->guru->nama;
                            } elseif ($user->siswa) {
                              $nama = $user->siswa->nama;
                            }
                          @endphp
                          {{ $nama }}
                        @else
                          -
                        @endif
                      </div>
                    </div>
                  </div>
                </a>
              </li>
              <li>
                <div class="dropdown-divider"></div>
              </li>
              <li>
                <a class="dropdown-item" href="/profile-account">
                  <i class="ti ti-user-check me-2 ti-sm"></i>
                  <span class="align-middle">Profil Saya</span>
                </a>
              </li>
              <li>
                <div class="dropdown-divider"></div>
              </li>
              <li>
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                  <i class='ti ti-logout me-2'></i>
                  <span class="align-middle">Keluar</span>
                </a>
              </li>
              <form method="POST" id="logout-form" action="{{ route('logout') }}">
                @csrf
              </form>
            </ul>
          </li>
          <!--/ User -->
        </ul>
      </div>

      <!-- Search Small Screens -->
      <div class="navbar-search-wrapper search-input-wrapper {{ isset($menuHorizontal) ? $containerNav : '' }} d-none">
        <input type="text" class="form-control search-input {{ isset($menuHorizontal) ? '' : $containerNav }} border-0" placeholder="Search..." aria-label="Search...">
        <i class="ti ti-x ti-sm search-toggler cursor-pointer"></i>
      </div>
      @php
        $userRole = Auth::check() ? Auth::user()->role : null;
      @endphp
      <script>
        window.currentUserRole = @json($userRole);
      </script>
      @if(isset($navbarDetached) && $navbarDetached == '')
    </div>
    @endif
  </nav>
  <!-- / Navbar -->

<!-- Modal Detail Pengumuman (khusus 1 pengumuman) -->
<div class="modal fade" id="modalDetailPengumumanNotif" tabindex="-1" aria-labelledby="modalDetailPengumumanNotifLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <span class="avatar-initial rounded-circle bg-white text-primary me-2">
          <i class="ti ti-bell"></i>
        </span>
        <h5 class="modal-title d-flex align-items-center mb-0" id="modalDetailPengumumanNotifLabel">
          <span id="detailNotifJudul"></span>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row mb-3">
          <div class="col-auto">
            <span class="badge bg-label-info d-inline-flex align-items-center">
              <i class="ti ti-user me-1"></i>
              <span id="detailNotifRole"></span>
            </span>
          </div>
          <div class="col-auto">
            <span class="badge bg-label-success d-inline-flex align-items-center">
              <i class="ti ti-check me-1"></i>
              <span id="detailNotifStatus"></span>
            </span>
          </div>
          <div class="col text-end text-muted small">
            <i class="ti ti-clock"></i> <span id="detailNotifWaktu"></span>
          </div>
        </div>
        <hr class="my-2">
        <div id="detailNotifIsi" class="fs-6"></div>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>
<!--/ Modal Detail Pengumuman -->

<!-- Modal Semua Pengumuman -->
<div class="modal fade" id="modalSemuaPengumuman" tabindex="-1" aria-labelledby="modalSemuaPengumumanLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalSemuaPengumumanLabel">Semua Pengumuman</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        @if(isset($notifPengumuman) && count($notifPengumuman))
          <ul class="list-group list-group-flush">
            @foreach($notifPengumuman as $item)
              @php
                $role = strtolower($item->role ?? '');
                $warna = 'secondary';
                if($role === 'admin') $warna = 'primary';
                elseif($role === 'guru') $warna = 'info';
                elseif($role === 'siswa') $warna = 'success';
              @endphp
              <li class="list-group-item list-group-item-action semua-pengumuman-item"
                  data-judul="{{ $item->judul }}"
                  data-isi="{{ $item->isi }}"
                  data-waktu="{{ \Carbon\Carbon::parse($item->updated_at ?? $item->created_at)->translatedFormat('d F Y H:i') }}"
                  data-role="{{ $item->role }}"
                  data-status="{{ $item->status }}">
                <div class="d-flex align-items-start">
                  <div class="flex-shrink-0 me-3">
                    <div class="avatar">
                      @if(!empty($item->avatar))
                        <img src="{{ $item->avatar }}" alt class="h-auto rounded-circle">
                      @else
                        <span class="avatar-initial rounded-circle bg-label-{{ $warna }}"><i class="ti ti-bell"></i></span>
                      @endif
                    </div>
                  </div>
                  <div class="flex-grow-1">
                    <div class="d-flex justify-content-between align-items-center">
                      <h6 class="mb-1">{{ $item->judul }}</h6>
                      <small class="text-muted">{{ \Carbon\Carbon::parse($item->updated_at ?? $item->created_at)->translatedFormat('d F Y H:i') }}</small>
                    </div>
                    <div class="mb-1 text-muted small">{{ $item->role }} | {{ $item->status }}</div>
                    <div>{{ $item->isi }}</div>
                  </div>
                </div>
              </li>
            @endforeach
          </ul>
        @else
          <div class="text-center text-muted">Tidak ada pengumuman</div>
        @endif
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>
<!--/ Modal Semua Pengumuman -->

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Lihat semua pengumuman: buka modal semua pengumuman
  var btnLihatSemua = document.getElementById('lihatSemuaPengumuman');
  if (btnLihatSemua) {
    btnLihatSemua.addEventListener('click', function(e) {
      e.preventDefault();
      var modal = new bootstrap.Modal(document.getElementById('modalSemuaPengumuman'));
      modal.show();
    });
  }

  // Klik item di modal semua pengumuman: buka modal detail
  document.querySelectorAll('.semua-pengumuman-item').forEach(function(item) {
    item.addEventListener('click', function() {
      document.getElementById('detailNotifJudul').textContent = this.dataset.judul;
      document.getElementById('detailNotifIsi').textContent = this.dataset.isi;
      document.getElementById('detailNotifWaktu').textContent = this.dataset.waktu;
      document.getElementById('detailNotifRole').textContent = this.dataset.role;
      document.getElementById('detailNotifStatus').textContent = this.dataset.status;
      var semuaModalEl = document.getElementById('modalSemuaPengumuman');
      var semuaModal = bootstrap.Modal.getInstance(semuaModalEl);
      // Buka modal detail hanya setelah modal semua pengumuman benar-benar tertutup
      function openDetailModalOnce() {
        var detailModal = new bootstrap.Modal(document.getElementById('modalDetailPengumumanNotif'));
        detailModal.show();
        semuaModalEl.removeEventListener('hidden.bs.modal', openDetailModalOnce);
      }
      semuaModalEl.addEventListener('hidden.bs.modal', openDetailModalOnce);
      semuaModal.hide();
    });
  });
});
</script>

<style>
@keyframes bell-shake {
  0% { transform: rotate(0); }
  15% { transform: rotate(-15deg); }
  30% { transform: rotate(10deg); }
  45% { transform: rotate(-10deg); }
  60% { transform: rotate(6deg); }
  75% { transform: rotate(-4deg); }
  100% { transform: rotate(0); }
}
.bell-animate {
  animation: bell-shake 1s cubic-bezier(.36,.07,.19,.97) both infinite;
  transform-origin: top center;
}
</style>
