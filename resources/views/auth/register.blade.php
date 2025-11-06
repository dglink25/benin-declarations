<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - CitiNova</title>

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
                linear-gradient(rgba(26, 82, 118, 0.85), rgba(44, 62, 80, 0.9)),
                url('https://images.unsplash.com/photo-1571167366136-b57e07761693?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80');
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
        
        .register-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            box-shadow: 
                0 20px 40px rgba(0, 0, 0, 0.2),
                0 0 0 1px rgba(255, 255, 255, 0.1);
            overflow: hidden;
            width: 100%;
            max-width: 500px;
            position: relative;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .register-header {
            background: 
                linear-gradient(135deg, var(--primary-color), #144a6d),
                url('data:image/jpeg;base64,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');
            background-size: cover;
            background-position: center;
            background-blend-mode: overlay;
            color: white;
            padding: 40px 30px 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .register-header::before {
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
        
        .register-title {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 10px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }
        
        .register-subtitle {
            font-size: 1rem;
            opacity: 0.9;
            text-shadow: 0 1px 2px rgba(0,0,0,0.3);
        }
        
        .register-body {
            padding: 40px 30px;
            background: rgba(255, 255, 255, 0.8);
        }
        
        .form-group {
            margin-bottom: 20px;
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
        
        .password-strength {
            margin-top: 8px;
            height: 4px;
            background: #e9ecef;
            border-radius: 2px;
            overflow: hidden;
            position: relative;
        }
        
        .password-strength-bar {
            height: 100%;
            width: 0%;
            border-radius: 2px;
            transition: all 0.3s ease;
        }
        
        .strength-weak { background: #dc3545; width: 25%; }
        .strength-fair { background: #fd7e14; width: 50%; }
        .strength-good { background: #ffc107; width: 75%; }
        .strength-strong { background: #28a745; width: 100%; }
        
        .password-strength-text {
            font-size: 0.8rem;
            margin-top: 4px;
            text-align: right;
            color: #6c757d;
        }
        
        .form-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 30px;
        }
        
        .login-link {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
            font-size: 0.9rem;
        }
        
        .login-link:hover {
            color: #144a6d;
            text-decoration: underline;
        }
        
        .btn-register {
            background: linear-gradient(135deg, var(--primary-color), #144a6d);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 14px 30px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(26, 82, 118, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            position: relative;
            overflow: hidden;
        }
        
        .btn-register::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }
        
        .btn-register:hover::before {
            left: 100%;
        }
        
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(26, 82, 118, 0.4);
            color: white;
        }
        
        .btn-register:active {
            transform: translateY(0);
        }
        
        .register-footer {
            text-align: center;
            padding: 20px 30px;
            border-top: 1px solid rgba(233, 236, 239, 0.5);
            background: rgba(248, 249, 250, 0.8);
            backdrop-filter: blur(10px);
        }
        
        .terms-text {
            font-size: 0.8rem;
            color: #6c757d;
            margin: 0;
        }
        
        .terms-link {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
        }
        
        .terms-link:hover {
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
        
        /* Devise du Bénin */
        .benin-motto {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: linear-gradient(135deg, #008751, #fcd116, #e8112d);
            border-radius: 15px;
            padding: 15px 20px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.3);
            animation: mottoGlow 4s ease-in-out infinite;
            z-index: 1000;
            max-width: 200px;
            text-align: center;
            border: 2px solid rgba(255,255,255,0.3);
        }
        
        .motto-text {
            color: white;
            font-weight: 700;
            font-size: 0.9rem;
            text-shadow: 0 2px 4px rgba(0,0,0,0.5);
            margin: 0;
            line-height: 1.3;
        }
        
        .motto-subtext {
            color: rgba(255,255,255,0.9);
            font-size: 0.7rem;
            font-weight: 500;
            margin-top: 4px;
            text-shadow: 0 1px 2px rgba(0,0,0,0.5);
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
        
        @keyframes mottoGlow {
            0%, 100% {
                box-shadow: 0 8px 25px rgba(0,0,0,0.3);
                transform: scale(1);
            }
            50% {
                box-shadow: 0 12px 35px rgba(0,135,81,0.4);
                transform: scale(1.02);
            }
        }
        
        /* Responsive */
        @media (max-width: 576px) {
            body {
                padding: 10px;
                background-position: 60% center;
            }
            
            .register-container {
                max-width: 100%;
            }
            
            .register-header {
                padding: 30px 20px 20px;
            }
            
            .register-body {
                padding: 30px 20px;
            }
            
            .form-footer {
                flex-direction: column;
                gap: 15px;
                align-items: stretch;
            }
            
            .btn-register {
                width: 100%;
            }
            
            .benin-motto {
                bottom: 15px;
                right: 15px;
                left: 15px;
                max-width: none;
                padding: 12px 15px;
            }
            
            .motto-text {
                font-size: 0.8rem;
            }
            
            .motto-subtext {
                font-size: 0.65rem;
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
        
        .register-container {
            animation: slideIn 0.6s ease-out;
        }
    </style>
</head>
<body>
    <!-- Devise nationale du Bénin -->
    <div class="benin-motto">
        <p class="motto-text">FRATERNITÉ - JUSTICE - TRAVAIL</p>
        <p class="motto-subtext">Devise de la République du Bénin</p>
    </div>
    
    <div class="register-container">
        <div class="register-header">
            <i class="bi bi-building logo"></i>
            <h1 class="register-title">CitiNova</h1>
            <p class="register-subtitle">Créer votre compte</p>
        </div>
        
        <div class="register-body">
            <!-- Session Status -->
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="form-group">
                    <label for="name" class="form-label">Nom complet</label>
                    <div class="position-relative">
                        <i class="fas fa-user input-icon"></i>
                        <input 
                            id="name" 
                            class="form-control with-icon" 
                            type="text" 
                            name="name" 
                            value="{{ old('name') }}" 
                            required 
                            autofocus 
                            autocomplete="name"
                            placeholder="Votre nom complet"
                        >
                    </div>
                    @if ($errors->has('name'))
                        <span class="error-message">
                            {{ $errors->first('name') }}
                        </span>
                    @endif
                </div>

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
                            autocomplete="new-password"
                            placeholder="Créez un mot de passe sécurisé"
                            oninput="checkPasswordStrength(this.value)"
                        >
                        <button type="button" class="password-toggle" onclick="togglePassword('password')">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <div class="password-strength">
                        <div class="password-strength-bar" id="passwordStrengthBar"></div>
                    </div>
                    <div class="password-strength-text" id="passwordStrengthText">
                        Force du mot de passe
                    </div>
                    @if ($errors->has('password'))
                        <span class="error-message">
                            {{ $errors->first('password') }}
                        </span>
                    @endif
                </div>

                <!-- Confirm Password -->
                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                    <div class="position-relative">
                        <i class="fas fa-lock input-icon"></i>
                        <input 
                            id="password_confirmation" 
                            class="form-control with-icon" 
                            type="password" 
                            name="password_confirmation" 
                            required 
                            autocomplete="new-password"
                            placeholder="Confirmez votre mot de passe"
                        >
                        <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    @if ($errors->has('password_confirmation'))
                        <span class="error-message">
                            {{ $errors->first('password_confirmation') }}
                        </span>
                    @endif
                </div>

                <div class="form-footer">
                    <a class="login-link" href="{{ route('login') }}">
                        <i class="fas fa-arrow-left me-2"></i>
                        Déjà inscrit ?
                    </a>

                    <button type="submit" class="btn-register">
                        <i class="fas fa-user-plus"></i>
                        Créer mon compte
                    </button>
                </div>
            </form>
        </div>
        
        <div class="register-footer">
            <p class="terms-text">
                En créant un compte, vous acceptez nos 
                <a href="#" class="terms-link">Conditions d'utilisation</a> 
                et notre 
                <a href="#" class="terms-link">Politique de confidentialité</a>
            </p>
        </div>
    </div>

    <script>
        function togglePassword(fieldId) {
            const passwordInput = document.getElementById(fieldId);
            const toggleIcon = passwordInput.parentNode.querySelector('.password-toggle i');
            
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
        
        function checkPasswordStrength(password) {
            const strengthBar = document.getElementById('passwordStrengthBar');
            const strengthText = document.getElementById('passwordStrengthText');
            
            let strength = 0;
            let text = '';
            let barClass = '';
            
            // Longueur minimale
            if (password.length >= 8) strength += 25;
            
            // Contient des lettres minuscules et majuscules
            if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) strength += 25;
            
            // Contient des chiffres
            if (password.match(/([0-9])/)) strength += 25;
            
            // Contient des caractères spéciaux
            if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) strength += 25;
            
            // Définir le texte et la classe en fonction de la force
            if (strength === 0) {
                text = 'Très faible';
                barClass = 'strength-weak';
            } else if (strength <= 25) {
                text = 'Faible';
                barClass = 'strength-weak';
            } else if (strength <= 50) {
                text = 'Moyen';
                barClass = 'strength-fair';
            } else if (strength <= 75) {
                text = 'Bon';
                barClass = 'strength-good';
            } else {
                text = 'Fort';
                barClass = 'strength-strong';
            }
            
            // Mettre à jour l'interface
            strengthBar.className = 'password-strength-bar ' + barClass;
            strengthText.textContent = text;
        }
        
        // Animation d'entrée améliorée
        document.addEventListener('DOMContentLoaded', function() {
            const registerContainer = document.querySelector('.register-container');
            const beninMotto = document.querySelector('.benin-motto');
            
            // Reset pour l'animation
            registerContainer.style.opacity = '0';
            registerContainer.style.transform = 'translateY(30px) scale(0.95)';
            beninMotto.style.opacity = '0';
            beninMotto.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                registerContainer.style.transition = 'all 0.6s ease-out';
                registerContainer.style.opacity = '1';
                registerContainer.style.transform = 'translateY(0) scale(1)';
                
                beninMotto.style.transition = 'all 0.8s ease 0.3s';
                beninMotto.style.opacity = '1';
                beninMotto.style.transform = 'translateY(0)';
            }, 100);
        });
    </script>
</body>
</html>