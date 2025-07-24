@extends('layouts/layoutMaster')

@section('title', 'Riwayat Mengajar')

@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss'
])
@endsection

@section('page-style')
@vite(['resources/assets/vendor/scss/pages/page-profile.scss'])
<style>
  body {
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    min-height: 100vh;
  }
  
  .history-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem 1rem;
  }
  
  .page-header {
    text-align: center;
    margin-bottom: 3rem;
    animation: fadeInDown 1s ease-out;
  }
  
  @keyframes fadeInDown {
    from {
      opacity: 0;
      transform: translateY(-30px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
  
  .page-title {
    font-size: 2.5rem;
    font-weight: 800;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 0.5rem;
  }
  
  .page-subtitle {
    font-size: 1.1rem;
    color: #64748b;
    font-weight: 400;
  }
  
  .stats-overview {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
    margin-bottom: 3rem;
    animation: fadeInUp 1s ease-out 0.2s both;
  }
  
  .stat-card {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    text-align: center;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
  }
  
  .stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #667eea, #764ba2);
  }
  
  .stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
  }
  
  .stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea, #764ba2);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    color: white;
    font-size: 1.5rem;
  }
  
  .stat-number {
    font-size: 2rem;
    font-weight: 800;
    color: #334155;
    margin-bottom: 0.5rem;
  }
  
  .stat-label {
    color: #64748b;
    font-size: 0.9rem;
    font-weight: 500;
  }
  
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
  
  .achievement-badge {
    position: absolute;
    top: 1rem;
    right: 1rem;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, #ffd700, #ffed4e);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #b45309;
    font-size: 1.2rem;
    box-shadow: 0 4px 15px rgba(255, 215, 0, 0.3);
    animation: pulse-gold 2s infinite;
  }
  
  @keyframes pulse-gold {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.1); }
  }
  
  .experience-summary {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 3rem;
    text-align: center;
    border: 1px solid rgba(102, 126, 234, 0.2);
    animation: fadeInUp 1s ease-out 0.4s both;
  }
  
  .experience-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #334155;
    margin-bottom: 1rem;
  }
  
  .experience-text {
    color: #64748b;
    font-size: 1rem;
    line-height: 1.6;
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
  
  .timeline-section {
    position: relative;
    margin-bottom: 4rem;
    animation: fadeInUp 0.8s ease-out;
  }
  
  .section-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #334155;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
  }
  
  .section-title i {
    font-size: 1.75rem;
    color: #667eea;
  }
  
  /* New Unified Class Card Design */
  .class-card {
    border-radius: 16px;
    padding: 2rem;
    color: white;
    position: relative;
    overflow: hidden;
    margin-bottom: 1.5rem;
    width: 100%;
    height: 200px;
    box-sizing: border-box;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    transition: all 0.3s ease;
  }
  
  .class-card.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    box-shadow: 0 8px 32px rgba(102, 126, 234, 0.3);
  }
  
  .class-card.history {
    background: linear-gradient(135deg, #64748b 0%, #475569 100%);
    box-shadow: 0 8px 32px rgba(100, 116, 139, 0.3);
  }
  
  .class-card:hover {
    transform: translateY(-4px);
  }
  
  .class-card.active:hover {
    box-shadow: 0 12px 40px rgba(102, 126, 234, 0.4);
  }
  
  .class-card.history:hover {
    box-shadow: 0 12px 40px rgba(100, 116, 139, 0.4);
  }
  
  .class-card-header {
    flex-grow: 1;
  }
  
  .class-name {
    font-size: 1.8rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    line-height: 1.2;
  }
  
  .class-year {
    font-size: 1rem;
    opacity: 0.9;
    margin-bottom: 1rem;
  }
  
  .class-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: auto;
  }
  
  .class-stats {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
  }
  
  .stat-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background: rgba(255, 255, 255, 0.2);
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.85rem;
    backdrop-filter: blur(10px);
  }
  
  .stat-item i {
    font-size: 1rem;
  }
  
  .class-status {
    background: rgba(255, 255, 255, 0.2);
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    backdrop-filter: blur(10px);
  }
  
  /* Connected Journey Layout */
  .journey-container {
    position: relative;
    margin-top: 2rem;
  }
  
  /* Connection Line from Current to History */
  .journey-container::before {
    content: '';
    position: absolute;
    top: -2rem;
    left: 50%;
    transform: translateX(-50%);
    width: 2px;
    height: 2rem;
    background: linear-gradient(to bottom, #667eea, #764ba2);
    border-radius: 1px;
  }
  
  .journey-container::after {
    content: '';
    position: absolute;
    top: -8px;
    left: 50%;
    transform: translateX(-50%);
    width: 8px;
    height: 8px;
    background: #667eea;
    border-radius: 50%;
    border: 2px solid white;
    box-shadow: 0 0 0 2px #667eea;
  }
  
  .history-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.5rem;
    margin-top: 1rem;
  }
  
  .history-item {
    animation: fadeInUp 0.6s ease-out;
    animation-fill-mode: both;
  }
  
  .history-item:nth-child(1) { animation-delay: 0.1s; }
  .history-item:nth-child(2) { animation-delay: 0.2s; }
  .history-item:nth-child(3) { animation-delay: 0.3s; }
  .history-item:nth-child(4) { animation-delay: 0.4s; }
  
  @keyframes fadeInUp {
    from {
      opacity: 0;
      transform: translateY(20px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
  
  .history-card {
    background: linear-gradient(135deg, #64748b 0%, #475569 100%);
    border-radius: 20px;
    padding: 2rem;
    color: white;
    box-shadow: 0 20px 40px rgba(100, 116, 139, 0.3);
    position: relative;
    overflow: hidden;
    animation: slideInLeft 1s ease-out;
    margin-bottom: 2rem;
    min-height: 200px;
    height: auto;
    transition: all 0.3s ease;
    width: 100%;
    max-width: none;
    box-sizing: border-box;
    display: flex;
    flex-direction: column;
  }
  
  .history-card::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    animation: rotate 20s linear infinite;
  }
  
  .history-card:hover {
    transform: translateY(-5px) scale(1.02);
    box-shadow: 0 25px 50px rgba(100, 116, 139, 0.4);
  }
  
  .history-card-content {
    position: relative;
    z-index: 2;
  }
  
  .history-card-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1rem;
    flex-grow: 1;
  }
  
  .history-class-name {
    font-size: 2rem;
    font-weight: 800;
    color: white;
    margin-bottom: 0.5rem;
  }
  
  .history-year {
    font-size: 1.1rem;
    opacity: 0.9;
    margin-bottom: 1rem;
    color: white;
  }
  
  .history-status {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    padding: 0.75rem 1.25rem;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    flex-shrink: 0;
  }
  
  .history-stats {
    display: flex;
    gap: 2rem;
    flex-wrap: wrap;
    margin-top: 1rem;
  }
  
  .history-stat-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background: rgba(255, 255, 255, 0.2);
    padding: 0.75rem 1.25rem;
    border-radius: 50px;
    backdrop-filter: blur(10px);
    color: white;
  }
  
  .history-stat-item i {
    font-size: 1.2rem;
  }
  
  .history-meta {
    margin-top: auto;
    padding-top: 1rem;
    border-top: 1px solid #f1f5f9;
  }
  
  /* Removed duplicate - using the main current-class-card definition above */
  
  .empty-state {
    text-align: center;
    padding: 3rem 1rem;
    animation: fadeIn 1s ease-out;
  }
  
  @keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
  }
  
  .empty-illustration {
    width: 200px;
    height: 200px;
    margin: 0 auto 1.5rem;
    opacity: 0.7;
  }
  
  .empty-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #334155;
    margin-bottom: 0.5rem;
  }
  
  .empty-description {
    color: #64748b;
    font-size: 1rem;
    line-height: 1.6;
  }
  
  @media (max-width: 768px) {
    .page-title {
      font-size: 2rem;
    }
    
    .current-class-card {
      padding: 1.5rem;
    }
    
    .class-name {
      font-size: 1.5rem;
    }
    
    .class-stats {
      gap: 1rem;
    }
    
    .history-timeline {
      padding-left: 1.5rem;
    }
    
    .timeline-item::before {
      left: -1.5rem;
    }
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

<div class="history-container">
  <!-- Page Header -->
  <div class="page-header">
    <h1 class="page-title">Riwayat Mengajar</h1>
    <p class="page-subtitle">Perjalanan karir mengajar {{ $guru->nama ?? 'Anda' }} di sekolah ini</p>
  </div>

  <!-- Statistics Overview -->
  <div class="stats-overview">
    <div class="stat-card">
      <div class="stat-icon">
        <i class="ti ti-school"></i>
      </div>
      <div class="stat-number">{{ ($riwayatKelas->count() ?? 0) + (($kelas && $waliKelas) ? 1 : 0) }}</div>
      <div class="stat-label">Total Kelas Diampu</div>
    </div>
    
    <div class="stat-card">
      <div class="stat-icon">
        <i class="ti ti-calendar-time"></i>
      </div>
      <div class="stat-number">
        @php
          // Count distinct academic years from wali_kelas data
          $pengalaman = $riwayatKelas->pluck('tahun_ajaran_id')->unique()->count();
          
          // Add current year if teacher has active class
          if ($kelas && $waliKelas) {
            $currentYearId = $waliKelas->tahun_ajaran_id;
            if (!$riwayatKelas->pluck('tahun_ajaran_id')->contains($currentYearId)) {
              $pengalaman += 1;
            }
          }
          
          // If still 0, default to 1
          if ($pengalaman == 0) {
            $pengalaman = 1;
          }
        @endphp
        {{ $pengalaman }}
      </div>
      <div class="stat-label">Tahun Pengalaman</div>
    </div>
    
    <div class="stat-card">
      <div class="stat-icon">
        <i class="ti ti-users"></i>
      </div>
      <div class="stat-number">{{ $daftarSiswa->count() ?? 0 }}</div>
      <div class="stat-label">Siswa Aktif</div>
    </div>
    
    <div class="stat-card">
      <div class="stat-icon">
        <i class="ti ti-trophy"></i>
      </div>
      <div class="stat-number">{{ $kelas && $waliKelas ? '1' : '0' }}</div>
      <div class="stat-label">Kelas Aktif</div>
    </div>
  </div>

  <!-- Experience Summary -->
  @if($riwayatKelas && $riwayatKelas->count() > 0)
  <div class="experience-summary">
    <h3 class="experience-title">
      <i class="ti ti-medal me-2"></i>
      Pencapaian Mengajar
    </h3>
    <p class="experience-text">
      Dengan pengalaman mengajar selama {{ $pengalaman }} tahun di sekolah ini, 
      Anda telah membimbing berbagai generasi siswa melalui {{ ($riwayatKelas->count() ?? 0) + (($kelas && $waliKelas) ? 1 : 0) }} kelas yang berbeda. 
      Dedikasi Anda dalam dunia pendidikan sangat berharga untuk kemajuan sekolah.
    </p>
  </div>
  @endif

  <!-- Current Active Class -->
  @if($kelas && $waliKelas)
  <div class="timeline-section">
    <h2 class="section-title">
      <i class="ti ti-star-filled"></i>
      Kelas Aktif Saat Ini
    </h2>
    
    <div class="class-card active">
      <div class="class-card-header">
        <div class="class-name">{{ $kelas->nama_kelas ?? '-' }}</div>
        <div class="class-year">Tahun Ajaran {{ $waliKelas->tahunAjaran->tahun ?? '-' }}</div>
      </div>
      
      <div class="class-footer">
        <div class="class-stats">
          <div class="stat-item">
            <i class="ti ti-users"></i>
            <span>{{ $daftarSiswa->count() ?? 0 }} Siswa</span>
          </div>
          <div class="stat-item">
            <i class="ti ti-calendar"></i>
            <span>Semester Aktif</span>
          </div>
          <div class="stat-item">
            <i class="ti ti-award"></i>
            <span>Wali Kelas</span>
          </div>
        </div>
        <div class="class-status">Aktif</div>
      </div>
    </div>
  </div>
  @endif

  <!-- History Timeline -->
  @if($riwayatKelas && $riwayatKelas->count() > 0)
  <div class="timeline-section">
    <h2 class="section-title">
      <i class="ti ti-history"></i>
      Riwayat Kelas Sebelumnya
    </h2>
    
    <div class="history-grid">
      @foreach($riwayatKelas as $rw)
      <div class="history-item">
        <div class="class-card history">
          <div class="class-card-header">
            <div class="class-name">{{ $rw->kelas->nama_kelas ?? '-' }}</div>
            <div class="class-year">Tahun Ajaran {{ $rw->tahunAjaran->tahun ?? '-' }}</div>
          </div>
          
          <div class="class-footer">
            <div class="class-stats">
              <div class="stat-item">
                <i class="ti ti-users"></i>
                <span>{{ $rw->kelas->siswa_count ?? 0 }} Siswa</span>
              </div>
              <div class="stat-item">
                <i class="ti ti-calendar-event"></i>
                <span>{{ \Carbon\Carbon::parse($rw->created_at)->format('M Y') }}</span>
              </div>
            </div>
            <div class="class-status">{{ ucfirst($rw->status ?? 'Selesai') }}</div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
  @endif

  <!-- Empty State -->
  @if((!$kelas || !$waliKelas) && (!$riwayatKelas || $riwayatKelas->count() == 0))
  <div class="empty-state">
    <div class="empty-illustration">
      <lottie-player 
        src="{{ asset('assets/lottie/empty.json') }}" 
        background="transparent" 
        speed="1" 
        style="width: 100%; height: 100%;" 
        loop 
        autoplay>
      </lottie-player>
    </div>
    <h3 class="empty-title">Belum Ada Riwayat Mengajar</h3>
    <p class="empty-description">
      Sepertinya Anda baru bergabung dengan sekolah ini.<br>
      Semangat memulai perjalanan mengajar yang menginspirasi!
    </p>
  </div>
  @endif
</div>



<!-- Interactive Elements Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Add click effect to stat cards
  const statCards = document.querySelectorAll('.stat-card');
  statCards.forEach(card => {
    card.addEventListener('click', function() {
      this.style.transform = 'scale(0.95)';
      setTimeout(() => {
        this.style.transform = '';
      }, 150);
    });
  });

  // Add hover effect to timeline items
  const timelineItems = document.querySelectorAll('.timeline-item');
  timelineItems.forEach((item, index) => {
    item.addEventListener('mouseenter', function() {
      this.style.animationDelay = '0s';
      this.style.animation = 'none';
      this.offsetHeight; // Trigger reflow
      this.style.animation = 'fadeInUp 0.3s ease-out forwards';
    });
  });

  // Add parallax effect to floating particles
  document.addEventListener('mousemove', function(e) {
    const particles = document.querySelectorAll('.particle');
    const mouseX = e.clientX / window.innerWidth;
    const mouseY = e.clientY / window.innerHeight;
    
    particles.forEach((particle, index) => {
      const speed = (index + 1) * 0.5;
      const x = (mouseX - 0.5) * speed;
      const y = (mouseY - 0.5) * speed;
      particle.style.transform += ` translate(${x}px, ${y}px)`;
    });
  });

  // Add progress indicator for experience
  const experienceCards = document.querySelectorAll('.history-card');
  experienceCards.forEach((card, index) => {
    const progressBar = document.createElement('div');
    progressBar.style.cssText = `
      position: absolute;
      bottom: 0;
      left: 0;
      height: 3px;
      background: linear-gradient(90deg, #667eea, #764ba2);
      width: 0%;
      transition: width 1s ease-out;
      border-radius: 0 0 15px 15px;
    `;
    card.appendChild(progressBar);
    
    // Animate progress bar on scroll
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          setTimeout(() => {
            progressBar.style.width = `${Math.min(100, (index + 1) * 20)}%`;
          }, index * 200);
        }
      });
    });
    observer.observe(card);
  });

  // Add typing effect to experience text
  const experienceText = document.querySelector('.experience-text');
  if (experienceText) {
    const text = experienceText.textContent;
    experienceText.textContent = '';
    let i = 0;
    
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const typeWriter = () => {
            if (i < text.length) {
              experienceText.textContent += text.charAt(i);
              i++;
              setTimeout(typeWriter, 30);
            }
          };
          typeWriter();
          observer.unobserve(experienceText);
        }
      });
    });
    observer.observe(experienceText);
  }

  // Add counter animation to stat numbers
  const statNumbers = document.querySelectorAll('.stat-number');
  statNumbers.forEach(number => {
    const target = parseInt(number.textContent);
    number.textContent = '0';
    
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          let current = 0;
          const increment = target / 50;
          const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
              number.textContent = target;
              clearInterval(timer);
            } else {
              number.textContent = Math.floor(current);
            }
          }, 40);
          observer.unobserve(number);
        }
      });
    });
    observer.observe(number);
  });
});
</script>

<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

@endsection 