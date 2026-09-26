<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Pengurus - Karang Taruna 0210</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { background-color: #0A2540; }
    </style>
</head>
<body> <!-- TAG INI SEBELUMNYA HILANG -->
    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="card border-0 shadow-lg rounded-4 p-4" style="max-width: 400px; width: 100%;">
            <div class="text-center mb-4">
                <h4 class="fw-bold">Login Pengurus</h4>
                <small class="text-muted">Masuk ke Sistem Karang Taruna 0210</small>
            </div>

            @if($errors->any())
                <div class="alert alert-danger py-2 small rounded-3">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label small fw-semibold">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-success w-100 rounded-pill fw-bold py-2 mt-2">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Masuk
                </button>
            </form>

            <div class="text-center mt-3">
                <a href="{{ route('public.index') }}" class="text-decoration-none small text-muted">
                    <i class="bi bi-arrow-left"></i> Kembali ke Landing Page
                </a>
            </div>
        </div>
    </div>
</body>
</html>