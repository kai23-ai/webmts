<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;
    protected $table = 'kelas';
    protected $fillable = ['kode_kelas', 'nama_kelas', 'status'];
    
    public function waliKelas()
    {
        return $this->hasMany(WaliKelas::class, 'kelas_id');
    }

    public function waliKelasAktif()
    {
        return $this->hasOne(WaliKelas::class, 'kelas_id')
                    ->whereHas('tahunAjaran', function($query) {
                        $query->where('status', 'aktif');
                    });
    }
} 