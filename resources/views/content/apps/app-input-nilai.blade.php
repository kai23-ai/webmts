@extends('layouts/layoutMaster')

@section('title', 'Input Nilai')

@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
  'resources/assets/vendor/libs/select2/select2.scss',
  'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss',
  'resources/assets/vendor/libs/spinkit/spinkit.scss'
])
@endsection

@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
  'resources/assets/vendor/libs/select2/select2.js',
  'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'
])
@endsection

@section('page-style')
@vite(['resources/assets/vendor/scss/pages/page-profile.scss'])
<style>
  body {
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    min-height: 100vh;
  }
  
  .input-nilai-container {
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
  
  /* Modern Card Styling to match history page */
  .card {
    border-radius: 16px;
    border: none;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    animation: fadeInUp 0.8s ease-out;
  }
  
  .card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12);
  }
  
  .card-header {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    color: #334155;
    border-radius: 16px 16px 0 0 !important;
    border: none;
    padding: 1.5rem;
    border-bottom: 1px solid #e2e8f0;
  }
  
  .card-header h5 {
    margin: 0;
    font-weight: 700;
    font-size: 1.25rem;
  }
  
  .card-body {
    padding: 2rem;
  }
  
  /* Form Controls Styling */
  .form-select, .form-control {
    border-radius: 12px;
    border: 2px solid #e2e8f0;
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
    background: white;
  }
  
  .form-select:focus, .form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
    transform: translateY(-1px);
  }
  
  .form-label {
    font-weight: 600;
    color: #334155;
    margin-bottom: 0.75rem;
  }
  
  /* Table Styling */
  .table {
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
  }
  
  .table thead th {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    color: #334155;
    border: none;
    font-weight: 600;
    padding: 1rem;
    border-bottom: 2px solid #cbd5e1;
  }
  
  .table tbody tr {
    transition: all 0.3s ease;
  }
  
  .table tbody tr:hover {
    background-color: rgba(102, 126, 234, 0.05);
    transform: scale(1.01);
  }
  
  .table tbody td {
    padding: 1rem;
    border-color: #e2e8f0;
    vertical-align: middle;
  }
  
  /* Button Styling */
  .btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    border-radius: 12px;
    padding: 0.75rem 2rem;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
  }
  
  .btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
    background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
  }
  
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
  
  /* Force hide status alerts when no subject selected */
  .hide-status-alerts .alert-info,
  .hide-status-alerts .alert-success,
  .hide-status-alerts .alert[class*="info"],
  .hide-status-alerts .alert[class*="success"] {
    display: none !important;
    visibility: hidden !important;
    opacity: 0 !important;
    height: 0 !important;
    margin: 0 !important;
    padding: 0 !important;
  }
  
  /* Specific CSS to hide the "Belum ada nilai yang diinput" alert */
  .alert-info:has-text("Belum ada nilai yang diinput"),
  .alert:contains("Belum ada nilai yang diinput"),
  .alert:contains("Silakan masukkan nilai"),
  .alert-info:contains("Belum ada nilai"),
  .alert-info:contains("nilai yang diinput") {
    display: none !important;
    visibility: hidden !important;
    opacity: 0 !important;
    height: 0 !important;
    margin: 0 !important;
    padding: 0 !important;
  }
  
  /* Global CSS to hide status alerts when no subject is selected */
  body:not(.subject-selected) .alert-info,
  body:not(.subject-selected) .alert-success {
    display: none !important;
  }
  
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
  /* Fix: Hilangkan scroll vertikal & horizontal pada body/html saat select2 dibuka */
  body.select2-open, html.select2-open {
    overflow: auto !important;
  }
  body, html {
    overflow-x: hidden;
    /* overflow-y: auto;  // default, biar scroll vertikal hanya muncul jika perlu */
  }
  /* Select2 z-index fix */
  .select2-container {
    z-index: 1050;
  }
  
  .select2-container--open {
    z-index: 1060;
  }
  
  .select2-dropdown {
    z-index: 1060;
  }
  
  /* Ensure profile banner stays below dropdowns */
  .elegant-profile-banner {
    z-index: 1;
  }
  
  /* Loading Spinner Styles */
  .btn-loading {
    position: relative;
    pointer-events: none;
    opacity: 0.8;
  }
  
  .btn-loading .btn-text {
    opacity: 0.5;
  }
  
  /* Attractive SpinKit Button Spinner */
  .btn-spinner {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 18px;
    height: 18px;
  }
  
  .btn-spinner .sk-chase {
    width: 18px;
    height: 18px;
    position: relative;
    animation: sk-chase 2.5s infinite linear both;
  }
  
  .btn-spinner .sk-chase-dot {
    width: 100%;
    height: 100%;
    position: absolute;
    left: 0;
    top: 0; 
    animation: sk-chase-dot 2.0s infinite ease-in-out both; 
  }
  
  .btn-spinner .sk-chase-dot:before {
    content: '';
    display: block;
    width: 25%;
    height: 25%;
    background-color: #ffffff;
    border-radius: 100%;
    animation: sk-chase-dot-before 2.0s infinite ease-in-out both; 
  }
  
  .btn-spinner .sk-chase-dot:nth-child(1) { animation-delay: -1.1s; }
  .btn-spinner .sk-chase-dot:nth-child(2) { animation-delay: -1.0s; }
  .btn-spinner .sk-chase-dot:nth-child(3) { animation-delay: -0.9s; }
  .btn-spinner .sk-chase-dot:nth-child(4) { animation-delay: -0.8s; }
  .btn-spinner .sk-chase-dot:nth-child(5) { animation-delay: -0.7s; }
  .btn-spinner .sk-chase-dot:nth-child(6) { animation-delay: -0.6s; }
  .btn-spinner .sk-chase-dot:nth-child(1):before { animation-delay: -1.1s; }
  .btn-spinner .sk-chase-dot:nth-child(2):before { animation-delay: -1.0s; }
  .btn-spinner .sk-chase-dot:nth-child(3):before { animation-delay: -0.9s; }
  .btn-spinner .sk-chase-dot:nth-child(4):before { animation-delay: -0.8s; }
  .btn-spinner .sk-chase-dot:nth-child(5):before { animation-delay: -0.7s; }
  .btn-spinner .sk-chase-dot:nth-child(6):before { animation-delay: -0.6s; }
  
  @keyframes sk-chase {
    100% { transform: translate(-50%, -50%) rotate(360deg); } 
  }
  
  @keyframes sk-chase-dot {
    80%, 100% { transform: rotate(360deg); } 
  }
  
  @keyframes sk-chase-dot-before {
    50% {
      transform: scale(0.4); 
    } 100%, 0% {
      transform: scale(1.0); 
    } 
  }
  
  /* Form Loading Overlay with Attractive Spinner */
  .form-loading-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255, 255, 255, 0.95);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    z-index: 10;
    opacity: 0;
    visibility: hidden;
    transition: all 0.4s ease;
    backdrop-filter: blur(8px);
  }
  
  .form-loading-overlay.show {
    opacity: 1;
    visibility: visible;
  }
  
  .form-spinner {
    width: 50px;
    height: 50px;
    position: relative;
    margin-bottom: 1rem;
  }
  
  .form-spinner .sk-circle {
    width: 50px;
    height: 50px;
    position: relative;
  }
  
  .form-spinner .sk-circle .sk-circle-dot {
    width: 100%;
    height: 100%;
    position: absolute;
    left: 0;
    top: 0;
  }
  
  .form-spinner .sk-circle .sk-circle-dot:before {
    content: '';
    display: block;
    margin: 0 auto;
    width: 15%;
    height: 15%;
    background-color: #667eea;
    border-radius: 100%;
    animation: sk-circle-fade-dot 1.2s infinite ease-in-out both;
  }
  
  .form-spinner .sk-circle .sk-circle-dot:nth-child(1) { transform: rotate(30deg); }
  .form-spinner .sk-circle .sk-circle-dot:nth-child(2) { transform: rotate(60deg); }
  .form-spinner .sk-circle .sk-circle-dot:nth-child(3) { transform: rotate(90deg); }
  .form-spinner .sk-circle .sk-circle-dot:nth-child(4) { transform: rotate(120deg); }
  .form-spinner .sk-circle .sk-circle-dot:nth-child(5) { transform: rotate(150deg); }
  .form-spinner .sk-circle .sk-circle-dot:nth-child(6) { transform: rotate(180deg); }
  .form-spinner .sk-circle .sk-circle-dot:nth-child(7) { transform: rotate(210deg); }
  .form-spinner .sk-circle .sk-circle-dot:nth-child(8) { transform: rotate(240deg); }
  .form-spinner .sk-circle .sk-circle-dot:nth-child(9) { transform: rotate(270deg); }
  .form-spinner .sk-circle .sk-circle-dot:nth-child(10) { transform: rotate(300deg); }
  .form-spinner .sk-circle .sk-circle-dot:nth-child(11) { transform: rotate(330deg); }
  
  .form-spinner .sk-circle .sk-circle-dot:nth-child(1):before { animation-delay: -1.1s; }
  .form-spinner .sk-circle .sk-circle-dot:nth-child(2):before { animation-delay: -1.0s; }
  .form-spinner .sk-circle .sk-circle-dot:nth-child(3):before { animation-delay: -0.9s; }
  .form-spinner .sk-circle .sk-circle-dot:nth-child(4):before { animation-delay: -0.8s; }
  .form-spinner .sk-circle .sk-circle-dot:nth-child(5):before { animation-delay: -0.7s; }
  .form-spinner .sk-circle .sk-circle-dot:nth-child(6):before { animation-delay: -0.6s; }
  .form-spinner .sk-circle .sk-circle-dot:nth-child(7):before { animation-delay: -0.5s; }
  .form-spinner .sk-circle .sk-circle-dot:nth-child(8):before { animation-delay: -0.4s; }
  .form-spinner .sk-circle .sk-circle-dot:nth-child(9):before { animation-delay: -0.3s; }
  .form-spinner .sk-circle .sk-circle-dot:nth-child(10):before { animation-delay: -0.2s; }
  .form-spinner .sk-circle .sk-circle-dot:nth-child(11):before { animation-delay: -0.1s; }
  
  @keyframes sk-circle-fade-dot {
    0%, 39%, 100% { 
      opacity: 0;
      transform: scale(0.6);
    } 40% { 
      opacity: 1; 
      transform: scale(1.0);
    }
  }
  
  .loading-text {
    color: #667eea;
    font-weight: 600;
    font-size: 0.9rem;
    text-align: center;
    animation: pulse 1.5s ease-in-out infinite alternate;
  }
  
  @keyframes pulse {
    from { opacity: 0.6; }
    to { opacity: 1; }
  }
  
  /* SweetAlert Z-Index Fix */
  .swal2-container {
    z-index: 99999 !important;
  }
  
  .swal2-popup {
    z-index: 99999 !important;
  }
  
  /* Select2 Z-Index Fix */
  .select2-container {
    z-index: 1050 !important;
  }
  
  .select2-dropdown {
    z-index: 1051 !important;
  }
  
  /* Bootstrap Select Z-Index */
  .bootstrap-select .dropdown-menu {
    z-index: 1052 !important;
  }
  
  /* General Select Dropdown Fix */
  select, .form-select {
    z-index: 1 !important;
  }
  
  /* Success Animation */
  .save-success {
    animation: saveSuccess 0.6s ease-out;
  }
  
  @keyframes saveSuccess {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); background-color: #d4edda; }
    100% { transform: scale(1); }
  }
  
  /* Styling untuk card wali kelas */
  .wali-kelas-card {
    background-color: #f5f5ff;
    border-radius: 0.5rem;
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
  }
  
  .wali-kelas-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.1);
  }
  
  .avatar-section {
    background-color: #e7e7ff;
    padding: 1.5rem;
    text-align: center;
    position: relative;
    overflow: hidden;
  }
  
  .avatar-section::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.3) 0%, rgba(255,255,255,0) 70%);
    animation: rotate 10s linear infinite;
  }
  
  @keyframes rotate {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }
  
  .avatar-container {
    position: relative;
    width: 100px;
    height: 100px;
    margin: 0 auto 1rem;
  }
  
  .avatar-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
    border: 3px solid #fff;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
  }
  
  .avatar-container:hover .avatar-image {
    transform: scale(1.05);
  }
  
  .info-section {
    padding: 1.5rem;
  }
  
  .info-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.5rem 1rem;
    border-radius: 50px;
    margin-right: 0.5rem;
    margin-bottom: 0.5rem;
    font-weight: 500;
    transition: all 0.3s ease;
  }
  
  .info-badge:hover {
    transform: translateY(-2px);
  }
  
  .info-badge i {
    margin-right: 0.5rem;
  }
  
  .info-badge.primary {
    background-color: #e7e7ff;
    color: #696cff;
  }
  
  .info-badge.secondary {
    background-color: #ebeef0;
    color: #8592a3;
  }
  
  .info-badge.success {
    background-color: #e8fadf;
    color: #71dd37;
  }
  
  .info-badge.info {
    background-color: #d7f5fc;
    color: #03c3ec;
  }
  
  .kelas-badge {
    background-color: #696cff;
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 50px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    margin-bottom: 1rem;
    box-shadow: 0 5px 15px rgba(105, 108, 255, 0.3);
    transition: all 0.3s ease;
  }
  
  .kelas-badge:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(105, 108, 255, 0.4);
  }
  
  .kelas-badge i {
    margin-right: 0.5rem;
    font-size: 1.25rem;
  }
  
  .siswa-counter {
    display: flex;
    align-items: center;
    margin-bottom: 1rem;
  }
  
  .counter-item {
    background-color: #f5f5f5;
    border-radius: 0.5rem;
    padding: 0.75rem 1rem;
    margin-right: 0.75rem;
    text-align: center;
    min-width: 80px;
    transition: all 0.3s ease;
  }
  
  .counter-item:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
  }
  
  .counter-number {
    font-size: 1.5rem;
    font-weight: 700;
    color: #696cff;
    margin-bottom: 0.25rem;
    line-height: 1;
  }
  
  .counter-label {
    font-size: 0.75rem;
    color: #8592a3;
  }
  
  .legger-btn {
    padding: 0.75rem 1.5rem;
    border-radius: 50px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 5px 15px rgba(105, 108, 255, 0.2);
  }
  
  .legger-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(105, 108, 255, 0.3);
  }
  
  .legger-btn i {
    margin-right: 0.5rem;
    font-size: 1.25rem;
  }
  
  /* Animasi pulse untuk badge */
  .pulse {
    animation: pulse 2s infinite;
  }
  
  @keyframes pulse {
    0% {
      transform: scale(1);
    }
    50% {
      transform: scale(1.05);
    }
    100% {
      transform: scale(1);
    }
  }
  
  /* Animasi fade-in untuk card */
  .fade-in {
    animation: fadeIn 0.5s ease-in-out;
  }
  
  @keyframes fadeIn {
    from {
      opacity: 0;
      transform: translateY(20px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
  
  /* Modern Profile Card Styles */
  .modern-profile-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 20px;
    border: none;
    box-shadow: 0 20px 40px rgba(102, 126, 234, 0.15);
    position: relative;
    overflow: hidden;
    transition: all 0.4s ease;
  }
  
  .modern-profile-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 30px 60px rgba(102, 126, 234, 0.25);
  }
  
  .modern-profile-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(45deg, rgba(255,255,255,0.1) 0%, transparent 50%, rgba(255,255,255,0.05) 100%);
    pointer-events: none;
  }
  
  .profile-avatar-modern {
    width: 85px;
    height: 85px;
    border-radius: 20px;
    border: 4px solid rgba(255,255,255,0.3);
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    transition: all 0.3s ease;
    object-fit: cover;
    backdrop-filter: blur(10px);
  }
  
  .profile-avatar-modern:hover {
    transform: scale(1.08) rotate(-3deg);
    border-color: rgba(255,255,255,0.6);
  }
  
  .profile-info-glass {
    background: rgba(255,255,255,0.15);
    backdrop-filter: blur(15px);
    border-radius: 16px;
    padding: 1.5rem;
    border: 1px solid rgba(255,255,255,0.2);
    box-shadow: 0 8px 32px rgba(0,0,0,0.1);
  }
  
  .profile-name-modern {
    color: #ffffff;
    font-size: 1.4rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    text-shadow: 0 2px 8px rgba(0,0,0,0.3);
  }
  
  .profile-badge-modern {
    background: rgba(255,255,255,0.2);
    color: #ffffff;
    padding: 0.4rem 1rem;
    border-radius: 25px;
    font-size: 0.85rem;
    font-weight: 600;
    margin: 0.2rem;
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.1);
    transition: all 0.3s ease;
  }
  
  .profile-badge-modern:hover {
    background: rgba(255,255,255,0.3);
    transform: translateY(-2px);
  }
  
  .stats-card-modern {
    background: rgba(255,255,255,0.95);
    border-radius: 18px;
    padding: 1.5rem;
    text-align: center;
    min-width: 130px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    transition: all 0.4s ease;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.3);
  }
  
  .stats-card-modern:hover {
    transform: translateY(-10px) scale(1.05);
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
  }
  
  .stats-number-modern {
    background: linear-gradient(135deg, #667eea, #764ba2);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    font-size: 2rem;
    font-weight: 800;
    margin-bottom: 0.5rem;
    line-height: 1;
  }
  
  .stats-label-modern {
    color: #667eea;
    font-weight: 600;
    font-size: 0.9rem;
    margin-bottom: 0.3rem;
  }
  
  .stats-sublabel-modern {
    color: #64748b;
    font-size: 0.75rem;
  }
  
  .btn-legger-modern {
    background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
    border: none;
    border-radius: 16px;
    padding: 1rem 2rem;
    color: white;
    text-decoration: none;
    font-weight: 700;
    font-size: 1rem;
    box-shadow: 0 10px 30px rgba(255, 107, 107, 0.4);
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.6rem;
    position: relative;
    overflow: hidden;
  }
  
  .btn-legger-modern::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
    transition: left 0.6s;
  }
  
  .btn-legger-modern:hover::before {
    left: 100%;
  }
  
  .btn-legger-modern:hover {
    transform: translateY(-4px) scale(1.05);
    box-shadow: 0 15px 40px rgba(255, 107, 107, 0.6);
    color: white;
  }
  
  .btn-legger-modern i {
    font-size: 1.3rem;
  }
  
  /* Mini Elegant Profile Banner */
  .elegant-profile-banner {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 12px;
    padding: 1rem;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.12);
    position: relative;
    overflow: hidden;
    animation: slideInDown 0.5s ease-out;
  }
  
  @keyframes slideInDown {
    from { opacity: 0; transform: translateY(-15px); }
    to { opacity: 1; transform: translateY(0); }
  }
  
  .elegant-profile-banner::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.04) 0%, transparent 70%);
    animation: rotate 50s linear infinite;
  }
  
  .profile-content {
    display: flex;
    align-items: center;
    gap: 1rem;
    position: relative;
    z-index: 2;
  }
  
  .floating-avatar {
    position: relative;
    flex-shrink: 0;
  }
  
  .avatar-elegant {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    border: 2px solid rgba(255,255,255,0.3);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    transition: all 0.3s ease;
    object-fit: cover;
  }
  
  .avatar-elegant:hover {
    transform: scale(1.1);
    border-color: rgba(255,255,255,0.6);
    box-shadow: 0 6px 18px rgba(0,0,0,0.2);
  }
  
  .avatar-status {
    position: absolute;
    bottom: 0px;
    right: 0px;
    width: 12px;
    height: 12px;
    background: #10b981;
    border-radius: 50%;
    border: 2px solid white;
    animation: pulse 2s infinite;
  }
  
  .profile-details {
    flex-grow: 1;
    min-width: 0;
  }
  
  .profile-name {
    color: white;
    font-size: 1.1rem;
    font-weight: 700;
    margin-bottom: 0.3rem;
    text-shadow: 0 1px 3px rgba(0,0,0,0.2);
    line-height: 1.2;
  }
  
  .profile-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
  }
  
  .meta-item {
    background: rgba(255,255,255,0.15);
    color: white;
    padding: 0.25rem 0.6rem;
    border-radius: 12px;
    font-size: 0.7rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 0.3rem;
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255,255,255,0.1);
    transition: all 0.3s ease;
  }
  
  .meta-item:hover {
    background: rgba(255,255,255,0.25);
    transform: translateY(-1px);
  }
  
  .meta-item i {
    font-size: 0.8rem;
  }
  
  .stats-grid {
    display: flex;
    gap: 0.75rem;
    flex-shrink: 0;
  }
  
  .stat-item {
    background: rgba(255,255,255,0.95);
    border-radius: 10px;
    padding: 0.75rem 1rem;
    min-width: 120px;
    height: 65px;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.06);
    transition: all 0.3s ease;
    backdrop-filter: blur(8px);
  }
  
  .stat-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
  }
  
  .class-stat {
    border-left: 3px solid #667eea;
  }
  
  .student-stat {
    border-left: 3px solid #10b981;
  }
  
  .stat-icon {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    transition: all 0.3s ease;
    flex-shrink: 0;
  }
  
  .class-stat .stat-icon {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
  }
  
  .student-stat .stat-icon {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
  }
  
  .stat-content {
    flex-grow: 1;
    text-align: left;
  }
  
  .stat-number {
    font-size: 1.3rem;
    font-weight: 800;
    margin-bottom: 0.1rem;
    line-height: 1;
  }
  
  .class-stat .stat-number {
    background: linear-gradient(135deg, #667eea, #764ba2);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
  }
  
  .student-stat .stat-number {
    background: linear-gradient(135deg, #10b981, #059669);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
  }
  
  .stat-label {
    font-weight: 600;
    font-size: 0.75rem;
    margin-bottom: 0.1rem;
  }
  
  .class-stat .stat-label {
    color: #667eea;
  }
  
  .student-stat .stat-label {
    color: #10b981;
  }
  
  .stat-sublabel {
    color: #64748b;
    font-size: 0.65rem;
  }
  
  .profile-action {
    flex-shrink: 0;
  }
  
  .btn-elegant-action {
    background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
    border: none;
    border-radius: 10px;
    padding: 0.75rem 1rem;
    color: white;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.8rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    box-shadow: 0 4px 15px rgba(255, 107, 107, 0.25);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    height: 65px;
    min-width: 120px;
  }
  
  .btn-elegant-action::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.4s;
  }
  
  .btn-elegant-action:hover::before {
    left: 100%;
  }
  
  .btn-elegant-action:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(255, 107, 107, 0.35);
    color: white;
  }
  
  .btn-icon {
    font-size: 1rem;
  }
  
  .btn-text {
    font-size: 0.8rem;
  }
  
  .btn-arrow {
    font-size: 0.8rem;
    transition: transform 0.3s ease;
  }
  
  .btn-elegant-action:hover .btn-arrow {
    transform: translateX(2px);
  }
  
  /* Responsive Design */
  @media (max-width: 768px) {
    .profile-content {
      flex-direction: column;
      text-align: center;
      gap: 1rem;
    }
    
    .stats-grid {
      flex-direction: row;
      justify-content: center;
      flex-wrap: wrap;
    }
    
    .stat-item {
      flex: 1;
      min-width: 120px;
      max-width: 150px;
    }
    
    .profile-meta {
      justify-content: center;
    }
    
    .profile-action {
      align-self: center;
    }
  }
  
  @media (max-width: 480px) {
    .profile-content {
      gap: 0.75rem;
    }
    
    .stats-grid {
      gap: 0.5rem;
    }
    
    .stat-item {
      min-width: 100px;
      padding: 0.6rem;
    }
    
    .stat-number {
      font-size: 1.1rem;
    }
    
    .stat-label {
      font-size: 0.65rem;
    }
    
    .stat-sublabel {
      font-size: 0.55rem;
    }
  }
</style>
@endsection

@section('page-script')
@vite(['resources/assets/js/app-input-nilai.js'])
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

<div class="input-nilai-container">
  <!-- Page Header -->
  <div class="page-header">
    <h1 class="page-title">Input Nilai Siswa</h1>
    <p class="page-subtitle">Kelola dan input nilai siswa dengan mudah dan efisien</p>
  </div>

<!-- Profile Section - Outside Card -->
@if($kelasGuru)
<!-- Elegant Profile Banner -->
<div class="elegant-profile-banner mb-4">
  <div class="profile-content">
    <!-- Floating Avatar -->
    <div class="floating-avatar">
      @if(Auth::user()->guru && Auth::user()->guru->foto)
        <img src="{{ asset('storage/'.Auth::user()->guru->foto) }}" alt="Foto Guru" class="avatar-elegant">
      @else
        @if(Auth::user()->guru && Auth::user()->guru->jenis_kelamin == 'P')
          <img src="{{ asset('assets/img/avatars/2.png') }}" alt="Avatar Perempuan" class="avatar-elegant">
        @else
          <img src="{{ asset('assets/img/avatars/1.png') }}" alt="Avatar Laki-laki" class="avatar-elegant">
        @endif
      @endif
      <div class="avatar-status"></div>
    </div>
    
    <!-- Profile Info -->
    <div class="profile-details">
      <h3 class="profile-name">{{ Auth::user()->guru->nama ?? Auth::user()->name }}</h3>
      <div class="profile-meta">
        <span class="meta-item">
          <i class="ti ti-id-badge"></i>
          NIP: {{ Auth::user()->guru->nip ?? '-' }}
        </span>
        <span class="meta-item">
          <i class="ti ti-user"></i>
          {{ Auth::user()->guru->jenis_kelamin == 'P' ? 'Perempuan' : 'Laki-laki' }}
        </span>
      </div>
    </div>
    
    <!-- Stats Grid -->
    <div class="stats-grid">
      <div class="stat-item class-stat">
        <div class="stat-icon">
          <i class="ti ti-school"></i>
        </div>
        <div class="stat-content">
          <div class="stat-number">{{ $kelasGuru->nama_kelas }}</div>
          <div class="stat-label">Wali Kelas</div>
          <div class="stat-sublabel">{{ $tahunAjaranAktif->tahun ?? 'Aktif' }}</div>
        </div>
      </div>
      
      <div class="stat-item student-stat">
        <div class="stat-icon">
          <i class="ti ti-users"></i>
        </div>
        <div class="stat-content">
          <div class="stat-number">{{ $siswaWaliKelas->count() }}</div>
          <div class="stat-label">Total Siswa</div>
          <div class="stat-sublabel">{{ $siswaWaliKelas->where('jenis_kelamin', 'L')->count() }}L • {{ $siswaWaliKelas->where('jenis_kelamin', 'P')->count() }}P</div>
        </div>
      </div>
    </div>
    
    <!-- Action Button -->
    <div class="profile-action">
      <a href="{{ url('dashboard/guru/export-legger') }}" target="_blank" class="btn-elegant-action">
        <span class="btn-icon">
          <i class="ti ti-file-spreadsheet"></i>
        </span>
        <span class="btn-text">Buat Legger</span>
        <span class="btn-arrow">
          <i class="ti ti-arrow-right"></i>
        </span>
      </a>
    </div>
  </div>
