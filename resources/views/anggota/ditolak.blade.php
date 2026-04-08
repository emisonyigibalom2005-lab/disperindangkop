@extends('layouts.app')
@section('title','Pendaftaran Ditolak')
@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card shadow border-0">
                <div class="card-body text-center py-5">
                    <i class="fas fa-times-circle fa-4x text-danger mb-3"></i>
                    <h3 class="font-weight-bold text-danger">Pendaftaran Ditolak</h3>
                    <p class="text-muted">Mohon maaf, pendaftaran anggota Anda tidak disetujui.</p>
                    @if($anggota->catatan_admin)
                    <div class="alert alert-danger text-left">
                        <strong>Alasan:</strong> {{ $anggota->catatan_admin }}
                    </div>
                    @endif
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
