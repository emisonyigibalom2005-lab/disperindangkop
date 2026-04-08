<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\KoperasiController as AdminKoperasi;
use App\Http\Controllers\Admin\BantuanController as AdminBantuan;
use App\Http\Controllers\Admin\BeritaController as AdminBerita;
use App\Http\Controllers\Admin\PengumumanController as AdminPengumuman;
use App\Http\Controllers\Admin\UserController as AdminUser;
use App\Http\Controllers\Admin\LaporanController as AdminLaporan;
use App\Http\Controllers\Admin\GaleriController as AdminGaleri;
use App\Http\Controllers\Admin\JadwalController as AdminJadwal;
use App\Http\Controllers\Admin\PelatihanController as AdminPelatihan;
use App\Http\Controllers\Admin\KontakController as AdminKontak;
use App\Http\Controllers\Admin\HalamanStatisController as AdminHalamanStatis;
use App\Http\Controllers\Admin\StrukturController as AdminStruktur;
use App\Http\Controllers\Admin\SettingController as AdminSetting;
use App\Http\Controllers\Admin\AnggotaController;
use App\Http\Controllers\Admin\SimpananController;
use App\Http\Controllers\Petugas\DashboardController as PetugasDashboard;
use App\Http\Controllers\Petugas\KoperasiController as PetugasKoperasi;
use App\Http\Controllers\Petugas\BantuanController as PetugasBantuan;
use App\Http\Controllers\Pimpinan\DashboardController as PimpinanDashboard;
use App\Http\Controllers\Pimpinan\LaporanController as PimpinanLaporan;
use App\Http\Controllers\Koperasi\DashboardController as KoperasiDashboard;
use App\Http\Controllers\Koperasi\ProfileController as KoperasiProfile;
use App\Http\Controllers\Koperasi\BantuanController as KoperasiBantuan;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\NotifikasiController;

// ================= PUBLIC ROUTES =================
Route::get("/", [PublicController::class, "home"])->name("public.home");
Route::get("/tentang", [PublicController::class, "tentang"])->name("public.tentang");
Route::get("/profil", [PublicController::class, "profil"])->name("profil");
Route::get("/profil/{slug}", [PublicController::class, "halaman"])->name("public.halaman");
Route::get("/layanan", [PublicController::class, "layanan"])->name("layanan");
Route::get("/pelatihan", [PublicController::class, "pelatihan"])->name("pelatihan");
Route::get("/pelatihan/{pelatihan}/daftar", [PublicController::class, "pelatihanDaftar"])->name("pelatihan.daftar");
Route::post("/pelatihan/{pelatihan}/daftar", [PublicController::class, "pelatihanDaftarStore"])->name("pelatihan.daftar.store");
Route::get("/bantuan-modal", [PublicController::class, "bantuanModal"])->name("bantuan-modal");
Route::post("/bantuan-modal", [PublicController::class, "bantuanModalStore"])->name("bantuan-modal.store");
Route::get("/statistik", [PublicController::class, "statistik"])->name("statistik");
Route::get("/daftar-koperasi", [PublicController::class, "daftarKoperasi"])->name("daftar-koperasi");
Route::middleware("auth")->group(function() {
    Route::get("/daftar-anggota", [PublicController::class, "daftarAnggota"])->name("daftar-anggota");
    Route::post("/daftar-anggota", [PublicController::class, "daftarAnggotaStore"])->name("daftar-anggota.store");
});
Route::get("/direktori-koperasi", [PublicController::class, "koperasi"])->name("public.koperasi");
Route::get("/direktori-koperasi/{koperasi}", [PublicController::class, "koperasiDetail"])->name("public.koperasi.detail");
Route::get("/berita", [PublicController::class, "berita"])->name("public.berita");
Route::get("/berita/{berita}", [PublicController::class, "beritaDetail"])->name("public.berita.detail");
Route::get("/galeri", [PublicController::class, "galeri"])->name("public.galeri");
Route::get("/jadwal", function () {
    $jadwal = \App\Models\Jadwal::where("is_publik", true)->aktif()->latest("tanggal")->paginate(12);
    return view("public.jadwal", compact("jadwal"));
})->name("public.jadwal");
Route::get("/pengumuman", [PublicController::class, "pengumuman"])->name("public.pengumuman");
Route::get("/pengumuman/{id}/download", [PublicController::class, "downloadPengumuman"])->name("public.pengumuman.download");
Route::get("/kontak", [PublicController::class, "kontak"])->name("public.kontak");
Route::post("/kontak", [PublicController::class, "kontakStore"])->name("public.kontak.store");

