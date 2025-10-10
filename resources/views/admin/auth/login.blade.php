<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول - لوحة التحكم</title>
    <link rel="stylesheet" href="{{ url('Admin/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ url('Admin/css/style.css') }}">
    <link rel="stylesheet" href="{{ url('Admin/css/custom.css') }}">
    <link rel="stylesheet" href="{{ url('Admin/icon/style.css') }}">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 40px;
            width: 100%;
            max-width: 420px;
        }
        .login-header {
            text-align: center;
            margin-bottom: 35px;
        }
        .login-header h2 {
            color: #333;
            font-weight: 700;
            margin-bottom: 8px;
            font-size: 28px;
        }
        .login-header p {
            color: #666;
            font-size: 15px;
            margin: 0;
        }
        .form-group {
            margin-bottom: 25px;
        }
        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
            font-size: 14px;
        }
        .form-control {
            width: 100%;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            font-size: 16px;
            background: #fff;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }
        .form-control:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        .form-control.is-invalid {
            border-color: #dc3545;
        }
        .invalid-feedback {
            display: block;
            margin-top: 5px;
            color: #dc3545;
            font-size: 12px;
        }
        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 8px;
            padding: 15px;
            font-weight: 600;
            color: white;
            width: 100%;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .btn-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }
        .btn-login:active {
            transform: translateY(0);
        }
        .alert {
            border-radius: 8px;
            margin-bottom: 20px;
            padding: 12px 15px;
            font-size: 14px;
        }
        .alert-danger {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }
        .alert-success {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }
        .logo {
            width: 70px;
            height: 70px;
            margin: 0 auto 25px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 26px;
            font-weight: bold;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }
        
        /* Responsive Design */
        @media (max-width: 480px) {
            .login-card {
                margin: 20px;
                padding: 30px 25px;
                max-width: none;
            }
            .login-header h2 {
                font-size: 24px;
            }
            .form-control {
                padding: 12px;
                font-size: 16px;
            }
            .btn-login {
                padding: 12px;
                font-size: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <div class="logo">A</div>
            <h2>تسجيل الدخول</h2>
            <p>أدخل بياناتك للوصول إلى لوحة التحكم</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.submit') }}">
            @csrf
            
            <div class="form-group">
                <label for="email" class="form-label">البريد الإلكتروني</label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       class="form-control @error('email') is-invalid @enderror" 
                       value="{{ old('email') }}" 
                       required 
                       autofocus>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="password" class="form-label">كلمة المرور</label>
                <input type="password" 
                       id="password" 
                       name="password" 
                       class="form-control @error('password') is-invalid @enderror" 
                       required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <button type="submit" class="btn btn-login">
                تسجيل الدخول
            </button>
        </form>
    </div>

    <script src="{{ url('Admin/js/jquery.min.js') }}"></script>
    <script src="{{ url('Admin/js/bootstrap.min.js') }}"></script>
</body>
</html>
