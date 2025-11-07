
<nav class="navbar navbar-expand-lg navbar-light fixed-top" style="background-color: rgba(255, 255, 255, 0.98); backdrop-filter: blur(10px);">
    <div class="container">
       <!-- Logo avec image -->
        <a class="navbar-brand" href="{{ Auth::check() ? route('dashboard') : url('/') }}">
            <img src="{{ asset('images/CITINOVA1.png') }}" alt="CITINOVA" class="logo-img" style="height: 40px;">
        </a>
        <!-- Bouton hamburger -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Contenu de la navigation -->
        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                @if(Auth::check())
                    <!-- Liens pour utilisateurs connectés -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <i class="bi bi-speedometer2 me-1"></i>Dashboard
                        </a>
                    </li>
                     <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('declarations.create') ? 'active' : '' }}" href="{{ route('declarations.create') }}">
                            <i class="bi bi-list-ul me-1"></i>Signaler un problème
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('declarations.index') ? 'active' : '' }}" href="{{ route('declarations.index') }}">
                            <i class="bi bi-list-ul me-1"></i>Mes déclarations
                        </a>
                    </li>
                @else
                    <!-- Liens pour visiteurs -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="#accueil">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#a-propos">À propos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#programmes">Domaines</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#impact">Impact</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Ressources
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#admin">Équipe</a></li>
                            <li><a class="dropdown-item" href="#galerie">Galerie</a></li>
                        </ul>
                    </li>
                @endif
            </ul>

            <!-- Partie droite de la navigation -->
            <div class="d-flex align-items-center">
                @auth
                    <!-- Menu utilisateur connecté -->
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle me-2"></i>
                            {{ Auth::user()->name ?? 'Utilisateur' }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="bi bi-person me-2"></i>Profil
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
                    </div>
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

<!-- Style pour la navigation Bootstrap -->
<style>
.navbar {
    padding: 12px 0;
    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
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

/* Responsive */
@media (max-width: 991.98px) {
    .navbar-collapse {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(10px);
        border-radius: 0 0 15px 15px;
        padding: 20px;
        margin-top: 10px;
    }
    
    .nav-link {
        padding: 10px 15px !important;
        border-radius: 10px;
        margin: 2px 0;
    }
    
    .btn-citinova {
        margin-top: 10px;
        justify-content: center;
    }
    
    .d-flex.gap-2 {
        flex-direction: column;
    }
}

/* Styles pour le logo */
.logo-img {
    transition: transform 0.3s ease;
}

.logo-img:hover {
    transform: scale(1.05);
}

/* Responsive */
@media (max-width: 768px) {
    .navbar-brand img {
        height: 35px !important;
    }
}
</style>