<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Koperasi extends Model
{
    protected $table = 'koperasi';
    use HasFactory;

    protected $fillable = [
        'user_id', 'no_registrasi', 'no_ktp', 'nama_pemilik', 'nama_usaha',
        'jenis_usaha', 'kategori', 'alamat', 'distrik', 'kelurahan',
        'no_telp', 'email', 'modal_usaha', 'omset_per_bulan', 'jumlah_karyawan',
        'status_verifikasi', 'status_usaha', 'catatan_verifikasi',
        'verified_by', 'verified_at', 'foto_usaha',
    ];

    protected $casts = [
        'verified_at'    => 'datetime',
        'modal_usaha'    => 'decimal:2',
        'omset_per_bulan'=> 'decimal:2',
    ];

    // ── Relasi ──────────────────────────────────────────────
    public function user()        { return $this->belongsTo(User::class); }
    public function verifiedBy()  { return $this->belongsTo(User::class, 'verified_by'); }
    public function dokumen()     { return $this->hasMany(DokumenKoperasi::class, 'koperasi_id'); }
    public function penerimaBantuan() { return $this->hasMany(PenerimaBantuan::class, 'koperasi_id'); }

    // ── Scope ──────────────────────────────────────────────
    public function scopeVerified($q)   { return $q->where('status_verifikasi', 'diverifikasi'); }
    public function scopePending($q)    { return $q->where('status_verifikasi', 'pending'); }
    public function scopeAktif($q)      { return $q->where('status_usaha', 'aktif'); }
    public function scopeByDistrik($q, $distrik) { return $q->where('distrik', $distrik); }

    // ── Helper ──────────────────────────────────────────────
    public function getStatusVerifikasiLabelAttribute(): string
    {
        return match ($this->status_verifikasi) {
            'pending'      => '<span class="badge badge-warning">Pending</span>',
            'diverifikasi' => '<span class="badge badge-success">Terverifikasi</span>',
            'ditolak'      => '<span class="badge badge-danger">Ditolak</span>',
            default        => $this->status_verifikasi,
        };
    }

    public function getStatusUsahaLabelAttribute(): string
    {
        return $this->status_usaha === 'aktif'
            ? '<span class="badge badge-success">Aktif</span>'
            : '<span class="badge badge-secondary">Tidak Aktif</span>';
    }

    public function getKategoriLabelAttribute(): string
    {
        return match ($this->kategori) {
            'mikro'    => 'Usaha Mikro',
            'kecil'    => 'Usaha Kecil',
            'menengah' => 'Usaha Menengah',
            default    => ucfirst($this->kategori),
        };
    }

    public static function generateNoRegistrasi(): string
    {
        $year    = date('Y');
        $lastId  = static::whereYear('created_at', $year)->max('id') ?? 0;
        $seq     = str_pad($lastId + 1, 4, '0', STR_PAD_LEFT);
        return "KOPERASI-{$year}-{$seq}";
    }

    // ── Distrik Tolikara ──────────────────────────────────
    public static function listDistrik(): array
    {
        return [
            'Karubaga', 'Tiom', 'Kembu', 'Bokondini', 'Kanggime',
            'Kondaga', 'Numba', 'Kuari', 'Gilubandu', 'Apalapsili',
            'Bokoneri', 'Goti', 'Wunin', 'Yuneri', 'Panaga',
            'Dow', 'Nelawi', 'Airgaram', 'Geya', 'Angguruk',
            'Ninia', 'Suru-Suru', 'Korupun', 'Nalca', 'Ukha',
            'Tariangga', 'Bewani', 'Dundu', 'Nabunage', 'Kona',
        ];
    }
}