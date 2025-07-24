<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RankingSiswa extends Model
{
    use HasFactory;

    protected $table = 'ranking_siswa';

    protected $fillable = [
        'kelas_siswa_id',
        'wali_kelas_id',
        'tahun_ajaran_id',
        'semester_id',
        'posisi',
        'nilai_rata_rata',
        'catatan'
    ];

    protected $casts = [
        'nilai_rata_rata' => 'decimal:2',
        'posisi' => 'integer'
    ];

    /**
     * Relationship with Siswa (through KelasSiswa)
     */
    public function siswa()
    {
        return $this->hasOneThrough(Siswa::class, KelasSiswa::class, 'id', 'id', 'kelas_siswa_id', 'siswa_id');
    }

    /**
     * Relationship with Kelas (through WaliKelas)
     */
    public function kelas()
    {
        return $this->hasOneThrough(Kelas::class, WaliKelas::class, 'id', 'id', 'wali_kelas_id', 'kelas_id');
    }

    /**
     * Relationship with TahunAjaran
     */
    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id');
    }

    /**
     * Relationship with KelasSiswa
     */
    public function kelasSiswa()
    {
        return $this->belongsTo(KelasSiswa::class, 'kelas_siswa_id');
    }

    /**
     * Relationship with WaliKelas
     */
    public function waliKelas()
    {
        return $this->belongsTo(WaliKelas::class, 'wali_kelas_id');
    }

    /**
     * Relationship with Semester
     */
    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }

    /**
     * Scope for active academic year
     */
    public function scopeActiveYear($query)
    {
        return $query->whereHas('tahunAjaran', function($q) {
            $q->where('aktif', true);
        });
    }

    /**
     * Scope for specific class
     */
    public function scopeForClass($query, $kelasId)
    {
        return $query->where('kelas_id', $kelasId);
    }

    /**
     * Scope ordered by position
     */
    public function scopeOrderedByPosition($query)
    {
        return $query->orderBy('posisi');
    }

    /**
     * Get ranking badge class based on position
     */
    public function getRankBadgeClassAttribute()
    {
        switch ($this->posisi) {
            case 1:
                return 'rank-1';
            case 2:
                return 'rank-2';
            case 3:
                return 'rank-3';
            default:
                return 'rank-other';
        }
    }

    /**
     * Get ranking medal icon based on position
     */
    public function getRankIconAttribute()
    {
        switch ($this->posisi) {
            case 1:
                return 'ti-trophy';
            case 2:
                return 'ti-medal-2';
            case 3:
                return 'ti-medal';
            default:
                return 'ti-award';
        }
    }
}