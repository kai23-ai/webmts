@php
$customizerHidden = 'customizer-hide';
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Login - Pages')

@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/@form-validation/form-validation.scss'
])
<!-- Load BoxIcons for role selection -->
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<!-- Load Remixicon for additional icons -->
<link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
@endsection

@section('page-style')
@vite([
  'resources/assets/vendor/scss/pages/page-auth.scss'
])
<style>
  .role-selector {
    margin-top: 1rem;
    margin-bottom: 1.5rem;
  }
  .role-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.25rem;
  }
  @media (max-width: 767px) {
    .role-grid {
      grid-template-columns: repeat(2, 1fr);
    }
  }
  @media (max-width: 480px) {
    .role-grid {
      grid-template-columns: 1fr;
    }
  }
  .role-card {
    border: 2px solid #e0e0e0;
    border-radius: 1rem;
    padding: 1.5rem 1rem;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
  }
  .role-card:before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 4px;
    transition: all 0.3s ease;
  }
  .role-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
  }
  
  /* Admin role styling */
  #role-admin {
    border-color: #e0e0e0;
  }
  #role-admin:before {
    background: linear-gradient(90deg, transparent, transparent);
  }
  #role-admin:hover, #role-admin.active {
    border-color: #696cff;
    background-color: rgba(105, 108, 255, 0.08);
  }
  #role-admin:hover:before, #role-admin.active:before {
    background: linear-gradient(90deg, #696cff, #a5a7ff);
  }
  #role-admin .role-icon {
    color: #696cff;
  }
  #role-admin.active {
    box-shadow: 0 5px 15px rgba(105, 108, 255, 0.2);
  }
  
  /* Guru role styling */
  #role-guru {
    border-color: #e0e0e0;
  }
  #role-guru:before {
    background: linear-gradient(90deg, transparent, transparent);
  }
  #role-guru:hover, #role-guru.active {
    border-color: #ff6b6b;
    background-color: rgba(255, 107, 107, 0.08);
  }
  #role-guru:hover:before, #role-guru.active:before {
    background: linear-gradient(90deg, #ff6b6b, #ffa5a5);
  }
  #role-guru .role-icon {
    color: #ff6b6b;
  }
  #role-guru.active {
    box-shadow: 0 5px 15px rgba(255, 107, 107, 0.2);
  }
  
  /* Siswa role styling */
  #role-siswa {
    border-color: #e0e0e0;
  }
  #role-siswa:before {
    background: linear-gradient(90deg, transparent, transparent);
  }
  #role-siswa:hover, #role-siswa.active {
    border-color: #20c997;
    background-color: rgba(32, 201, 151, 0.08);
  }
  #role-siswa:hover:before, #role-siswa.active:before {
    background: linear-gradient(90deg, #20c997, #8ae9d1);
  }
  #role-siswa .role-icon {
    color: #20c997;
  }
  #role-siswa.active {
    box-shadow: 0 5px 15px rgba(32, 201, 151, 0.2);
  }
  
  .role-icon {
    font-size: 2rem;
    margin-bottom: 1rem;
    transition: all 0.3s ease;
    width: 70px;
    height: 70px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
  }
  
  /* Admin icon styling */
  #role-admin .role-icon {
    background-color: rgba(105, 108, 255, 0.1);
  }
  #role-admin.active .role-icon {
    background-color: rgba(105, 108, 255, 0.2);
    box-shadow: 0 0 0 4px rgba(105, 108, 255, 0.1);
  }
  
  /* Guru icon styling */
  #role-guru .role-icon {
    background-color: rgba(255, 107, 107, 0.1);
  }
  #role-guru.active .role-icon {
    background-color: rgba(255, 107, 107, 0.2);
    box-shadow: 0 0 0 4px rgba(255, 107, 107, 0.1);
  }
  
  /* Siswa icon styling */
  #role-siswa .role-icon {
    background-color: rgba(32, 201, 151, 0.1);
  }
  #role-siswa.active .role-icon {
    background-color: rgba(32, 201, 151, 0.2);
    box-shadow: 0 0 0 4px rgba(32, 201, 151, 0.1);
  }
  
  .role-card:hover .role-icon {
    transform: scale(1.1);
  }
  .role-name {
    font-weight: 600;
    margin-bottom: 0.5rem;
  }
  .role-description {
    font-size: 0.85rem;
    color: #697a8d;
    line-height: 1.4;
  }
  .ripple {
    position: absolute;
    border-radius: 50%;
    background-color: rgba(105, 108, 255, 0.3);
    width: 100px;
    height: 100px;
    margin-top: -50px;
    margin-left: -50px;
    animation: ripple 0.6s linear;
    transform: scale(0);
    pointer-events: none;
  }
  @keyframes ripple {
    to {
      transform: scale(2.5);
      opacity: 0;
    }
  }
</style>
@endsection

@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/@form-validation/popular.js',
  'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
  'resources/assets/vendor/libs/@form-validation/auto-focus.js'
])
@endsection

@section('page-script')
@vite([
  'resources/assets/js/pages-auth.js'
])
@endsection

@section('content')
<div class="authentication-wrapper authentication-cover authentication-bg">
  
  <div class="authentication-inner row">
    
    <!-- /Left Text -->
    <div class="d-none d-lg-flex col-lg-7 p-0">
      <div class="auth-cover-bg auth-cover-bg-color d-flex justify-content-center align-items-center">
        <div id="lottie-login" style="width: 650px; height: 650px;"></div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.10.2/lottie.min.js"></script>
        <script>
          document.addEventListener('DOMContentLoaded', function() {
            lottie.loadAnimation({
              container: document.getElementById('lottie-login'),
              renderer: 'svg',
              loop: true,
              autoplay: true,
              path: '{{ asset('assets/lottie/register.json') }}'
            });
          });
        </script>
        <img src="{{ asset('assets/img/illustrations/bg-shape-image-'.$configData['style'].'.png') }}" alt="auth-login-cover" class="platform-bg" data-app-light-img="illustrations/bg-shape-image-light.png" data-app-dark-img="illustrations/bg-shape-image-dark.png">
      </div>
    </div>
    <!-- /Left Text -->

    <!-- Login -->
    <div class="d-flex col-12 col-lg-5 align-items-center p-sm-5 p-4">
      <div class="w-px-400 mx-auto">
        <!-- Logo -->
        <div class="app-brand mb-4">
          <a href="{{url('/')}}" class="app-brand-link gap-2">
            <span class="app-brand-logo demo">@include('_partials.macros',["height"=>20,"withbg"=>'fill: #fff;'])</span>
          </a>
        </div>
        <!-- /Logo -->
        <h3 class=" mb-1">Selamat datang di {{config('variables.templateName')}}! 👋</h3>
        <p class="mb-4">Silakan masuk ke akun Anda untuk memulai petualangan</p>

        @if ($errors->any())
          <div class="alert alert-danger">
            {{ $errors->first('login') }}
          </div>
        @endif

        <form id="formAuthentication" class="mb-3" action="{{ route('auth.login') }}" method="POST">
          @csrf
          <div class="mb-4">
            <label class="form-label fw-semibold">Pilih Role</label>
            <div class="role-selector">
              <input type="hidden" name="role" id="selected_role" value="admin">
              <div class="role-grid">
                <div class="role-card" id="role-admin" data-role="admin">
                  <div class="role-icon">
                    <i class="ri-admin-line"></i>
                  </div>
                  <div class="role-name">Admin</div>
                  <div class="role-description">Akses penuh ke sistem manajemen</div>
                </div>
                <div class="role-card" id="role-guru" data-role="guru">
                  <div class="role-icon">
                    <i class="bx bxs-graduation"></i>
                  </div>
                  <div class="role-name">Guru</div>
                  <div class="role-description">Kelola kelas dan nilai siswa</div>
                </div>
                <div class="role-card" id="role-siswa" data-role="siswa">
                  <div class="role-icon">
                    <i class="ri-user-follow-line"></i>
                  </div>
                  <div class="role-name">Siswa</div>
                  <div class="role-description">Akses materi dan nilai pembelajaran</div>
                </div>
              </div>
            </div>
          </div>
          <div class="mb-3">
            <label for="nip_nis" class="form-label" id="nipNisLabel">NIP</label>
            <input type="text" class="form-control" id="nip_nis" name="nip_nis" placeholder="Masukkan NIP" required autofocus>
          </div>
          <div class="mb-3 form-password-toggle">
            <label class="form-label" for="password">Kata Sandi</label>
            <div class="input-group input-group-merge">
              <input type="password" id="password" class="form-control" name="password" placeholder="Masukkan kata sandi" required />
              <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
            </div>
          </div>
          <button class="btn btn-primary d-grid w-100">
            Masuk
          </button>
        </form>
        <script>
// Wait for DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
  // Function to select a role with enhanced visual feedback
  window.selectRole = function(role) {
    // Update hidden input value
    document.getElementById('selected_role').value = role;
    
    // Update visual selection with smooth transition
    document.querySelectorAll('.role-card').forEach(function(card) {
      if (card.getAttribute('data-role') === role) {
        card.classList.add('active');
        // Add subtle animation for selected card
        card.style.animation = 'pulse 0.5s';
        setTimeout(() => {
          card.style.animation = '';
        }, 500);
      } else {
        card.classList.remove('active');
      }
    });
    
    // Update label and placeholder based on role with custom styling
    var label = document.getElementById('nipNisLabel');
    var input = document.getElementById('nip_nis');
    
    // Define role-specific colors
    var roleColors = {
      'guru': '#ff6b6b',
      'siswa': '#20c997',
      'admin': '#696cff'
    };
    
    // Set the color based on role
    var activeColor = roleColors[role];
    
    if (role === 'guru') {
      label.innerText = 'NIP';
      label.style.color = activeColor;
      input.placeholder = 'Masukkan NIP';
    } else if (role === 'siswa') {
      label.innerText = 'NIS';
      label.style.color = activeColor;
      input.placeholder = 'Masukkan NIS';
    } else {
      label.innerText = 'Username/Email';
      label.style.color = activeColor;
      input.placeholder = 'Masukkan Username atau Email';
    }
    
    // Apply custom styling to the input field
    input.style.borderColor = activeColor;
    
    // Add custom CSS to override browser focus styles
    var customStyle = document.getElementById('custom-input-style');
    if (!customStyle) {
      customStyle = document.createElement('style');
      customStyle.id = 'custom-input-style';
      document.head.appendChild(customStyle);
    }
    
    // Update the style with the current active color
    customStyle.textContent = `
      #nip_nis:focus {
        border-color: ${activeColor} !important;
        box-shadow: 0 0 0 0.25rem ${activeColor}25 !important;
      }
    `;
    
    // Focus on the input field immediately after role selection
    input.focus();
  };
  
  // Add click event listeners to all role cards
  document.querySelectorAll('.role-card').forEach(function(card) {
    card.addEventListener('click', function() {
      var role = this.getAttribute('data-role');
      selectRole(role);
      
      // Enhanced ripple effect on click
      let ripple = document.createElement('div');
      ripple.className = 'ripple';
      this.appendChild(ripple);
      
      setTimeout(function() {
        ripple.remove();
      }, 600);
    });
    
    // Add keyboard accessibility
    card.setAttribute('tabindex', '0');
    card.addEventListener('keydown', function(e) {
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        var role = this.getAttribute('data-role');
        selectRole(role);
      }
    });
    
    // Add hover sound effect for better interaction feedback
    card.addEventListener('mouseenter', function() {
      // You could add a subtle hover sound here if desired
      // const hoverSound = new Audio('path/to/hover-sound.mp3');
      // hoverSound.volume = 0.2;
      // hoverSound.play();
    });
  });
  
  // Set admin as default selected role
  selectRole('admin');
});
</script>
      </div>
    </div>
    <!-- /Login -->
  </div>
</div>
@endsection