</div>
@else
<!-- Warning for non-homeroom teachers -->
<div class="alert alert-warning mb-4">
  <div class="d-flex align-items-center">
    <i class="ti ti-alert-triangle me-2"></i>
    <div>
      <strong>Anda belum ditugaskan sebagai wali kelas</strong><br>
      Silakan hubungi administrator untuk mendapatkan akses input nilai.
    </div>
  </div>
</div>
@endif

<!-- Form Section -->
<div class="row">
  <div class="col-12">
    <div class="card" id="main-card">
      <div class="card-body">
        <!-- Form Input Nilai -->
        <div class="row mb-4">
          <div class="col-md-4">
            <label for="mata_pelajaran" class="form-label">Pilih Mata Pelajaran</label>
            <select class="form-select" id="mata_pelajaran" name="mata_pelajaran_id">
              <option value="">Pilih Mata Pelajaran</option>
              @foreach($mataPelajaran as $mp)
                <option value="{{ $mp->id }}">{{ $mp->nama_mapel }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-4">
            <label for="tahun_ajaran" class="form-label">Pilih Tahun Ajaran</label>
            <select class="form-select" id="tahun_ajaran" name="tahun_ajaran_id">
              <option value="">Pilih Tahun Ajaran</option>
              @foreach($tahunAjaran as $ta)
                <option value="{{ $ta->id }}" {{ $ta->aktif ? 'selected' : '' }}>
                  {{ $ta->tahun }} {{ $ta->aktif ? '(Aktif)' : '' }}
                </option>
              @endforeach
            </select>
          </div>
          <div class="col-md-4">
            <label for="semester" class="form-label">Pilih Semester</label>
            <select class="form-select" id="semester" name="semester_id">
              <option value="">Pilih Semester</option>
              @foreach($semester as $sem)
                <option value="{{ $sem->id }}" {{ $sem->status == 'aktif' ? 'selected' : '' }}>
                  {{ $sem->nama }} {{ $sem->status == 'aktif' ? '(Aktif)' : '' }}
                </option>
              @endforeach
            </select>
          </div>
        </div>
        


        <!-- Tabel Input Nilai Siswa -->
        <div class="row mb-4" id="form-nilai" style="display: none;">
          <div class="col-12">
            <div class="card border border-primary">
              <div class="card-header">
                <!-- Judul dihapus sesuai permintaan user -->
              </div>
              <div class="card-body">
                @if($siswaWaliKelas->count() > 0)
                  <form id="form-batch-nilai" method="POST">
                  <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="table-input-nilai">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>NIS</th>
                          <th>Nama Siswa</th>
                          <th>Nilai</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($siswaWaliKelas as $index => $siswa)
                          <tr data-kelas-siswa-id="{{ $siswa->pivot->id ?? $siswa->kelas_siswa_id ?? $siswa->id }}">
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $siswa->nis }}</td>
                            <td>{{ $siswa->nama }}</td>
                            <td>
                              <input type="number" class="form-control nilai-angka" name="nilai[{{ $siswa->pivot->id ?? $siswa->kelas_siswa_id ?? $siswa->id }}]" min="0" max="100" data-kelas-siswa="{{ $siswa->pivot->id ?? $siswa->kelas_siswa_id ?? $siswa->id }}">
                            </td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                  <div class="mt-3 text-center" style="position: relative;">
                    <div class="form-loading-overlay" id="formLoadingOverlay">
                      <div class="form-spinner">
                        <div class="sk-circle">
                          <div class="sk-circle-dot"></div>
                          <div class="sk-circle-dot"></div>
                          <div class="sk-circle-dot"></div>
                          <div class="sk-circle-dot"></div>
                          <div class="sk-circle-dot"></div>
                          <div class="sk-circle-dot"></div>
                          <div class="sk-circle-dot"></div>
                          <div class="sk-circle-dot"></div>
                          <div class="sk-circle-dot"></div>
                          <div class="sk-circle-dot"></div>
                          <div class="sk-circle-dot"></div>
                        </div>
                      </div>
                      <div class="loading-text">Menyimpan nilai siswa...</div>
                    </div>
                    <button type="submit" class="btn btn-primary" id="btnSimpanNilai">
                      <i class="ti ti-device-floppy me-1"></i>
                      <span class="btn-text">Simpan Semua Nilai</span>
                    </button>
                  </div>
                  </form>
                @else
                  <div class="text-center text-muted py-4">
                    <i class="ti ti-users-off ti-lg mb-3"></i>
                    <p>Tidak ada siswa di wali kelas Anda</p>
                  </div>
                @endif
              </div>
            </div>
          </div>
        </div>


      </div>
    </div>
  </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.10.2/lottie.min.js"></script>
