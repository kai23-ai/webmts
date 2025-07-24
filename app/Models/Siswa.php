<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswa';
    protected $fillable = [
        'no_induk',
        'nis',
        'nisn',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'email',
        'notelp',
        'foto',
        'status',
    ];
    // Tambahkan fillable/guarded jika perlu

    public function kelasSiswa()
    {
        return $this->hasMany(KelasSiswa::class, 'siswa_id');
    }

    public function kelasAktif()
    {
        return $this->hasOne(KelasSiswa::class, 'siswa_id')
                    ->whereHas('tahunAjaran', function($query) {
                        $query->where('status', 'aktif');
                    });
    }
} 