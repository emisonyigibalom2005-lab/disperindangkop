<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PengajuanBantuan extends Model {
    protected $table = 'pengajuan_bantuan';
    protected $fillable = ['koperasi_id','nama_pemohon','no_hp','email','nama_usaha','jenis_bantuan','jumlah_diajukan','tujuan_penggunaan','status','catatan_admin'];

    public function koperasi() { return $this->belongsTo(Koperasi::class); }
}