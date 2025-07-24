@extends('layouts/layoutMaster')

@section('title', 'Tambah Pengumuman')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card">
    <div class="card-header">
      <h5 class="mb-0">Tambah Pengumuman</h5>
    </div>
    <div class="card-body">
      <form action="{{ route('pengumuman.store') }}" method="POST">
        @csrf
        <div class="mb-3">
          <label for="judul" class="form-label">Judul</label>
          <input type="text" class="form-control" id="judul" name="judul" value="{{ old('judul') }}" required>
        </div>
        <div class="mb-3">
          <label for="isi" class="form-label">Isi</label>
          <textarea class="form-control" id="isi" name="isi" rows="4" required>{{ old('isi') }}</textarea>
        </div>
        <div class="mb-3">
          <label for="role" class="form-label">Role</label>
          <select class="form-select" id="role" name="role" required>
            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="guru" {{ old('role') == 'guru' ? 'selected' : '' }}>Guru</option>
            <option value="siswa" {{ old('role') == 'siswa' ? 'selected' : '' }}>Siswa</option>
            <option value="semua" {{ old('role') == 'semua' ? 'selected' : '' }}>Semua</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="status" class="form-label">Status</label>
          <select class="form-select" id="status" name="status" required>
            <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
            <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
          </select>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('pengumuman.index') }}" class="btn btn-secondary">Batal</a>
      </form>
    </div>
  </div>
</div>
@endsection 