@extends('layouts/layoutMaster')

@section('title', 'Dashboard Siswa')

<!-- Vendor Styles -->
@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
  'resources/assets/vendor/libs/apex-charts/apex-charts.scss'
])
@endsection

<!-- Page Styles -->
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
  
  /* Progress bar styles */
  .progress-sm {
    height: 0.5rem;
  }
  
  /* Subject card styles */
  .subject-card {
    border-radius: 0.5rem;
    overflow: hidden;
    transition: all 0.3s ease;
  }
  .subject-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0,0,0,.15)!important;
  }
  .subject-icon {
    width: 45px;
    height: 45px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 0.5rem;
  }
  
  /* Modal Rapor Styles */
  .rapor-header {
    text-align: center;
    border-bottom: 2px solid #000;
    padding-bottom: 15px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }
  .rapor-logo {
    width: 80px;
    height: 80px;
  }
  .rapor-header-content {
    flex: 1;
    padding: 0 20px;
  }
  .rapor-title {
    font-size: 16px;
    font-weight: bold;
    margin: 5px 0;
  }
  .rapor-subtitle {
    font-size: 14px;
    margin: 2px 0;
  }
  .rapor-info-table {
    width: 100%;
    margin-bottom: 20px;
    border-bottom: 2px solid #000;
    padding-bottom: 15px;
  }
  .rapor-info-table td {
    padding: 3px 8px;
    font-size: 13px;
    vertical-align: top;
  }
  .rapor-grades-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 12px;
  }
  .rapor-grades-table th,
  .rapor-grades-table td {
    border: 1px solid #000;
    padding: 8px 5px;
    text-align: center;
    vertical-align: middle;
  }
  .rapor-grades-table th {
    background-color: #f8f9fa;
    font-weight: bold;
  }
  .rapor-grades-table .text-left {
    text-align: left !important;
  }
  .rapor-grades-table .subject-name {
    text-align: left;
    padding-left: 10px;
  }
  .rapor-footer {
    margin-top: 30px;
    text-align: right;
    font-size: 12px;
  }
  .modal-rapor .modal-dialog {
    max-width: 800px;
  }
  .modal-rapor .modal-body {
    padding: 30px;
  }
</style>
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
  'resources/assets/vendor/libs/apex-charts/apexcharts.js'
])
@endsection

<!-- Page Scripts -->
@section('page-script')
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Initialize charts
  if (document.getElementById('scoreChart')) {
    const scoreOptions = {
      series: [{
        name: 'Nilai',
        data: [
          @foreach($nilaiSiswa as $nilai)
            {{ $nilai->nilai_akhir ?? 0 }},
          @endforeach
        ]
      }],
      chart: {
        height: 350,
        type: 'radar',
        toolbar: {
          show: false
        }
      },
      colors: ['#696cff'],
      xaxis: {
        categories: [
          @foreach($nilaiSiswa as $nilai)
            '{{ $nilai->mapel->nama_mapel ?? "Mapel" }}',
          @endforeach
        ]
      },
      yaxis: {
        min: 0,
        max: 100
      },
      markers: {
        size: 5
      },
      fill: {
        opacity: 0.2
      }
    };
    
    const scoreChart = new ApexCharts(document.getElementById('scoreChart'), scoreOptions);
    scoreChart.render();
  }
});
</script>
@endsection

