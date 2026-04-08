@extends("layouts.app")
@section("title","Notifikasi")
@section("page-title","Notifikasi")
@section("breadcrumb")
<li class="breadcrumb-item active">Notifikasi</li>
@endsection
@section("content")
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0"><i class="fas fa-bell mr-2 text-warning"></i>Semua Notifikasi</h3>
    </div>
    <div class="card-body p-0">
    @forelse($notifikasi as $n)
        <div class="d-flex align-items-start p-3 border-bottom {{ $n->dibaca ? "" : "bg-light" }}">
            <div class="mr-3 mt-1">
                <span class="badge badge-{{ $n->warna }} p-2" style="font-size:16px;">
                    <i class="fas {{ $n->icon }}"></i>
                </span>
            </div>
            <div class="flex-grow-1">
                <strong>{{ $n->judul }}</strong>
                <p class="mb-1 text-muted small">{{ $n->pesan }}</p>
                <small class="text-muted"><i class="fas fa-clock mr-1"></i>{{ $n->created_at->diffForHumans() }}</small>
            </div>
            <div class="ml-2">
                <form action="{{ route("notifikasi.destroy", $n) }}" method="POST"
                      onsubmit="return confirm("Hapus?"))">
                    @csrf @method("DELETE")
                    <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                </form>
            </div>
        </div>
    @empty
        <div class="text-center py-5 text-muted">
            <i class="fas fa-bell-slash fa-3x d-block mb-2" style="opacity:.2"></i>
            Tidak ada notifikasi
        </div>
    @endforelse
    </div>
    @if($notifikasi->count())
    <div class="card-footer">{{ $notifikasi->links("pagination::bootstrap-4") }}</div>
    @endif
</div>
@endsection