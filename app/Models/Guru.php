<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $table = 'guru';
    protected $fillable = [
        'nip',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'status',
        'email',
        'notelp',
        'foto',
    ];
    // Tambahkan fillable/guarded jika perlu

    public function users()
    {
        return $this->hasMany(User::class, 'guru_id');
    }

    public function wali_kelas()
    {
        return $this->hasOne(WaliKelas::class, 'guru_id');
    }
} 