// ================= AUTH ROUTES =================
Route::middleware("guest")->group(function () {
    Route::get("/login", [LoginController::class, "showLoginForm"])->name("login");
    Route::post("/login", [LoginController::class, "login"])->name("login.post");
    Route::get("/register", [LoginController::class, "showRegisterForm"])->name("register");
    Route::post("/register", [LoginController::class, "register"])->name("register.post");
    Route::get("/forgot-password", [LoginController::class, "showForgotForm"])->name("password.request");
    Route::post("/forgot-password", [LoginController::class, "sendResetLink"])->name("password.email");
    Route::get("/reset-password/{token}", [LoginController::class, "showResetForm"])->name("password.reset");
    Route::post("/reset-password", [LoginController::class, "resetPassword"])->name("password.update");
});

Route::post("/logout", [LoginController::class, "logout"])->name("logout")->middleware("auth");

Route::get("/dashboard", function () {
    return match (auth()->user()->role) {
        "admin"    => redirect("/admin/dashboard"),
        "petugas"  => redirect("/petugas/dashboard"),
        "pimpinan" => redirect("/pimpinan/dashboard"),
        "koperasi" => redirect("/koperasi-portal/dashboard"),
        default    => abort(403),
    };
})->middleware("auth")->name("dashboard");

// ================= NOTIFIKASI =================
Route::middleware("auth")->group(function () {
    Route::get("/notifikasi", [NotifikasiController::class, "index"])->name("notifikasi.index");
    Route::get("/notifikasi/unread", [NotifikasiController::class, "unread"])->name("notifikasi.unread");
    Route::post("/notifikasi/read-all", [NotifikasiController::class, "readAll"])->name("notifikasi.readAll");
    Route::post("/notifikasi/{notifikasi}/read", [NotifikasiController::class, "read"])->name("notifikasi.read");
    Route::delete("/notifikasi/{notifikasi}", [NotifikasiController::class, "destroy"])->name("notifikasi.destroy");
});

// ================= ADMIN ROUTES =================
Route::prefix("admin")->middleware(["auth","role:admin"])->name("admin.")->group(function () {
    Route::get("/dashboard", [AdminDashboard::class, "index"])->name("dashboard");
    Route::resource("koperasi", AdminKoperasi::class);
    Route::post("/koperasi/{koperasi}/verifikasi", [AdminKoperasi::class, "verifikasi"])->name("koperasi.verifikasi");
    Route::post("/koperasi/{koperasi}/toggle-status", [AdminKoperasi::class, "toggleStatus"])->name("koperasi.toggleStatus");
    Route::get("/koperasi/{koperasi}/dokumen", [AdminKoperasi::class, "dokumen"])->name("koperasi.dokumen");
    Route::post("/koperasi/{koperasi}/upload-dokumen", [AdminKoperasi::class, "uploadDokumen"])->name("koperasi.uploadDokumen");
    Route::delete("/koperasi/dokumen/{dokumen}", [AdminKoperasi::class, "hapusDokumen"])->name("koperasi.hapusDokumen");
    Route::resource("bantuan", AdminBantuan::class);
    Route::get("/bantuan/{bantuan}/penerima", [AdminBantuan::class, "penerima"])->name("bantuan.penerima");
    Route::post("/bantuan/{bantuan}/tambah-penerima", [AdminBantuan::class, "tambahPenerima"])->name("bantuan.tambahPenerima");
    Route::post("/bantuan/penerima/{penerima}/validasi", [AdminBantuan::class, "validasiPenerima"])->name("bantuan.validasiPenerima");
    Route::get("/bantuan/penerima/{penerima}/cetak-sk", [AdminBantuan::class, "cetakSk"])->name("bantuan.cetakSk");
    Route::resource("berita", AdminBerita::class)->parameters(["berita" => "berita"]);
    Route::post("/berita/{berita}/publish", [AdminBerita::class, "publish"])->name("berita.publish");
    Route::resource("pengumuman", AdminPengumuman::class);
    Route::post("/pengumuman/{pengumuman}/toggle", [AdminPengumuman::class, "toggle"])->name("pengumuman.toggle");
    Route::get("/pengumuman/{id}/download", [AdminPengumuman::class, "download"])->name("public.pengumuman.download");
    Route::get("/galeri/foto", function () {
        $galeri = \App\Models\Galeri::where("tipe","foto")->paginate(8);
        return view("admin.galeri.index", compact("galeri"));
    })->name("admin.galeri.foto");
    Route::get("/galeri/video", function () {
        $galeri = \App\Models\Galeri::where("tipe","video")->paginate(8);
        return view("admin.galeri.index", compact("galeri"));
    })->name("admin.galeri.video");
    Route::resource("galeri", AdminGaleri::class);
    Route::resource("jadwal", AdminJadwal::class);
    Route::post("/jadwal/{jadwal}/status", [AdminJadwal::class, "updateStatus"])->name("jadwal.updateStatus");
    Route::resource("pelatihan", AdminPelatihan::class);
    Route::get("/pelatihan/{pelatihan}/peserta", [AdminPelatihan::class, "peserta"])->name("pelatihan.peserta");
    Route::put("/pelatihan/peserta/{pendaftaran}/status", [AdminPelatihan::class, "updateStatusPeserta"])->name("pelatihan.peserta.status");
    Route::get("/kontak", [AdminKontak::class, "index"])->name("kontak.index");
    Route::get("/kontak/create", [AdminKontak::class, "create"])->name("kontak.create");
    Route::post("/kontak", [AdminKontak::class, "store"])->name("kontak.store");
    Route::get("/kontak/{id}", [AdminKontak::class, "show"])->name("kontak.show");
    Route::delete("/kontak/{id}", [AdminKontak::class, "destroy"])->name("kontak.destroy");
    Route::resource("halaman-statis", AdminHalamanStatis::class);
    Route::resource("struktur", AdminStruktur::class);
    Route::get("/struktur-bagan", [AdminStruktur::class, "bagan"])->name("struktur.bagan");
    Route::post("/struktur-bagan", [AdminStruktur::class, "uploadBagan"])->name("struktur.bagan.upload");
    Route::delete("/struktur-bagan", [AdminStruktur::class, "hapusBagan"])->name("struktur.bagan.hapus");
    Route::get("/laporan", [AdminLaporan::class, "index"])->name("laporan.index");
    Route::get("/laporan/koperasi", [AdminLaporan::class, "koperasi"])->name("laporan.koperasi");
    Route::get("/laporan/bantuan", [AdminLaporan::class, "bantuan"])->name("laporan.bantuan");
    Route::get("/laporan/sertifikat", [AdminLaporan::class, "sertifikat"])->name("laporan.sertifikat");
    Route::get("/laporan/sertifikat/{koperasi}/cetak", [AdminLaporan::class, "cetakSertifikat"])->name("laporan.cetakSertifikat");
    Route::get("/laporan/export-pdf", [AdminLaporan::class, "exportPdf"])->name("laporan.exportPdf");
    Route::get("/laporan/export-excel", [AdminLaporan::class, "exportExcel"])->name("laporan.exportExcel");
    Route::get("/laporan/export-word", [AdminLaporan::class, "exportWord"])->name("laporan.exportWord");
    Route::get("/users", [AdminUser::class, "index"])->name("users.index");
    Route::get("/users/create", [AdminUser::class, "create"])->name("users.create");
    Route::post("/users", [AdminUser::class, "store"])->name("users.store");
    Route::get("/users/{user}", [AdminUser::class, "show"])->name("users.show");
    Route::get("/users/{user}/edit", [AdminUser::class, "edit"])->name("users.edit");
    Route::put("/users/{user}", [AdminUser::class, "update"])->name("users.update");
    Route::delete("/users/{user}", [AdminUser::class, "destroy"])->name("users.destroy");
    Route::post("/users/{user}/toggle-active", [AdminUser::class, "toggleActive"])->name("users.toggleActive");
    Route::get("/activity-log", [AdminUser::class, "activityLog"])->name("users.activityLog");
    Route::get("/profile", [AdminUser::class, "profile"])->name("profile");
    Route::put("/profile", [AdminUser::class, "updateProfile"])->name("profile.update");
    Route::get("/settings", [AdminSetting::class, "index"])->name("settings.index");
    Route::put("/settings", [AdminSetting::class, "update"])->name("settings.update");
    Route::resource("anggota", AnggotaController::class)->parameters(["anggota" => "anggota"]);
    Route::get("/anggota/{anggota}/sertifikat", [AnggotaController::class, "sertifikat"])->name("anggota.sertifikat");
    Route::put("/anggota/{anggota}/status", [AnggotaController::class, "updateStatus"])->name("anggota.status");
    Route::post("/simpanan", [SimpananController::class, "store"])->name("simpanan.store");
    Route::get("/pengajuan-bantuan", [\App\Http\Controllers\Admin\PengajuanBantuanController::class, "index"])->name("pengajuan-bantuan.index");
    Route::get("/pengajuan-bantuan/{pengajuan_bantuan}", [\App\Http\Controllers\Admin\PengajuanBantuanController::class, "show"])->name("pengajuan-bantuan.show");
    Route::put("/pengajuan-bantuan/{pengajuan_bantuan}", [\App\Http\Controllers\Admin\PengajuanBantuanController::class, "update"])->name("pengajuan-bantuan.update");
    Route::delete("/pengajuan-bantuan/{pengajuan_bantuan}", [\App\Http\Controllers\Admin\PengajuanBantuanController::class, "destroy"])->name("pengajuan-bantuan.destroy");
});

