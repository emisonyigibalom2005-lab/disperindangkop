@extends('public.layouts.app')
@section('title', 'Profil Dinas')

@section('content')
<section style="background:linear-gradient(135deg,#1a3a6e,#2d5aa0);padding:60px 0 40px;color:white;">
    <div class="container text-center">
        <h2 class="font-weight-bold mb-2"><i class="fas fa-building mr-2"></i>Profil Dinas</h2>
        <p class="mb-0" style="opacity:.75">Disperindagkop Kabupaten Tolikara</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row">
            @forelse($halaman as $h)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100 border-0" style="border-radius:12px;overflow:hidden;">
                    @if($h->gambar)
                    <img src="{{ asset('storage/'.$h->gambar) }}" class="card-img-top" style="height:160px;object-fit:cover;">
                    @else
                    <div style="height:160px;background:linear-gradient(135deg,#1a3a6e,#2d5aa0);display:flex;align-items:center;justify-content:center;">
                        <i class="{{ $h->icon ?? 'fas fa-file-alt' }} fa-3x text-white" style="opacity:.5"></i>
                    </div>
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h5 class="font-weight-bold mb-3">{{ $h->judul }}</h5>
                        <p class="text-muted small flex-grow-1">{{ Str::limit(strip_tags($h->konten), 120) }}</p>
                        <a href="{{ route('public.halaman', $h->slug) }}"
                           class="btn btn-outline-primary btn-sm mt-auto">
                            Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5 text-muted">
                <i class="fas fa-building fa-3x mb-3 d-block" style="opacity:.2"></i>
                <p>Belum ada halaman profil</p>
            </div>
            @endforelse
        </div>
    </div>
</section>
@endsection