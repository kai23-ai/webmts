<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NilaiMuatanLokal extends Model
{
    protected $table = 'nilai_muatan_lokal';
    protected $fillable = [
        'kelas_siswa_id',
        'wali_kelas_id',
        'muatan_lokal_id',
        'semester_id',
        'nilai_akhir',
        'capaian_kompetensi',
    ];

    public function kelasSiswa()
    {
        return $this->belongsTo(KelasSiswa::class, 'kelas_siswa_id');
    }

    public function waliKelas()
    {
        return $this->belongsTo(WaliKelas::class, 'wali_kelas_id');
    }

    public function muatanLokal()
    {
        return $this->belongsTo(MuatanLokal::class, 'muatan_lokal_id');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }
} 