// ================= PETUGAS ROUTES =================
Route::prefix("petugas")->middleware(["auth","role:petugas"])->name("petugas.")->group(function () {
    Route::get("/dashboard", [PetugasDashboard::class, "index"])->name("dashboard");
    Route::get("/profile", [PetugasDashboard::class, "profile"])->name("profile");
    Route::put("/profile", [PetugasDashboard::class, "updateProfile"])->name("profile.update");
    Route::resource("koperasi", PetugasKoperasi::class);
    Route::post("/koperasi/{koperasi}/verifikasi", [PetugasKoperasi::class, "verifikasi"])->name("koperasi.verifikasi");
    Route::post("/koperasi/{koperasi}/toggle-status", [PetugasKoperasi::class, "toggleStatus"])->name("koperasi.toggleStatus");
    Route::post("/koperasi/{koperasi}/upload-dokumen", [PetugasKoperasi::class, "uploadDokumen"])->name("koperasi.uploadDokumen");
    Route::resource("bantuan", PetugasBantuan::class)->only(["index","show"]);
    Route::get("/bantuan/{bantuan}/penerima", [PetugasBantuan::class, "penerima"])->name("bantuan.penerima");
    Route::post("/bantuan/{bantuan}/tambah-penerima", [PetugasBantuan::class, "tambahPenerima"])->name("bantuan.tambahPenerima");
    Route::post("/bantuan/penerima/{penerima}/validasi", [PetugasBantuan::class, "validasiPenerima"])->name("bantuan.validasiPenerima");
    Route::get("/bantuan/penerima/{penerima}/cetak-sk", [PetugasBantuan::class, "cetakSk"])->name("bantuan.cetakSk");
    Route::get("/jadwal", [\App\Http\Controllers\Petugas\JadwalController::class, "index"])->name("jadwal.index");
    Route::get("/jadwal/{jadwal}", [\App\Http\Controllers\Petugas\JadwalController::class, "show"])->name("jadwal.show");
    Route::post("/jadwal/{jadwal}/status", [\App\Http\Controllers\Petugas\JadwalController::class, "updateStatus"])->name("jadwal.updateStatus");
});