<div id="not-selected-message" class="row mb-4" style="display:none;">
  <div class="col-12 text-center">
    <div style="max-width:320px;margin:0 auto;">
      <div id="lottie-not-found" style="height:180px;"></div>
    </div>
    <div class="text-muted mt-2" style="font-size:1.1rem;">Anda belum memilih mata pelajaran</div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const mataPelajaranSelect = document.getElementById('mata_pelajaran');
    const btnSimpanNilai = document.getElementById('btnSimpanNilai');
    const formLoadingOverlay = document.getElementById('formLoadingOverlay');
    
    // Function to show attractive loading spinner
    function showLoadingSpinner() {
        if (btnSimpanNilai) {
            btnSimpanNilai.classList.add('btn-loading');
            btnSimpanNilai.disabled = true;
            btnSimpanNilai.innerHTML = `
                <div class="btn-spinner">
                    <div class="sk-chase">
                        <div class="sk-chase-dot"></div>
                        <div class="sk-chase-dot"></div>
                        <div class="sk-chase-dot"></div>
                        <div class="sk-chase-dot"></div>
                        <div class="sk-chase-dot"></div>
                        <div class="sk-chase-dot"></div>
                    </div>
                </div>
                <i class="ti ti-device-floppy me-1" style="opacity: 0.5;"></i>
                <span class="btn-text">Menyimpan...</span>
            `;
        }
        
        if (formLoadingOverlay) {
            formLoadingOverlay.classList.add('show');
        }
    }
    
    // Function to hide loading spinner
    function hideLoadingSpinner() {
        if (btnSimpanNilai) {
            btnSimpanNilai.classList.remove('btn-loading');
            btnSimpanNilai.disabled = false;
            btnSimpanNilai.innerHTML = `
                <i class="ti ti-device-floppy me-1"></i>
                <span class="btn-text">Simpan Semua Nilai</span>
            `;
        }
        
        if (formLoadingOverlay) {
            formLoadingOverlay.classList.remove('show');
        }
    }
    
    // Function to hide all status panels when no subject is selected
    function hideStatusPanelsIfNoSubject() {
        if (!mataPelajaranSelect || !mataPelajaranSelect.value) {
            // Hide various possible status panel selectors with more comprehensive approach
            const statusPanelSelectors = [
                '.alert-success',
                '.alert-info', 
                '.alert.alert-success',
                '.alert.alert-info',
                '[class*="alert-success"]',
                '[class*="alert-info"]',
                '.status-panel',
                '#nilai-status-panel',
                '[id*="status"]',
                '[class*="status"]'
            ];
            
            statusPanelSelectors.forEach(selector => {
                try {
                    const panels = document.querySelectorAll(selector);
                    panels.forEach(panel => {
                        // Check if it contains status text about nilai/pengisian
                        const panelText = (panel.textContent || panel.innerText || '').toLowerCase();
                        if (panelText.includes('pengisian') || 
                            panelText.includes('nilai') || 
                            panelText.includes('lengkap') ||
                            panelText.includes('siswa telah diisi') ||
                            panelText.includes('belum ada nilai') ||
                            panelText.includes('sudah diisi') ||
                            panelText.includes('terisi')) {
                            panel.style.display = 'none !important';
                            panel.classList.add('d-none');
                            panel.setAttribute('hidden', 'true');
                        }
                    });
                } catch (e) {
                    console.log('Error hiding panel with selector:', selector);
                }
            });
            
            // More aggressive approach - hide all alerts that might be status related
            const allAlerts = document.querySelectorAll('.alert, [class*="alert"]');
            allAlerts.forEach(alert => {
                try {
                    const alertText = (alert.textContent || alert.innerText || '').toLowerCase();
                    const alertClasses = alert.className.toLowerCase();
                    
                    // Check if it's a status alert about nilai
                    if ((alertClasses.includes('alert-success') || 
                         alertClasses.includes('alert-info') ||
                         alertClasses.includes('success') ||
                         alertClasses.includes('info')) &&
                        (alertText.includes('pengisian') || 
                         alertText.includes('nilai') || 
                         alertText.includes('lengkap') ||
                         alertText.includes('siswa telah diisi') ||
                         alertText.includes('belum ada nilai') ||
                         alertText.includes('sudah diisi') ||
                         alertText.includes('terisi'))) {
                        alert.style.display = 'none !important';
                        alert.classList.add('d-none');
                        alert.setAttribute('hidden', 'true');
                    }
                } catch (e) {
                    console.log('Error processing alert:', e);
                }
            });
        }
    }
    
    // Function to show status panels when subject is selected
    function showStatusPanelsIfSubject() {
        if (mataPelajaranSelect && mataPelajaranSelect.value) {
            // Show previously hidden status panels
            const hiddenPanels = document.querySelectorAll('[style*="display: none"], .d-none');
            hiddenPanels.forEach(panel => {
                const panelText = panel.textContent || panel.innerText || '';
                if (panelText.toLowerCase().includes('pengisian') || 
                    panelText.toLowerCase().includes('nilai') || 
                    panelText.toLowerCase().includes('lengkap')) {
                    panel.style.display = '';
                    panel.classList.remove('d-none');
                }
            });
        }
    }
    
    // Don't hide status panels on page load - let them show naturally
    
    // Hide/show status panels when mata pelajaran changes
    if (mataPelajaranSelect) {
        mataPelajaranSelect.addEventListener('change', function() {
            setTimeout(() => {
                if (this.value) {
                    showStatusPanelsIfSubject();
                } else {
                    hideStatusPanelsIfNoSubject();
                }
            }, 100);
        });
        
        // Also check on page load - multiple times to catch dynamic content
        setTimeout(() => {
            if (!mataPelajaranSelect.value) {
                hideStatusPanelsIfNoSubject();
            }
        }, 500);
        
        setTimeout(() => {
            if (!mataPelajaranSelect.value) {
                hideStatusPanelsIfNoSubject();
            }
        }, 1000);
        
        setTimeout(() => {
            if (!mataPelajaranSelect.value) {
                hideStatusPanelsIfNoSubject();
            }
        }, 2000);
    }
    
    // Add observer to catch dynamically added alerts
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === 'childList') {
                mutation.addedNodes.forEach(function(node) {
                    if (node.nodeType === 1) { // Element node
                        // Check if it's an alert or contains alerts
                        const alerts = node.classList && node.classList.contains('alert') ? [node] : 
                                     node.querySelectorAll ? node.querySelectorAll('.alert') : [];
                        
                        alerts.forEach(alert => {
                            const alertText = (alert.textContent || alert.innerText || '').toLowerCase();
                            if ((alert.classList.contains('alert-success') || 
                                 alert.classList.contains('alert-info')) &&
                                (alertText.includes('pengisian') || 
                                 alertText.includes('nilai') || 
                                 alertText.includes('lengkap') ||
                                 alertText.includes('siswa telah diisi') ||
                                 alertText.includes('belum ada nilai') ||
                                 alertText.includes('sudah diisi') ||
                                 alertText.includes('terisi'))) {
                                
                                // Only hide if no subject is selected
                                if (!mataPelajaranSelect || !mataPelajaranSelect.value) {
                                    alert.style.display = 'none !important';
                                    alert.classList.add('d-none');
                                    alert.setAttribute('hidden', 'true');
                                }
                            }
                        });
                    }
                });
            }
        });
    });
    
    // Start observing
    observer.observe(document.body, {
        childList: true,
        subtree: true
    });
    
    // Force hide specific alert immediately and repeatedly
    function forceHideStatusAlert() {
        // Target the specific alert text
        const alertSelectors = [
            '.alert',
            '[class*="alert"]',
            '.alert-info',
            '.alert-success'
        ];
        
        alertSelectors.forEach(selector => {
            const alerts = document.querySelectorAll(selector);
            alerts.forEach(alert => {
                const alertText = (alert.textContent || alert.innerText || '').toLowerCase();
                if (alertText.includes('belum ada nilai yang diinput') || 
                    alertText.includes('silakan masukkan nilai') ||
                    alertText.includes('belum ada nilai') ||
                    alertText.includes('nilai yang diinput')) {
                    
                    // Only hide if no subject is selected
                    if (!mataPelajaranSelect || !mataPelajaranSelect.value) {
                        alert.style.display = 'none !important';
                        alert.style.visibility = 'hidden !important';
                        alert.style.opacity = '0 !important';
                        alert.style.height = '0 !important';
                        alert.style.margin = '0 !important';
                        alert.style.padding = '0 !important';
                        alert.classList.add('d-none');
                        alert.setAttribute('hidden', 'true');
                        alert.remove(); // Remove completely
                    }
                }
            });
        });
    }
    
    // Run immediately and repeatedly
    forceHideStatusAlert();
    setTimeout(forceHideStatusAlert, 100);
    setTimeout(forceHideStatusAlert, 500);
    setTimeout(forceHideStatusAlert, 1000);
    setTimeout(forceHideStatusAlert, 2000);
    
    // Run every 2 seconds to catch any new alerts
    setInterval(() => {
        if (!mataPelajaranSelect || !mataPelajaranSelect.value) {
            forceHideStatusAlert();
        }
    }, 2000);
    
    // Add body class to control CSS hiding
    function updateBodyClass() {
        if (mataPelajaranSelect && mataPelajaranSelect.value) {
            document.body.classList.add('subject-selected');
        } else {
            document.body.classList.remove('subject-selected');
        }
    }
    
    // Update body class on change
    if (mataPelajaranSelect) {
        mataPelajaranSelect.addEventListener('change', updateBodyClass);
    }
    
    // Set initial state
    updateBodyClass();
});
</script>
@endsection 