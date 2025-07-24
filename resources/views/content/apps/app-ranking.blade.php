@extends('layouts/layoutMaster')

@section('title', 'Ranking Siswa')

@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
  'resources/assets/vendor/libs/select2/select2.scss',
  'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'
])
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
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 1rem;
}

/* Student Pool */
.student-pool {
  background: #f8f9fa;
  border-radius: 15px;
  padding: 2rem;
  margin-bottom: 2rem;
  border: 2px dashed #dee2e6;
  min-height: 200px;
  transition: all 0.3s ease;
}

.student-pool.drag-over {
  border-color: #667eea;
  background: rgba(102, 126, 234, 0.05);
  transform: scale(1.02);
}

.student-pool h5 {
  color: #495057;
  margin-bottom: 1.5rem;
  font-weight: 600;
}

/* Ranking List */
.ranking-list {
  background: white;
  border-radius: 15px;
  padding: 2rem;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
  min-height: 600px;
}

.ranking-list h5 {
  color: #495057;
  margin-bottom: 1.5rem;
  font-weight: 600;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

/* Podium Styles */
.podium-container {
  display: flex;
  justify-content: center;
  align-items: end;
  gap: 1rem;
  margin-bottom: 2rem;
  padding: 2rem 0;
  background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
  border-radius: 15px;
  position: relative;
  overflow: hidden;
}

.podium-container::before {
  content: '';
  position: absolute;
  top: -50%;
  left: -50%;
  width: 200%;
  height: 200%;
  background: radial-gradient(circle, rgba(255,215,0,0.1) 0%, transparent 70%);
  animation: podiumShine 8s ease-in-out infinite;
}

@keyframes podiumShine {
  0%, 100% { transform: rotate(0deg); }
  50% { transform: rotate(180deg); }
}

.podium-position {
  display: flex;
  flex-direction: column;
  align-items: center;
  position: relative;
  z-index: 2;
  transition: all 0.3s ease;
}

.podium-position:hover {
  transform: translateY(-5px);
}

/* Podium Heights */
.podium-1st {
  order: 2;
}

.podium-2nd {
  order: 1;
}

.podium-3rd {
  order: 3;
}

/* Student Card on Podium */
.podium-student {
  background: white;
  border-radius: 15px;
  padding: 1rem;
  margin-bottom: 1rem;
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
  border: 2px solid transparent;
  transition: all 0.3s ease;
  min-width: 150px;
  text-align: center;
}

.podium-1st .podium-student {
  border-color: #ffd700;
  box-shadow: 0 8px 25px rgba(255, 215, 0, 0.3);
}

.podium-2nd .podium-student {
  border-color: #c0c0c0;
  box-shadow: 0 8px 25px rgba(192, 192, 192, 0.3);
}

.podium-3rd .podium-student {
  border-color: #cd7f32;
  box-shadow: 0 8px 25px rgba(205, 127, 50, 0.3);
}

/* Podium Avatar */
.podium-avatar {
  width: 80px;
  height: 80px;
  border-radius: 50%;
  object-fit: cover;
  margin-bottom: 0.75rem;
  border: 3px solid;
  transition: all 0.3s ease;
}

.podium-1st .podium-avatar {
  border-color: #ffd700;
  box-shadow: 0 0 20px rgba(255, 215, 0, 0.5);
}

.podium-2nd .podium-avatar {
  border-color: #c0c0c0;
  box-shadow: 0 0 20px rgba(192, 192, 192, 0.5);
}

.podium-3rd .podium-avatar {
  border-color: #cd7f32;
  box-shadow: 0 0 20px rgba(205, 127, 50, 0.5);
}

/* Podium Crown/Medal */
.podium-crown {
  position: absolute;
  top: -15px;
  left: 50%;
  transform: translateX(-50%);
  width: 30px;
  height: 30px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.2rem;
  font-weight: 700;
  color: white;
  z-index: 3;
}

.podium-1st .podium-crown {
  background: linear-gradient(135deg, #ffd700, #ffed4e);
  color: #b45309;
  box-shadow: 0 4px 15px rgba(255, 215, 0, 0.4);
}

.podium-2nd .podium-crown {
  background: linear-gradient(135deg, #c0c0c0, #e5e5e5);
  color: #6b7280;
  box-shadow: 0 4px 15px rgba(192, 192, 192, 0.4);
}

.podium-3rd .podium-crown {
  background: linear-gradient(135deg, #cd7f32, #d4a574);
  color: #92400e;
  box-shadow: 0 4px 15px rgba(205, 127, 50, 0.4);
}

/* Podium Base */
.podium-base {
  width: 120px;
  border-radius: 8px 8px 0 0;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  font-weight: 700;
  font-size: 1.1rem;
  position: relative;
  overflow: hidden;
}

.podium-base::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 3px;
  background: rgba(255, 255, 255, 0.3);
}

.podium-1st .podium-base {
  height: 80px;
  background: linear-gradient(135deg, #ffd700, #ffed4e);
  color: #b45309;
  box-shadow: 0 8px 20px rgba(255, 215, 0, 0.3);
}

.podium-2nd .podium-base {
  height: 60px;
  background: linear-gradient(135deg, #c0c0c0, #e5e5e5);
  color: #6b7280;
  box-shadow: 0 8px 20px rgba(192, 192, 192, 0.3);
}

.podium-3rd .podium-base {
  height: 40px;
  background: linear-gradient(135deg, #cd7f32, #d4a574);
  color: #92400e;
  box-shadow: 0 8px 20px rgba(205, 127, 50, 0.3);
}

/* Podium Student Info */
.podium-name {
  font-weight: 700;
  font-size: 0.9rem;
  color: #495057;
  margin-bottom: 0.25rem;
  line-height: 1.2;
}

.podium-score {
  background: #f8f9fa;
  padding: 0.25rem 0.75rem;
  border-radius: 15px;
  font-weight: 600;
  font-size: 0.8rem;
  color: #495057;
}

/* Regular Ranking (4th and below) */
.regular-ranking {
  margin-top: 1rem;
}

.regular-ranking h6 {
  color: #495057;
  font-weight: 600;
  margin-bottom: 1rem;
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
  cursor: grab;
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
  gap: 1rem;
  position: relative;
}

.student-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.12);
}

.student-card.dragging {
  opacity: 0.5;
  transform: rotate(5deg);
  cursor: grabbing;
  z-index: 1000;
}

.student-card.drag-placeholder {
  background: #f8f9fa;
  border: 2px dashed #667eea;
  opacity: 0.7;
}

/* Ranking Position */
.ranking-position {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
  font-size: 1.1rem;
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
  width: 50px;
  height: 50px;
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
  font-size: 1rem;
}

.student-nis {
  color: #6c757d;
  font-size: 0.875rem;
}

/* Student Score */
.student-score {
  background: #f8f9fa;
  padding: 0.5rem 1rem;
  border-radius: 20px;
  font-weight: 600;
  color: #495057;
  flex-shrink: 0;
}

/* Drop Zone */
.drop-zone {
  min-height: 80px;
  border: 2px dashed transparent;
  border-radius: 10px;
  padding: 1rem;
  margin-bottom: 0.5rem;
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #6c757d;
  font-style: italic;
}

.drop-zone.drag-over {
  border-color: #667eea;
  background: rgba(102, 126, 234, 0.05);
  color: #667eea;
}

.drop-zone.has-student {
  border: none;
  padding: 0;
  background: none;
}

/* Action Buttons */
.action-buttons {
  display: flex;
  gap: 1rem;
  justify-content: center;
  margin-top: 2rem;
}

.btn-save-ranking {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
  border: none !important;
  border-radius: 12px;
  padding: 0.75rem 2rem;
  color: white !important;
  font-weight: 600;
  transition: all 0.3s ease;
  box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
  text-decoration: none !important;
}

.btn-save-ranking:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
  color: white !important;
  background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%) !important;
}

.btn-save-ranking:focus,
.btn-save-ranking:active {
  color: white !important;
  background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%) !important;
}

.btn-reset-ranking {
  background: #6c757d !important;
  border: none !important;
  border-radius: 12px;
  padding: 0.75rem 2rem;
  color: white !important;
  font-weight: 600;
  transition: all 0.3s ease;
  text-decoration: none !important;
}

.btn-reset-ranking:hover {
  background: #5a6268 !important;
  transform: translateY(-2px);
  color: white !important;
}

.btn-reset-ranking:focus,
.btn-reset-ranking:active {
  color: white !important;
  background: #5a6268 !important;
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

/* Responsive */
@media (max-width: 768px) {
  .page-title {
    font-size: 2rem;
  }
  
  .student-card {
    padding: 0.75rem;
  }
  
  .student-avatar {
    width: 40px;
    height: 40px;
  }
  
  .ranking-position {
    width: 35px;
    height: 35px;
    font-size: 1rem;
  }
}

/* Loading Animation */
.loading-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(255, 255, 255, 0.9);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 9999;
  opacity: 0;
  visibility: hidden;
  transition: all 0.3s ease;
}

.loading-overlay.show {
  opacity: 1;
  visibility: visible;
}

.loading-spinner {
  width: 50px;
  height: 50px;
  border: 4px solid #f3f3f3;
  border-top: 4px solid #667eea;
  border-radius: 50%;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
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
  let draggedElement = null;
  let draggedFromPool = false;

  // Initialize drag and drop
  initializeDragAndDrop();

  function initializeDragAndDrop() {
    const studentCards = document.querySelectorAll('.student-card');
    const dropZones = document.querySelectorAll('.drop-zone');
    const studentPool = document.querySelector('.student-pool');
    const rankingList = document.querySelector('.ranking-list');

    // Make student cards draggable
    studentCards.forEach(card => {
      card.draggable = true;
      
      card.addEventListener('dragstart', function(e) {
        draggedElement = this;
        draggedFromPool = this.closest('.student-pool') !== null;
        this.classList.add('dragging');
        e.dataTransfer.effectAllowed = 'move';
      });

      card.addEventListener('dragend', function(e) {
        this.classList.remove('dragging');
        draggedElement = null;
        draggedFromPool = false;
      });
    });

    // Handle drop zones
    dropZones.forEach(zone => {
      zone.addEventListener('dragover', function(e) {
        e.preventDefault();
        e.dataTransfer.dropEffect = 'move';
        this.classList.add('drag-over');
      });

      zone.addEventListener('dragleave', function(e) {
        this.classList.remove('drag-over');
      });

      zone.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('drag-over');
        
        if (draggedElement && !this.classList.contains('has-student')) {
          // Move student to ranking position
          const position = this.dataset.position;
          moveStudentToRanking(draggedElement, this, position);
        }
      });
    });

    // Handle student pool drop
    studentPool.addEventListener('dragover', function(e) {
      e.preventDefault();
      e.dataTransfer.dropEffect = 'move';
      this.classList.add('drag-over');
    });

    studentPool.addEventListener('dragleave', function(e) {
      this.classList.remove('drag-over');
    });

    studentPool.addEventListener('drop', function(e) {
      e.preventDefault();
      this.classList.remove('drag-over');
      
      if (draggedElement && !draggedFromPool) {
        // Move student back to pool
        moveStudentToPool(draggedElement);
      }
    });
  }

  function moveStudentToRanking(studentCard, dropZone, position) {
    const pos = parseInt(position);
    
    if (pos <= 3) {
      // Handle podium positions (1st, 2nd, 3rd)
      const podiumStudent = dropZone.querySelector('.podium-student');
      const crown = podiumStudent.querySelector('.podium-crown');
      
      // Get student data
      const studentName = studentCard.querySelector('.student-name').textContent;
      const studentScore = studentCard.querySelector('.student-score').textContent;
      const studentAvatar = studentCard.querySelector('.student-avatar');
      
      // Create podium content
      podiumStudent.innerHTML = `
        <div class="podium-crown">${position}</div>
        <img src="${studentAvatar.src}" alt="${studentAvatar.alt}" class="podium-avatar">
        <div class="podium-name">${studentName}</div>
        <div class="podium-score">${studentScore}</div>
      `;
      
      // Hide original student card
      studentCard.style.display = 'none';
      studentCard.dataset.position = position;
      studentCard.dataset.podiumPosition = 'true';
      
    } else {
      // Handle regular positions (4th and below)
      const rankingPosition = studentCard.querySelector('.ranking-position');
      if (rankingPosition) {
        rankingPosition.textContent = position;
        rankingPosition.className = 'ranking-position ' + getRankClass(position);
      } else {
        // Create ranking position if moving from pool
        const positionEl = document.createElement('div');
        positionEl.className = 'ranking-position ' + getRankClass(position);
        positionEl.textContent = position;
        studentCard.insertBefore(positionEl, studentCard.firstChild);
      }

      // Move to drop zone
      dropZone.appendChild(studentCard);
      dropZone.classList.add('has-student');
      dropZone.innerHTML = '';
      dropZone.appendChild(studentCard);
      studentCard.style.display = 'flex';
      studentCard.dataset.position = position;
      delete studentCard.dataset.podiumPosition;
    }
    
    updateRankingData();
  }

  function moveStudentToPool(studentCard) {
    const position = studentCard.dataset.position;
    const isPodiumPosition = studentCard.dataset.podiumPosition === 'true';
    
    if (isPodiumPosition && position <= 3) {
      // Handle podium positions - restore original podium content
      const dropZone = document.querySelector(`[data-position="${position}"]`);
      const podiumStudent = dropZone.querySelector('.podium-student');
      
      podiumStudent.innerHTML = `
        <div class="podium-crown">${position}</div>
        <div style="text-align: center; color: #6c757d; font-style: italic; font-size: 0.9rem;">
          Seret siswa ke sini<br>untuk peringkat ${position}
        </div>
      `;
      
      // Show student card again and move to pool
      studentCard.style.display = 'flex';
      delete studentCard.dataset.podiumPosition;
    } else {
      // Handle regular positions
      const rankingPosition = studentCard.querySelector('.ranking-position');
      if (rankingPosition) {
        rankingPosition.remove();
      }

      // Clear the drop zone
      const dropZone = document.querySelector(`[data-position="${position}"]`);
      if (dropZone) {
        dropZone.classList.remove('has-student');
        dropZone.innerHTML = 'Seret siswa ke sini untuk posisi ' + position;
      }
    }

    // Move back to pool
    const studentPool = document.querySelector('.student-pool');
    studentPool.appendChild(studentCard);

    // Remove position data
    delete studentCard.dataset.position;
    
    updateRankingData();
  }

  function getRankClass(position) {
    const pos = parseInt(position);
    if (pos === 1) return 'rank-1';
    if (pos === 2) return 'rank-2';
    if (pos === 3) return 'rank-3';
    return 'rank-other';
  }

  function updateRankingData() {
    // Update stats
    const rankedStudents = document.querySelectorAll('.ranking-list .student-card').length;
    const totalStudents = document.querySelectorAll('.student-card').length;
    
    document.querySelector('.ranked-count').textContent = rankedStudents;
    document.querySelector('.unranked-count').textContent = totalStudents - rankedStudents;
  }

  // Save ranking
  document.getElementById('saveRanking').addEventListener('click', function() {
    const rankingData = [];
    const rankedStudents = document.querySelectorAll('.ranking-list .student-card');
    
    rankedStudents.forEach(student => {
      rankingData.push({
        kelas_siswa_id: student.dataset.kelasSiswaId,
        position: student.dataset.position,
        score: student.dataset.score || 0
      });
    });

    if (rankingData.length === 0) {
      Swal.fire({
        icon: 'warning',
        title: 'Peringatan',
        text: 'Silakan atur peringkat siswa terlebih dahulu!'
      });
      return;
    }

    // Show loading
    document.querySelector('.loading-overlay').classList.add('show');

    // Send AJAX request to save ranking
    fetch('/ranking/save', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      body: JSON.stringify({
        ranking_data: rankingData
      })
    })
    .then(response => response.json())
    .then(data => {
      document.querySelector('.loading-overlay').classList.remove('show');
      
      if (data.success) {
        Swal.fire({
          icon: 'success',
          title: 'Berhasil!',
          text: data.message,
          timer: 2000,
          showConfirmButton: false
        });
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Error!',
          text: data.message
        });
      }
    })
    .catch(error => {
      document.querySelector('.loading-overlay').classList.remove('show');
      Swal.fire({
        icon: 'error',
        title: 'Error!',
        text: 'Terjadi kesalahan saat menyimpan data'
      });
    });
  });

  // Reset ranking
  document.getElementById('resetRanking').addEventListener('click', function() {
    Swal.fire({
      title: 'Reset Peringkat?',
      text: 'Semua siswa akan dikembalikan ke daftar awal',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Ya, Reset',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        resetAllRanking();
        Swal.fire({
          icon: 'success',
          title: 'Reset Berhasil',
          text: 'Semua peringkat telah direset',
          timer: 1500,
          showConfirmButton: false
        });
      }
    });
  });

  function resetAllRanking() {
    const studentPool = document.querySelector('.student-pool');
    const rankedStudents = document.querySelectorAll('.ranking-list .student-card');
    
    rankedStudents.forEach(student => {
      const position = student.dataset.position;
      const isPodiumPosition = student.dataset.podiumPosition === 'true';
      
      if (isPodiumPosition && position <= 3) {
        // Show student card again for podium positions
        student.style.display = 'flex';
        delete student.dataset.podiumPosition;
      } else {
        // Remove ranking position for regular positions
        const rankingPosition = student.querySelector('.ranking-position');
        if (rankingPosition) {
          rankingPosition.remove();
        }
      }
      
      // Move back to pool
      studentPool.appendChild(student);
      delete student.dataset.position;
    });

    // Clear all drop zones
    document.querySelectorAll('.drop-zone').forEach(zone => {
      const position = zone.dataset.position;
      zone.classList.remove('has-student');
      
      if (position <= 3) {
        // Reset podium content
        const podiumStudent = zone.querySelector('.podium-student');
        if (podiumStudent) {
          podiumStudent.innerHTML = `
            <div class="podium-crown">${position}</div>
            <div style="text-align: center; color: #6c757d; font-style: italic; font-size: 0.9rem;">
              Seret siswa ke sini<br>untuk peringkat ${position}
            </div>
          `;
        }
      } else {
        // Reset regular drop zone
        zone.innerHTML = 'Seret siswa ke sini untuk posisi ' + position;
      }
    });

    updateRankingData();
  }

  // Initialize stats
  updateRankingData();
});
</script>
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

