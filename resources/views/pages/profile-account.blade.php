@extends('layouts/layoutMaster')

@section('title', 'Profil Akun')

@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/select2/select2.scss',
  'resources/assets/vendor/libs/@form-validation/form-validation.scss',
  'resources/assets/vendor/libs/animate-css/animate.scss',
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
/* Clean Profile Styles */
.profile-nav {
  background: #f8f9fa;
  border-radius: 10px;
  padding: 0.5rem;
  margin-bottom: 1.5rem;
}

.profile-nav .nav-link {
  border-radius: 8px;
  transition: all 0.2s ease;
  color: #6c757d;
  font-weight: 500;
}

.profile-nav .nav-link.active {
  background: #696cff;
  color: white;
}

.profile-nav .nav-link:hover:not(.active) {
  background: #e9ecef;
  color: #495057;
}

.profile-card {
  border-radius: 12px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
  border: none;
  overflow: hidden;
}

.profile-header {
  background: linear-gradient(135deg, #696cff 0%, #5a67d8 100%);
  color: white;
  padding: 3rem 2rem;
  text-align: center;
  position: relative;
  overflow: hidden;
}

.profile-header::before {
  content: '';
  position: absolute;
  top: -50%;
  right: -50%;
  width: 200%;
  height: 200%;
  background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 50%);
  animation: float 6s ease-in-out infinite;
}

.profile-header::after {
  content: '';
  position: absolute;
  bottom: -30%;
  left: -30%;
  width: 150%;
  height: 150%;
  background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 60%);
  animation: float 8s ease-in-out infinite reverse;
}

@keyframes float {
  0%, 100% { transform: translateY(0px) rotate(0deg); }
  50% { transform: translateY(-20px) rotate(180deg); }
}

.avatar-wrapper {
  position: relative;
  display: inline-block;
  margin-bottom: 1.5rem;
  z-index: 2;
}

.profile-avatar {
  width: 120px;
  height: 120px;
  border-radius: 50%;
  border: 4px solid rgba(255, 255, 255, 0.3);
  transition: all 0.3s ease;
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
}

.profile-avatar:hover {
  transform: scale(1.05);
  border-color: rgba(255, 255, 255, 0.6);
  box-shadow: 0 12px 40px rgba(0, 0, 0, 0.3);
}

.avatar-edit {
  position: absolute;
  bottom: 5px;
  right: 5px;
  background: #fff;
  color: #696cff;
  border: 3px solid #696cff;
  border-radius: 50%;
  width: 36px;
  height: 36px;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.3s ease;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.avatar-edit:hover {
  background: #696cff;
  color: white;
  transform: scale(1.1);
  box-shadow: 0 6px 20px rgba(105, 108, 255, 0.4);
}

.profile-info {
  position: relative;
  z-index: 2;
}

.profile-name {
  font-size: 1.75rem;
  font-weight: 700;
  margin-bottom: 0.5rem;
  text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.profile-role {
  font-size: 1rem;
  opacity: 0.9;
  background: rgba(255, 255, 255, 0.2);
  padding: 0.5rem 1rem;
  border-radius: 20px;
  display: inline-block;
  backdrop-filter: blur(10px);
  border: 1px solid rgba(255, 255, 255, 0.3);
}

.profile-stats {
  display: flex;
  justify-content: center;
  gap: 2rem;
  margin-top: 1.5rem;
  position: relative;
  z-index: 2;
}

.stat-item {
  text-align: center;
}

.stat-number {
  font-size: 1.25rem;
  font-weight: 600;
  display: block;
}

.stat-label {
  font-size: 0.875rem;
  opacity: 0.8;
  margin-top: 0.25rem;
}

.form-section {
  padding: 2rem;
}

.form-group {
  margin-bottom: 1.5rem;
}

.form-label {
  font-weight: 500;
  color: #495057;
  margin-bottom: 0.5rem;
}

.form-control {
  border: 1px solid #d0d5dd;
  border-radius: 8px;
  padding: 0.75rem 1rem;
  transition: all 0.2s ease;
  font-size: 0.95rem;
}

.form-control:focus {
  border-color: #696cff;
  box-shadow: 0 0 0 3px rgba(105, 108, 255, 0.1);
}

.upload-section {
  background: #f8f9fa;
  border-radius: 8px;
  padding: 1.5rem;
  text-align: center;
  margin-bottom: 2rem;
  border: 2px dashed #dee2e6;
  transition: all 0.2s ease;
}

.upload-section:hover {
  border-color: #696cff;
  background: rgba(105, 108, 255, 0.05);
}

.btn-primary {
  background: #696cff;
  border-color: #696cff;
  border-radius: 8px;
  padding: 0.75rem 1.5rem;
  font-weight: 500;
  transition: all 0.2s ease;
}

.btn-primary:hover {
  background: #5a67d8;
  border-color: #5a67d8;
  transform: translateY(-1px);
}

.btn-outline-secondary {
  border-radius: 8px;
  padding: 0.75rem 1.5rem;
  font-weight: 500;
  transition: all 0.2s ease;
}

.btn-outline-secondary:hover {
  transform: translateY(-1px);
}

.fade-in {
  animation: fadeIn 0.5s ease;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}
</style>
@endsection

@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/select2/select2.js',
  'resources/assets/vendor/libs/@form-validation/popular.js',
  'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
  'resources/assets/vendor/libs/@form-validation/auto-focus.js',
  'resources/assets/vendor/libs/cleavejs/cleave.js',
  'resources/assets/vendor/libs/cleavejs/cleave-phone.js',
  'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'
])
@endsection

