@extends('layouts/layoutMaster')

@section('title', 'Edit Pengumuman')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card">
    <div class="card-header">
      <h5 class="mb-0">Edit Pengumuman</h5>
    </div>
    <div class="card-body">
      <form action="{{ route('pengumuman.update', $announcement->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
          <label for="judul" class="form-label">Judul</label>
          <input type="text" class="form-control" id="judul" name="judul" value="{{ old('judul', $announcement->judul) }}" required>
        </div>
        <div class="mb-3">
          <label for="isi" class="form-label">Isi</label>
          <textarea class="form-control" id="isi" name="isi" rows="4" required>{{ old('isi', $announcement->isi) }}</textarea>
        </div>
        <div class="mb-3">
          <label for="role" class="form-label">Role</label>
          <select class="form-select" id="role" name="role" required>
            <option value="admin" {{ old('role', $announcement->role) == 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="guru" {{ old('role', $announcement->role) == 'guru' ? 'selected' : '' }}>Guru</option>
            <option value="siswa" {{ old('role', $announcement->role) == 'siswa' ? 'selected' : '' }}>Siswa</option>
            <option value="semua" {{ old('role', $announcement->role) == 'semua' ? 'selected' : '' }}>Semua</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="status" class="form-label">Status</label>
          <select class="form-select" id="status" name="status" required>
            <option value="aktif" {{ old('status', $announcement->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
            <option value="nonaktif" {{ old('status', $announcement->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
          </select>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('pengumuman.index') }}" class="btn btn-secondary">Batal</a>
      </form>
    </div>
  </div>
</div>
@endsection 