<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Daftar Koperasi | DISPERINDAGKOP Tolikara</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
:root{--navy:#0d2240;--blue:#1a3a6e;--red:#c8102e;--gold:#f5a623;--gray-50:#f8fafc;--gray-200:#e2e8f0;--gray-400:#94a3b8;--gray-600:#475569;--gray-800:#1e293b;}
*{margin:0;padding:0;box-sizing:border-box;}
body{font-family:'Plus Jakarta Sans',sans-serif;min-height:100vh;background:linear-gradient(135deg,#0d2240,#1a3a6e);padding:30px 16px;display:flex;align-items:flex-start;justify-content:center;}
.card{background:#fff;border-radius:20px;width:100%;max-width:680px;box-shadow:0 30px 80px rgba(0,0,0,.4);overflow:hidden;margin:auto;}
.card-stripe{height:4px;background:linear-gradient(90deg,var(--blue),var(--gold),var(--red));}
.card-header{background:linear-gradient(135deg,var(--navy),var(--blue));padding:28px 40px;display:flex;align-items:center;gap:16px;}
.header-logo{width:50px;height:50px;background:linear-gradient(135deg,var(--gold),#fdb944);border-radius:14px;display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 6px 18px rgba(245,166,35,.35);}
.header-logo i{font-size:22px;color:var(--navy);}
.header-text h2{font-size:1.3rem;font-weight:800;color:#fff;margin-bottom:3px;}
.header-text p{font-size:12.5px;color:rgba(255,255,255,.55);}
.card-body{padding:36px 40px;}
.section-title{font-size:11px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--gold);margin-bottom:16px;padding-bottom:8px;border-bottom:1px solid var(--gray-200);}
.row{display:grid;grid-template-columns:1fr 1fr;gap:16px;}
.row.full{grid-template-columns:1fr;}
.field{margin-bottom:16px;}
.field-label{display:block;font-size:11.5px;font-weight:700;color:var(--gray-600);margin-bottom:7px;letter-spacing:.3px;text-transform:uppercase;}
.field-label span{color:var(--red);}
.field-wrap{position:relative;}
.field-icon{position:absolute;left:13px;top:50%;transform:translateY(-50%);color:var(--gray-400);font-size:13px;pointer-events:none;transition:color .2s;}
.field-wrap:focus-within .field-icon{color:var(--blue);}
.field-wrap input,.field-wrap select,.field-wrap textarea{width:100%;padding:11px 13px 11px 38px;background:var(--gray-50);border:2px solid var(--gray-200);border-radius:9px;font-size:13.5px;font-family:'Plus Jakarta Sans',sans-serif;color:var(--gray-800);outline:none;transition:all .2s;}
.field-wrap textarea{padding-top:11px;min-height:80px;resize:vertical;}
.field-wrap input:focus,.field-wrap select:focus,.field-wrap textarea:focus{background:#fff;border-color:var(--blue);box-shadow:0 0 0 4px rgba(26,58,110,.07);}
.field-wrap input.is-invalid,.field-wrap select.is-invalid{border-color:#f43f5e;background:#fff1f2;}
.err-msg{font-size:11.5px;color:#f43f5e;margin-top:4px;display:flex;align-items:center;gap:4px;}
.alert-danger{display:flex;align-items:flex-start;gap:10px;padding:12px 14px;border-radius:10px;font-size:13px;margin-bottom:20px;background:#fff1f2;border:1px solid #fecdd3;color:#be123c;}
.btn-submit{width:100%;padding:14px;background:linear-gradient(135deg,var(--blue),#2451a3);color:#fff;border:none;border-radius:11px;font-size:14px;font-weight:700;font-family:'Plus Jakarta Sans',sans-serif;letter-spacing:.8px;text-transform:uppercase;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:10px;transition:all .25s;box-shadow:0 4px 16px rgba(26,58,110,.25);margin-top:8px;}
.btn-submit:hover{background:linear-gradient(135deg,var(--navy),var(--blue));transform:translateY(-1px);}
.login-row{text-align:center;margin-top:16px;font-size:13px;color:var(--gray-400);}
.login-row a{color:var(--blue);font-weight:700;text-decoration:none;}
.login-row a:hover{color:var(--gold);}
.pw-toggle{position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--gray-400);font-size:13px;}
.pw-toggle:hover{color:var(--blue);}
@media(max-width:600px){.row{grid-template-columns:1fr;}.card-body{padding:24px 20px;}.card-header{padding:20px;}}
</style>
</head>
<body>
<div class="card">
    <div class="card-stripe"></div>
    <div class="card-header">
        <div class="header-logo" style="background:none;box-shadow:none;"><img src="{{ asset('images/logo.login.png') }}" alt="Logo Tolikara" style="height:50px;width:auto;"></div>
        <div class="header-text">
            <h2>Registrasi</h2>
            <p>DISPERINDAGKOP Kabupaten Tolikara — Papua Pegunungan</p>
        </div>
    </div>
    <div class="card-body">

        @if($errors->any())
        <div class="alert-danger"><i class="fas fa-exclamation-circle"></i><span>{{ $errors->first() }}</span></div>
        @endif

        <form method="POST" action="{{ route('register.post') }}">
            @csrf

            {{-- DATA PEMILIK --}}
            <p class="section-title"><i class="fas fa-user mr-2"></i>Data Pemilik</p>
            <div class="row">
                <div class="field">
                    <label class="field-label">Nama Lengkap <span>*</span></label>
                    <div class="field-wrap">
                        <i class="fas fa-user field-icon"></i>
                        <input type="text" name="name" class="{{ $errors->has('name') ? 'is-invalid' : '' }}" placeholder="Nama sesuai KTP" value="{{ old('name') }}" required>
                    </div>
                    @error('name')<div class="err-msg"><i class="fas fa-exclamation-circle"></i>{{ $message }}</div>@enderror
                </div>
                <div class="field">
                    <label class="field-label">No. KTP <span>*</span></label>
                    <div class="field-wrap">
                        <i class="fas fa-id-card field-icon"></i>
                        <input type="text" name="no_ktp" class="{{ $errors->has('no_ktp') ? 'is-invalid' : '' }}" placeholder="16 digit NIK" value="{{ old('no_ktp') }}" maxlength="16" required>
                    </div>
                    @error('no_ktp')<div class="err-msg"><i class="fas fa-exclamation-circle"></i>{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="row">
                <div class="field">
                    <label class="field-label">Email <span>*</span></label>
                    <div class="field-wrap">
                        <i class="fas fa-envelope field-icon"></i>
                        <input type="email" name="email" class="{{ $errors->has('email') ? 'is-invalid' : '' }}" placeholder="email@contoh.com" value="{{ old('email') }}" required>
                    </div>
                    @error('email')<div class="err-msg"><i class="fas fa-exclamation-circle"></i>{{ $message }}</div>@enderror
                </div>
                <div class="field">
                    <label class="field-label">No. Telepon</label>
                    <div class="field-wrap">
                        <i class="fas fa-phone field-icon"></i>
                        <input type="text" name="phone" placeholder="08xxxxxxxxxx" value="{{ old('phone') }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="field">
                    <label class="field-label">Password <span>*</span></label>
                    <div class="field-wrap">
                        <i class="fas fa-lock field-icon"></i>
                        <input type="password" id="password" name="password" class="{{ $errors->has('password') ? 'is-invalid' : '' }}" placeholder="Minimal 8 karakter" required>
                        <button type="button" class="pw-toggle" onclick="togglePw('password','ic1')"><i class="fas fa-eye" id="ic1"></i></button>
                    </div>
                    @error('password')<div class="err-msg"><i class="fas fa-exclamation-circle"></i>{{ $message }}</div>@enderror
                </div>
                <div class="field">
                    <label class="field-label">Konfirmasi Password <span>*</span></label>
                    <div class="field-wrap">
                        <i class="fas fa-lock field-icon"></i>
                        <input type="password" id="password2" name="password_confirmation" placeholder="Ulangi password" required>
                        <button type="button" class="pw-toggle" onclick="togglePw('password2','ic2')"><i class="fas fa-eye" id="ic2"></i></button>
                    </div>
                </div>
            </div>

            {{-- DATA USAHA --}}
            <p class="section-title mt-2"><i class="fas fa-store mr-2"></i>Data Usaha</p>
            <div class="row">
                <div class="field">
                    <label class="field-label">Nama Usaha <span>*</span></label>
                    <div class="field-wrap">
                        <i class="fas fa-store field-icon"></i>
                        <input type="text" name="nama_usaha" class="{{ $errors->has('nama_usaha') ? 'is-invalid' : '' }}" placeholder="Nama usaha/toko" value="{{ old('nama_usaha') }}" required>
                    </div>
                    @error('nama_usaha')<div class="err-msg"><i class="fas fa-exclamation-circle"></i>{{ $message }}</div>@enderror
                </div>
                <div class="field">
                    <label class="field-label">Jenis Usaha <span>*</span></label>
                    <div class="field-wrap">
                        <i class="fas fa-tag field-icon"></i>
                        <input type="text" name="jenis_usaha" class="{{ $errors->has('jenis_usaha') ? 'is-invalid' : '' }}" placeholder="Contoh: Kuliner, Kerajinan" value="{{ old('jenis_usaha') }}" required>
                    </div>
                    @error('jenis_usaha')<div class="err-msg"><i class="fas fa-exclamation-circle"></i>{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="row">
                <div class="field">
                    <label class="field-label">Distrik <span>*</span></label>
                    <div class="field-wrap">
                        <i class="fas fa-map-marker-alt field-icon"></i>
                        <select name="distrik" class="{{ $errors->has('distrik') ? 'is-invalid' : '' }}" required>
                            <option value="">-- Pilih Distrik --</option>
                            @foreach($distrik as $d)
                            <option value="{{ $d }}" {{ old('distrik')==$d?'selected':'' }}>{{ $d }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('distrik')<div class="err-msg"><i class="fas fa-exclamation-circle"></i>{{ $message }}</div>@enderror
                </div>
                <div class="field">
                    <label class="field-label">Kelurahan/Kampung <span>*</span></label>
                    <div class="field-wrap">
                        <i class="fas fa-map-pin field-icon"></i>
                        <input type="text" name="kelurahan" class="{{ $errors->has('kelurahan') ? 'is-invalid' : '' }}" placeholder="Nama kelurahan/kampung" value="{{ old('kelurahan') }}" required>
                    </div>
                    @error('kelurahan')<div class="err-msg"><i class="fas fa-exclamation-circle"></i>{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="row full">
                <div class="field">
                    <label class="field-label">Alamat Lengkap <span>*</span></label>
                    <div class="field-wrap">
                        <i class="fas fa-home field-icon" style="top:18px;transform:none;"></i>
                        <textarea name="alamat" class="{{ $errors->has('alamat') ? 'is-invalid' : '' }}" placeholder="Alamat lengkap tempat usaha" required>{{ old('alamat') }}</textarea>
                    </div>
                    @error('alamat')<div class="err-msg"><i class="fas fa-exclamation-circle"></i>{{ $message }}</div>@enderror
                </div>
            </div>

            <button type="submit" class="btn-submit"><i class="fas fa-user-plus"></i> Daftar Sekarang</button>
        </form>

        <div class="login-row">Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a></div>
    </div>
</div>

<script>
function togglePw(id,icId){
    const pw=document.getElementById(id),ic=document.getElementById(icId);
    if(pw.type==='password'){pw.type='text';ic.classList.replace('fa-eye','fa-eye-slash');}
    else{pw.type='password';ic.classList.replace('fa-eye-slash','fa-eye');}
}
</script>
</body>
</html>
