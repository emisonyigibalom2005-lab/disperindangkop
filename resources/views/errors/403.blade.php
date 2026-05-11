<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Akses Ditolak</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .error-container {
            text-align: center;
            color: white;
            padding: 40px;
        }
        .error-code {
            font-size: 120px;
            font-weight: 900;
            text-shadow: 4px 4px 8px rgba(0,0,0,0.3);
            margin-bottom: 20px;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        .error-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            max-width: 600px;
            margin: 0 auto;
        }
        .error-icon {
            font-size: 80px;
            color: #dc3545;
            margin-bottom: 20px;
        }
        .error-title {
            color: #333;
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 15px;
        }
        .error-message {
            color: #666;
            font-size: 18px;
            margin-bottom: 25px;
            line-height: 1.6;
        }
        .user-info {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
            text-align: left;
        }
        .user-info-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #dee2e6;
        }
        .user-info-item:last-child {
            border-bottom: none;
        }
        .user-info-label {
            font-weight: 600;
            color: #495057;
        }
        .user-info-value {
            color: #6c757d;
        }
        .btn-custom {
            padding: 12px 30px;
            font-size: 16px;
            border-radius: 50px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            margin: 5px;
        }
        .btn-primary-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
        }
        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }
        .btn-secondary-custom {
            background: #6c757d;
            border: none;
            color: white;
        }
        .btn-secondary-custom:hover {
            background: #5a6268;
            transform: translateY(-2px);
        }
        .alert-info-custom {
            background: #e7f3ff;
            border-left: 4px solid #2196F3;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-card">
            <div class="error-icon">
                <i class="fas fa-ban"></i>
            </div>
            <h1 class="error-title">Akses Ditolak</h1>
            <p class="error-message">
                {{ $message ?? 'Anda tidak memiliki izin untuk mengakses halaman ini.' }}
            </p>

            @if($user)
            <div class="user-info">
                <h5 class="mb-3"><i class="fas fa-user-circle mr-2"></i>Informasi Akun Anda</h5>
                <div class="user-info-item">
                    <span class="user-info-label">Nama:</span>
                    <span class="user-info-value">{{ $user->name }}</span>
                </div>
                <div class="user-info-item">
                    <span class="user-info-label">Email:</span>
                    <span class="user-info-value">{{ $user->email }}</span>
                </div>
                <div class="user-info-item">
                    <span class="user-info-label">Role:</span>
                    <span class="user-info-value">
                        <span class="badge badge-{{ $user->role === 'admin' ? 'success' : 'warning' }}">
                            {{ $user->role_label }}
                        </span>
                    </span>
                </div>
                <div class="user-info-item">
                    <span class="user-info-label">Status:</span>
                    <span class="user-info-value">
                        <span class="badge badge-{{ $user->is_active ? 'success' : 'danger' }}">
                            {{ $user->is_active ? 'Aktif' : 'Tidak Aktif' }}
                        </span>
                    </span>
                </div>
            </div>

            <div class="alert-info-custom">
                <i class="fas fa-info-circle mr-2"></i>
                <strong>Catatan:</strong> Halaman ini hanya dapat diakses oleh pengguna dengan role <strong>Administrator</strong>.
                @if($user->role !== 'admin')
                    Silakan kembali ke dashboard Anda atau hubungi administrator untuk bantuan.
                @endif
            </div>
            @endif

            <div class="mt-4">
                @auth
                    <a href="{{ auth()->user()->getDashboardRoute() }}" class="btn btn-primary-custom">
                        <i class="fas fa-home mr-2"></i>Ke Dashboard Saya
                    </a>
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-secondary-custom">
                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary-custom">
                        <i class="fas fa-sign-in-alt mr-2"></i>Login
                    </a>
                    <a href="{{ route('public.home') }}" class="btn btn-secondary-custom">
                        <i class="fas fa-home mr-2"></i>Beranda
                    </a>
                @endauth
            </div>
        </div>
    </div>
</body>
</html>
