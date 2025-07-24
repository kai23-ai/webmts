@extends('layouts/contentNavbarLayout')

@section('title', 'Lihat Nilai')

@section('content')
<h4 class="py-3 mb-4">
  <span class="text-muted fw-light">Siswa /</span> Lihat Nilai
</h4>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title">Nilai Akademik Siswa</h5>
      </div>
      <div class="card-body">
        <div class="row mb-3">
          <div class="col-md-6">
            <label for="semester" class="form-label">Semester</label>
            <select class="form-select" id="semester">
              <option value="1">Semester 1</option>
              <option value="2">Semester 2</option>
            </select>
          </div>
          <div class="col-md-6">
            <label for="tahun-ajaran" class="form-label">Tahun Ajaran</label>
            <select class="form-select" id="tahun-ajaran">
              <option value="2023/2024">2023/2024</option>
              <option value="2024/2025">2024/2025</option>
            </select>
          </div>
        </div>
        
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>No</th>
                <th>Mata Pelajaran</th>
                <th>Guru</th>
                <th>Nilai Tugas</th>
                <th>Nilai UTS</th>
                <th>Nilai UAS</th>
                <th>Nilai Akhir</th>
                <th>Grade</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>Matematika</td>
                <td>Pak Ahmad</td>
                <td>85</td>
                <td>80</td>
                <td>90</td>
                <td><strong>85</strong></td>
                <td><span class="badge bg-success">A</span></td>
              </tr>
              <tr>
                <td>2</td>
                <td>Fisika</td>
                <td>Bu Siti</td>
                <td>90</td>
                <td>85</td>
                <td>88</td>
                <td><strong>88</strong></td>
                <td><span class="badge bg-success">A</span></td>
              </tr>
              <tr>
                <td>3</td>
                <td>Kimia</td>
                <td>Pak Budi</td>
                <td>75</td>
                <td>80</td>
                <td>82</td>
                <td><strong>79</strong></td>
                <td><span class="badge bg-warning">B</span></td>
              </tr>
              <tr>
                <td>4</td>
                <td>Biologi</td>
                <td>Bu Citra</td>
                <td>88</td>
                <td>85</td>
                <td>90</td>
                <td><strong>88</strong></td>
                <td><span class="badge bg-success">A</span></td>
              </tr>
              <tr>
                <td>5</td>
                <td>Bahasa Indonesia</td>
                <td>Pak Rudi</td>
                <td>92</td>
                <td>88</td>
                <td>90</td>
                <td><strong>90</strong></td>
                <td><span class="badge bg-success">A</span></td>
              </tr>
              <tr>
                <td>6</td>
                <td>Bahasa Inggris</td>
                <td>Bu Linda</td>
                <td>85</td>
                <td>82</td>
                <td>88</td>
                <td><strong>85</strong></td>
                <td><span class="badge bg-success">A</span></td>
              </tr>
            </tbody>
          </table>
        </div>
        
        <div class="row mt-4">
          <div class="col-md-6">
            <div class="card bg-light">
              <div class="card-body">
                <h6 class="card-title">Rata-rata Nilai</h6>
                <h3 class="text-primary">85.8</h3>
                <p class="text-muted mb-0">Dari 6 mata pelajaran</p>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card bg-light">
              <div class="card-body">
                <h6 class="card-title">Grade Rata-rata</h6>
                <h3 class="text-success">A</h3>
                <p class="text-muted mb-0">Sangat Baik</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection 