<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation du mot de passe - CITINOVA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #004e92, #000428);
            color: #fff;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        .reset-container {
            background-color: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.3);
            padding: 40px 30px;
            width: 400px;
            text-align: center;
        }

        .logo-container {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .logo {
            width: 60px;
            height: auto;
        }

        .login-title {
            font-weight: 600;
            font-size: 1.8rem;
        }

        .login-subtitle {
            font-size: 0.9rem;
            opacity: 0.8;
        }

        .form-control {
            background-color: rgba(255,255,255,0.2);
            border: none;
            color: #fff;
            border-radius: 10px;
            padding: 12px;
        }

        .form-control:focus {
            background-color: rgba(255,255,255,0.3);
            outline: none;
            box-shadow: 0 0 10px #00c6ff;
            color: #fff;
        }

        .btn-primary {
            background: #00c6ff;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            padding: 10px;
            width: 100%;
            transition: 0.3s;
        }

        .btn-primary:hover {
            background: #0072ff;
        }

        .login-footer {
            margin-top: 15px;
            font-size: 0.9rem;
        }

        .login-footer a {
            color: #00c6ff;
            text-decoration: none;
            font-weight: 500;
        }

        .login-footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="reset-container">
        <div class="logo-container">
            <img src="{{ asset('images/CITINOVA1.png') }}" alt="Logo CITINOVA" class="logo">
            <div class="logo-text">
                <h1 class="login-title">CITINOVA</h1>
                <p class="login-subtitle">Réinitialisation du mot de passe</p>
            </div>
        </div>

        <form action="{{ route('password.store') }}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="mb-3 text-start">
                <label class="form-label">Adresse e-mail</label>
                <input type="email" name="email" class="form-control" placeholder="exemple@mail.com" value="{{ old('email', $request->email) }}" required autofocus>
            </div>

            <div class="mb-3 text-start">
                <label class="form-label">Nouveau mot de passe</label>
                <input type="password" name="password" class="form-control" placeholder="********" required>
            </div>

            <div class="mb-3 text-start">
                <label class="form-label">Confirmez le mot de passe</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="********" required>
            </div>

            <button type="submit" class="btn btn-primary">Réinitialiser le mot de passe</button>

            <div class="login-footer mt-3">
                <p><a href="{{ route('login') }}">Retour à la connexion</a></p>
            </div>
        </form>
    </div>
</body>
</html>