@section('content')
<!-- Header -->
<div class="row">
  <div class="col-12">
    <div class="card mb-4">
      <div class="user-profile-header-banner">
        <img src="{{ asset('assets/img/pages/profile-banner.png') }}" alt="Banner image" class="rounded-top">
      </div>
      <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
        <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
          @php
            $avatar = '1.png'; // default laki-laki
            if (isset($siswa->jenis_kelamin)) {
              $jk = strtoupper(trim($siswa->jenis_kelamin));
              if ($jk === 'P') {
                $avatar = '2.png'; // avatar perempuan
              }
            }
          @endphp
          <img src="{{ asset('assets/img/avatars/' . $avatar) }}" alt="user image" class="d-block h-auto ms-0 ms-sm-4 rounded user-profile-img">
        </div>
        <div class="flex-grow-1 mt-3 mt-sm-5">
          <div class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
            <div class="user-profile-info">
              <h4>{{ $siswa->nama ?? '-' }}</h4>
              <ul class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                <li class="list-inline-item d-flex gap-1">
                  <i class='ti ti-id'></i> No. Induk: {{ $siswa->no_induk ?? '-' }}
                </li>
                <li class="list-inline-item d-flex gap-1">
                  <i class='ti ti-map-pin'></i> {{ $siswa->alamat ?? '-' }}
                </li>
                <li class="list-inline-item d-flex gap-1">
                  <i class='ti ti-check'></i> Status: {{ $siswa->status ?? '-' }}
                </li>
              </ul>
            </div>
            <a href="{{ url('profile-account') }}" class="btn btn-primary">
              <i class='ti ti-user me-1'></i>Profil Saya
            </a>
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
      <li class="nav-item"><a class="nav-link active" href="{{ url('dashboard/siswa') }}"><i class='ti-xs ti ti-user-check me-1'></i> Profil</a></li>
      <li class="nav-item"><a class="nav-link" href="{{ url('history-siswa') }}"><i class='ti-xs ti ti-history me-1'></i> History</a></li>
    </ul>
  </div>
</div>
<!--/ Navbar pills -->

