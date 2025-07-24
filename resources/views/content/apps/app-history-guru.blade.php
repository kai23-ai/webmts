@extends('layouts/contentNavbarLayout')

@section('title', 'History Guru')

@section('content')
<h4 class="py-3 mb-4">
  <span class="text-muted fw-light">Guru /</span> History
</h4>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title">History Aktivitas Guru</h5>
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
                <td>Input Nilai</td>
                <td>Mata Pelajaran Matematika Kelas X-A</td>
                <td><span class="badge bg-success">Selesai</span></td>
              </tr>
              <tr>
                <td>2024-01-14</td>
                <td>Input Nilai</td>
                <td>Mata Pelajaran Fisika Kelas XI-B</td>
                <td><span class="badge bg-success">Selesai</span></td>
              </tr>
              <tr>
                <td>2024-01-13</td>
                <td>Input Nilai</td>
                <td>Mata Pelajaran Kimia Kelas XII-C</td>
                <td><span class="badge bg-warning">Pending</span></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection 