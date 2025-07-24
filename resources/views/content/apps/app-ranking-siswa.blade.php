@extends('layouts/layoutMaster')

@section('title', 'Ranking Kelas')

@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
  'resources/assets/vendor/libs/select2/select2.scss',
  'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'
])
<style>
/* Page Header Styles */
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

/* Ranking Container */
.ranking-container {
  max-width: 1000px;
  margin: 0 auto;
  padding: 0 1rem;
}

/* Stats Cards */
.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 1.5rem;
  margin-bottom: 2rem;
}

.stat-card {
  background: white;
  border-radius: 15px;
  padding: 1.5rem;
  text-align: center;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
  transition: all 0.3s ease;
}

.stat-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
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

/* Ranking List */
.ranking-list {
  background: white;
  border-radius: 15px;
  padding: 2rem;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

.ranking-list h5 {
  color: #495057;
  margin-bottom: 1.5rem;
  font-weight: 600;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

/* Student Card */
.student-card {
  background: white;
  border-radius: 12px;
  padding: 1rem;
  margin-bottom: 0.75rem;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
  border: 1px solid #e9ecef;
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
  gap: 1rem;
  animation: fadeInUp 0.6s ease;
  animation-fill-mode: both;
}

.student-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.12);
}

.student-card:nth-child(1) { animation-delay: 0.1s; }
.student-card:nth-child(2) { animation-delay: 0.2s; }
.student-card:nth-child(3) { animation-delay: 0.3s; }
.student-card:nth-child(4) { animation-delay: 0.4s; }
.student-card:nth-child(5) { animation-delay: 0.5s; }

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

/* Ranking Position */
.ranking-position {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
  font-size: 1.2rem;
  flex-shrink: 0;
}

.ranking-position.rank-1 {
  background: linear-gradient(135deg, #ffd700, #ffed4e);
  color: #b45309;
  box-shadow: 0 4px 15px rgba(255, 215, 0, 0.3);
}

.ranking-position.rank-2 {
  background: linear-gradient(135deg, #c0c0c0, #e5e5e5);
  color: #6b7280;
  box-shadow: 0 4px 15px rgba(192, 192, 192, 0.3);
}

.ranking-position.rank-3 {
  background: linear-gradient(135deg, #cd7f32, #d4a574);
  color: #92400e;
  box-shadow: 0 4px 15px rgba(205, 127, 50, 0.3);
}

.ranking-position.rank-other {
  background: linear-gradient(135deg, #667eea, #764ba2);
  color: white;
  box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

/* Student Avatar */
.student-avatar {
  width: 60px;
  height: 60px;
  border-radius: 50%;
  object-fit: cover;
  border: 2px solid #e9ecef;
  flex-shrink: 0;
}

/* Student Info */
.student-info {
  flex-grow: 1;
}

.student-name {
  font-weight: 600;
  color: #495057;
  margin-bottom: 0.25rem;
  font-size: 1.1rem;
}

.student-nis {
  color: #6c757d;
  font-size: 0.875rem;
}

.student-class {
  color: #6c757d;
  font-size: 0.75rem;
  margin-top: 0.25rem;
}

/* Student Score */
.student-score {
  background: #f8f9fa;
  padding: 0.75rem 1.25rem;
  border-radius: 25px;
  font-weight: 700;
  color: #495057;
  flex-shrink: 0;
  font-size: 1.1rem;
}

/* Current Student Highlight */
.student-card.current-student {
  border: 2px solid #667eea;
  background: rgba(102, 126, 234, 0.05);
}

.student-card.current-student .student-name {
  color: #667eea;
}

/* Empty State */
.empty-state {
  text-align: center;
  padding: 3rem 1rem;
  animation: fadeIn 1s ease-out;
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

/* Responsive */
@media (max-width: 768px) {
  .page-title {
    font-size: 2rem;
  }
  
  .student-card {
    padding: 0.75rem;
  }
  
  .student-avatar {
    width: 50px;
    height: 50px;
  }
  
  .ranking-position {
    width: 40px;
    height: 40px;
    font-size: 1rem;
  }
}
</style>
@endsection

@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
  'resources/assets/vendor/libs/select2/select2.js',
  'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'
])
@endsection

@section('page-script')
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Load existing rankings
  loadRankings();

  function loadRankings() {
    fetch('/ranking/get')
      .then(response => response.json())
      .then(data => {
        if (data.success && data.data.length > 0) {
          displayRankings(data.data);
          updateStats(data.data.length);
        } else {
          showEmptyState();
        }
      })
      .catch(error => {
        console.error('Error loading rankings:', error);
        showEmptyState();
      });
  }

  function displayRankings(rankings) {
    const rankingList = document.querySelector('.ranking-content');
    const currentUserId = {{ Auth::user()->siswa->id ?? 'null' }};
    
    rankingList.innerHTML = '';
    
    rankings.forEach(ranking => {
      const isCurrentStudent = ranking.siswa_id === currentUserId;
      const rankClass = getRankClass(ranking.posisi);
      
      const studentCard = document.createElement('div');
      studentCard.className = `student-card ${isCurrentStudent ? 'current-student' : ''}`;
      
      studentCard.innerHTML = `
        <div class="ranking-position ${rankClass}">${ranking.posisi}</div>
        
        ${getAvatarHtml(ranking)}
        
        <div class="student-info">
          <div class="student-name">${ranking.nama}${isCurrentStudent ? ' (Anda)' : ''}</div>
          <div class="student-nis">NIS: ${ranking.nis}</div>
          <div class="student-class">${ranking.nama_kelas}</div>
        </div>
        
        <div class="student-score">${parseFloat(ranking.nilai_rata_rata).toFixed(1)}</div>
      `;
      
      rankingList.appendChild(studentCard);
    });
  }

  function getAvatarHtml(ranking) {
    if (ranking.foto) {
      return `<img src="/storage/${ranking.foto}" alt="Foto ${ranking.nama}" class="student-avatar">`;
    } else {
      const avatarFile = ranking.jenis_kelamin === 'P' ? '2.png' : '1.png';
      const altText = ranking.jenis_kelamin === 'P' ? 'Avatar Perempuan' : 'Avatar Laki-laki';
      return `<img src="/assets/img/avatars/${avatarFile}" alt="${altText}" class="student-avatar">`;
    }
  }

  function getRankClass(position) {
    const pos = parseInt(position);
    if (pos === 1) return 'rank-1';
    if (pos === 2) return 'rank-2';
    if (pos === 3) return 'rank-3';
    return 'rank-other';
  }

  function updateStats(rankedCount) {
    document.querySelector('.ranked-count').textContent = rankedCount;
  }

  function showEmptyState() {
    const rankingList = document.querySelector('.ranking-content');
    rankingList.innerHTML = `
      <div class="empty-state">
        <h3 class="empty-title">Belum Ada Peringkat</h3>
        <p class="empty-description">
          Peringkat kelas belum tersedia.<br>
          Silakan hubungi wali kelas untuk informasi lebih lanjut.
        </p>
      </div>
    `;
  }
});
</script>
@endsection

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Page Header -->
<div class="page-header">
  <h1 class="page-title">Ranking Kelas</h1>
  <p class="page-subtitle">Lihat peringkat siswa di kelas Anda untuk tahun ajaran {{ $tahunAjaranAktif->tahun ?? '2024/2025' }} - {{ $semesterAktif->nama ?? 'Semester Aktif' }}</p>
</div>

<div class="ranking-container">
  <!-- Stats Grid -->
  <div class="stats-grid">
    <div class="stat-card">
      <div class="stat-icon">
        <i class="ti ti-users"></i>
      </div>
      <div class="stat-number">{{ $siswa->count() }}</div>
      <div class="stat-label">Total Siswa</div>
    </div>
    
    <div class="stat-card">
      <div class="stat-icon">
        <i class="ti ti-trophy"></i>
      </div>
      <div class="stat-number ranked-count">0</div>
      <div class="stat-label">Sudah Diperingkat</div>
    </div>
    
    <div class="stat-card">
      <div class="stat-icon">
        <i class="ti ti-school"></i>
      </div>
      <div class="stat-number">{{ $kelasGuru->nama_kelas ?? 'N/A' }}</div>
      <div class="stat-label">Kelas Anda</div>
    </div>
    
    <div class="stat-card">
      <div class="stat-icon">
        <i class="ti ti-calendar"></i>
      </div>
      <div class="stat-number">{{ $tahunAjaranAktif->tahun ?? date('Y') }}</div>
      <div class="stat-label">Tahun Ajaran</div>
    </div>
  </div>

  <!-- Ranking List -->
  <div class="ranking-list">
    <h5><i class="ti ti-trophy me-2"></i>Peringkat Kelas</h5>
    
    <div class="ranking-content">
      <!-- Rankings will be loaded here via JavaScript -->
    </div>
  </div>
</div>
@endsection