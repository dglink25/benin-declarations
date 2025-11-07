
@include('layouts.navigation')

@php
    $departements = $departements ?? \App\Models\Departement::orderBy('name')->get();
@endphp <!-- Inclure la navigation Laravel -->

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
    
    /* Section Impact */
    .impact-section {
        padding: 100px 0;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    }
    
    .impact-card {
        transition: all 0.3s ease;
        border-radius: 15px;
        overflow: hidden;
        height: 100%;
    }
    
    .impact-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
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
                <p class="text-muted">CITINOVA se concentre sur deux types d'infrastructures essentielles pour le développement territorial : l'éclairage public et les routes. Notre plateforme permet une gestion optimisée de chaque catégorie avec des outils adaptés aux besoins spécifiques.</p>
                <button class="btn btn-report-section mt-2" data-bs-toggle="modal" data-bs-target="#reportModal">
                    <i class="fas fa-exclamation-triangle me-2"></i>Signaler un problème d'infrastructure
                </button>
            </div>

            <div class="row g-4">
                <!-- Éclairage Public -->
                <div class="col-md-6">
                    <div class="card h-100 shadow-sm border-0 programme-card">
                        <img src="{{ asset('images/lampe.jpg') }}" class="card-img-top" alt="Éclairage public">
                        <div class="card-body">
                            <h5 class="card-title text-orange">Éclairage Public</h5>
                            <p class="card-text">Gestion et suivi des infrastructures d'éclairage public pour améliorer la sécurité et la qualité de vie nocturne.</p>
                            <!-- Statistiques -->
                            <div class="d-flex align-items-center justify-content-between contribution-line">
                                <span class="fw-semibold text-muted">Points lumineux suivis</span>
                                <span class="badge rounded-pill bg-gradient-orange">15,842</span>
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

                <!-- Routes -->
                <div class="col-md-6">
                    <div class="card h-100 shadow-sm border-0 programme-card">
                        <img src="{{ asset('images/Routes1.jpg') }}" class="card-img-top" alt="Routes">
                        <div class="card-body">
                            <h5 class="card-title text-orange">Routes</h5>
                            <p class="card-text">Suivi et maintenance des infrastructures routières pour assurer la fluidité et la sécurité du transport.</p>
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
            </div>
        </div>
    </section>

    <!-- Section Impact -->
    <section id="impact" class="impact-section py-5">
        <div class="container">
            <div class="text-center mb-5">
                <p class="who-we text-center">Notre impact</p>
                <h2 class="fw-bold">Impact sur le territoire</h2>
                <p class="text-muted">Découvrez comment CITINOVA transforme la gestion des infrastructures au Bénin avec des résultats concrets et mesurables.</p>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0 impact-card">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <i class="fas fa-road fa-3x text-orange"></i>
                            </div>
                            <h5 class="card-title">Routes réhabilitées</h5>
                            <p class="card-text">Plus de 300 km de routes ont été réhabilitées grâce à notre système de suivi et de signalement.</p>
                            <div class="d-flex align-items-center justify-content-center">
                                <span class="badge rounded-pill bg-gradient-orange">+42%</span>
                                <span class="ms-2 fw-semibold text-muted">d'efficacité</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0 impact-card">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <i class="fas fa-lightbulb fa-3x text-orange"></i>
                            </div>
                            <h5 class="card-title">Éclairage public amélioré</h5>
                            <p class="card-text">15,000 points lumineux suivis avec un taux de résolution des pannes augmenté de 65%.</p>
                            <div class="d-flex align-items-center justify-content-center">
                                <span class="badge rounded-pill bg-gradient-orange">+65%</span>
                                <span class="ms-2 fw-semibold text-muted">de résolution</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0 impact-card">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <i class="fas fa-users fa-3x text-orange"></i>
                            </div>
                            <h5 class="card-title">Communautés impactées</h5>
                            <p class="card-text">Plus de 2 millions de citoyens bénéficient d'infrastructures mieux entretenues et plus sûres.</p>
                            <div class="d-flex align-items-center justify-content-center">
                                <span class="badge rounded-pill bg-gradient-orange">2M+</span>
                                <span class="ms-2 fw-semibold text-muted">citoyens</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

            <!-- Modal pour signaler un problème - Version Urgence Immédiate uniquement -->
        <div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="reportModalLabel">
                            <i class="fas fa-exclamation-triangle me-2"></i>Signalement Urgence Immédiate
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="max-height: 80vh; overflow-y: auto;">
                        
                        {{-- Messages de statut --}}
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>✔ Succès :</strong> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>⚠ Erreur :</strong> {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <strong>Veuillez corriger les erreurs suivantes :</strong>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Formulaire Urgence Immédiate --}}
                        <form action="{{ route('declarations.store') }}" method="POST" enctype="multipart/form-data" id="urgenceForm">
                            @csrf
                            <input type="hidden" name="urgence" value="1">

                            {{-- Section Informations Personnelles --}}
                            <div class="card mb-4 border-0 shadow-sm">
                                <div class="card-header bg-warning text-dark">
                                    <h6 class="mb-0">
                                        <i class="fas fa-user me-2"></i>Informations Personnelles (Obligatoires)
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="nom" class="form-label">Nom <span class="text-danger">*</span></label>
                                            <input type="text" name="nom" id="nom" class="form-control" placeholder="Votre nom complet" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                            <input type="email" name="email" id="email" class="form-control" placeholder="votre@email.com" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="user_telephone" class="form-label">Téléphone</label>
                                            <input type="tel" name="user_telephone" id="user_telephone" class="form-control" placeholder="Votre numéro de téléphone">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="user_adresse" class="form-label">Adresse</label>
                                            <input type="text" name="user_adresse" id="user_adresse" class="form-control" placeholder="Votre adresse complète">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Section Détails du Problème --}}
                            <div class="card mb-4 border-0 shadow-sm">
                                <div class="card-header bg-primary text-white">
                                    <h6 class="mb-0">
                                        <i class="fas fa-info-circle me-2"></i>Détails de l'Incident
                                    </h6>
                                </div>
                                <div class="card-body">
                                    {{-- Type de problème --}}
                                    <div class="mb-3">
                                        <label for="problemType" class="form-label">Type de problème <span class="text-danger">*</span></label>
                                        <select class="form-select" id="problemType" name="problemType" required>
                                            <option value="">Sélectionnez le type</option>
                                            <option value="eclairage">Problème d'éclairage public</option>
                                            <option value="route">Route dégradée</option>
                                            <option value="autre">Autre problème d'infrastructure</option>
                                        </select>
                                    </div>

                                    {{-- Images --}}
                                    <div class="mb-3">
                                        <label for="images" class="form-label">Photos du problème</label>
                                        <input type="file" name="images[]" multiple accept="image/*" id="images" 
                                            class="form-control">
                                        <div class="form-text">Prenez des photos claires du problème (max 50MB par image)</div>
                                    </div>

                                    {{-- Description --}}
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description du problème <span class="text-danger">*</span></label>
                                        <textarea name="description" id="description" rows="4" class="form-control" 
                                            placeholder="Décrivez précisément le problème, l'emplacement exact et toute information utile..." required></textarea>
                                    </div>
                                </div>
                            </div>

                            {{-- Section Localisation --}}
                            <div class="card mb-4 border-0 shadow-sm">
                                <div class="card-header bg-success text-white">
                                    <h6 class="mb-0">
                                        <i class="fas fa-map-marker-alt me-2"></i>Localisation du Problème
                                    </h6>
                                </div>
                                <div class="card-body">
                                    {{-- Choix mode localisation --}}
                                    <div class="mb-4">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="localisation_option" id="localisation_manuelle" value="manuelle" checked>
                                            <label class="form-check-label" for="localisation_manuelle">
                                                Saisir l'adresse manuellement
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="localisation_option" id="localisation_auto" value="auto">
                                            <label class="form-check-label" for="localisation_auto">
                                                Utiliser la géolocalisation
                                            </label>
                                        </div>
                                    </div>

                                    {{-- Localisation manuelle --}}
                                    <div id="localisationManuelle">
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <label for="departement_id" class="form-label">Département <span class="text-danger">*</span></label>
                                                <select name="departement_id" id="departement_id" class="form-select" required>
                                                    <option value="">-- Sélectionnez --</option>
                                                    @foreach($departements as $dep)
                                                        <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="commune_id" class="form-label">Commune <span class="text-danger">*</span></label>
                                                <select name="commune_id" id="commune_id" class="form-select" disabled required>
                                                    <option value="">-- Choisir un département --</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="arrondissement_id" class="form-label">Arrondissement</label>
                                                <select name="arrondissement_id" id="arrondissement_id" class="form-select" disabled>
                                                    <option value="">-- Choisir une commune --</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" name="quartier" class="form-control" placeholder="Quartier / Village">
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" name="rue" class="form-control" placeholder="Rue / Lieu-dit">
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" name="maison" class="form-control" placeholder="Numéro Maison">
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Localisation automatique --}}
                                    <div id="localisationAuto" class="d-none">
                                        <div class="mb-3">
                                            <button type="button" id="btnGeo" class="btn btn-outline-primary">
                                                <i class="fas fa-location-arrow me-2"></i>Activer la géolocalisation
                                            </button>
                                        </div>
                                        
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label for="latitude" class="form-label">Latitude</label>
                                                <input type="text" name="latitude" id="latitude" class="form-control" readonly>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="longitude" class="form-label">Longitude</label>
                                                <input type="text" name="longitude" id="longitude" class="form-control" readonly>
                                            </div>
                                        </div>
                                        
                                        <div id="geoInfo" class="mt-3 p-3 bg-light rounded d-none">
                                            <h6>Informations détectées :</h6>
                                            <div id="detectedAddress" class="text-muted"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Bouton de soumission --}}
                            <div class="text-center">
                                <button type="submit" class="btn btn-danger btn-lg px-5">
                                    <i class="fas fa-paper-plane me-2"></i>Envoyer le Signalement Urgent
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

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
                    <h5 class="teacher-name mt-3">Maurel LOGBO</h5>
                    <p class="teacher-title">Dev Front-end</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="teacher-card text-center p-2 rounded">
                    <div class="image">
                        <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" alt="Responsable Technique" class="teacher-img" style="width: 200px; height: 200px; object-fit: cover; border-radius: 50%;">
                    </div>
                    <h5 class="teacher-name mt-3">Daniella AGOUNGNON</h5>
                    <p class="teacher-title">Géomentienne</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="teacher-card text-center p-2 rounded">
                    <div class="image">
                        <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" alt="Expert Infrastructure" class="teacher-img" style="width: 200px; height: 200px; object-fit: cover; border-radius: 50%;">
                    </div>
                    <h5 class="teacher-name mt-3">Diègue HOUNDOKINNOU</h5>
                    <p class="teacher-title">Dev Back-end</p>
                </div>
            </div>
        </div>
    </div>
