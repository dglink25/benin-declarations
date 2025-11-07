<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérification d'e-mail - CITINOVA</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #1a5276;
            --secondary-color: #28a745;
            --accent-color: #f39c12;
            --light-bg: #FDFDFC;
            --text-dark: #1b1b18;
        }

        body {
            font-family: 'Instrument Sans', sans-serif;
            background: #f8f9fa;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
        }

        .login-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 100%;
            max-width: 500px;
            animation: slideIn 0.5s ease-out;
        }

        .login-header {
            background: linear-gradient(135deg, var(--primary-color), #144a6d);
            color: white;
            padding: 30px;
            text-align: center;
            position: relative;
        }

        .login-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color), var(--secondary-color));
        }

        .logo-container {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            margin-bottom: 10px;
        }

        .logo {
            width: 60px;
            height: auto;
        }

        .logo-text h1 {
            font-size: 1.8rem;
            font-weight: 700;
            margin: 0;
        }

        .logo-text p {
            font-size: 0.9rem;
            margin: 0;
            opacity: 0.9;
        }

        .login-body {
            padding: 40px 30px;
        }

        .message {
            font-size: 0.95rem;
            margin-bottom: 20px;
            color: var(--text-dark);
        }

        .success-message {
            font-size: 0.9rem;
            margin-bottom: 20px;
            color: #28a745;
        }

        .btn-login {
            background: linear-gradient(135deg, var(--primary-color), #144a6d);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 14px 20px;
            font-weight: 600;
            font-size: 1.1rem;
            width: 100%;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 15px;
        }

        .btn-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 5px 15px rgba(26, 82, 118, 0.3);
        }

        .logout-btn {
            background: none;
            border: none;
            color: var(--primary-color);
            text-decoration: underline;
            font-size: 0.9rem;
            cursor: pointer;
            width: 100%;
        }

        .logout-btn:hover {
            color: var(--secondary-color);
        }

        .login-footer {
            text-align: center;
            padding: 20px 30px;
            border-top: 1px solid #e9ecef;
            background: #f8f9fa;
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-header">
            <div class="logo-container">
                <img src="{{ asset('images/CITINOVA1.png') }}" alt="Logo" class="logo">
                <div class="logo-text">
                    <h1>CITINOVA</h1>
                    <p>Gestion des Infrastructures Territoriales</p>
                </div>
            </div>
        </div>

        <div class="login-body">
            <p class="message">Merci pour votre inscription ! Avant de commencer, veuillez vérifier votre adresse e-mail en cliquant sur le lien que nous venons de vous envoyer. Si vous n’avez pas reçu l’e-mail, nous pouvons vous en envoyer un autre.</p>

            @if (session('status') == 'verification-link-sent')
                <p class="success-message">Un nouveau lien de vérification a été envoyé à votre adresse e-mail.</p>
            @endif

            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn-login"><i class="fas fa-envelope"></i> Renvoyer le lien de vérification</button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">Se déconnecter</button>
            </form>
        </div>

        <div class="login-footer">
            <p>Besoin d’aide ? Contactez l’administrateur.</p>
        </div>
    </div>
</body>
</html>
