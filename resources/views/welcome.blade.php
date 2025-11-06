<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>

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
        background-color: var(--light-bg);
        color: var(--text-dark);
        overflow-x: hidden;
        scroll-behavior: smooth;
    }
    
    /* Navigation améliorée et alignée */
    .navbar {
        background-color: rgba(255, 255, 255, 0.98) !important;
        backdrop-filter: blur(10px);
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        padding: 12px 0;
    }
    
    .navbar-brand {
        font-weight: 700;
        font-size: 1.8rem;
        color: var(--primary-color) !important;
        display: flex;
        align-items: center;
    }
    
    .navbar-nav {
        display: flex;
        align-items: center;
        gap: 5px;
    }
    
    .nav-link {
        font-weight: 500;
        color: var(--text-dark) !important;
        padding: 8px 16px !important;
        border-radius: 20px;
        transition: all 0.3s ease;
        position: relative;
        display: flex;
        align-items: center;
        white-space: nowrap;
    }
    
    .nav-link:hover {
        color: var(--primary-color) !important;
        background-color: rgba(26, 82, 118, 0.05);
    }
    
    .nav-link.active {
        color: white !important;
        background: linear-gradient(135deg, var(--primary-color), #144a6d);
        box-shadow: 0 4px 12px rgba(26, 82, 118, 0.3);
    }
    
    .nav-link.active::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 50%;
        transform: translateX(-50%);
        width: 6px;
        height: 6px;
        background-color: var(--accent-color);
        border-radius: 50%;
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
    }
    
    .dropdown-item:hover {
        background-color: rgba(26, 82, 118, 0.08);
        color: var(--primary-color);
    }
    
    .navbar-toggler {
        border: none;
        padding: 4px 8px;
    }
    
    .navbar-toggler:focus {
        box-shadow: none;
    }
    
    .navbar-toggler-icon {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%2826, 82, 118, 0.8%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
    }
    
    .btn-citinova {
        background: linear-gradient(135deg, var(--primary-color), #144a6d);
        color: white;
        padding: 10px 25px;
        border-radius: 30px;
        font-weight: 600;
        border: none;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(26, 82, 118, 0.3);
        display: flex;
        align-items: center;
        white-space: nowrap;
    }
    
    .btn-citinova:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(26, 82, 118, 0.4);
        color: white;
    }
    
    .btn-report {
        background: linear-gradient(135deg, #e74c3c, #c0392b);
        color: white;
        padding: 10px 20px;
        border-radius: 30px;
        font-weight: 600;
        border: none;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(231, 76, 60, 0.3);
        position: fixed;
        bottom: 30px;
        right: 30px;
        z-index: 1000;
        display: flex;
        align-items: center;
        white-space: nowrap;
    }
    
    .btn-report:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(231, 76, 60, 0.4);
        color: white;
    }
    
    /* Section Carrousel Élégante */
    .carousel-section {
        position: relative;
        padding: 120px 0 80px;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        overflow: hidden;
    }
    
    .carousel-item {
        padding: 40px 0;
    }
    
    .text-wrapper h2 {
        font-size: 3rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 20px;
        line-height: 1.2;
    }
    
    .text-wrapper p {
        font-size: 1.2rem;
        color: var(--text-dark);
        margin-bottom: 30px;
        line-height: 1.6;
    }
    
    .image-decor-wrapper {
        position: relative;
        padding: 20px;
    }
    
    .main-img {
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        transition: transform 0.5s ease;
    }
    
    .carousel-item.active .main-img {
        transform: scale(1.05);
    }
    
    .decor {
        position: absolute;
        z-index: 1;
    }
    
    .decor-1 {
        top: 10%;
        left: 5%;
        width: 120px;
        opacity: 0.7;
        animation: float 6s ease-in-out infinite;
    }
    
    .decor-2 {
        bottom: 15%;
        right: 8%;
        width: 100px;
        opacity: 0.6;
        animation: float 8s ease-in-out infinite;
    }
    
    .decor-3 {
        top: 50%;
        left: 10%;
        width: 80px;
        opacity: 0.5;
        animation: float 7s ease-in-out infinite;
    }
    
    .custom-control {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 50px;
        height: 50px;
        background-color: white;
        border-radius: 50%;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        opacity: 0.8;
        transition: all 0.3s ease;
        z-index: 10;
    }
    
    .custom-control:hover {
        opacity: 1;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }
    
    .carousel-control-prev {
        left: 20px;
    }
    
    .carousel-control-next {
        right: 20px;
    }
    
    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        background-color: var(--primary-color);
        border-radius: 50%;
        width: 30px;
        height: 30px;
        background-size: 60%;
    }
    
    @keyframes float {
        0% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(-15px);
        }
        100% {
            transform: translateY(0px);
        }
    }
    
    /* Section À propos */
    .section-apropos {
        padding: 100px 0;
    }
    
    .who-we {
        color: var(--accent-color);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.9rem;
    }
    
    .section-title {
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 20px;
    }
    
    .section-description {
        font-size: 1.1rem;
        line-height: 1.7;
        margin-bottom: 20px;
    }
    
    .founder-quote {
        border-left: 4px solid var(--accent-color);
        padding-left: 20px;
        font-style: italic;
        color: #666;
        margin: 25px 0;
    }
    
    .img-wave-border {
        border-radius: 20px;
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }
    
    .img-wave-border:hover {
        transform: translateY(-5px);
    }
    
    /* Section Domaines d'infrastructure */
    .programme-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: none;
        border-radius: 15px;
        overflow: hidden;
        height: 100%;
    }
    
    .programme-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1) !important;
    }
    
    .text-orange {
        color: var(--accent-color) !important;
    }
    
    .bg-gradient-orange {
        background: linear-gradient(135deg, var(--accent-color), #e67e22) !important;
    }
    
    .btn-glass {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: var(--primary-color);
        transition: all 0.3s ease;
    }
    
    .btn-glass:hover {
        background: rgba(255, 255, 255, 0.3);
        color: var(--primary-color);
    }
    
    .btn-report-section {
        background: linear-gradient(135deg, #e74c3c, #c0392b);
        color: white;
        padding: 8px 20px;
        border-radius: 30px;
        font-weight: 600;
        border: none;
        transition: all 0.3s ease;
        box-shadow: 0 3px 10px rgba(231, 76, 60, 0.3);
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        white-space: nowrap;
    }
    
    .btn-report-section:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(231, 76, 60, 0.4);
        color: white;
    }
    
    /* Section Services */
    .cours-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        border: none;
        height: 100%;
    }
    
    .cours-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }
    
    .cours-title {
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 15px;
    }
    
    .cours-title span {
        display: inline-block;
        background: var(--primary-color);
        color: white;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        text-align: center;
        line-height: 40px;
        margin-right: 15px;
        font-weight: 700;
    }
    
    .cours-text {
        color: #666;
        line-height: 1.6;
    }
    
    .cours-niveau {
        color: #888;
        font-size: 0.9rem;
        margin-top: 15px;
    }
    
    .btn-vp {
        background: transparent;
        border: 2px solid var(--primary-color);
        color: var(--primary-color);
        padding: 10px 30px;
        border-radius: 30px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-vp:hover {
        background: var(--primary-color);
        color: white;
    }
    
    .cours-toggle-wrapper {
        text-align: center;
        margin-top: 30px;
    }
    
    /* Section Histoire du Bénin */
    .benin-history-section {
        padding: 100px 0;
        background: linear-gradient(135deg, #1a5276 0%, #2c3e50 100%);
        color: white;
    }
    
    .history-card {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border-radius: 15px;
        padding: 30px;
        transition: all 0.3s ease;
        height: 100%;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .history-card:hover {
        transform: translateY(-5px);
        background: rgba(255, 255, 255, 0.15);
    }
    
    .history-icon {
        font-size: 3rem;
        margin-bottom: 20px;
        color: var(--accent-color);
    }
    
    .history-title {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 15px;
    }
    
    /* Section Projets */
    .timeline-section {
        padding: 100px 0;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    }
    
    .timeline {
        position: relative;
        max-width: 1200px;
        margin: 0 auto;
    }
    
    .timeline::after {
        content: '';
        position: absolute;
        width: 6px;
        background-color: var(--primary-color);
        top: 0;
        bottom: 0;
        left: 50%;
        margin-left: -3px;
        border-radius: 10px;
    }
    
    .timeline-item {
        padding: 10px 40px;
        position: relative;
        width: 50%;
        box-sizing: border-box;
    }
    
    .timeline-item::after {
        content: '';
        position: absolute;
        width: 25px;
        height: 25px;
        background-color: white;
        border: 4px solid var(--primary-color);
        top: 15px;
        border-radius: 50%;
        z-index: 1;
    }
    
    .left {
        left: 0;
    }
    
    .right {
        left: 50%;
    }
    
    .left::after {
        right: -13px;
    }
    
    .right::after {
        left: -13px;
    }
    
    .timeline-content {
        padding: 20px 30px;
        background-color: white;
        border-radius: 15px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
    }
    
    .timeline-content h4 {
        color: var(--primary-color);
        margin-bottom: 10px;
    }
    
    /* Section Équipe */
    .teachers-section {
        padding: 100px 0;
    }
    
    .teacher-card {
        transition: all 0.3s ease;
    }
    
    .teacher-card:hover {
        transform: translateY(-10px);
    }
    
    .teacher-img {
        border: 3px solid var(--primary-color) !important;
        transition: all 0.3s ease;
    }
    
    .teacher-card:hover .teacher-img {
        border-color: var(--accent-color) !important;
    }
    
    .teacher-name {
        color: var(--primary-color);
        font-weight: 600;
    }
    
    .teacher-title {
        color: #666;
    }
    
    /* Section Galerie */
    #galerie {
        padding: 100px 0;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    }
    
    .gallery-img {
        cursor: pointer;
        transition: transform 0.3s ease;
        height: 250px;
        object-fit: cover;
        width: 100%;
        border-radius: 10px;
    }
    
    .gallery-img:hover {
        transform: scale(1.03);
    }
    
    .modal-gallery {
        z-index: 1060;
    }
    
    .modal-gallery .modal-content {
        background-color: transparent;
        border: none;
    }
    
    .modal-gallery .modal-body {
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    
    .modal-gallery img {
        max-height: 85vh;
        max-width: 100%;
        object-fit: contain;
        border-radius: 10px;
    }
    
    .modal-gallery .btn-close {
        position: absolute;
        top: 15px;
        right: 15px;
        background-color: rgba(255, 255, 255, 0.8);
        border-radius: 50%;
        opacity: 1;
        z-index: 1070;
    }
    
    .modal-gallery .modal-dialog {
        max-width: 95%;
        margin: 10px auto;
    }
    
    /* Footer */
    .footer {
        background: linear-gradient(135deg, var(--primary-color) 0%, #144a6d 100%);
        color: white;
    }
    
    .footer-title {
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 1rem;
    }
    
    .footer-separator {
        width: 50px;
        height: 2px;
        background-color: var(--accent-color);
        opacity: 1;
        margin: 0 0 1rem 0;
    }
    
    .footer-text {
        font-size: 0.9rem;
        line-height: 1.6;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .text-wrapper h2 {
            font-size: 2.2rem;
        }
        
        .text-wrapper p {
            font-size: 1.1rem;
        }
        
        .decor {
            display: none;
        }
        
        .custom-control {
            width: 40px;
            height: 40px;
        }
        
        .timeline::after {
            left: 31px;
        }
        
        .timeline-item {
            width: 100%;
            padding-left: 70px;
            padding-right: 25px;
        }
        
        .timeline-item::after {
            left: 18px;
        }
        
        .right {
            left: 0;
        }
        
        .btn-report {
            bottom: 20px;
            right: 20px;
            padding: 8px 16px;
            font-size: 0.9rem;
        }
        
        .navbar-nav {
            gap: 0;
            padding: 10px 0;
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
    }
    
    @media (max-width: 576px) {
        .navbar-brand {
            font-size: 1.5rem;
        }
        
        .btn-citinova {
            padding: 8px 16px;
            font-size: 0.9rem;
        }
    }
</style>
</head>
<body>
    <!-- Bouton Signaler un problème (flottant) -->
    <button class="btn btn-report animate__animated animate__pulse animate__infinite" data-bs-toggle="modal" data-bs-target="#reportModal">
        <i class="fas fa-exclamation-triangle me-2"></i>Signaler un problème
    </button>

    <!-- Barre de navigation corrigée -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand" href="#accueil">
                <i class="bi bi-building me-2"></i>
                <span>CITINOVA</span>
            </a>

            <!-- Bouton hamburger -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Menu corrigé et aligné -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item">
                        <a class="nav-link active" href="#accueil">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#a-propos">À propos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#programmes">Domaines</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#cours">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#histoire">Histoire du Bénin</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Ressources
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#activites">Projets</a></li>
                            <li><a class="dropdown-item" href="#admin">Équipe</a></li>
                            <li><a class="dropdown-item" href="#galerie">Galerie</a></li>
                        </ul>
                    </li>
                    <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                        <div class="d-flex flex-column flex-lg-row gap-2">
                            @if (Route::has('login'))
                                @auth
                                    <a href="{{ url('/dashboard') }}" class="btn btn-citinova">
                                        <i class="bi bi-speedometer2 me-2"></i>Dashboard
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-citinova">
                                        <i class="bi bi-box-arrow-in-right me-2"></i>Connexion
                                    </a>
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="btn btn-citinova">
                                            <i class="bi bi-person-plus me-2"></i>Inscription
                                        </a>
                                    @endif
                                @endauth
                            @endif
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Section Hero avec Carrousel -->
    <section id="accueil" class="carousel-section">
        <div id="carouselCitiNova" class="carousel slide" data-bs-ride="carousel" data-bs-interval="6000">
            <div class="carousel-inner">
                <!-- Slide 1 -->
                <div class="carousel-item active">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-lg-6 col-12 animate__animated animate__fadeInLeft">
                                <div class="text-wrapper">
                                    <h2>CITINOVA – Gestion des Infrastructures Territoriales</h2>
                                    <p>
                                        Gérez, suivez et améliorez les infrastructures de votre communauté. 
                                        Notre plateforme centralisée permet une gestion optimale des ressources 
                                        publiques à tous les niveaux administratifs du Bénin.
                                    </p>
                                    <div class="d-flex gap-3">
                                        <a href="#a-propos" class="btn btn-citinova mt-1">Accéder au Portail</a>
                                        <button class="btn btn-report-section mt-1" data-bs-toggle="modal" data-bs-target="#reportModal">
                                            <i class="fas fa-exclamation-triangle me-2"></i>Signaler un problème
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12 animate__animated animate__fadeInRight">
                                <div class="image-decor-wrapper position-relative">
                                    <img src="https://images.unsplash.com/photo-1583324113626-70df0f4deaab?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" class="main-img img-fluid" alt="Infrastructures urbaines">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Slide 2 -->
                <div class="carousel-item">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-lg-6 col-12 animate__animated animate__fadeInLeft">
                                <div class="text-wrapper">
                                    <h2>Centralisation des Données Infrastructures</h2>
                                    <p>
                                        Visualisez en temps réel l'état de toutes les infrastructures publiques 
                                        de votre territoire. Des écoles aux centres de santé, des routes aux marchés, 
                                        accédez à une vue d'ensemble complète et actualisée.
                                    </p>
                                    <div class="d-flex gap-3">
                                        <a href="#cours" class="btn btn-citinova mt-1">Explorer les Données</a>
                                        <button class="btn btn-report-section mt-1" data-bs-toggle="modal" data-bs-target="#reportModal">
                                            <i class="fas fa-exclamation-triangle me-2"></i>Signaler un problème
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12 animate__animated animate__fadeInRight">
                                <div class="image-decor-wrapper position-relative">
                                    <img src="https://images.unsplash.com/photo-1542744173-8e7e53415bb0?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" class="main-img img-fluid" alt="Planification urbaine">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Slide 3 -->
                <div class="carousel-item">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-lg-6 col-12 animate__animated animate__fadeInLeft">
                                <div class="text-wrapper">
                                    <h2>Collaboration Multi-Niveaux</h2>
                                    <p>
                                        Travaillez en synergie entre les différents échelons administratifs. 
                                        Des gestionnaires locaux aux administrateurs nationaux, notre plateforme 
                                        facilite la coordination et l'optimisation des projets d'infrastructures.
                                    </p>
                                    <div class="d-flex gap-3">
                                        <a href="#admin" class="btn btn-citinova mt-1">Découvrir la Collaboration</a>
                                        <button class="btn btn-report-section mt-1" data-bs-toggle="modal" data-bs-target="#reportModal">
                                            <i class="fas fa-exclamation-triangle me-2"></i>Signaler un problème
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12 animate__animated animate__fadeInRight">
                                <div class="image-decor-wrapper position-relative">
                                    <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" class="main-img img-fluid" alt="Collaboration">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Éléments de décoration -->
            <img src="https://cdn-icons-png.flaticon.com/512/484/484167.png" class="decor decor-1" alt="Décoration 1">
            <img src="https://cdn-icons-png.flaticon.com/512/484/484167.png" class="decor decor-2" alt="Décoration 2">
            <img src="https://cdn-icons-png.flaticon.com/512/484/484167.png" class="decor decor-3" alt="Décoration 3">
            
            <!-- Contrôles repositionnés -->
            <button class="carousel-control-prev custom-control ms-3" type="button" data-bs-target="#carouselCitiNova" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next custom-control me-3" type="button" data-bs-target="#carouselCitiNova" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    </section>

    <!-- Section À propos -->
    <section id="a-propos" class="section-apropos py-5">
        <div class="container">
            <div class="row align-items-center">
                <!-- Texte dynamique -->
                <div class="col-lg-7 col-12 mb-4 mb-lg-0" style="text-align: justify;">
                    <span class="who-we">Qui sommes-nous</span>
                    <h2 class="section-title text-start mb-4">À propos de CITINOVA</h2>
                    <div id="ecole-description" class="section-description">
                        <p>CITINOVA est une plateforme innovante dédiée à la gestion centralisée des infrastructures territoriales au Bénin. Notre mission est de moderniser la gestion des ressources publiques en offrant aux administrations à tous les niveaux des outils performants pour le suivi, la maintenance et le développement des infrastructures.</p>
                        <p>Notre solution permet une collaboration efficace entre les différents acteurs territoriaux, depuis les gestionnaires locaux jusqu'aux décideurs nationaux, en passant par les préfets et les maires.</p>
                    </div>
                    <blockquote class="founder-quote">
                        "Notre vision : un Bénin où chaque infrastructure publique est optimisée pour le bien-être des citoyens"
                    </blockquote>
                    <div class="d-flex gap-3">
                        <a href="#programmes" class="btn btn-citinova mt-3">Découvrir nos domaines</a>
                        <button class="btn btn-report-section mt-3" data-bs-toggle="modal" data-bs-target="#reportModal">
                            <i class="fas fa-exclamation-triangle me-2"></i>Signaler un problème
                        </button>
                    </div>
                </div>
                <!-- Image animée -->
                <div class="col-lg-5 col-12 text-center">
                    <div class="image-wrapper">
                        <img src="https://images.unsplash.com/photo-1504307651254-35680f356dfd?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Carte du Bénin" class="img-wave-border img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Domaines d'infrastructure -->
    <section id="programmes" class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <p class="who-we text-center">Nos domaines d'intervention</p>
                <h2 class="fw-bold">Domaines d'Infrastructures</h2>
                <p class="text-muted">CITINOVA couvre l'ensemble des infrastructures publiques essentielles au développement territorial. Notre plateforme permet une gestion optimisée de chaque catégorie d'infrastructures avec des outils adaptés aux besoins spécifiques.</p>
                <button class="btn btn-report-section mt-2" data-bs-toggle="modal" data-bs-target="#reportModal">
                    <i class="fas fa-exclamation-triangle me-2"></i>Signaler un problème d'infrastructure
                </button>
            </div>

            <div class="row g-4">
                <!-- Éducation -->
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0 programme-card">
                        <img src="{{ asset('images/INFRASTRUCTURE_etucatif.jpg') }}" class="card-img-top" alt="Infrastructures éducatives">
                        <div class="card-body">
                            <h5 class="card-title text-orange">Éducation</h5>
                            <p class="card-text">Gestion des établissements scolaires, universités et centres de formation professionnelle.</p>
                            <!-- Statistiques -->
                            <div class="d-flex align-items-center justify-content-between contribution-line">
                                <span class="fw-semibold text-muted">Infrastructures suivies</span>
                                <span class="badge rounded-pill bg-gradient-orange">1,247</span>
                            </div>
                            <div class="d-flex gap-2 mt-3">
                                <a href="#" class="btn btn-glass btn-sm flex-fill">Explorer</a>
                                <button class="btn btn-report-section btn-sm" data-bs-toggle="modal" data-bs-target="#reportModal">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Santé -->
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0 programme-card">
                        <img src="{{ asset('images/infrastructure_santé.jpeg') }}" class="card-img-top" alt="Infrastructures de santé">
                        <div class="card-body">
                            <h5 class="card-title text-orange">Santé</h5>
                            <p class="card-text">Suivi des hôpitaux, centres de santé, dispensaires et infrastructures médicales.</p>
                            <!-- Statistiques -->
                            <div class="d-flex align-items-center justify-content-between contribution-line">
                                <span class="fw-semibold text-muted">Infrastructures suivies</span>
                                <span class="badge rounded-pill bg-gradient-orange">384</span>
                            </div>
                            <div class="d-flex gap-2 mt-3">
                                <a href="#" class="btn btn-glass flex-fill">Explorer</a>
                                <button class="btn btn-report-section btn-sm" data-bs-toggle="modal" data-bs-target="#reportModal">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Transport -->
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0 programme-card">
                        <img src="{{ asset('images/transport1.jpeg') }}" class="card-img-top" alt="Infrastructures de transport">
                        <div class="card-body">
                            <h5 class="card-title text-orange">Transport</h5>
                            <p class="card-text">Gestion des routes, ponts, aéroports et autres infrastructures de mobilité.</p>
                            <!-- Statistiques -->
                            <div class="d-flex align-items-center justify-content-between contribution-line">
                                <span class="fw-semibold text-muted">Km de routes suivis</span>
                                <span class="badge rounded-pill bg-gradient-orange">2,156</span>
                            </div>
                            <div class="d-flex gap-2 mt-3">
                                <a href="#" class="btn btn-glass flex-fill">Explorer</a>
                                <button class="btn btn-report-section btn-sm" data-bs-toggle="modal" data-bs-target="#reportModal">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bloc caché avec plus d'infrastructures -->
                <div class="collapse" id="moreInfrastructures">
                    <div class="row g-4 mt-2">
                        <!-- Énergie -->
                        <div class="col-md-4">
                            <div class="card h-100 shadow-sm border-0 programme-card">
                                <img src="https://images.unsplash.com/photo-1473341304170-971dccb5ac1e?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" class="card-img-top" alt="Infrastructures énergétiques">
                                <div class="card-body">
                                    <h5 class="card-title text-orange">Énergie</h5>
                                    <p class="card-text">Centrales électriques, réseaux de distribution, barrages et infrastructures solaires.</p>
                                    <div class="d-flex align-items-center justify-content-between contribution-line">
                                        <span class="fw-semibold text-muted">Centrales suivies</span>
                                        <span class="badge rounded-pill bg-gradient-orange">24</span>
                                    </div>
                                    <div class="d-flex gap-2 mt-3">
                                        <a href="#" class="btn btn-glass btn-sm flex-fill">Explorer</a>
                                        <button class="btn btn-report-section btn-sm" data-bs-toggle="modal" data-bs-target="#reportModal">
                                            <i class="fas fa-exclamation-triangle"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Eau et Assainissement -->
                        <div class="col-md-4">
                            <div class="card h-100 shadow-sm border-0 programme-card">
                                <img src="{{ asset('images/hydrolique.jpeg') }}" class="card-img-top" alt="Infrastructures hydrauliques">
                                <div class="card-body">
                                    <h5 class="card-title text-orange">Eau et Assainissement</h5>
                                    <p class="card-text">Adduction d'eau, stations de traitement, réseaux d'assainissement et barrages.</p>
                                    <div class="d-flex align-items-center justify-content-between contribution-line">
                                        <span class="fw-semibold text-muted">Stations suivies</span>
                                        <span class="badge rounded-pill bg-gradient-orange">156</span>
                                    </div>
                                    <div class="d-flex gap-2 mt-3">
                                        <a href="#" class="btn btn-glass btn-sm flex-fill">Explorer</a>
                                        <button class="btn btn-report-section btn-sm" data-bs-toggle="modal" data-bs-target="#reportModal">
                                            <i class="fas fa-exclamation-triangle"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Télécommunications -->
                        <div class="col-md-4">
                            <div class="card h-100 shadow-sm border-0 programme-card">
                                <img src="{{ asset('images/telecom3.jpeg') }}" class="card-img-top" alt="Infrastructures télécoms">
                                <div class="card-body">
                                    <h5 class="card-title text-orange">Télécommunications</h5>
                                    <p class="card-text">Fibre optique, tours de téléphonie, centres de données et réseaux numériques.</p>
                                    <div class="d-flex align-items-center justify-content-between contribution-line">
                                        <span class="fw-semibold text-muted">Tours suivies</span>
                                        <span class="badge rounded-pill bg-gradient-orange">1,842</span>
                                    </div>
                                    <div class="d-flex gap-2 mt-3">
                                        <a href="#" class="btn btn-glass btn-sm flex-fill">Explorer</a>
                                        <button class="btn btn-report-section btn-sm" data-bs-toggle="modal" data-bs-target="#reportModal">
                                            <i class="fas fa-exclamation-triangle"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Administratif -->
                        <div class="col-md-4">
                            <div class="card h-100 shadow-sm border-0 programme-card">
                                <img src="{{ asset('images/administratif.jpeg') }}" class="card-img-top" alt="Infrastructures administratives">
                                <div class="card-body">
                                    <h5 class="card-title text-orange">Administratif</h5>
                                    <p class="card-text">Ministères, préfectures, mairies, palais de justice et bâtiments publics.</p>
                                    <div class="d-flex align-items-center justify-content-between contribution-line">
                                        <span class="fw-semibold text-muted">Bâtiments suivis</span>
                                        <span class="badge rounded-pill bg-gradient-orange">478</span>
                                    </div>
                                    <div class="d-flex gap-2 mt-3">
                                        <a href="#" class="btn btn-glass btn-sm flex-fill">Explorer</a>
                                        <button class="btn btn-report-section btn-sm" data-bs-toggle="modal" data-bs-target="#reportModal">
                                            <i class="fas fa-exclamation-triangle"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sport et Culture -->
                        <div class="col-md-4">
                            <div class="card h-100 shadow-sm border-0 programme-card">
                                <img src="{{ asset('images/sport_culture.jpeg') }}" class="card-img-top" alt="Infrastructures sportives">
                                <div class="card-body">
                                    <h5 class="card-title text-orange">Sport et Culture</h5>
                                    <p class="card-text">Stades, palais des sports, musées, bibliothèques et centres culturels.</p>
                                    <div class="d-flex align-items-center justify-content-between contribution-line">
                                        <span class="fw-semibold text-muted">Infrastructures suivies</span>
                                        <span class="badge rounded-pill bg-gradient-orange">89</span>
                                    </div>
                                    <div class="d-flex gap-2 mt-3">
                                        <a href="#" class="btn btn-glass btn-sm flex-fill">Explorer</a>
                                        <button class="btn btn-report-section btn-sm" data-bs-toggle="modal" data-bs-target="#reportModal">
                                            <i class="fas fa-exclamation-triangle"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Agricole -->
                        <div class="col-md-4">
                            <div class="card h-100 shadow-sm border-0 programme-card">
                                <img src="https://images.unsplash.com/photo-1500382017468-9049fed747ef?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" class="card-img-top" alt="Infrastructures agricoles">
                                <div class="card-body">
                                    <h5 class="card-title text-orange">Agricole</h5>
                                    <p class="card-text">Silos, unités de transformation, marchés agricoles et centres de recherche.</p>
                                    <div class="d-flex align-items-center justify-content-between contribution-line">
                                        <span class="fw-semibold text-muted">Silos suivis</span>
                                        <span class="badge rounded-pill bg-gradient-orange">67</span>
                                    </div>
                                    <div class="d-flex gap-2 mt-3">
                                        <a href="#" class="btn btn-glass btn-sm flex-fill">Explorer</a>
                                        <button class="btn btn-report-section btn-sm" data-bs-toggle="modal" data-bs-target="#reportModal">
                                            <i class="fas fa-exclamation-triangle"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bouton Voir plus -->
                <div class="col-12 text-center mt-4">
                    <button id="toggleInfraBtn" class="btn btn-vp" type="button" data-bs-toggle="collapse" data-bs-target="#moreInfrastructures" aria-expanded="false" aria-controls="moreInfrastructures">
                        Voir tous les domaines d'infrastructure
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Histoire du Bénin -->
    <section id="histoire" class="benin-history-section py-5">
        <div class="container">
            <div class="text-center mb-5">
                <p class="who-we text-center">Notre patrimoine</p>
                <h2 class="fw-bold text-white">Histoire et Patrimoine du Bénin</h2>
                <p class="text-light">Découvrez la richesse historique et culturelle du Bénin, berceau de civilisations anciennes et terre d'innovations modernes.</p>
                <button class="btn btn-report-section mt-2" data-bs-toggle="modal" data-bs-target="#reportModal">
                    <i class="fas fa-exclamation-triangle me-2"></i>Signaler un problème patrimonial
                </button>
            </div>

            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="history-card text-center">
                        <div class="history-icon">
                            <i class="fas fa-landmark"></i>
                        </div>
                        <h4 class="history-title">Royaumes Anciens</h4>
                        <p>Découvrez les grands royaumes du Dahomey, du Borgou et leurs richesses architecturales préservées.</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="history-card text-center">
                        <div class="history-icon">
                            <i class="fas fa-university"></i>
                        </div>
                        <h4 class="history-title">Patrimoine UNESCO</h4>
                        <p>Les palais royaux d'Abomey et la ville de Ouidah classés au patrimoine mondial de l'UNESCO.</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="history-card text-center">
                        <div class="history-icon">
                            <i class="fas fa-water"></i>
                        </div>
                        <h4 class="history-title">Ganvié la Venise</h4>
                        <p>La cité lacustre de Ganvié, merveille d'architecture traditionnelle sur pilotis.</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="history-card text-center">
                        <div class="history-icon">
                            <i class="fas fa-monument"></i>
                        </div>
                        <h4 class="history-title">Porte du Non-Retour</h4>
                        <p>Mémorial de la traite négrière à Ouidah, lieu de mémoire et de recueillement.</p>
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-lg-6">
                    <div class="history-card">
                        <h4 class="history-title">Infrastructures Historiques</h4>
                        <p>Le Bénin préserve un patrimoine architectural unique alliant traditions ancestrales et modernité. Des cases traditionnelles aux bâtiments coloniaux, chaque édifice raconte une partie de notre histoire.</p>
                        <ul class="list-unstyled mt-3">
                            <li><i class="fas fa-check text-warning me-2"></i> Cases à étage du Nord-Bénin</li>
                            <li><i class="fas fa-check text-warning me-2"></i> Architecture coloniale de Porto-Novo</li>
                            <li><i class="fas fa-check text-warning me-2"></i> Tata somba classés au patrimoine</li>
                            <li><i class="fas fa-check text-warning me-2"></i> Mosquées en terre de la région</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="history-card">
                        <h4 class="history-title">Modernisation et Préservation</h4>
                        <p>CITINOVA s'engage à préserver le patrimoine architectural béninois tout en accompagnant le développement d'infrastructures modernes et durables.</p>
                        <p>Notre plateforme permet de suivre l'état des monuments historiques et de coordonner les travaux de restauration pour les générations futures.</p>
                        <button class="btn btn-report-section mt-3" data-bs-toggle="modal" data-bs-target="#reportModal">
                            <i class="fas fa-exclamation-triangle me-2"></i>Signaler un monument à restaurer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal pour signaler un problème -->
    <div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="reportModalLabel"><i class="fas fa-exclamation-triangle me-2"></i>Signaler un problème d'infrastructure</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="reportForm">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="problemType" class="form-label">Type de problème</label>
                                <select class="form-select" id="problemType" required>
                                    <option value="">Sélectionnez le type</option>
                                    <option value="route">Route dégradée</option>
                                    <option value="batiment">Bâtiment endommagé</option>
                                    <option value="eau">Problème d'eau</option>
                                    <option value="electricite">Panne d'électricité</option>
                                    <option value="sante">Infrastructure de santé</option>
                                    <option value="education">École/Université</option>
                                    <option value="autre">Autre</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="location" class="form-label">Localisation</label>
                                <input type="text" class="form-control" id="location" placeholder="Commune, quartier..." required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="problemDescription" class="form-label">Description du problème</label>
                            <textarea class="form-control" id="problemDescription" rows="4" placeholder="Décrivez le problème en détail..." required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="photo" class="form-label">Photo (optionnelle)</label>
                            <input class="form-control" type="file" id="photo" accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label for="contact" class="form-label">Vos coordonnées (optionnel)</label>
                            <input type="text" class="form-control" id="contact" placeholder="Email ou téléphone">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-warning" onclick="submitReport()">Envoyer le signalement</button>
                </div>
            </div>
        </div>
    </div>

     <!-- Section Services -->
    <section id="cours" class="py-5">
        <div class="container">
            <p class="who-we text-center">Nos services</p>
            <h2 class="text-center mb-4">Services CITINOVA</h2>
            <p class="text-center mb-5">Découvrez les services que nous proposons pour optimiser la gestion des infrastructures territoriales au Bénin.</p>

            <div class="row g-4" id="coursList">
                <!-- Cartes visibles par défaut -->
                <div class="col-md-4">
                    <div class="cours-card h-100">
                        <div class="card-body">
                            <h5 class="cours-title"><span class="bg-3">01</span>Suivi en Temps Réel</h5>
                            <p class="cours-text">Surveillance continue de l'état des infrastructures avec alertes automatiques pour maintenance préventive.</p>
                            <p class="cours-niveau">
                                <i class="fas fa-chart-line text-warning ms-3 me-2"></i> Analytics
                                <i class="fas fa-bell text-warning ms-3 me-2"></i> Alertes
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="cours-card h-100">
                        <div class="card-body">
                            <h5 class="cours-title"><span class="bg-3">02</span>Gestion Budgétaire</h5>
                            <p class="cours-text">Optimisation des ressources financières avec suivi des dépenses et planification des investissements.</p>
                            <p class="cours-niveau">
                                <i class="fas fa-money-bill-wave text-warning me-2"></i> Finance
                                <i class="fas fa-chart-pie text-warning ms-3 me-2"></i> Reporting
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="cours-card h-100">
                        <div class="card-body">
                            <h5 class="cours-title">
                                <span class="bg-3">03</span> Collaboration Multi-Niveaux
                            </h5>
                            <p class="cours-text">
                                Plateforme de coordination entre les différents échelons administratifs pour une gestion cohérente.
                            </p>
                            <p class="cours-niveau">
                                <i class="fas fa-users text-warning ms-3 me-2"></i> Collaboration
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Bloc caché -->
                <div class="collapse" id="moreCourses">
                    <div class="row g-4 mt-2">
                        <div class="col-md-4">
                            <div class="cours-card h-100">
                                <div class="card-body">
                                    <h5 class="cours-title"><span class="bg-3">04</span>Cartographie Interactive</h5>
                                    <p class="cours-text">Visualisation géographique des infrastructures avec filtres par type, état et localisation.</p>
                                    <p class="cours-niveau">
                                        <i class="fas fa-map text-warning ms-3 me-2"></i> Géolocalisation
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="cours-card h-100">
                                <div class="card-body">
                                    <h5 class="cours-title"><span class="bg-3">05</span>Rapports Automatisés</h5>
                                    <p class="cours-text">Génération automatique de rapports détaillés pour la prise de décision éclairée.</p>
                                    <p class="cours-niveau">
                                        <i class="fas fa-file-alt text-warning ms-3 me-2"></i> Documentation
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="cours-card h-100">
                                <div class="card-body">
                                    <h5 class="cours-title"><span class="bg-3">06</span>Maintenance Prédictive</h5>
                                    <p class="cours-text">Anticipation des besoins de maintenance grâce à l'analyse des données historiques.</p>
                                    <p class="cours-niveau">
                                        <i class="fas fa-tools text-warning ms-3 me-2"></i> Maintenance
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bouton intégré dans la liste -->
                <div class="cours-toggle-wrapper">
                    <button id="toggleBtn" class="btn btn-vp toggle-btn" type="button" data-bs-toggle="collapse" data-bs-target="#moreCourses" aria-expanded="false" aria-controls="moreCourses">
                        Voir plus de services
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Projets -->
    <section id="activites" class="timeline-section">
        <div class="container">
            <p class="who-we text-center">Nos réalisations</p>
            <h2 class="section-title text-center" > Projets Réalisés</h2>
            <p class="text-center mb-5">
                Découvrez les projets d'infrastructures que nous avons accompagnés à travers le Bénin, avec des résultats concrets et mesurables.
            </p>
            <div class="timeline">

                <!-- Projet 1 -->
                <div class="timeline-item left">
                    <div class="timeline-content">
                        <h4>Modernisation des Écoles Primaires <i class="fas fa-school text-orange"></i></h4>
                        <p>Rénovation de 50 écoles primaires dans 5 départements, avec amélioration des conditions d'apprentissage pour 15,000 élèves.</p>
                    </div>
                </div>

                <!-- Projet 2 -->
                <div class="timeline-item right">
                    <div class="timeline-content">
                        <h4>Réseau Routier Departmental <i class="fas fa-road text-orange"></i></h4>
                        <p>Construction et réhabilitation de 500 km de routes départementales, améliorant la connectivité entre les communes.</p>
                    </div>
                </div>

                <!-- Projet 3 -->
                <div class="timeline-item left">
                    <div class="timeline-content">
                        <h4>Centres de Santé Communautaires <i class="fas fa-hospital text-orange"></i></h4>
                        <p>Équipement de 20 centres de santé avec du matériel médical moderne, bénéficiant à 200,000 habitants.</p>
                    </div>
                </div>

                <div class="timeline-item right">
                    <div class="timeline-content">
                        <h4>Infrastructures Numériques <i class="fas fa-wifi text-orange"></i></h4>
                        <p>Déploiement de la fibre optique dans 10 communes, facilitant l'accès au haut débit pour les administrations et les citoyens.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Équipe -->
    <section id="admin" class="teachers-section p-5 bg-light">
    <div class="container-fluid text-center">
        <p class="who-we text-center">Notre équipe</p>
        <h2 class="mb-4">L'Équipe CITINOVA</h2>
        <div class="row g-3 justify-content-center">
            <div class="col-md-6 col-lg-3">
                <div class="teacher-card text-center p-2 rounded">
                    <div class="image">
                        <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" alt="Directeur Général" class="teacher-img" style="width: 200px; height: 200px; object-fit: cover; border-radius: 50%;">
                    </div>
                    <h5 class="teacher-name mt-3">Jean Akplogan</h5>
                    <p class="teacher-title">Directeur Général</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="teacher-card text-center p-2 rounded">
                    <div class="image">
                        <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" alt="Responsable Technique" class="teacher-img" style="width: 200px; height: 200px; object-fit: cover; border-radius: 50%;">
                    </div>
                    <h5 class="teacher-name mt-3">Marie Dossou</h5>
                    <p class="teacher-title">Responsable Technique</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="teacher-card text-center p-2 rounded">
                    <div class="image">
                        <img src="https://images.unsplash.com/photo-1580489944761-15a19d654956?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" alt="Chef de Projet" class="teacher-img" style="width: 200px; height: 200px; object-fit: cover; border-radius: 50%;">
                    </div>
                    <h5 class="teacher-name mt-3">Alice Sèna</h5>
                    <p class="teacher-title">Chef de Projet</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="teacher-card text-center p-2 rounded">
                    <div class="image">
                        <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" alt="Expert Infrastructure" class="teacher-img" style="width: 200px; height: 200px; object-fit: cover; border-radius: 50%;">
                    </div>
                    <h5 class="teacher-name mt-3">Koffi Adjanoh</h5>
                    <p class="teacher-title">Expert Infrastructure</p>
                </div>
            </div>
        </div>
    </div>
</section>

    <!-- Section Galerie -->
    <section id="galerie">
        <div class="container">
            <p class="who-we text-center">Galerie de nos réalisations</p>
            <h2 class="section-title text-center" >Galerie</h2>

            <div class="row g-4">
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="overflow-hidden rounded shadow-sm">
                        <img src="https://images.unsplash.com/photo-1542744173-8e7e53415bb0?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Infrastructure éducative" class="img-fluid gallery-img" data-bs-toggle="modal" data-bs-target="#galleryModal" data-img-src="https://images.unsplash.com/photo-1542744173-8e7e53415bb0?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80">
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-4">
                    <div class="overflow-hidden rounded shadow-sm">
                        <img src="https://images.unsplash.com/photo-1583324113626-70df0f4deaab?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Planification urbaine" class="img-fluid gallery-img" data-bs-toggle="modal" data-bs-target="#galleryModal" data-img-src="https://images.unsplash.com/photo-1583324113626-70df0f4deaab?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80">
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-4">
                    <div class="overflow-hidden rounded shadow-sm">
                        <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Infrastructure de transport" class="img-fluid gallery-img" data-bs-toggle="modal" data-bs-target="#galleryModal" data-img-src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80">
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-4">
                    <div class="overflow-hidden rounded shadow-sm">
                        <img src="{{ asset('images/santé_moderne.jpeg') }}" alt="Infrastructure de santé" class="img-fluid gallery-img" data-bs-toggle="modal" data-bs-target="#galleryModal" data-img-src="https://images.unsplash.com/photo-1516549655669-df5c78905421?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80">
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-4">
                    <div class="overflow-hidden rounded shadow-sm">
                        <img src="https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Réseau routier" class="img-fluid gallery-img" data-bs-toggle="modal" data-bs-target="#galleryModal" data-img-src="https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80">
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-4">
                    <div class="overflow-hidden rounded shadow-sm">
                        <img src="{{ asset('images/ecole_moderne.jpeg') }}" alt="École moderne" class="img-fluid gallery-img" data-bs-toggle="modal" data-bs-target="#galleryModal" data-img-src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal pour la galerie -->
    <div class="modal fade modal-gallery" id="galleryModal" tabindex="-1" aria-labelledby="galleryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header border-0 p-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <img id="modalImage" src="" alt="" class="img-fluid">
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer text-light pb-4">
        <div class="container p-3">
            <div class="row gy-5 grop">
                <!-- À propos -->
                <div class="col-md-3">
                    <h5 class="footer-title">À propos de CITINOVA</h5>
                    <hr class="footer-separator">
                    <p class="footer-text">
                        Plateforme innovante de gestion des infrastructures territoriales au Bénin.<br><br>
                        Notre mission est de moderniser la gestion des ressources publiques pour un développement territorial harmonieux.
                    </p>
                </div>

                <div class="col-md-3">
                    <h5 class="footer-title"> Localisation</h5>
                    <hr class="footer-separator">
                    <div class="footer-map">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3964.123456789012!2d2.3466118!3d6.4502548!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwMjcnMDAuOSJOIDLCsDIwJzQ3LjgiRQ!5e0!3m2!1sfr!2sbj!4v1234567890"
                            width="100%" 
                            height="150" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                        <p class="footer-text">
                            Cotonou, Bénin<br>
                        </p>
                    </div>
                </div>

                <!-- Contact -->
                <div class="col-md-3">
                    <h5 class="footer-title">Contact</h5>
                    <hr class="footer-separator">
                    <form id="contactForm">
                        @csrf
                        <input type="text" name="name" class="form-control form-control-sm mb-3" placeholder="Nom" required>
                        <input type="email" name="email" class="form-control form-control-sm mb-3" placeholder="Email" required>
                        <textarea name="message" class="form-control form-control-sm mb-3" rows="2" placeholder="Message" required></textarea>
                        <button type="submit" class="btn btn-sm btn-warning w-100">Envoyer</button>
                    </form>

                    <div id="formResponse" class="mt-3"></div>
                </div>

                <!-- Coordonnées -->
                <div class="col-md-3">
                    <h5 class="footer-title">Coordonnées</h5>
                    <hr class="footer-separator">
                    <p class="footer-text d-flex flex-column gap-3">
                        <span><i class="bi bi-geo-alt-fill text-warning me-2"></i> Cotonou, Bénin</span>
                        <span><i class="bi bi-telephone-fill text-warning me-2"></i> +229 XX XX XX XX</span>
                        <span><i class="bi bi-envelope-fill text-warning me-2"></i> support@citinova.bj</span>
                    </p>
                </div>
            </div>

            <hr class="border-light mt-5">
            <div class="text-center small">
                &copy; 2025 CITINOVA — Tous droits réservés.
            </div>
        </div>
    </footer>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Scripts personnalisés -->
    <script>
        // Script pour la galerie modale
        document.addEventListener('DOMContentLoaded', function() {
            const galleryImages = document.querySelectorAll('.gallery-img');
            const modalImage = document.getElementById('modalImage');
            const galleryModal = document.getElementById('galleryModal');
            
            galleryImages.forEach(img => {
                img.addEventListener('click', function() {
                    const imgSrc = this.getAttribute('data-img-src');
                    modalImage.src = imgSrc;
                    modalImage.alt = this.alt;
                });
            });
            
            // Gestion du bouton "Voir plus" des infrastructures
            const toggleInfraBtn = document.getElementById('toggleInfraBtn');
            if (toggleInfraBtn) {
                toggleInfraBtn.addEventListener('click', function() {
                    const expanded = this.getAttribute('aria-expanded') === 'true';
                    this.textContent = expanded ? 'Voir tous les domaines d\'infrastructure' : 'Voir moins';
                });
            }
            
            // Gestion du bouton "Voir plus" des services
            const toggleBtn = document.getElementById('toggleBtn');
            if (toggleBtn) {
                toggleBtn.addEventListener('click', function() {
                    const expanded = this.getAttribute('aria-expanded') === 'true';
                    this.textContent = expanded ? 'Voir plus de services' : 'Voir moins';
                });
            }
            
            // Animation au défilement
            const animateOnScroll = function() {
                const elements = document.querySelectorAll('.timeline-item, .programme-card, .cours-card, .teacher-card, .history-card');
                
                elements.forEach(element => {
                    const elementTop = element.getBoundingClientRect().top;
                    const elementVisible = 150;
                    
                    if (elementTop < window.innerHeight - elementVisible) {
                        element.classList.add('animate__animated', 'animate__fadeInUp');
                    }
                });
            };
            
            window.addEventListener('scroll', animateOnScroll);
            // Déclencher une fois au chargement
            animateOnScroll();
        });

        // Fonction pour soumettre un signalement
        function submitReport() {
            const problemType = document.getElementById('problemType').value;
            const location = document.getElementById('location').value;
            const description = document.getElementById('problemDescription').value;
            
            if (!problemType || !location || !description) {
                alert('Veuillez remplir tous les champs obligatoires.');
                return;
            }
            
            // Simulation d'envoi
            alert('Merci ! Votre signalement a été envoyé. Nous traiterons votre demande rapidement.');
            document.getElementById('reportForm').reset();
            bootstrap.Modal.getInstance(document.getElementById('reportModal')).hide();
        }
    </script>
</body>
</html>
    
   