@section('page-script')
@vite(['resources/assets/js/pages-account-settings-account.js'])
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Simple form submission
  document.getElementById('formAccountSettings').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const form = this;
    const saveBtn = document.getElementById('saveBtn');
    const btnText = saveBtn.querySelector('.btn-text');
    const originalText = btnText.textContent;
    
    // Show loading state
    saveBtn.disabled = true;
    btnText.textContent = 'Menyimpan...';
    
    const formData = new FormData(form);
    
    fetch(form.action, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value
      },
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        btnText.textContent = 'Berhasil!';
        
        Swal.fire({
          icon: 'success',
          title: 'Berhasil!',
          text: 'Profil berhasil diperbarui',
          timer: 2000,
          showConfirmButton: false
        });
        
        setTimeout(() => {
          window.location.reload();
        }, 2000);
      } else {
        throw new Error(data.message || 'Gagal memperbarui profil');
      }
    })
    .catch(error => {
      saveBtn.disabled = false;
      btnText.textContent = originalText;
      
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: error.message || 'Terjadi kesalahan saat menyimpan profil'
      });
    });
  });

  // File upload functionality
  const uploadArea = document.getElementById('uploadArea');
  const fileInput = document.getElementById('upload');
  const avatar = document.getElementById('uploadedAvatar');
  const resetBtn = document.querySelector('.account-image-reset');

  // Drag and drop
  ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    uploadArea.addEventListener(eventName, preventDefaults, false);
  });

  function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
  }

  ['dragenter', 'dragover'].forEach(eventName => {
    uploadArea.addEventListener(eventName, () => uploadArea.style.borderColor = '#696cff', false);
  });

  ['dragleave', 'drop'].forEach(eventName => {
    uploadArea.addEventListener(eventName, () => uploadArea.style.borderColor = '#dee2e6', false);
  });

  uploadArea.addEventListener('drop', function(e) {
    const files = e.dataTransfer.files;
    if (files.length > 0) {
      handleFile(files[0]);
    }
  });

  function handleFile(file) {
    if (file.type.startsWith('image/')) {
      const reader = new FileReader();
      reader.onload = function(e) {
        avatar.src = e.target.result;
      };
      reader.readAsDataURL(file);
    } else {
      Swal.fire({
        icon: 'warning',
        title: 'Format File Tidak Valid',
        text: 'Silakan pilih file gambar (JPG, PNG, GIF)'
      });
    }
  }

  // File input change
  fileInput.addEventListener('change', function(e) {
    if (e.target.files.length > 0) {
      handleFile(e.target.files[0]);
    }
  });

  // Reset button
  resetBtn.addEventListener('click', function() {
    const originalSrc = avatar.getAttribute('data-original-src') || avatar.src;
    avatar.src = originalSrc;
    fileInput.value = '';
  });

  // Store original avatar src
  avatar.setAttribute('data-original-src', avatar.src);
});

// Reset form function
function resetForm() {
  const form = document.getElementById('formAccountSettings');
  const avatar = document.getElementById('uploadedAvatar');
  const fileInput = document.getElementById('upload');
  
  form.reset();
  
  const originalSrc = avatar.getAttribute('data-original-src');
  if (originalSrc) {
    avatar.src = originalSrc;
  }
  fileInput.value = '';
}
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

@php
  $user = Auth::user();
  $profile = $user->guru ?? $user->siswa ?? null;
  
  // Logic untuk avatar sesuai jenis kelamin dan foto custom
  $avatar = '1.png'; // default laki-laki
  
  if ($profile) {
    if (!empty($profile->foto)) {
      $avatar = $profile->foto;
    } else {
      $jenisKelamin = strtoupper(trim($profile->jenis_kelamin ?? ''));
      if ($jenisKelamin === 'P') {
        $avatar = '2.png';
      }
    }
  }
  
  // Calculate years of experience based on actual data
  $yearsExperience = 0;
  if ($user->role === 'guru' && $profile) {
    // For teachers: count distinct academic years they've taught
    $yearsExperience = \App\Models\WaliKelas::where('guru_id', $profile->id)
      ->join('tahun_ajaran', 'wali_kelas.tahun_ajaran_id', '=', 'tahun_ajaran.id')
      ->distinct('tahun_ajaran.id')
      ->count();
    
    // If no wali kelas data, try counting from nilai (grades) data
    if ($yearsExperience == 0) {
      $yearsExperience = \App\Models\Nilai::where('guru_id', $profile->id)
        ->join('tahun_ajaran', 'nilai.tahun_ajaran_id', '=', 'tahun_ajaran.id')
        ->distinct('tahun_ajaran.id')
        ->count();
    }
  } elseif ($user->role === 'siswa' && $profile) {
    // For students: count distinct academic years they've been enrolled
    $yearsExperience = \App\Models\KelasSiswa::where('siswa_id', $profile->id)
      ->join('tahun_ajaran', 'kelas_siswa.tahun_ajaran_id', '=', 'tahun_ajaran.id')
      ->distinct('tahun_ajaran.id')
      ->count();
  }
  
  // If still 0, default to 1 (current year)
  if ($yearsExperience == 0) {
    $yearsExperience = 1;
  }
@endphp

<!-- Navigation -->
<ul class="nav nav-pills profile-nav flex-column flex-md-row mb-4">
  <li class="nav-item">
    <a class="nav-link active" href="/profile-account">
      <i class="ti-xs ti ti-users me-2"></i> Akun
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="/profile-security">
      <i class="ti-xs ti ti-lock me-2"></i> Keamanan
    </a>
  </li>
</ul>

<!-- Profile Card -->
<div class="row">
  <div class="col-md-12">
    <div class="card profile-card fade-in">
      <!-- Profile Header -->
      <div class="profile-header">
        <div class="avatar-wrapper">
          <img src="{{ asset('assets/img/avatars/' . $avatar) }}" alt="user-avatar" class="profile-avatar" id="uploadedAvatar" />
          <div class="avatar-edit" onclick="document.getElementById('upload').click()">
            <i class="ti ti-camera" style="font-size: 0.875rem;"></i>
          </div>
        </div>
        
        <div class="profile-info">
          <h3 class="profile-name">{{ $profile ? $profile->nama : 'Nama Pengguna' }}</h3>
          <div class="profile-role">{{ ucfirst($user->role) }}</div>
          
          <div class="profile-stats">
            <div class="stat-item">
              <span class="stat-number">{{ $yearsExperience }}</span>
              <div class="stat-label">{{ $user->role === 'guru' ? 'Tahun Mengajar' : 'Tahun Belajar' }}</div>
            </div>
            <div class="stat-item">
              <span class="stat-number">{{ $profile ? (strlen($profile->alamat ?? '') > 0 ? '✓' : '○') : '○' }}</span>
              <div class="stat-label">Profil Lengkap</div>
            </div>
            <div class="stat-item">
              <span class="stat-number">{{ ucfirst($user->role) === 'Guru' ? 'Aktif' : 'Siswa' }}</span>
              <div class="stat-label">Status</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Form Section -->
      <div class="form-section">
        <!-- Upload Section -->
        <div class="upload-section" id="uploadArea">
          <i class="ti ti-cloud-upload mb-2" style="font-size: 2rem; color: #696cff;"></i>
          <h6>Unggah Foto Profil</h6>
          <p class="text-muted mb-3">Klik untuk memilih atau seret file ke sini</p>
          <label for="upload" class="btn btn-primary btn-sm">
            <i class="ti ti-upload me-1"></i>Pilih Foto
            <input type="file" id="upload" class="account-file-input" hidden accept="image/png, image/jpeg, image/jpg, image/gif" />
          </label>
          <button type="button" class="btn btn-outline-secondary btn-sm ms-2 account-image-reset">
            <i class="ti ti-refresh me-1"></i>Reset
          </button>
          <div class="text-muted mt-2">
            <small>Format: JPG, PNG, GIF • Maksimal: 800KB</small>
          </div>
        </div>

        <!-- Form -->
        <form id="formAccountSettings" method="POST" action="{{ route('profile-account.update') }}" enctype="multipart/form-data">
          @csrf
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="nama" class="form-label">Nama Lengkap</label>
                <input class="form-control" type="text" id="nama" name="nama" value="{{ $profile ? $profile->nama : '' }}" autofocus />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="role" class="form-label">Role</label>
                <input class="form-control" type="text" id="role" name="role" value="{{ ucfirst($user->role) }}" readonly />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="email" class="form-label">E-mail</label>
                <input class="form-control" type="email" id="email" name="email" value="{{ $profile && isset($profile->email) ? $profile->email : ($user->email ?? '') }}" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="alamat" class="form-label">Alamat</label>
                <input type="text" class="form-control" id="alamat" name="alamat" value="{{ $profile ? $profile->alamat : '' }}" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="telepon" class="form-label">Telepon</label>
                <input type="tel" class="form-control" id="telepon" name="telepon" value="{{ $profile && isset($profile->notelp) ? $profile->notelp : '' }}" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                <select class="form-control" id="jenis_kelamin" name="jenis_kelamin">
                  <option value="">Pilih Jenis Kelamin</option>
                  <option value="L" {{ ($profile && $profile->jenis_kelamin == 'L') ? 'selected' : '' }}>Laki-laki</option>
                  <option value="P" {{ ($profile && $profile->jenis_kelamin == 'P') ? 'selected' : '' }}>Perempuan</option>
                </select>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label for="status" class="form-label">Status</label>
                <input class="form-control" type="text" id="status" name="status" value="{{ $profile ? $profile->status : '' }}" />
              </div>
            </div>
          </div>
        </form>
        
        <!-- Action Buttons -->
        <div class="d-flex gap-2 mt-4">
          <button type="submit" class="btn btn-primary" form="formAccountSettings" id="saveBtn">
            <i class="ti ti-device-floppy me-2"></i>
            <span class="btn-text">Simpan Perubahan</span>
          </button>
          <button type="reset" class="btn btn-outline-secondary" onclick="resetForm()">
            <i class="ti ti-x me-2"></i>Batal
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection 