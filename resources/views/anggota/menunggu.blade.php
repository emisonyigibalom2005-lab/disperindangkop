@extends('layouts.app')
@section('title','Menunggu Verifikasi')
@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card shadow border-0">
                <div class="card-body text-center py-5">
                    <i class="fas fa-hourglass-half fa-4x text-warning mb-3"></i>
                    <h3 class="font-weight-bold">Menunggu Verifikasi</h3>
                    <p class="text-muted">Pendaftaran anggota Anda sedang ditinjau oleh admin. Harap tunggu konfirmasi.</p>
                    <hr>
                    <p><strong>Nama:</strong> {{ $anggota->nama }}</p>
                    <p><strong>No. Pendaftaran:</strong> {{ $anggota->no_anggota }}</p>
                    <p><strong>Tanggal Daftar:</strong> {{ $anggota->created_at->format('d M Y') }}</p>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="btn btn-outline-secondary mt-3">
                        <i class="fas fa-sign-out-alt mr-1"></i> Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
