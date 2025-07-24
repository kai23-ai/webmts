@extends('layouts/contentNavbarLayout')

@section('title', 'Histori Siswa')

@section('content')
<h4 class="py-3 mb-4">
  <span class="text-muted fw-light">Siswa /</span> Histori
</h4>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title">Histori Aktivitas Siswa</h5>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Tanggal</th>
                <th>Aktivitas</th>
                <th>Keterangan</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>2024-01-15</td>
                <td>Login Sistem</td>
                <td>Mengakses SIAKAD</td>
                <td><span class="badge bg-success">Berhasil</span></td>
              </tr>
              <tr>
                <td>2024-01-14</td>
                <td>Lihat Nilai</td>
                <td>Mata Pelajaran Matematika</td>
                <td><span class="badge bg-success">Berhasil</span></td>
              </tr>
              <tr>
                <td>2024-01-13</td>
                <td>Lihat Nilai</td>
                <td>Mata Pelajaran Fisika</td>
                <td><span class="badge bg-success">Berhasil</span></td>
              </tr>
              <tr>
                <td>2024-01-12</td>
                <td>Lihat Nilai</td>
                <td>Mata Pelajaran Kimia</td>
                <td><span class="badge bg-success">Berhasil</span></td>
              </tr>
              <tr>
                <td>2024-01-11</td>
                <td>Login Sistem</td>
                <td>Mengakses SIAKAD</td>
                <td><span class="badge bg-success">Berhasil</span></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection 