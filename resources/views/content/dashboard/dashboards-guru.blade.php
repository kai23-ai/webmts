@extends('layouts/layoutMaster')

@section('title', 'User Profile - Profile')

<!-- Vendor Styles -->
@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.scss'
])
@endsection

<!-- Page Styles -->
@section('page-style')
@vite(['resources/assets/vendor/scss/pages/page-profile.scss'])
<style>
  body {
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    min-height: 100vh;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
  }
  
  .dashboard-container {
    max-width: 900px;
    margin: 0 auto;
    padding: 2rem 1rem;
  }
  
  .lottie-wrapper {
    margin-bottom: 2rem;
    animation: fadeInScale 1s ease-out;
  }
  
  @keyframes fadeInScale {
    from {
      opacity: 0;
      transform: scale(0.8);
    }
    to {
      opacity: 1;
      transform: scale(1);
    }
  }
  
  .welcome-section {
    text-align: center;
    margin-bottom: 3rem;
    animation: fadeInUp 1s ease-out 0.3s both;
  }
  
  @keyframes fadeInUp {
    from {
      opacity: 0;
      transform: translateY(30px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
  
  .welcome-title {
    font-size: 3rem;
    font-weight: 800;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 1rem;
    line-height: 1.2;
  }
  
  .welcome-subtitle {
    font-size: 1.25rem;
    color: #64748b;
    font-weight: 400;
    max-width: 600px;
    margin: 0 auto 2rem;
    line-height: 1.6;
  }
  
  .info-badges {
    display: flex;
    justify-content: center;
    gap: 1rem;
    margin-bottom: 3rem;
    flex-wrap: wrap;
    animation: fadeInUp 1s ease-out 0.6s both;
  }
  
  .info-badge {
    background: white;
    padding: 1rem 2rem;
    border-radius: 50px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    font-weight: 600;
    color: #334155;
    transition: all 0.3s ease;
  }
  
  .info-badge:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
  }
  
  .info-badge i {
    margin-right: 0.5rem;
    color: #667eea;
  }
  
  .action-section {
    text-align: center;
    animation: fadeInUp 1s ease-out 0.9s both;
  }
  
  .btn-primary-custom {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    padding: 1.25rem 3rem;
    font-size: 1.1rem;
    font-weight: 600;
    border-radius: 50px;
    color: white;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
  }
  
  .btn-primary-custom::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s;
  }
  
  .btn-primary-custom:hover::before {
    left: 100%;
  }
  
  .btn-primary-custom:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 40px rgba(102, 126, 234, 0.4);
    color: white;
  }
  
  .btn-primary-custom i {
    font-size: 1.2rem;
  }
  
  .quick-actions {
    position: fixed;
    bottom: 2rem;
    right: 2rem;
    z-index: 1000;
  }
  
  .action-btn {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea, #764ba2);
    border: none;
    color: white;
    font-size: 1.5rem;
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
    transition: all 0.3s ease;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    position: relative;
  }
  
  .action-btn:hover {
    transform: scale(1.1);
    box-shadow: 0 12px 35px rgba(102, 126, 234, 0.4);
    color: white;
  }
  
  .action-btn::before {
    content: attr(data-tooltip);
    position: absolute;
    right: 70px;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(0, 0, 0, 0.8);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 500;
    white-space: nowrap;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
    pointer-events: none;
    backdrop-filter: blur(10px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
  }
  
  .action-btn::after {
    content: '';
    position: absolute;
    right: 60px;
    top: 50%;
    transform: translateY(-50%);
    width: 0;
    height: 0;
    border-left: 8px solid rgba(0, 0, 0, 0.8);
    border-top: 8px solid transparent;
    border-bottom: 8px solid transparent;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
  }
  
  .action-btn:hover::before,
  .action-btn:hover::after {
    opacity: 1;
    visibility: visible;
  }
  
  .action-btn:hover::before {
    transform: translateY(-50%) translateX(-5px);
  }

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

  @media (max-width: 768px) {
    .welcome-title {
      font-size: 2.5rem;
    }
    
    .welcome-subtitle {
      font-size: 1.1rem;
    }
    
    .info-badges {
      flex-direction: column;
      align-items: center;
    }
    
    .btn-primary-custom {
      padding: 1rem 2rem;
      font-size: 1rem;
    }
    
    .quick-actions {
      bottom: 1rem;
      right: 1rem;
    }
    
    .action-btn {
      width: 50px;
      height: 50px;
      font-size: 1.2rem;
    }
    
    .action-btn::before {
      right: 60px;
      font-size: 0.8rem;
      padding: 0.4rem 0.8rem;
    }
    
    .action-btn::after {
      right: 50px;
    }
  }
</style>
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
@vite(['resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js'])
{{-- @vite(['resources/assets/vendor/libs/template-customizer/template-customizer.js']) --}}
@endsection

<!-- Page Scripts -->
@section('page-script')
@vite(['resources/assets/js/pages-dashboard-guru.js'])
<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
@endsection

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

<div class="dashboard-container">
  <!-- Lottie Animation -->
  <div class="text-center lottie-wrapper">
    <lottie-player 
      src="{{ asset('assets/lottie/welcome.json') }}" 
      background="transparent" 
      speed="1" 
      style="width: 300px; height: 300px; margin: 0 auto;" 
      loop 
      autoplay>
    </lottie-player>
  </div>

  <!-- Welcome Section -->
  <div class="welcome-section">
    <h1 class="welcome-title">Selamat Datang, {{ $guru->nama ?? 'Guru' }}!</h1>
    <p class="welcome-subtitle">
      Semoga hari ini menjadi hari yang produktif dalam mendidik dan membimbing siswa-siswi tercinta. 
      Mari bersama-sama menciptakan lingkungan belajar yang inspiratif dan bermakna.
    </p>
  </div>

  <!-- Info Badges -->
  @if($kelas && $waliKelas)
  <div class="info-badges">
    <div class="info-badge">
      <i class="ti ti-school"></i>
      Wali Kelas {{ $kelas->nama_kelas }}
    </div>
    <div class="info-badge">
      <i class="ti ti-calendar"></i>
      {{ $waliKelas->tahunAjaran->tahun ?? 'Tahun Ajaran Aktif' }}
    </div>
  </div>
  @endif

  <!-- Action Button -->
  @if($kelas && $waliKelas)
    @php
      $semesterAktif = \App\Models\Semester::where('status', 'aktif')->first();
    @endphp
    @if($semesterAktif)
    <div class="action-section">
      <a href="{{ url('input-nilai') }}" class="btn-primary-custom">
        <i class="ti ti-edit"></i>
        Input Nilai Siswa
      </a>
    </div>
    @endif
  @endif
</div>
@endsection 