// ================= PIMPINAN ROUTES =================
Route::prefix("pimpinan")->middleware(["auth","role:pimpinan"])->name("pimpinan.")->group(function () {
    Route::get("/dashboard", [PimpinanDashboard::class, "index"])->name("dashboard");
    Route::get("/koperasi", [PimpinanDashboard::class, "koperasi"])->name("koperasi");
    Route::get("/koperasi/{koperasi}", [PimpinanDashboard::class, "showKoperasi"])->name("koperasi.show");
    Route::get("/laporan", [PimpinanLaporan::class, "index"])->name("laporan.index");
    Route::get("/laporan/bantuan", [PimpinanLaporan::class, "bantuan"])->name("laporan.bantuan");
    Route::get("/laporan/export-pdf", [PimpinanLaporan::class, "exportPdf"])->name("laporan.exportPdf");
    Route::get("/laporan/export-excel", [PimpinanLaporan::class, "exportExcel"])->name("laporan.exportExcel");
    Route::get("/jadwal", [\App\Http\Controllers\Pimpinan\DashboardController::class, "jadwal"])->name("jadwal.index");
    Route::get("/profile", [PimpinanDashboard::class, "profile"])->name("profile");
    Route::put("/profile", [PimpinanDashboard::class, "updateProfile"])->name("profile.update");
});

// ================= KOPERASI PORTAL =================
Route::middleware(["auth","role:koperasi"])->prefix("koperasi-portal")->name("koperasi.")->group(function () {
    Route::get('/daftar', [App\Http\Controllers\Koperasi\DashboardController::class, 'daftar'])->name('daftar');
    Route::get("/dashboard", [KoperasiDashboard::class, "index"])->name("dashboard");
    Route::get("/profile", [KoperasiProfile::class, "show"])->name("profile");
    Route::put("/profile", [KoperasiProfile::class, "update"])->name("profile.update");
    Route::post("/profile/upload-dokumen", [KoperasiProfile::class, "uploadDokumen"])->name("profile.uploadDokumen");
    Route::get("/bantuan", [KoperasiBantuan::class, "index"])->name("bantuan.index");
    Route::get("/bantuan/{bantuan}", [KoperasiBantuan::class, "show"])->name("bantuan.show");
    Route::get("/riwayat", [KoperasiBantuan::class, "riwayat"])->name("bantuan.riwayat");
    Route::get("/jadwal", [KoperasiBantuan::class, "jadwal"])->name("bantuan.jadwal");
    Route::get("/notifikasi", [KoperasiDashboard::class, "notifikasi"])->name("notifikasi");
    Route::post("/notifikasi/{notifikasi}/read", [KoperasiDashboard::class, "readNotifikasi"])->name("notifikasi.read");
});

// ================= ANGGOTA =================
Route::get("/anggota/{anggota}/print", [AnggotaController::class, "print"])->name("anggota.print");
Route::post("/simpanan", [SimpananController::class, "store"])->name("simpanan.store");
// Portal Anggota
Route::middleware(['auth','role:anggota'])->prefix('anggota-portal')->name('anggota.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Anggota\PortalAnggotaController::class, 'dashboard'])->name('dashboard');
    Route::get('/kartu', [App\Http\Controllers\Anggota\PortalAnggotaController::class, 'kartu'])->name('kartu');
    Route::get('/profil', [App\Http\Controllers\Anggota\PortalAnggotaController::class, 'profil'])->name('profil');
});

// Portal Anggota
Route::middleware(['auth','role:anggota'])->prefix('anggota-portal')->name('anggota.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Anggota\PortalAnggotaController::class, 'dashboard'])->name('dashboard');
    Route::get('/kartu', [App\Http\Controllers\Anggota\PortalAnggotaController::class, 'kartu'])->name('kartu');
    Route::get('/profil', [App\Http\Controllers\Anggota\PortalAnggotaController::class, 'profil'])->name('profil');
});

// Dokumen Anggota
Route::get('/admin/anggota-dokumen', [App\Http\Controllers\Admin\AnggotaController::class, 'dokumen'])->name('admin.anggota.dokumen')->middleware(['auth','role:admin']);
