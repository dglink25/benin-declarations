<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Animate CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Scripts -->
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles pour la navigation -->
    <style>
        .navbar {
            padding: 12px 0;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            z-index: 1030;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.8rem;
            color: var(--primary-color, #1a5276) !important;
            display: flex;
            align-items: center;
        }

        .nav-link {
            font-weight: 500;
            color: var(--text-dark, #1b1b18) !important;
            padding: 8px 16px !important;
            border-radius: 20px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            white-space: nowrap;
            margin: 0 2px;
        }

        .nav-link:hover {
            color: var(--primary-color, #1a5276) !important;
            background-color: rgba(26, 82, 118, 0.05);
        }

        .nav-link.active {
            color: white !important;
            background: linear-gradient(135deg, var(--primary-color, #1a5276), #144a6d);
            box-shadow: 0 4px 12px rgba(26, 82, 118, 0.3);
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            padding: 8px;
        }

        .dropdown-item {
            border-radius: 8px;
            padding: 8px 16px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
        }

        .dropdown-item:hover {
            background-color: rgba(26, 82, 118, 0.08);
            color: var(--primary-color, #1a5276);
        }

        .btn-citinova {
            background: linear-gradient(135deg, var(--primary-color, #1a5276), #144a6d);
            color: white;
            padding: 10px 20px;
            border-radius: 30px;
            font-weight: 600;
            border: none;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(26, 82, 118, 0.3);
            display: flex;
            align-items: center;
            white-space: nowrap;
            text-decoration: none;
        }

        .btn-citinova:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(26, 82, 118, 0.4);
            color: white;
        }

        /* Badge de rôle */
        .navbar .badge {
            font-weight: 500;
            padding: 4px 8px;
        }

        /* Styles pour le logo */
        .logo-img {
            transition: transform 0.3s ease;
        }

        .logo-img:hover {
            transform: scale(1.05);
        }

        /* Responsive */
        @media (max-width: 991.98px) {
            .navbar-collapse {
                background: rgba(255, 255, 255, 0.98);
                backdrop-filter: blur(10px);
                border-radius: 0 0 15px 15px;
                padding: 20px;
                margin-top: 10px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            }
            
            .nav-link {
                padding: 10px 15px !important;
                border-radius: 10px;
                margin: 2px 0;
                justify-content: flex-start;
            }
            
            .btn-citinova {
                margin-top: 10px;
                justify-content: center;
                width: 100%;
            }
            
            .d-flex.gap-2 {
                flex-direction: column;
                width: 100%;
            }
            
            .dropdown-menu {
                border: 1px solid rgba(0, 0, 0, 0.05);
                margin-top: 5px;
            }
        }

        @media (max-width: 768px) {
            .navbar-brand img {
                height: 35px !important;
            }
            
            .nav-link {
                font-size: 0.95rem;
            }
            
            .btn-citinova {
                padding: 8px 16px;
                font-size: 0.9rem;
            }
        }

        /* Animation pour le dropdown */
        .dropdown-toggle::after {
            transition: transform 0.2s ease;
        }

        .dropdown.show .dropdown-toggle::after {
            transform: rotate(-180deg);
        }

        /* Amélioration de l'accessibilité */
        .navbar-toggler:focus {
            box-shadow: 0 0 0 2px rgba(26, 82, 118, 0.5);
        }

        .nav-link:focus {
            outline: 2px solid rgba(26, 82, 118, 0.5);
            outline-offset: 2px;
        }

        /* Correction pour le body avec navbar fixed */
        body {
            padding-top: 76px;
        }
    </style>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        {{-- Navigation --}}
        <nav class="navbar navbar-expand-lg navbar-light fixed-top" style="background-color: rgba(255, 255, 255, 0.98); backdrop-filter: blur(10px);">
            <div class="container">
                <!-- Logo -->
                <a class="navbar-brand" href="{{ Auth::check() ? route('dashboard') : url('/') }}">
                    <img src="{{ asset('images/CITINOVA1.png') }}" alt="CITINOVA" class="logo-img" style="height: 40px;">
                </a>
                <!-- Liens pour utilisateurs connectés -->
                            
                    
                           
                                <a class="nav-link {{ request()->routeIs('declarations.create') ? 'active' : '' }}" href="{{ route('declarations.create') }}">
                                    <i class="bi bi-exclamation-triangle me-1"></i>Signaler un problème
                                </a>
                           
                                <a class="nav-link {{ request()->routeIs('declarations.mes-declarations') ? 'active' : '' }}" href="{{ route('declarations.mes-declarations') }}">
                                    <i class="bi bi-list-ul me-1"></i>Mes déclarations
                                </a>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                                                <i class="bi bi-box-arrow-right me-2"></i>Déconnexion
                                            </a>
                                        </form>
                
                <!-- Bouton hamburger -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Contenu de la navigation -->
                <div class="collapse navbar-collapse" id="navbarContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        @auth
                            
                        @else
                            <!-- Liens pour visiteurs non authentifiés -->
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}#accueil">Accueil</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/') }}#a-propos">À propos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/') }}#programmes">Domaines</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/') }}#impact">Impact</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Ressources
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ url('/') }}#admin">Équipe</a></li>
                                    <li><a class="dropdown-item" href="{{ url('/') }}#galerie">Galerie</a></li>
                                    <li><a class="dropdown-item" href="{{ url('/') }}#contact">Contact</a></li>
                                </ul>
                            </li>
                        @endauth
                    </ul>

                    <!-- Partie droite de la navigation -->
                    <div class="d-flex align-items-center">
                        @auth
                            <!-- Menu utilisateur connecté -->
                            
                                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-person-circle me-2"></i>
                                    {{ Auth::user()->name }}
                                    <span class="badge bg-primary ms-2" style="font-size: 0.7rem;">
                                        {{ ucfirst(Auth::user()->role) }}
                                    </span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                            <i class="bi bi-person me-2"></i>Profil
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('dashboard') }}">
                                            <i class="bi bi-speedometer2 me-2"></i>Tableau de bord
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                                                <i class="bi bi-box-arrow-right me-2"></i>Déconnexion
                                            </a>
                                        </form>
                                    </li>
                                </ul>
                            
                        @else
                            <!-- Boutons connexion/inscription -->
                            <div class="d-flex gap-2">
                                <a href="{{ route('login') }}" class="btn btn-citinova">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>Connexion
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="btn btn-citinova">
                                        <i class="bi bi-person-plus me-2"></i>Inscription
                                    </a>
                                @endif
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main>
            @yield('content')
        </main>
    </div>
</body>
</html>