</section>

    <!-- Section Galerie -->
    <section id="galerie">
        <div class="container">
            <p class="who-we text-center">Problèmes signalés et résolus</p>
            <h2 class="section-title text-center" >Signalements</h2>

            <div class="row g-4">
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="overflow-hidden rounded shadow-sm">
                        <img src="https://images.unsplash.com/photo-1518837695005-2083093ee35b?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Éclairage public défaillant" class="img-fluid gallery-img" data-bs-toggle="modal" data-bs-target="#galleryModal" data-img-src="https://images.unsplash.com/photo-1518837695005-2083093ee35b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80">
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-4">
                    <div class="overflow-hidden rounded shadow-sm">
                        <img src="https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Route dégradée" class="img-fluid gallery-img" data-bs-toggle="modal" data-bs-target="#galleryModal" data-img-src="https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80">
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-4">
                    <div class="overflow-hidden rounded shadow-sm">
                        <img src="https://images.unsplash.com/photo-1583324113626-70df0f4deaab?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Route réhabilitée" class="img-fluid gallery-img" data-bs-toggle="modal" data-bs-target="#galleryModal" data-img-src="https://images.unsplash.com/photo-1583324113626-70df0f4deaab?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80">
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-4">
                    <div class="overflow-hidden rounded shadow-sm">
                        <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Éclairage public fonctionnel" class="img-fluid gallery-img" data-bs-toggle="modal" data-bs-target="#galleryModal" data-img-src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80">
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-4">
                    <div class="overflow-hidden rounded shadow-sm">
                        <img src="https://images.unsplash.com/photo-1542744173-8e7e53415bb0?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Travaux de réhabilitation" class="img-fluid gallery-img" data-bs-toggle="modal" data-bs-target="#galleryModal" data-img-src="https://images.unsplash.com/photo-1542744173-8e7e53415bb0?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80">
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-4">
                    <div class="overflow-hidden rounded shadow-sm">
                        <img src="https://images.unsplash.com/photo-1504307651254-35680f356dfd?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Carte des interventions" class="img-fluid gallery-img" data-bs-toggle="modal" data-bs-target="#galleryModal" data-img-src="https://images.unsplash.com/photo-1504307651254-35680f356dfd?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80">
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
                        <span><i class="bi bi-telephone-fill text-warning me-2"></i> +229 01 90 07 89 88</span>
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

            
        document.addEventListener('DOMContentLoaded', function() {
            // Gestion de la localisation manuelle/auto
            const locManuelle = document.getElementById('localisationManuelle');
            const locAuto = document.getElementById('localisationAuto');
            const locRadios = document.querySelectorAll('input[name="localisation_option"]');
            
            locRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === 'auto') {
                        locManuelle.classList.add('d-none');
                        locAuto.classList.remove('d-none');
                        // Rendre les champs de localisation manuelle non requis
                        document.querySelectorAll('#localisationManuelle select, #localisationManuelle input').forEach(field => {
                            field.required = false;
                        });
                    } else {
                        locManuelle.classList.remove('d-none');
                        locAuto.classList.add('d-none');
                        // Rendre les champs requis à nouveau
                        document.getElementById('departement_id').required = true;
                        document.getElementById('commune_id').required = true;
                    }
                });
            });

            // Géolocalisation
            const btnGeo = document.getElementById('btnGeo');
            if (btnGeo) {
                btnGeo.addEventListener('click', function() {
                    if (navigator.geolocation) {
                        btnGeo.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Localisation en cours...';
                        btnGeo.disabled = true;
                        
                        navigator.geolocation.getCurrentPosition(function(position) {
                            const lat = position.coords.latitude;
                            const lng = position.coords.longitude;
                            
                            document.getElementById('latitude').value = lat;
                            document.getElementById('longitude').value = lng;
                            
                            // Reverse geocoding simple
                            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                                .then(response => response.json())
                                .then(data => {
                                    const address = data.display_name || 'Adresse non disponible';
                                    document.getElementById('detectedAddress').textContent = address;
                                    document.getElementById('geoInfo').classList.remove('d-none');
                                    
                                    btnGeo.innerHTML = '<i class="fas fa-check me-2"></i>Localisation réussie';
                                })
                                .catch(error => {
                                    console.error('Erreur géocodage:', error);
                                    btnGeo.innerHTML = '<i class="fas fa-location-arrow me-2"></i>Activer la géolocalisation';
                                });
                            
                            btnGeo.disabled = false;
                            
                        }, function(error) {
                            console.error('Erreur géolocalisation:', error);
                            alert('Impossible d\'obtenir votre position. Veuillez vérifier les permissions de localisation.');
                            btnGeo.innerHTML = '<i class="fas fa-location-arrow me-2"></i>Activer la géolocalisation';
                            btnGeo.disabled = false;
                        });
                    } else {
                        alert('La géolocalisation n\'est pas supportée par votre navigateur.');
                    }
                });
            }

            // Gestion des départements/communes/arrondissements
            const departementSelect = document.getElementById('departement_id');
            const communeSelect = document.getElementById('commune_id');
            const arrondissementSelect = document.getElementById('arrondissement_id');

            if (departementSelect) {
                departementSelect.addEventListener('change', function() {
                    const depId = this.value;
                    communeSelect.innerHTML = '<option value="">Chargement...</option>';
                    communeSelect.disabled = true;
                    arrondissementSelect.innerHTML = '<option value="">-- Choisir une commune --</option>';
                    arrondissementSelect.disabled = true;

                    if (depId) {
                        fetch(`/get-communes/${depId}`)
                            .then(response => response.json())
                            .then(data => {
                                communeSelect.innerHTML = '<option value="">-- Sélectionnez une commune --</option>';
                                data.forEach(c => {
                                    communeSelect.innerHTML += `<option value="${c.id}">${c.name}</option>`;
                                });
                                communeSelect.disabled = false;
                            });
                    } else {
                        communeSelect.innerHTML = '<option value="">-- Choisir un département --</option>';
                    }
                });
            }

            if (communeSelect) {
                communeSelect.addEventListener('change', function() {
                    const communeId = this.value;
                    arrondissementSelect.innerHTML = '<option value="">Chargement...</option>';
                    arrondissementSelect.disabled = true;

                    if (communeId) {
                        fetch(`/get-arrondissements/${communeId}`)
                            .then(response => response.json())
                            .then(data => {
                                arrondissementSelect.innerHTML = '<option value="">-- Sélectionnez un arrondissement --</option>';
                                data.forEach(a => {
                                    arrondissementSelect.innerHTML += `<option value="${a.id}">${a.name}</option>`;
                                });
                                arrondissementSelect.disabled = false;
                            });
                    } else {
                        arrondissementSelect.innerHTML = '<option value="">-- Choisir une commune --</option>';
                    }
                });
            }

            // Message de confirmation pour l'urgence
            const urgenceForm = document.getElementById('urgenceForm');
            if (urgenceForm) {
                urgenceForm.addEventListener('submit', function(e) {
                    const confirmed = confirm(
                        "⚠️ SIGNALEMENT URGENT\n\n" +
                        "Votre déclaration sera traitée en priorité.\n" +
                        "Assurez-vous que les informations sont exactes.\n\n" +
                        "Confirmer l'envoi ?"
                    );
                    
                    if (!confirmed) {
                        e.preventDefault();
                    }
                });
            }
        });

    </script>
</body>
</html>