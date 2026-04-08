<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model {
    protected $table = 'anggotas';
    protected $fillable = [
        'user_id','no_anggota','nik','nama','tempat_lahir','tanggal_lahir',
        'jenis_kelamin','agama','no_hp','email','desa','distrik','kabupaten',
        'alamat_lengkap','nama_komplek_dekat_desa','nama_usaha','modal_usaha',
        'omzet_per_bulan','total_simpanan','keterangan_usaha','foto','status',
        'catatan_admin','tanggal_verifikasi'
    ];
    protected $casts = ['tanggal_lahir'=>'date','tanggal_verifikasi'=>'datetime'];

    public function user() { return $this->belongsTo(User::class); }

    public function getFotoUrlAttribute() {
        return $this->foto ? asset('storage/'.$this->foto) : asset('adminlte/dist/img/user2-160x160.jpg');
    }
    public function getUmurAttribute() {
        return $this->tanggal_lahir ? $this->tanggal_lahir->age : '-';
    }
    public static function generateNoAnggota() {
        $year = date('Y'); $month = date('m');
        $last = self::where('no_anggota','like',"AG{$year}{$month}%")->orderBy('no_anggota','desc')->first();
        $seq = $last ? (intval(substr($last->no_anggota,-4))+1) : 1;
        return "AG{$year}{$month}".str_pad($seq,4,'0',STR_PAD_LEFT);
    }
}
