<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;

    protected $table = 'semester';
    protected $fillable = [
        'nama',
        'status',
        'tahun_ajaran_id'
    ];

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id');
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'semester_id');
    }
} 