<!-- User Profile Content -->
<div class="row">
  <!-- Left Column - Class Information -->
  <div class="col-xl-4 col-lg-5 col-md-5">
    <!-- Class Information Card -->
    <div class="card mb-4">
      <div class="card-body">
        <h5 class="card-title">Informasi Kelas</h5>
        
        <div class="d-flex align-items-center mt-4 mb-3">
          <div class="bg-label-primary rounded p-3 me-3">
            <i class="ti ti-school text-primary fs-3"></i>
          </div>
          <div>
            <h5 class="mb-1">{{ $siswa->kelasAktif->kelas->nama_kelas ?? 'VII B' }}</h5>
            <div class="text-muted">Tahun Ajaran {{ $siswa->kelasAktif->tahunAjaran->tahun ?? '2023/2024' }}</div>
          </div>
        </div>
        
        <hr>
        
        <!-- Wali Kelas Information -->
        <h5 class="mt-4 mb-3">Wali Kelas</h5>
        <div class="d-flex align-items-center">
          <div class="me-3">
            @php
              $waliAvatar = '1.png'; // default laki-laki
              if (isset($siswa->kelasAktif->kelas->waliKelasAktif->guru->jenis_kelamin)) {
                $waliJk = strtoupper(trim($siswa->kelasAktif->kelas->waliKelasAktif->guru->jenis_kelamin));
                if ($waliJk === 'P') {
                  $waliAvatar = '2.png'; // avatar perempuan
                }
              }
            @endphp
            <img src="{{ asset('assets/img/avatars/' . $waliAvatar) }}" alt="Wali Kelas" class="rounded-circle" width="60" height="60">
          </div>
          <div>
            <h5 class="mb-1">{{ $siswa->kelasAktif->kelas->waliKelasAktif->guru->nama ?? 'Siti Aminah' }}</h5>
            <div class="text-muted">NIP: {{ $siswa->kelasAktif->kelas->waliKelasAktif->guru->nip ?? '0987654321' }}</div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Right Column - Student Information and Grades -->
  <div class="col-xl-8 col-lg-7 col-md-7">
    <div class="row">
      <!-- Student Information Card -->
      <div class="col-md-6">
        <div class="card mb-4">
          <div class="card-body">
            <h5 class="card-title mb-3">Informasi Siswa</h5>
            <ul class="list-unstyled mb-0">
              <li class="d-flex align-items-center mb-3">
                <i class="ti ti-user text-primary me-2"></i>
                <span class="fw-medium me-2">Nama:</span>
                <span>{{ $siswa->nama ?? '-' }}</span>
              </li>
              <li class="d-flex align-items-center mb-3">
                <i class="ti ti-id text-primary me-2"></i>
                <span class="fw-medium me-2">NIS:</span>
                <span>{{ $siswa->nis ?? '-' }}</span>
              </li>
              <li class="d-flex align-items-center mb-3">
                <i class="ti ti-number text-primary me-2"></i>
                <span class="fw-medium me-2">NISN:</span>
                <span>{{ $siswa->nisn ?? '-' }}</span>
              </li>
              <li class="d-flex align-items-center mb-3">
                <i class="ti ti-school text-primary me-2"></i>
                <span class="fw-medium me-2">Kelas:</span>
                <span>{{ $siswa->kelasAktif->kelas->nama_kelas ?? '-' }}</span>
              </li>
              <li class="d-flex align-items-center mb-3">
                <i class="ti ti-calendar text-primary me-2"></i>
                <span class="fw-medium me-2">Tanggal Lahir:</span>
                <span>{{ $siswa->tanggal_lahir ?? '-' }}</span>
              </li>
              <li class="d-flex align-items-center mb-3">
                <i class="ti ti-map-pin text-primary me-2"></i>
                <span class="fw-medium me-2">Alamat:</span>
                <span>{{ $siswa->alamat ?? '-' }}</span>
              </li>
              <li class="d-flex align-items-center mb-3">
                <i class="ti ti-phone text-primary me-2"></i>
                <span class="fw-medium me-2">Telepon:</span>
                <span>{{ $siswa->telepon ?? '-' }}</span>
              </li>
              <li class="d-flex align-items-center">
                <i class="ti ti-mail text-primary me-2"></i>
                <span class="fw-medium me-2">Email:</span>
                <span>{{ Auth::user()->email ?? '-' }}</span>
              </li>
            </ul>
          </div>
        </div>
      </div>
      
      <!-- Student Grades Card -->
      <div class="col-md-6">
        <div class="card mb-4">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Nilai Tahun Ajaran Ini</h5>
            <div class="dropdown">
              <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="semesterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                Semester Aktif
              </button>
              <ul class="dropdown-menu" aria-labelledby="semesterDropdown">
                <li><a class="dropdown-item" href="javascript:void(0);">Semester Aktif</a></li>
                <li><a class="dropdown-item" href="javascript:void(0);">Semester 1</a></li>
                <li><a class="dropdown-item" href="javascript:void(0);">Semester 2</a></li>
              </ul>
            </div>
          </div>
          <div class="card-body">
            @if($nilaiSiswa && $nilaiSiswa->count() > 0)
              <div class="table-responsive">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>Mata Pelajaran</th>
                      <th>Nilai</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($nilaiSiswa as $nilai)
                    <tr>
                      <td>{{ $nilai->mapel->nama_mapel ?? 'Mata Pelajaran' }}</td>
                      <td class="fw-bold">{{ $nilai->nilai_akhir ?? '0' }}</td>
                      <td>
                        @php
                          $nilaiAngka = $nilai->nilai_akhir ?? 0;
                          if ($nilaiAngka >= 90) {
                            $badge = 'success';
                            $status = 'Sangat Baik';
                          } elseif ($nilaiAngka >= 80) {
                            $badge = 'primary';
                            $status = 'Baik';
                          } elseif ($nilaiAngka >= 70) {
                            $badge = 'info';
                            $status = 'Cukup';
                          } elseif ($nilaiAngka >= 60) {
                            $badge = 'warning';
                            $status = 'Kurang';
                          } else {
                            $badge = 'danger';
                            $status = 'Sangat Kurang';
                          }
                        @endphp
                        <span class="badge bg-label-{{ $badge }}">{{ $status }}</span>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <div class="text-center mt-3">
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#nilaiModal">
                  <i class="ti ti-eye me-1"></i> Lihat Nilai
                </button>
              </div>
            @else
              <div class="text-center py-5">
                <div class="avatar avatar-lg bg-label-primary mb-3 mx-auto">
                  <i class="ti ti-report fs-1"></i>
                </div>
                <h6>Belum Ada Nilai</h6>
                <p class="text-muted mb-0">Nilai belum diinput oleh guru mata pelajaran</p>
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--/ User Profile Content -->

<!-- Modal Rapor Nilai -->
<div class="modal fade modal-rapor" id="nilaiModal" tabindex="-1" aria-labelledby="nilaiModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="nilaiModalLabel">Capaian Hasil Belajar</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Header Rapor -->
        <div class="rapor-header">
          <img src="{{ asset('assets/img/logo/logo-kemenag.png') }}" alt="Logo Kemenag" class="rapor-logo">
          <div class="rapor-header-content">
            <div class="rapor-title">KEMENTERIAN AGAMA REPUBLIK INDONESIA</div>
            <div class="rapor-title">MTsN 2 SUMENEP</div>
            <div class="rapor-subtitle">Jl. KH. ABDUL SALIM II No.354 PANGARANGAN</div>
            <div class="rapor-subtitle">Kecamatan Sumenep, Kabupaten Sumenep - Jawa Timur</div>
          </div>
          <img src="{{ asset('assets/img/logo/logo-madrasah.png') }}" alt="Logo Madrasah" class="rapor-logo">
        </div>

        <!-- Informasi Siswa -->
        <table class="rapor-info-table">
          <tr>
            <td width="15%"><strong>NAMA</strong></td>
            <td width="2%">:</td>
            <td width="33%">{{ strtoupper($siswa->nama ?? 'MUHAMMAD IZZAM BAYU RAHMAN') }}</td>
            <td width="15%"><strong>Kelas</strong></td>
            <td width="2%">:</td>
            <td width="33%">{{ $siswa->kelasAktif->kelas->nama_kelas ?? 'VII H' }}</td>
          </tr>
          <tr>
            <td><strong>NIS/NISN</strong></td>
            <td>:</td>
            <td>{{ $siswa->nis ?? '121135900012201196' }} / {{ $siswa->nisn ?? '0001658363' }}</td>
            <td><strong>Fase</strong></td>
            <td>:</td>
            <td>D</td>
          </tr>
          <tr>
            <td><strong>Madrasah</strong></td>
            <td>:</td>
            <td>MTsN 2 SUMENEP</td>
            <td><strong>Semester</strong></td>
            <td>:</td>
            <td>@php
              $semesterAktif = \App\Models\Semester::where('status', 'aktif')->first();
            @endphp
            {{ $semesterAktif->nama ?? 'Ganjil' }}</td>
          </tr>
          <tr>
            <td><strong>Alamat</strong></td>
            <td>:</td>
            <td>{{ $siswa->alamat ?? 'JL. KH. AGUSSALIM II No.354 PANGARANGAN' }}</td>
            <td><strong>Tahun Pelajaran</strong></td>
            <td>:</td>
            <td>{{ $siswa->kelasAktif->tahunAjaran->tahun ?? '2023/2024' }}</td>
          </tr>
        </table>

        <!-- Judul Tabel Nilai -->
        <div class="text-center mb-3">
          <h6><strong>CAPAIAN HASIL BELAJAR</strong></h6>
        </div>

        <!-- Tabel Nilai -->
        <table class="rapor-grades-table">
          <thead>
            <tr>
              <th width="5%">No</th>
              <th width="35%">Mata Pelajaran</th>
              <th width="15%">Nilai Akhir</th>
              <th width="45%">Capaian Kompetensi</th>
            </tr>
          </thead>
          <tbody>
            @php
              // Ambil semua mata pelajaran yang diurutkan
              $allMapel = \App\Models\MataPelajaran::orderBy('urutan')->get();
              
              // Ambil semester aktif
              $semesterAktif = \App\Models\Semester::where('status', 'aktif')->first();
              
              // Ambil nilai siswa untuk semester aktif
              $nilaiSiswaRapor = collect();
              
              // Coba beberapa cara untuk mendapatkan nilai
              if ($siswa->kelasAktif && $semesterAktif) {
                // Cara 1: Berdasarkan kelas_siswa_id
                $nilaiSiswaRapor = \App\Models\Nilai::where('kelas_siswa_id', $siswa->kelasAktif->id)
                                                   ->where('semester_id', $semesterAktif->id)
                                                   ->with('mapel')
                                                   ->get();
              }
              
              // Jika tidak ada nilai dengan cara 1, coba cara lain
              if ($nilaiSiswaRapor->isEmpty() && $semesterAktif) {
                // Cara 2: Langsung berdasarkan siswa_id jika ada field tersebut
                $nilaiSiswaRapor = \App\Models\Nilai::where('siswa_id', $siswa->id)
                                                   ->where('semester_id', $semesterAktif->id)
                                                   ->with('mapel')
                                                   ->get();
              }
              
              // Jika masih kosong, ambil semua nilai siswa untuk debugging
              if ($nilaiSiswaRapor->isEmpty()) {
                // Cara 3: Ambil dari tabel nilai berdasarkan relasi yang ada
                $nilaiSiswaRapor = \App\Models\Nilai::whereHas('kelasSiswa', function($query) use ($siswa) {
                                                       $query->where('siswa_id', $siswa->id);
                                                   })
                                                   ->where('semester_id', $semesterAktif->id ?? 1)
                                                   ->with(['mapel', 'kelasSiswa'])
                                                   ->get();
              }
              
              // Convert ke collection dengan key mapel_id untuk akses cepat
              $nilaiByMapel = $nilaiSiswaRapor->keyBy('mapel_id');
              
              $totalGrade = 0;
              $countGrade = 0;
              
              // Helper function untuk mendapatkan nilai - diperbaiki
              function getNilai($allMapel, $nilaiByMapel, $namaMapel) {
                // Cari mata pelajaran berdasarkan nama (case insensitive dan flexible)
                $mapelData = $allMapel->first(function($mapel) use ($namaMapel) {
                  return strtolower(trim($mapel->nama_mapel)) === strtolower(trim($namaMapel)) ||
                         str_contains(strtolower($mapel->nama_mapel), strtolower($namaMapel)) ||
                         str_contains(strtolower($namaMapel), strtolower($mapel->nama_mapel));
                });
                
                if (!$mapelData) {
                  // Jika tidak ditemukan, coba cari dengan nama yang mirip
                  $mapelData = $allMapel->first(function($mapel) use ($namaMapel) {
                    $cleanMapel = str_replace(['\'', '"', '-', ' '], '', strtolower($mapel->nama_mapel));
                    $cleanNama = str_replace(['\'', '"', '-', ' '], '', strtolower($namaMapel));
                    return $cleanMapel === $cleanNama;
                  });
                }
                
                if (!$mapelData) return [null, null];
                
                $nilai = $nilaiByMapel->get($mapelData->id);
                $nilaiAkhir = $nilai ? $nilai->nilai_akhir : null;
                $capaianKompetensi = $nilai ? $nilai->capaian_kompetensi : null;
                
                return [$nilaiAkhir, $capaianKompetensi];
              }
            @endphp
            
            <!-- 1. Pendidikan Agama Islam (Header dengan rowspan) -->
            <tr>
              <td rowspan="5" class="text-center" style="vertical-align: top; background-color: #f8f9fa;"><strong>1</strong></td>
              <td class="subject-name" style="background-color: #f8f9fa;"><strong>Pendidikan Agama Islam</strong></td>
              <td style="background-color: #f8f9fa;"></td>
              <td style="background-color: #f8f9fa;"></td>
            </tr>
            
            <!-- A. Al Qur'an Hadits -->
            @php
              list($nilaiAkhir, $capaianKompetensi) = getNilai($allMapel, $nilaiByMapel, 'Al Qur\'an Hadits');
              if ($nilaiAkhir) { $totalGrade += $nilaiAkhir; $countGrade++; }
            @endphp
            <tr>
              <td class="subject-name" style="padding-left: 20px;">A. Al Qur'an Hadits</td>
              <td class="text-center"><strong>{{ $nilaiAkhir ?? '-' }}</strong></td>
              <td class="text-left" style="font-size: 11px; padding: 5px;">{{ $capaianKompetensi ?? '-' }}</td>
            </tr>
            
            <!-- B. Akidah Akhlak -->
            @php
              list($nilaiAkhir, $capaianKompetensi) = getNilai($allMapel, $nilaiByMapel, 'Akidah Akhlak');
              if ($nilaiAkhir) { $totalGrade += $nilaiAkhir; $countGrade++; }
            @endphp
            <tr>
              <td class="subject-name" style="padding-left: 20px;">B. Akidah Akhlak</td>
              <td class="text-center"><strong>{{ $nilaiAkhir ?? '-' }}</strong></td>
              <td class="text-left" style="font-size: 11px; padding: 5px;">{{ $capaianKompetensi ?? '-' }}</td>
            </tr>
            
            <!-- C. Fiqih -->
            @php
              list($nilaiAkhir, $capaianKompetensi) = getNilai($allMapel, $nilaiByMapel, 'Fiqih');
              if ($nilaiAkhir) { $totalGrade += $nilaiAkhir; $countGrade++; }
            @endphp
            <tr>
              <td class="subject-name" style="padding-left: 20px;">C. Fiqih</td>
              <td class="text-center"><strong>{{ $nilaiAkhir ?? '-' }}</strong></td>
              <td class="text-left" style="font-size: 11px; padding: 5px;">{{ $capaianKompetensi ?? '-' }}</td>
            </tr>
            
            <!-- D. Sejarah Kebudayaan Islam -->
            @php
              list($nilaiAkhir, $capaianKompetensi) = getNilai($allMapel, $nilaiByMapel, 'Sejarah Kebudayaan Islam');
              if ($nilaiAkhir) { $totalGrade += $nilaiAkhir; $countGrade++; }
            @endphp
            <tr>
              <td class="subject-name" style="padding-left: 20px;">D. Sejarah Kebudayaan Islam</td>
              <td class="text-center"><strong>{{ $nilaiAkhir ?? '-' }}</strong></td>
              <td class="text-left" style="font-size: 11px; padding: 5px;">{{ $capaianKompetensi ?? '-' }}</td>
            </tr>
            
            <!-- 2. Bahasa Arab -->
            @php
              list($nilaiAkhir, $capaianKompetensi) = getNilai($allMapel, $nilaiByMapel, 'Bahasa Arab');
              if ($nilaiAkhir) { $totalGrade += $nilaiAkhir; $countGrade++; }
            @endphp
            <tr>
              <td class="text-center"><strong>2</strong></td>
              <td class="subject-name">Bahasa Arab</td>
              <td class="text-center"><strong>{{ $nilaiAkhir ?? '-' }}</strong></td>
              <td class="text-left" style="font-size: 11px; padding: 5px;">{{ $capaianKompetensi ?? '-' }}</td>
            </tr>
            
            <!-- 3. Pendidikan Pancasila -->
            @php
              list($nilaiAkhir, $capaianKompetensi) = getNilai($allMapel, $nilaiByMapel, 'Pendidikan Pancasila');
              if ($nilaiAkhir) { $totalGrade += $nilaiAkhir; $countGrade++; }
            @endphp
            <tr>
              <td class="text-center"><strong>3</strong></td>
              <td class="subject-name">Pendidikan Pancasila</td>
              <td class="text-center"><strong>{{ $nilaiAkhir ?? '-' }}</strong></td>
              <td class="text-left" style="font-size: 11px; padding: 5px;">{{ $capaianKompetensi ?? '-' }}</td>
            </tr>
            
            <!-- 4. Bahasa Indonesia -->
            @php
              list($nilaiAkhir, $capaianKompetensi) = getNilai($allMapel, $nilaiByMapel, 'Bahasa Indonesia');
              if ($nilaiAkhir) { $totalGrade += $nilaiAkhir; $countGrade++; }
            @endphp
            <tr>
              <td class="text-center"><strong>4</strong></td>
              <td class="subject-name">Bahasa Indonesia</td>
              <td class="text-center"><strong>{{ $nilaiAkhir ?? '-' }}</strong></td>
              <td class="text-left" style="font-size: 11px; padding: 5px;">{{ $capaianKompetensi ?? '-' }}</td>
            </tr>
            
            <!-- 5. Matematika -->
            @php
              list($nilaiAkhir, $capaianKompetensi) = getNilai($allMapel, $nilaiByMapel, 'Matematika');
              if ($nilaiAkhir) { $totalGrade += $nilaiAkhir; $countGrade++; }
            @endphp
            <tr>
              <td class="text-center"><strong>5</strong></td>
              <td class="subject-name">Matematika</td>
              <td class="text-center"><strong>{{ $nilaiAkhir ?? '-' }}</strong></td>
              <td class="text-left" style="font-size: 11px; padding: 5px;">{{ $capaianKompetensi ?? '-' }}</td>
            </tr>
            
            <!-- 6. Ilmu Pengetahuan Alam -->
            @php
              list($nilaiAkhir, $capaianKompetensi) = getNilai($allMapel, $nilaiByMapel, 'Ilmu Pengetahuan Alam');
              if ($nilaiAkhir) { $totalGrade += $nilaiAkhir; $countGrade++; }
            @endphp
            <tr>
              <td class="text-center"><strong>6</strong></td>
              <td class="subject-name">Ilmu Pengetahuan Alam</td>
              <td class="text-center"><strong>{{ $nilaiAkhir ?? '-' }}</strong></td>
              <td class="text-left" style="font-size: 11px; padding: 5px;">{{ $capaianKompetensi ?? '-' }}</td>
            </tr>
            
            <!-- 7. Ilmu Pengetahuan Sosial -->
            @php
              list($nilaiAkhir, $capaianKompetensi) = getNilai($allMapel, $nilaiByMapel, 'Ilmu Pengetahuan Sosial');
              if ($nilaiAkhir) { $totalGrade += $nilaiAkhir; $countGrade++; }
            @endphp
            <tr>
              <td class="text-center"><strong>7</strong></td>
              <td class="subject-name">Ilmu Pengetahuan Sosial</td>
              <td class="text-center"><strong>{{ $nilaiAkhir ?? '-' }}</strong></td>
              <td class="text-left" style="font-size: 11px; padding: 5px;">{{ $capaianKompetensi ?? '-' }}</td>
            </tr>
            
            <!-- 8. Bahasa Inggris -->
            @php
              list($nilaiAkhir, $capaianKompetensi) = getNilai($allMapel, $nilaiByMapel, 'Bahasa Inggris');
              if ($nilaiAkhir) { $totalGrade += $nilaiAkhir; $countGrade++; }
            @endphp
            <tr>
              <td class="text-center"><strong>8</strong></td>
              <td class="subject-name">Bahasa Inggris</td>
              <td class="text-center"><strong>{{ $nilaiAkhir ?? '-' }}</strong></td>
              <td class="text-left" style="font-size: 11px; padding: 5px;">{{ $capaianKompetensi ?? '-' }}</td>
            </tr>
            
            <!-- 9. Pendidikan Jasmani, Olahraga dan Kesehatan -->
            @php
              list($nilaiAkhir, $capaianKompetensi) = getNilai($allMapel, $nilaiByMapel, 'Pendidikan Jasmani, Olahraga dan Kesehatan');
              if ($nilaiAkhir) { $totalGrade += $nilaiAkhir; $countGrade++; }
            @endphp
            <tr>
              <td class="text-center"><strong>9</strong></td>
              <td class="subject-name">Pendidikan Jasmani, Olahraga dan Kesehatan</td>
              <td class="text-center"><strong>{{ $nilaiAkhir ?? '-' }}</strong></td>
              <td class="text-left" style="font-size: 11px; padding: 5px;">{{ $capaianKompetensi ?? '-' }}</td>
            </tr>
            
            <!-- 10. Informatika -->
            @php
              list($nilaiAkhir, $capaianKompetensi) = getNilai($allMapel, $nilaiByMapel, 'Informatika');
              if ($nilaiAkhir) { $totalGrade += $nilaiAkhir; $countGrade++; }
            @endphp
            <tr>
              <td class="text-center"><strong>10</strong></td>
              <td class="subject-name">Informatika</td>
              <td class="text-center"><strong>{{ $nilaiAkhir ?? '-' }}</strong></td>
              <td class="text-left" style="font-size: 11px; padding: 5px;">{{ $capaianKompetensi ?? '-' }}</td>
            </tr>
            
            <!-- 11. Seni Budaya / Prakarya -->
            @php
              list($nilaiAkhir, $capaianKompetensi) = getNilai($allMapel, $nilaiByMapel, 'Seni Budaya / Prakarya');
              if ($nilaiAkhir) { $totalGrade += $nilaiAkhir; $countGrade++; }
            @endphp
            <tr>
              <td class="text-center"><strong>11</strong></td>
              <td class="subject-name">Seni Budaya / Prakarya</td>
              <td class="text-center"><strong>{{ $nilaiAkhir ?? '-' }}</strong></td>
              <td class="text-left" style="font-size: 11px; padding: 5px;">{{ $capaianKompetensi ?? '-' }}</td>
            </tr>
            
            <!-- 12. Muatan Lokal (Header dengan rowspan) -->
            <tr>
              <td rowspan="3" class="text-center" style="vertical-align: top; background-color: #f8f9fa;"><strong>12</strong></td>
              <td class="subject-name" style="background-color: #f8f9fa;"><strong>Muatan Lokal</strong></td>
              <td style="background-color: #f8f9fa;"></td>
              <td style="background-color: #f8f9fa;"></td>
            </tr>
            
            <!-- A. Baca Tulis dan Tahfidz Al Qur'an -->
            @php
              list($nilaiAkhir, $capaianKompetensi) = getNilai($allMapel, $nilaiByMapel, 'Baca Tulis dan Tahfidz Al Qur\'an');
              if ($nilaiAkhir) { $totalGrade += $nilaiAkhir; $countGrade++; }
            @endphp
            <tr>
              <td class="subject-name" style="padding-left: 20px;">A. Baca Tulis dan Tahfidz Al Qur'an</td>
              <td class="text-center"><strong>{{ $nilaiAkhir ?? '-' }}</strong></td>
              <td class="text-left" style="font-size: 11px; padding: 5px;">{{ $capaianKompetensi ?? '-' }}</td>
            </tr>
            
            <!-- B. Bahasa Madura -->
            @php
              list($nilaiAkhir, $capaianKompetensi) = getNilai($allMapel, $nilaiByMapel, 'Bahasa Madura');
              if ($nilaiAkhir) { $totalGrade += $nilaiAkhir; $countGrade++; }
            @endphp
            <tr>
              <td class="subject-name" style="padding-left: 20px;">B. Bahasa Madura</td>
              <td class="text-center"><strong>{{ $nilaiAkhir ?? '-' }}</strong></td>
              <td class="text-left" style="font-size: 11px; padding: 5px;">{{ $capaianKompetensi ?? '-' }}</td>
            </tr>
            
            <!-- Baris Jumlah -->
            <tr style="background-color: #f8f9fa;">
              <td colspan="2" class="text-center"><strong>Jumlah</strong></td>
              <td class="text-center"><strong>{{ $totalGrade > 0 ? $totalGrade : '-' }}</strong></td>
              <td></td>
            </tr>
          </tbody>
        </table>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        <button type="button" class="btn btn-primary" onclick="window.print()">
          <i class="ti ti-printer me-1"></i> Cetak
        </button>
      </div>
    </div>
  </div>
</div>
<!--/ Modal Rapor Nilai -->

@endsection
