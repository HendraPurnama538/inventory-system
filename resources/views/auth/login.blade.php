<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Sistem Inventaris</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #1e1b4b 0%, #312e81 40%, #4f46e5 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            position: relative;
            overflow: hidden;
        }

        /* Decorative circles */
        body::before, body::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            background: rgba(255,255,255,.04);
        }
        body::before { width: 400px; height: 400px; top: -100px; right: -100px; }
        body::after  { width: 300px; height: 300px; bottom: -80px; left: -80px; }

        .login-card {
            background: #fff;
            border-radius: 20px;
            padding: 2.5rem 2rem;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 25px 60px rgba(0,0,0,.3);
            position: relative;
            z-index: 1;
            animation: slideUp .5s ease both;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .login-logo {
            width: 60px; height: 60px;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            color: #fff;
            margin: 0 auto 1.25rem;
            box-shadow: 0 8px 20px rgba(79,70,229,.35);
        }

        .login-title {
            font-size: 1.5rem;
            font-weight: 800;
            color: #1e1b4b;
            text-align: center;
            margin-bottom: .25rem;
        }

        .login-subtitle {
            font-size: .875rem;
            color: #64748b;
            text-align: center;
            margin-bottom: 2rem;
        }

        .form-label {
            font-size: .875rem;
            font-weight: 600;
            color: #475569;
        }

        .form-control {
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            padding: .65rem 1rem;
            font-size: .9rem;
            transition: all .2s;
        }

        .form-control:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 4px rgba(79,70,229,.1);
        }

        .input-group-text {
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-right: none;
            border-radius: 10px 0 0 10px;
            color: #94a3b8;
        }

        .input-group .form-control {
            border-left: none;
            border-radius: 0 10px 10px 0;
        }

        .btn-login {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            border: none;
            border-radius: 10px;
            padding: .75rem;
            font-size: .95rem;
            font-weight: 600;
            color: #fff;
            width: 100%;
            transition: all .2s;
            box-shadow: 0 4px 15px rgba(79,70,229,.3);
        }

        .btn-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(79,70,229,.4);
            color: #fff;
        }

        .btn-login:active { transform: translateY(0); }

        .demo-box {
            background: #f8fafc;
            border: 1px dashed #cbd5e1;
            border-radius: 10px;
            padding: .75rem 1rem;
            font-size: .8rem;
            color: #64748b;
            margin-top: 1.25rem;
        }

        .demo-box code {
            color: #4f46e5;
            font-weight: 600;
            background: rgba(79,70,229,.1);
            padding: .1em .35em;
            border-radius: 4px;
        }
    </style>
</head>
<body>

<div class="login-card">

    <div class="login-logo">
        <i class="bi bi-boxes"></i>
    </div>

    <h1 class="login-title">Sistem Inventaris</h1>
    <p class="login-subtitle">Silakan masuk untuk melanjutkan</p>

    {{-- Error global --}}
    @if($errors->has('email') && !$errors->has('password'))
        <div class="alert alert-danger py-2 d-flex align-items-center gap-2 mb-3" style="font-size:.875rem; border-radius:10px;">
            <i class="bi bi-exclamation-circle-fill"></i>
            {{ $errors->first('email') }}
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success py-2 d-flex align-items-center gap-2 mb-3" style="font-size:.875rem; border-radius:10px;">
            <i class="bi bi-check-circle-fill"></i>
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login.post') }}" novalidate>
        @csrf

        {{-- Email --}}
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                <input type="email" name="email" id="email"
                       class="form-control @error('email') is-invalid @enderror"
                       placeholder="admin@inventaris.com"
                       value="{{ old('email') }}"
                       autocomplete="email" required>
            </div>
            @error('email')
                <div class="text-danger mt-1" style="font-size:.8rem;">{{ $message }}</div>
            @enderror
        </div>

        {{-- Password --}}
        <div class="mb-4">
            <label for="password" class="form-label">Password</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input type="password" name="password" id="password"
                       class="form-control @error('password') is-invalid @enderror"
                       placeholder="••••••••"
                       autocomplete="current-password" required>
                <button class="btn btn-outline-secondary" type="button" id="togglePwd"
                        style="border-radius: 0 10px 10px 0; border-color: #e2e8f0;">
                    <i class="bi bi-eye" id="togglePwdIcon"></i>
                </button>
            </div>
            @error('password')
                <div class="text-danger mt-1" style="font-size:.8rem;">{{ $message }}</div>
            @enderror
        </div>

        {{-- Remember --}}
        <div class="form-check mb-4">
            <input type="checkbox" name="remember" id="remember" class="form-check-input" value="1">
            <label for="remember" class="form-check-label" style="font-size:.875rem;">Ingat saya</label>
        </div>

        <button type="submit" class="btn btn-login">
            <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
        </button>
    </form>

    {{-- Demo credentials --}}
    <div class="demo-box">
        <i class="bi bi-info-circle me-1"></i>
        <strong>Demo:</strong>
        Email: <code>admin@inventaris.com</code><br>
        Password: <code>password123</code>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Toggle show/hide password
    document.getElementById('togglePwd').addEventListener('click', function() {
        const pwd  = document.getElementById('password');
        const icon = document.getElementById('togglePwdIcon');
        if (pwd.type === 'password') {
            pwd.type = 'text';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            pwd.type = 'password';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        }
    });
</script>
</body>
</html>
