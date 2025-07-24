@extends('layouts/layoutMaster')

@section('title', 'Detail Pengumuman')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card">
    <div class="card-header">
      <h5 class="mb-0">Detail Pengumuman</h5>
    </div>
    <div class="card-body">
      <dl class="row">
        <dt class="col-sm-3">Judul</dt>
        <dd class="col-sm-9">{{ $announcement->judul }}</dd>
        <dt class="col-sm-3">Isi</dt>
        <dd class="col-sm-9">{{ $announcement->isi }}</dd>
        <dt class="col-sm-3">Role</dt>
        <dd class="col-sm-9">{{ ucfirst($announcement->role) }}</dd>
        <dt class="col-sm-3">Status</dt>
        <dd class="col-sm-9">
          @if($announcement->status == 'aktif')
            <span class="badge bg-success">Aktif</span>
          @else
            <span class="badge bg-secondary">Nonaktif</span>
          @endif
        </dd>
      </dl>
      <a href="{{ route('pengumuman.index') }}" class="btn btn-secondary">Kembali</a>
      <a href="{{ route('pengumuman.edit', $announcement->id) }}" class="btn btn-warning">Edit</a>
    </div>
  </div>
</div>
@endsection 