<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Page Header -->
<div class="page-header">
  <h1 class="page-title">Peringkat Siswa</h1>
  <p class="page-subtitle">Atur peringkat siswa untuk tahun ajaran {{ $tahunAjaranAktif->tahun ?? '2024/2025' }} - {{ $semesterAktif->nama ?? 'Semester Aktif' }}</p>
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
        <i class="ti ti-clock"></i>
      </div>
      <div class="stat-number unranked-count">{{ $siswa->count() }}</div>
      <div class="stat-label">Belum Diperingkat</div>
    </div>
    
    <div class="stat-card">
      <div class="stat-icon">
        <i class="ti ti-calendar"></i>
      </div>
      <div class="stat-number">{{ $tahunAjaranAktif->tahun ?? date('Y') }}</div>
      <div class="stat-label">Tahun Ajaran</div>
    </div>
  </div>

  <div class="row">
    <!-- Student Pool -->
    <div class="col-md-4">
      <div class="student-pool">
        <h5><i class="ti ti-users me-2"></i>Daftar Siswa</h5>
        @foreach($siswa as $s)
        <div class="student-card" data-student-id="{{ $s->id }}" data-kelas-siswa-id="{{ $s->kelas_siswa_id }}" data-score="{{ $s->rata_rata ?? 0 }}">
          @if($s->foto)
            <img src="{{ asset('storage/'.$s->foto) }}" alt="Foto {{ $s->nama }}" class="student-avatar">
          @else
            @if($s->jenis_kelamin == 'P')
              <img src="{{ asset('assets/img/avatars/2.png') }}" alt="Avatar Perempuan" class="student-avatar">
            @else
              <img src="{{ asset('assets/img/avatars/1.png') }}" alt="Avatar Laki-laki" class="student-avatar">
            @endif
          @endif
          
          <div class="student-info">
            <div class="student-name">{{ $s->nama }}</div>
            <div class="student-nis">NIS: {{ $s->nis }}</div>
            @if(isset($s->kelas_nama))
              <div class="student-class" style="font-size: 0.75rem; color: #6c757d;">{{ $s->kelas_nama }}</div>
            @endif
          </div>
          
          <div class="student-score">{{ number_format($s->rata_rata ?? 0, 1) }}</div>
        </div>
        @endforeach
      </div>
    </div>

    <!-- Ranking List -->
    <div class="col-md-8">
      <div class="ranking-list">
        <h5><i class="ti ti-trophy me-2"></i>Peringkat Siswa</h5>
        
        <!-- Podium for Top 3 -->
        <div class="podium-container">
          <!-- 2nd Place -->
          <div class="podium-position podium-2nd">
            <div class="drop-zone" data-position="2" style="border: none; padding: 0; margin: 0; min-height: auto;">
              <div class="podium-student">
                <div class="podium-crown">2</div>
                <div style="text-align: center; color: #6c757d; font-style: italic; font-size: 0.9rem;">
                  Seret siswa ke sini<br>untuk peringkat 2
                </div>
              </div>
            </div>
            <div class="podium-base">2nd</div>
          </div>
          
          <!-- 1st Place -->
          <div class="podium-position podium-1st">
            <div class="drop-zone" data-position="1" style="border: none; padding: 0; margin: 0; min-height: auto;">
              <div class="podium-student">
                <div class="podium-crown">1</div>
                <div style="text-align: center; color: #6c757d; font-style: italic; font-size: 0.9rem;">
                  Seret siswa ke sini<br>untuk peringkat 1
                </div>
              </div>
            </div>
            <div class="podium-base">1st</div>
          </div>
          
          <!-- 3rd Place -->
          <div class="podium-position podium-3rd">
            <div class="drop-zone" data-position="3" style="border: none; padding: 0; margin: 0; min-height: auto;">
              <div class="podium-student">
                <div class="podium-crown">3</div>
                <div style="text-align: center; color: #6c757d; font-style: italic; font-size: 0.9rem;">
                  Seret siswa ke sini<br>untuk peringkat 3
                </div>
              </div>
            </div>
            <div class="podium-base">3rd</div>
          </div>
        </div>
        
        <!-- Regular Rankings (4th and below) -->
        <div class="regular-ranking">
          <h6><i class="ti ti-list me-2"></i>Peringkat Lainnya</h6>
          @for($i = 4; $i <= 10; $i++)
          <div class="drop-zone" data-position="{{ $i }}">
            Seret siswa ke sini untuk posisi {{ $i }}
          </div>
          @endfor
        </div>
      </div>
    </div>
  </div>

  <!-- Action Buttons -->
  <div class="action-buttons">
    <button type="button" class="btn btn-save-ranking" id="saveRanking">
      <i class="ti ti-device-floppy me-2"></i>Simpan Peringkat
    </button>
    <button type="button" class="btn btn-reset-ranking" id="resetRanking">
      <i class="ti ti-refresh me-2"></i>Reset Peringkat
    </button>
  </div>
</div>

<!-- Loading Overlay -->
<div class="loading-overlay">
  <div class="loading-spinner"></div>
</div>
@endsection