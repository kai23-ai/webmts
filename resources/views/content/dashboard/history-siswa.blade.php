@extends('layouts/layoutMaster')

@section('title', 'History Siswa')

@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss'
])
@endsection

@section('page-style')
@vite(['resources/assets/vendor/scss/pages/page-profile.scss'])
<style>
  .dataTables_filter label > span {
    display: none !important;
  }
  .btn-blink {
    animation: blink-btn 1s linear infinite;
  }
  @keyframes blink-btn {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.3; }
  }
  
  /* Card hover effect */
  .hover-shadow-lg {
    transition: all 0.3s ease;
  }
  .hover-shadow-lg:hover {
    transform: translateY(-5px);
    box-shadow: 0 1rem 3rem rgba(0,0,0,.175)!important;
  }
  
  /* Timeline styles */
  .timeline-with-icons {
    position: relative;
    list-style: none;
  }
  .timeline-with-icons .timeline-item {
    position: relative;
  }
  .timeline-with-icons .timeline-item:after {
    position: absolute;
    display: block;
    top: 0;
  }
  .timeline-with-icons .timeline-icon {
    position: absolute;
    left: -48px;
    background-color: #fff;
    box-shadow: 0 0.5rem 1.2rem rgba(0, 0, 0, 0.05);
    border-radius: 50%;
    height: 31px;
    width: 31px;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .timeline-with-icons .timeline-item {
    position: relative;
    margin-left: 45px;
  }
  .timeline-with-icons .timeline-item:not(:last-child) {
    padding-bottom: 1.5rem;
  }
  .timeline-with-icons .timeline-item::after {
    content: "";
    width: 2px;
    height: 100%;
    background-color: #e9ecef;
    left: -30px;
    top: 0;
    position: absolute;
  }
</style>
@endsection

@section('vendor-script')
@vite(['resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js'])
@endsection

@section('page-script')
@vite(['resources/assets/js/pages-dashboard-guru.js'])
@endsection

@section('content')
<!-- Header -->
<div class="row">
  <div class="col-12">
    <!-- Modern Profile Header with Gradient Background -->
    <div class="card mb-4">
      <!-- Gradient Background Banner -->
      <div class="position-relative">
        <div class="bg-gradient-primary-to-secondary" style="height: 160px; background: linear-gradient(135deg, #7367f0 0%, #9e95f5 100%);"></div>
        
        <!-- Profile Info Container -->
        <div class="p-4">
          <div class="d-flex justify-content-between align-items-center">
            <!-- Left Side: Profile Image and Basic Info -->
            <div class="d-flex align-items-center">
              <!-- Profile Image -->
              @php
                $avatar = '5.png'; // default laki-laki
                if (isset($siswa->jenis_kelamin)) {
                  $jk = strtoupper(trim($siswa->jenis_kelamin));
                  if ($jk === 'P') {
                    $avatar = '6.png'; // avatar perempuan
                  }
                }
              @endphp
              <div class="position-relative mt-n5">
                <img src="{{ asset('assets/img/avatars/' . $avatar) }}" alt="Profile Image" class="rounded-circle border border-white border-4" width="100" height="100">
              </div>
              
              <!-- Basic Info -->
              <div class="ms-3">
                <h3 class="mb-1">{{ $siswa->nama ?? Auth::user()->name }}</h3>
                <div class="d-flex align-items-center mb-2">
                  <i class="ti ti-id-badge me-1 text-muted"></i>
                  <span>NIS: {{ $siswa->nis ?? '-' }}</span>
                </div>
                <div class="d-flex align-items-center">
                  <i class="ti ti-gender-{{ $siswa->jenis_kelamin == 'P' ? 'female' : 'male' }} me-1 text-muted"></i>
                  <span>{{ $siswa->jenis_kelamin == 'P' ? 'Perempuan' : 'Laki-laki' }}</span>
                </div>
              </div>
            </div>
            
            <!-- Right Side: Action Button -->
            <div>
              <a href="{{ url('profile-account') }}" class="btn btn-primary">
                <i class="ti ti-user me-1"></i> Profil Saya
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--/ Header -->

<!-- Navbar pills -->
<div class="row">
  <div class="col-md-12">
    <ul class="nav nav-pills flex-column flex-sm-row mb-4">
      <li class="nav-item"><a class="nav-link" href="{{ url('dashboard/siswa') }}"><i class='ti-xs ti ti-user-check me-1'></i> Profil</a></li>
      <li class="nav-item"><a class="nav-link active" href="{{ url('history-siswa') }}"><i class='ti-xs ti ti-history me-1'></i> History</a></li>
    </ul>
  </div>
</div>
<!--/ Navbar pills -->

<!-- Modern Class History Cards -->
<div class="row">
  <div class="col-12">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h5 class="card-title mb-0">Riwayat Akademik</h5>
          <div class="dropdown">
            <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="historyFilterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="ti ti-filter me-1"></i> Filter
            </button>
            <ul class="dropdown-menu" aria-labelledby="historyFilterDropdown">
              <li><a class="dropdown-item" href="javascript:void(0);">Semua Tahun</a></li>
              <li><a class="dropdown-item" href="javascript:void(0);">2023/2024</a></li>
              <li><a class="dropdown-item" href="javascript:void(0);">2022/2023</a></li>
            </ul>
          </div>
        </div>
        
        <!-- Active Class Card (Featured) -->
        @if($kelas && $kelasSiswa)
        <div class="card border-0 bg-label-primary mb-3 position-relative overflow-hidden">
          <div class="card-body p-4">
            <div class="d-flex justify-content-between">
              <div>
                <div class="d-flex align-items-center mb-2">
                  <div class="avatar avatar-sm me-2 bg-primary">
                    <i class="ti ti-school text-white"></i>
                  </div>
                  <h5 class="mb-0">{{ $kelas->nama_kelas ?? 'VII B' }}</h5>
                  <span class="badge bg-primary ms-2">Aktif</span>
                </div>
                <p class="mb-2 text-muted">
                  <i class="ti ti-calendar me-1"></i> Tahun Ajaran {{ $kelasSiswa->tahunAjaran->tahun ?? '2023/2024' }}
                </p>
                <button class="btn btn-sm btn-primary mt-2">
                  <i class="ti ti-star me-1"></i> Kelas Aktif
                </button>
              </div>
              <div class="position-absolute end-0 bottom-0 p-3">
                <i class="ti ti-school-2 text-primary opacity-25" style="font-size: 5rem;"></i>
              </div>
            </div>
          </div>
        </div>
        @endif
        
        <!-- Academic Timeline -->
        <div class="card mb-4">
          <div class="card-header">
            <h5 class="card-title mb-0">Timeline Akademik</h5>
          </div>
          <div class="card-body">
            <ul class="timeline-with-icons">
              @if($kelas && $kelasSiswa)
              <li class="timeline-item mb-4">
                <div class="timeline-icon bg-primary">
                  <i class="ti ti-school text-white"></i>
                </div>
                <div class="card border-0 shadow-sm mb-0">
                  <div class="card-body">
                    <h6 class="fw-bold mb-1">Kelas {{ $kelas->nama_kelas ?? 'VII B' }}</h6>
                    <p class="text-muted mb-2">Tahun Ajaran {{ $kelasSiswa->tahunAjaran->tahun ?? '2023/2024' }}</p>
                    <span class="badge bg-label-primary">Aktif</span>
                  </div>
                </div>
              </li>
              @endif
              
              @forelse($riwayatKelas as $rw)
              <li class="timeline-item mb-4">
                <div class="timeline-icon bg-secondary">
                  <i class="ti ti-history text-white"></i>
                </div>
                <div class="card border-0 shadow-sm mb-0">
                  <div class="card-body">
                    <h6 class="fw-bold mb-1">Kelas {{ $rw->kelas->nama_kelas ?? 'VI A' }}</h6>
                    <p class="text-muted mb-2">Tahun Ajaran {{ $rw->tahunAjaran->tahun ?? '2022/2023' }}</p>
                    <span class="badge bg-label-secondary">{{ ucfirst($rw->status) ?? 'Selesai' }}</span>
                  </div>
                </div>
              </li>
              @empty
              @if(!($kelas && $kelasSiswa))
              <!-- Empty State -->
              <div class="text-center py-5">
                <div class="mb-4">
                  <img src="{{ asset('assets/img/illustrations/empty-state.png') }}" alt="No History" class="img-fluid" style="max-height: 200px;">
                </div>
                <h5 class="text-primary mb-2">Belum ada riwayat kelas</h5>
                <p class="text-muted mb-4">Anda belum memiliki riwayat akademik sebelumnya</p>
              </div>
              @endif
              @endforelse
            </ul>
          </div>
        </div>
        
        <!-- Previous Classes -->
        <div class="row g-3">
          @forelse($riwayatKelas as $rw)
          <div class="col-md-6 col-xl-4">
            <div class="card h-100 border-0 shadow-sm hover-shadow-lg transition-all">
              <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                  <div class="avatar avatar-sm me-2 bg-label-secondary">
                    <i class="ti ti-history text-secondary"></i>
                  </div>
                  <h6 class="mb-0">{{ $rw->kelas->nama_kelas ?? 'VI A' }}</h6>
                </div>
                <p class="card-text text-muted mb-3">
                  <i class="ti ti-calendar me-1"></i> Tahun Ajaran {{ $rw->tahunAjaran->tahun ?? '2022/2023' }}
                </p>
                <div class="d-flex justify-content-between align-items-center">
                  <span class="badge bg-label-secondary">{{ ucfirst($rw->status) ?? 'Selesai' }}</span>
                  <button class="btn btn-sm btn-outline-primary">
                    <i class="ti ti-eye me-1"></i> Detail
                  </button>
                </div>
              </div>
            </div>
          </div>
          @empty
          @if(!($kelas && $kelasSiswa))
          <!-- Empty State -->
          <div class="col-12">
            <div class="text-center py-5">
              <div class="mb-4">
                <img src="{{ asset('assets/img/illustrations/empty-state.png') }}" alt="No History" class="img-fluid" style="max-height: 200px;">
              </div>
              <h5 class="text-primary mb-2">Belum ada riwayat kelas</h5>
              <p class="text-muted mb-4">Anda belum memiliki riwayat akademik sebelumnya</p>
            </div>
          </div>
          @endif
          @endforelse
        </div>
      </div>
    </div>
  </div>
</div>
<!--/ Modern Class History Cards -->
@endsection