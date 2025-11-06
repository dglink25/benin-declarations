<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - CitiNova</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #1a5276;
            --secondary-color: #28a745;
            --accent-color: #f39c12;
            --light-bg: #FDFDFC;
            --dark-bg: #0a0a0a;
            --text-dark: #1b1b18;
            --text-light: #EDEDEC;
        }
        
        
        body {
            font-family: 'Instrument Sans', sans-serif;
            background:
            
            url("data:image/png;base64,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")
            ;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
        }
        
        /* Effet de particules subtil */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 80%, rgba(243, 156, 18, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(40, 167, 69, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(26, 82, 118, 0.1) 0%, transparent 50%);
            pointer-events: none;
            z-index: -1;
        }
        
        .login-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            box-shadow: 
                0 20px 40px rgba(0, 0, 0, 0.2),
                0 0 0 1px rgba(255, 255, 255, 0.1);
            overflow: hidden;
            width: 100%;
            max-width: 450px;
            position: relative;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .login-header {
            background: 
                linear-gradient(135deg, var(--primary-color), #144a6d),
                url('https://images.unsplash.com/photo-1544551763-46a013bb70d5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80');
            background-size: cover;
            background-position: center;
            background-blend-mode: overlay;
            color: white;
            padding: 40px 30px 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .login-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: float 6s ease-in-out infinite;
        }
        
        .logo {
            font-size: 2.5rem;
            margin-bottom: 15px;
            display: block;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));
        }
        
        .login-title {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 10px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }
        
        .login-subtitle {
            font-size: 1rem;
            opacity: 0.9;
            text-shadow: 0 1px 2px rgba(0,0,0,0.3);
        }
        
        .login-body {
            padding: 40px 30px;
            background: rgba(255, 255, 255, 0.8);
        }
        
        .form-group {
            margin-bottom: 25px;
            position: relative;
        }
        
        .form-label {
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 8px;
            display: block;
        }
        
        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 12px 15px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(26, 82, 118, 0.1);
            background: rgba(255, 255, 255, 0.95);
        }
        
        .form-control.with-icon {
            padding-left: 45px;
        }
        
        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary-color);
            font-size: 1.1rem;
        }
        
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #6c757d;
            cursor: pointer;
            transition: color 0.3s ease;
        }
        
        .password-toggle:hover {
            color: var(--primary-color);
        }
        
        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }
        
        .form-check {
            display: flex;
            align-items: center;
        }
        
        .form-check-input {
            width: 18px;
            height: 18px;
            margin-right: 8px;
            border: 2px solid #dee2e6;
            border-radius: 4px;
            cursor: pointer;
        }
        
        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .form-check-label {
            font-size: 0.9rem;
            color: #555;
            cursor: pointer;
        }
        
        .forgot-link {
            color: var(--primary-color);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        
        .forgot-link:hover {
            color: #144a6d;
            text-decoration: underline;
        }
        
        .btn-login {
            background: linear-gradient(135deg, var(--primary-color), #144a6d);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 14px 20px;
            font-weight: 600;
            font-size: 1.1rem;
            width: 100%;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(26, 82, 118, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            position: relative;
            overflow: hidden;
        }
        
        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }
        
        .btn-login:hover::before {
            left: 100%;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(26, 82, 118, 0.4);
            color: white;
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .login-footer {
            text-align: center;
            padding: 20px 30px;
            border-top: 1px solid rgba(233, 236, 239, 0.5);
            background: rgba(248, 249, 250, 0.8);
            backdrop-filter: blur(10px);
        }
        
        .register-link {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }
        
        .register-link:hover {
            color: #144a6d;
            text-decoration: underline;
        }
        
        .alert {
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 20px;
            border: none;
            font-weight: 500;
            backdrop-filter: blur(10px);
        }
        
        .alert-success {
            background: rgba(40, 167, 69, 0.1);
            color: #155724;
            border-left: 4px solid #28a745;
        }
        
        .alert-error {
            background: rgba(220, 53, 69, 0.1);
            color: #721c24;
            border-left: 4px solid #dc3545;
        }
        
        .error-message {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 5px;
            display: block;
        }
        
        /* Bénin Flag Animation */
        .benin-flag {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 60px;
            height: 40px;
            background: 
                linear-gradient(90deg, 
                    #008751 0% 40%, 
                    #fcd116 40% 60%, 
                    #e8112d 60% 100%);
            border-radius: 4px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
            animation: wave 3s ease-in-out infinite;
            z-index: 1000;
        }
        
        @keyframes float {
            0% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-10px);
            }
            100% {
                transform: translateY(0px);
            }
        }
        
        @keyframes wave {
            0%, 100% {
                transform: rotate(0deg);
            }
            25% {
                transform: rotate(2deg);
            }
            75% {
                transform: rotate(-2deg);
            }
        }
        
        /* Responsive */
        @media (max-width: 576px) {
            body {
                padding: 10px;
                background-position: 60% center;
            }
            
            .login-container {
                max-width: 100%;
            }
            
            .login-header {
                padding: 30px 20px 20px;
            }
            
            .login-body {
                padding: 30px 20px;
            }
            
            .remember-forgot {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }
            
            .benin-flag {
                width: 50px;
                height: 33px;
                bottom: 15px;
                right: 15px;
            }
        }
        
        /* Animation d'entrée */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(30px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }
        
        .login-container {
            animation: slideIn 0.6s ease-out;
        }
    </style>
</head>
<body>
    <!-- Drapeau du Bénin animé -->
    <div class="benin-flag" title="République du Bénin"></div>
    
    <div class="login-container">
        <div class="login-header">
            <i class="bi bi-building logo"></i>
            <h1 class="login-title">CITINOVA</h1>
            <p class="login-subtitle">Gestion des Infrastructures Territoriales</p>
        </div>
        
        <div class="login-body">
            <!-- Session Status -->
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="form-group">
                    <label for="email" class="form-label">Adresse Email</label>
                    <div class="position-relative">
                        <i class="fas fa-envelope input-icon"></i>
                        <input 
                            id="email" 
                            class="form-control with-icon" 
                            type="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            required 
                            autofocus 
                            autocomplete="email"
                            placeholder="votre@email.com"
                        >
                    </div>
                    @if ($errors->has('email'))
                        <span class="error-message">
                            {{ $errors->first('email') }}
                        </span>
                    @endif
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password" class="form-label">Mot de passe</label>
                    <div class="position-relative">
                        <i class="fas fa-lock input-icon"></i>
                        <input 
                            id="password" 
                            class="form-control with-icon" 
                            type="password" 
                            name="password" 
                            required 
                            autocomplete="current-password"
                            placeholder="Votre mot de passe"
                        >
                        <button type="button" class="password-toggle" onclick="togglePassword()">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    @if ($errors->has('password'))
                        <span class="error-message">
                            {{ $errors->first('password') }}
                        </span>
                    @endif
                </div>

                <!-- Remember Me -->
                <div class="remember-forgot">
                    <div class="form-check">
                        <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                        <label for="remember_me" class="form-check-label">
                            Se souvenir de moi
                        </label>
                    </div>

                    @if (Route::has('password.request'))
                        <a class="forgot-link" href="{{ route('password.request') }}">
                            Mot de passe oublié ?
                        </a>
                    @endif
                </div>

                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt"></i>
                    Se connecter
                </button>
            </form>
        </div>
        
        <div class="login-footer">
            <p class="mb-0">
                Pas encore de compte ? 
                @if (Route::has('register'))
                    <a class="register-link" href="{{ route('register') }}">
                        S'inscrire
                    </a>
                @endif
            </p>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.querySelector('.password-toggle i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
        
        // Animation d'entrée améliorée
        document.addEventListener('DOMContentLoaded', function() {
            const loginContainer = document.querySelector('.login-container');
            const beninFlag = document.querySelector('.benin-flag');
            
            // Reset pour l'animation
            loginContainer.style.opacity = '0';
            loginContainer.style.transform = 'translateY(30px) scale(0.95)';
            beninFlag.style.opacity = '0';
            
            setTimeout(() => {
                loginContainer.style.transition = 'all 0.6s ease-out';
                loginContainer.style.opacity = '1';
                loginContainer.style.transform = 'translateY(0) scale(1)';
                
                beninFlag.style.transition = 'opacity 0.8s ease 0.3s';
                beninFlag.style.opacity = '1';
            }, 100);
        });
    </script>
</body>
</html>