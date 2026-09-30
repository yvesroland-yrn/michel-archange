<!doctype html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Paroisse Saint Michel Archange de la BAE</title>
<meta name="description" content="Site de la paroisse Saint Michel Archange de la BAE : horaires des messes, annonces, rendez-vous et contact.">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

<style>
  :root{
    --nuit:        #0B1B3A;
    --nuit-deep:   #07122B;
    --archange:    #2748B8;
    --or:          #D4A937;
    --or-clair:    #F2D98A;
    --ivoire:      #FAF7F0;
    --carte:       #FFFFFF;
    --encre:       #1B2233;
    --brume:       #6B7590;
    --parchemin:   #E6E1D3;
    --flamme:      #C8322B;
    --emeraude:    #1F8A70;

    --grad-ciel: linear-gradient(135deg, #07122B 0%, #0B1B3A 40%, #2748B8 100%);
    --grad-or:   linear-gradient(135deg, #B8891F 0%, #F2D98A 50%, #D4A937 100%);
    --ombre:     0 10px 30px -12px rgba(11, 27, 58, .25);
  }
  html{scroll-behavior:smooth;scroll-padding-top:76px}
  body{font-family:'Inter',system-ui,sans-serif;color:var(--encre);background:var(--ivoire);line-height:1.65}
  h1,h2,h3,.brand-name{font-family:'Cinzel',Georgia,serif;letter-spacing:.02em}
  a{color:inherit}
  :focus-visible{outline:3px solid var(--or);outline-offset:3px}

  /* ---------- Barre de navigation ---------- */
  .site-nav{background:rgba(15,29,58,.96);backdrop-filter:blur(6px);border-bottom:1px solid rgba(201,162,75,.35)}
  .site-nav .navbar-brand{display:flex;align-items:center;gap:.7rem;color:#fff}
  .site-nav .navbar-brand img{width:40px;height:40px;border-radius:50%;object-fit:cover;border:2px solid var(--or)}
  .brand-name{font-size:1rem;font-weight:700;line-height:1.1}
  .brand-name small{display:block;font-family:'Inter',sans-serif;font-size:.72rem;font-weight:400;color:#b9c3da;letter-spacing:0}
  .site-nav .nav-link{color:#dbe3f2;font-weight:500;padding:.5rem .9rem;border-radius:.5rem}
  .site-nav .nav-link:hover,.site-nav .nav-link.active{color:#fff;background:rgba(255,255,255,.08)}
  .site-nav .navbar-toggler{border-color:rgba(255,255,255,.4)}
  .site-nav .navbar-toggler-icon{filter:invert(1)}
  .btn-gold{background:var(--or);color:var(--nuit);font-weight:600;border:0}
  .btn-gold:hover,.btn-gold:focus{background:var(--nuit);color:var(--or-clair)}
  .btn-outline-light-soft{border:1px solid rgba(255,255,255,.55);color:#fff}
  .btn-outline-light-soft:hover{background:var(--carte);color:var(--nuit)}

  /* ---------- Accueil ---------- */
  .hero{
    position:relative;color:#fff;text-align:center;padding:7rem 1rem 6rem;
    background: var(--grad-ciel);
  }
  .hero .crest{width:116px;height:116px;border-radius:50%;border:4px solid var(--or);object-fit:cover;box-shadow:0 0 0 8px rgba(212,169,55,.15)}
  .hero h1{font-size:clamp(2rem,5.5vw,3.6rem);font-weight:700;margin:1.4rem 0 .3rem}
  .hero .sub{font-size:1.15rem;color:var(--or-clair);margin-bottom:1.2rem}
  .hero .verse{max-width:36rem;margin:0 auto 2rem;color:var(--or-clair);font-style:italic}
  .hero .verse b{font-style:normal;color:var(--or);font-weight:600}
  .hero-actions{display:flex;gap:.8rem;justify-content:center;flex-wrap:wrap}

  /* Bandeau horaires */
  .times{margin-top:-2.6rem;position:relative;z-index:2}
  .times-card{background:var(--carte);border:1px solid var(--parchemin);border-radius:1rem;box-shadow:var(--ombre)}
  .time-item{display:flex;gap:.9rem;align-items:flex-start;padding:1.3rem 1.4rem}
  .time-item + .time-item{border-left:1px solid var(--parchemin)}
  .time-item i{font-size:1.5rem;color:var(--or)}
  .time-item b{display:block;font-family:'Cinzel',serif}
  .time-item span{color:var(--brume);font-size:.93rem}
  @media (max-width:767px){.time-item + .time-item{border-left:0;border-top:1px solid var(--parchemin)}}

  /* ---------- Sections ---------- */
  section.block{padding:5rem 0}
  .section-title{font-size:clamp(1.6rem,3.2vw,2.2rem);font-weight:700;color:var(--nuit);margin-bottom:.4rem}
  .section-title::after{content:"";display:block;width:56px;height:3px;background:var(--or);margin-top:.7rem;border-radius:2px}
  .section-intro{color:var(--brume);max-width:40rem;margin-bottom:2.2rem}

  /* À propos */
  .about-photo{width:100%;aspect-ratio:4/5;object-fit:cover;border-radius:1rem;border:1px solid var(--parchemin);background:var(--or-clair)}
  .about-text p{max-width:38rem}
  .pillars{display:grid;grid-template-columns:repeat(auto-fit,minmax(170px,1fr));gap:1rem;margin-top:1.8rem}
  .pillar{background:var(--carte);border:1px solid var(--parchemin);border-left:4px solid var(--or);border-radius:.6rem;padding:1rem 1.1rem}
  .pillar i{color:var(--or);font-size:1.3rem}
  .pillar b{display:block;margin-top:.2rem}
  .pillar span{font-size:.9rem;color:var(--brume)}

  /* Annonces */
  #annonces{background:var(--carte);border-top:1px solid var(--parchemin);border-bottom:1px solid var(--parchemin)}
  .annonce{background:var(--ivoire);border:1px solid var(--parchemin);border-radius:.8rem;padding:1.3rem 1.4rem;margin-bottom:1rem}
  .annonce h3{font-family:'Inter',sans-serif;font-size:1.05rem;font-weight:600;letter-spacing:0;margin-bottom:.5rem;color:var(--encre)}
  .annonce time{font-size:.85rem;color:var(--brume)}
  .agenda{background:var(--nuit);color:#fff;border-radius:1rem;overflow:hidden}
  .agenda h3{font-size:1.1rem;padding:1.2rem 1.4rem;margin:0;border-bottom:1px solid rgba(255,255,255,.12)}
  .agenda ul{list-style:none;margin:0;padding:0}
  .agenda li{display:flex;gap:1rem;align-items:center;padding:1rem 1.4rem}
  .agenda li + li{border-top:1px solid rgba(255,255,255,.1)}
  .event-date{min-width:54px;text-align:center;background:var(--or);color:var(--nuit);border-radius:.6rem;padding:.35rem 0;line-height:1.1}
  .event-date b{display:block;font-size:1.35rem}
  .event-date span{font-size:.72rem;text-transform:capitalize;font-weight:600}
  .agenda small{color:var(--or-clair)}
  .empty{color:var(--brume);padding:1rem 0}
  .agenda .empty{color:var(--or-clair);padding:1.4rem;text-align-center}
  
  /* Annonces avec images */
  .annonce-card-img{transition:transform .3s}
  .annonce-card-img:hover{transform:scale(1.05)}

  /* Contact */
  .contact-card{background:var(--carte);border:1px solid var(--parchemin);border-radius:1rem;padding:1.8rem}
  .contact-line{display:flex;gap:.9rem;margin-bottom:1.2rem}
  .contact-line i{width:42px;height:42px;flex:none;display:grid;place-items:center;border-radius:50%;background:var(--or-clair);color:var(--nuit);font-size:1.1rem}
  .contact-line b{display:block}
  .contact-line span,.contact-line a{color:var(--brume);text-decoration:none}
  .contact-line a:hover{color:var(--archange);text-decoration:underline}
  .form-control,.form-select{border-color:var(--parchemin);padding:.7rem .9rem;border-radius:.6rem}
  .form-control:focus{border-color:var(--or);box-shadow:0 0 0 .2rem rgba(212,169,55,.25)}
  .form-label{font-weight:500;font-size:.92rem}
  .alert-ok{background:#e9f6ee;border:1px solid #b8dfc6;color:#1d5b34;border-radius:.6rem;padding:.8rem 1rem;margin-bottom:1rem}

  /* Pied de page */
  footer.site-foot{background:var(--nuit);color:var(--ivoire);font-size:.92rem;position:relative;overflow:hidden}
  footer.site-foot::before{
    content:"";
    position:absolute;
    top:0;
    left:0;
    right:0;
    height:80px;
    background:linear-gradient(180deg,rgba(212,169,55,.15) 0%,transparent 100%);
    clip-path:polygon(0 100%,5% 60%,15% 80%,25% 50%,35% 70%,45% 40%,55% 60%,65% 30%,75% 50%,85% 20%,95% 40%,100% 100%);
  }
  footer.site-foot a{color:var(--ivoire);text-decoration:none;margin:0 .6rem}
  footer.site-foot a:hover{color:var(--or)}
  .footer-section{margin-bottom:2rem}
  .footer-section h4{color:#fff;font-family:'Cinzel',serif;margin-bottom:1rem;font-size:1.1rem}
  .footer-section ul{list-style:none;padding:0;margin:0}
  .footer-section ul li{margin-bottom:.5rem}
  .footer-section ul li a{display:block;padding:.2rem 0}
  .footer-section .social-icons a{
    display:inline-flex;
    width:36px;
    height:36px;
    border-radius:50%;
    background:rgba(255,255,255,.1);
    align-items:center;
    justify-content:center;
    margin-right:.5rem;
    transition:background .2s
  }
  .footer-section .social-icons a:hover{background:var(--or);color:var(--nuit)}
  .footer-newsletter input{
    background:rgba(255,255,255,.1);
    border:1px solid rgba(255,255,255,.2);
    color:#fff;
    padding:.6rem 1rem;
    border-radius:.4rem;
    width:100%;
    margin-bottom:.5rem
  }
  .footer-newsletter input::placeholder{color:rgba(255,255,255,.6)}
  .footer-newsletter input:focus{
    outline:none;
    border-color:var(--or);
    background:rgba(255,255,255,.15)
  }
  .footer-newsletter button{
    background:var(--or);
    color:var(--nuit);
    border:none;
    padding:.6rem 1.2rem;
    border-radius:.4rem;
    font-weight:600;
    cursor:pointer;
    transition:background .2s
  }
  .footer-newsletter button:hover{background:var(--nuit);color:var(--or-clair)}
  .footer-bottom{
    border-top:1px solid rgba(255,255,255,.1);
    padding-top:1.5rem;
    margin-top:2rem;
    font-size:.85rem
  }
  .payment-icons{display:flex;gap:.5rem;align-items:center}
  .payment-icons span{font-size:1.5rem}
  .developer-credit{
    display:flex;
    align-items:center;
    gap:.5rem;
    font-size:.75rem;
    color:rgba(255,255,255,.5);
    margin-top:.5rem
  }
  .developer-credit span{font-weight:400}
  .author-logo-wrap{
    display:inline-flex;
    align-items:center;
    text-decoration:none;
    transition:opacity .2s
  }
  .author-logo-wrap:hover{opacity:.8}
  .author-logo{
    height:20px;
    width:auto;
    object-fit:contain
  }

  /* Bouton retour en haut */
  .to-top{position:fixed;right:1rem;bottom:1rem;width:44px;height:44px;border-radius:50%;background:var(--or);color:var(--nuit);display:grid;place-items:center;text-decoration:none;box-shadow:var(--ombre);opacity:0;pointer-events:none;transition:opacity .2s}
  .to-top.show{opacity:1;pointer-events:auto}

  @media (prefers-reduced-motion:reduce){html{scroll-behavior:auto}.to-top{transition:none}}

 /* Logo du développeur (Codyng) — bandeau bas de page */
  .developer-credit{
    display:flex;
    align-items:center;
    gap: 10px;
    margin: 0;
  }
  .author-logo-wrap{
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: #ffffff;
    border: 1px solid var(--or);
    border-radius: 999px;
    padding: 6px 20px;
    transition: transform .25s ease, box-shadow .25s ease;
  }
  .author-logo-wrap:hover{
    transform: scale(1.06);
    box-shadow: 0 0 0 2px rgba(182,144,42,0.35);
  }
  .author-logo{
    height: 40px;
    width: auto;
    display: block;
  }

  @media (max-width: 900px){
    .footer-main{ grid-template-columns: 1fr 1fr; }
    .newsletter-inner{ flex-direction: column; align-items:flex-start; }
  }
  @media (max-width: 560px){
    .footer-main{ grid-template-columns: 1fr; gap: 34px; }
    .footer-bottom-inner{ flex-direction: column; align-items:flex-start; }
  }

  .whatsapp-cta{
    margin-top: 24px;
    display:inline-flex;
    align-items:center;
    gap: 10px;
    padding: 11px 18px;
    border: 1px solid var(--or);
    border-radius: 999px;
    color: var(--encre);
    text-decoration:none;
    font-size: 12px;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    transition: all .3s ease;
  }
  .whatsapp-cta:hover{ background: var(--or); color: var(--encre); }
  .whatsapp-cta i{ font-size: 16px; }

</style>
</head>

<body>

{{-- ================= NAVIGATION ================= --}}
<nav class="navbar navbar-expand-lg navbar-dark site-nav sticky-top">
  <div class="container" style="max-width:1100px">
    <a class="navbar-brand" href="#accueil">
      <img src="{{ asset('images/saint-michel-avatar.jpg') }}" alt="Saint Michel Archange">
      <span class="brand-name">Saint Michel Archange<small>Paroisse de la BAE</small></span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu" aria-controls="menu" aria-expanded="false" aria-label="Ouvrir le menu">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="menu">
      <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
        <li class="nav-item"><a class="nav-link" href="#accueil">Accueil</a></li>
        <li class="nav-item"><a class="nav-link" href="#apropos">À propos</a></li>
        <li class="nav-item"><a class="nav-link" href="#annonces">Annonces</a></li>
        <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
        <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
          <a href="{{ route('login') }}" class="btn btn-gold btn-sm px-3"><i class="bi bi-box-arrow-in-right me-1"></i>Espace de gestion</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

{{-- ================= ACCUEIL ================= --}}
<header id="accueil" class="hero">
  <div class="container" style="max-width:1100px">
    <img src="{{ asset('images/saint-michel-avatar.jpg') }}" class="crest" alt="Saint Michel Archange">
    <h1>Paroisse Saint Michel Archange</h1>
    <p class="sub">de la BAE</p>
    <p class="verse">« Saint Michel Archange, défendez-nous dans le combat. » <b>Une communauté qui prie, se rassemble et sert.</b></p>
    <div class="hero-actions">
      <a href="#annonces" class="btn btn-gold btn-lg px-4"><i class="bi bi-megaphone me-2"></i>Voir les annonces</a>
      <a href="#contact" class="btn btn-outline-light-soft btn-lg px-4"><i class="bi bi-envelope me-2"></i>Nous contacter</a>
    </div>
  </div>
</header>

{{-- Horaires (à adapter) --}}
<div class="times">
  <div class="container" style="max-width:1100px">
    <div class="times-card">
      <div class="row g-0">
        <div class="col-md-4 time-item"><i class="bi bi-brightness-high"></i><div><b>Messe dominicale</b><span>Dimanche à 07h00 - Dimanche 9h00</span></div></div>
        <div class="col-md-4 time-item"><i class="bi bi-book"></i><div><b>Messe en semaine</b><span>Du mardi au vendredi à 06h30</span></div></div>
        <div class="col-md-4 time-item"><i class="bi bi-person-heart"></i><div><b>Confessions</b><span>Samedi de 16h00 à 17h30</span></div></div>
      </div>
    </div>
  </div>
</div>

{{-- ================= À PROPOS ================= --}}
<section id="apropos" class="block">
  <div class="container" style="max-width:1100px">
    <h2 class="section-title">Paroisse Saint Michel Archnage De La BAE</h2>
    <p class="section-intro">Découvrez notre communauté à travers le mot de notre curé et la présentation de notre clergé.</p>
    
    <!-- Mot du curé -->
    <div class="card border-0 shadow-sm mb-5" style="border-radius: 1rem; overflow: hidden;">
      <div class="row g-0">
        <div class="col-lg-4">
          <img src="{{ asset('images/saint-michel-avatar.jpg') }}" class="h-100 w-100 object-fit-cover" style="min-height: 300px;" alt="Le curé de la paroisse">
        </div>
        <div class="col-lg-8">
          <div class="card-body p-4 p-lg-5">
            <h3 class="h4 mb-3" style="font-family: 'Cinzel', serif; color: var(--or);">
              <i class="bi bi-quote me-2"></i>Mot du curé
            </h3>
            <div class="mb-3">
              <span class="badge" style="background: var(--or); color: var(--nuit);">Curé de la paroisse</span>
            </div>
            <p class="fst-italic text-muted mb-3">
              « Chers paroissiens, que la paix du Christ soit avec vous. Notre paroisse est une famille où chacun trouve sa place. 
              Ensemble, nous vivons notre foi à travers la prière, les sacrements et le service fraternel. 
              Saint Michel Archange, notre patron, nous inspire à combattre le mal et à servir Dieu avec courage. »
            </p>
            <p class="mb-0">
              Bienvenue dans notre communauté. Que votre visite sur ce site soit une bénédiction pour vous.
            </p>
            <div class="mt-4 pt-3 border-top">
              <strong style="font-family: 'Cinzel', serif;">Père [Nom du Curé]</strong>
              <br>
              <small class="text-muted">Curé de la Paroisse Saint Michel Archange de la BAE</small>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Présentation du clergé -->
    <div class="card border-0 shadow-sm" style="border-radius: 1rem;">
      <div class="card-body p-4 p-lg-5">
        <h3 class="h4 mb-4" style="font-family: 'Cinzel', serif; color: var(--or);">
          <i class="bi bi-people-fill me-2"></i>Notre clergé
        </h3>
        <p class="text-muted mb-4">
          Notre clergé se dévoue au service spirituel et pastoral de notre communauté. 
          Chaque membre apporte sa contribution à la vie de notre paroisse.
        </p>
        
        <div class="row g-4">
          <!-- Curé -->
          <div class="col-md-6 col-lg-4">
            <div class="text-center">
              <div class="mb-3">
                <img src="{{ asset('images/saint-michel-avatar.jpg') }}" class="rounded-circle" style="width: 120px; height: 120px; object-fit: cover; border: 3px solid var(--or);" alt="Curé">
              </div>
              <h5 class="mb-1" style="font-family: 'Cinzel', serif;">Père [Nom]</h5>
              <p class="text-muted small mb-2">Curé</p>
              <p class="small text-muted">Responsable de la paroisse et guide spirituel de la communauté.</p>
            </div>
          </div>
          
          <!-- Vicaire -->
          <div class="col-md-6 col-lg-4">
            <div class="text-center">
              <div class="mb-3">
                <img src="{{ asset('images/saint-michel-avatar.jpg') }}" class="rounded-circle" style="width: 120px; height: 120px; object-fit: cover; border: 3px solid var(--gold);" alt="Vicaire">
              </div>
              <h5 class="mb-1" style="font-family: 'Cinzel', serif;">Père [Nom]</h5>
              <p class="text-muted small mb-2">Vicaire</p>
              <p class="small text-muted">Assiste le curé dans les tâches pastorales et administratives.</p>
            </div>
          </div>
          
          <!-- Diacre -->
          <div class="col-md-6 col-lg-4">
            <div class="text-center">
              <div class="mb-3">
                <img src="{{ asset('images/saint-michel-avatar.jpg') }}" class="rounded-circle" style="width: 120px; height: 120px; object-fit: cover; border: 3px solid var(--gold);" alt="Diacre">
              </div>
              <h5 class="mb-1" style="font-family: 'Cinzel', serif;">Diacre [Nom]</h5>
              <p class="text-muted small mb-2">Diacre permanent</p>
              <p class="small text-muted">Service de la charité et assistance aux familles dans le besoin.</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Conseil de la paroisse -->
    <div class="card border-0 shadow-sm mt-4" style="border-radius: 1rem;">
      <div class="card-body p-4 p-lg-5">
        <h3 class="h4 mb-4" style="font-family: 'Cinzel', serif; color: var(--or);">
          <i class="bi bi-person-workspace me-2"></i>Conseil de la paroisse
        </h3>
        <p class="text-muted mb-4">
          Le conseil de la paroisse assiste le curé dans la gestion administrative et pastorale de la communauté.
        </p>
        
        <div class="row g-4">
          <!-- Président -->
          <div class="col-md-6 col-lg-3">
            <div class="card h-100 border-0 shadow-sm" style="border-radius: .8rem;">
              <div class="card-body text-center p-3">
                <div class="mb-3">
                  <img src="{{ asset('images/saint-michel-avatar.jpg') }}" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover; border: 2px solid var(--or);" alt="Membre du conseil">
                </div>
                <h6 class="mb-1" style="font-family: 'Cinzel', serif;">[Nom Prénom]</h6>
                <p class="text-muted small mb-2">Président</p>
                <a href="tel:+2250000000000" class="btn btn-sm btn-outline-dark" style="border-color: var(--or); color: var(--encre);">
                  <i class="bi bi-telephone me-1"></i>+225 00 00 00 00
                </a>
              </div>
            </div>
          </div>
          
          <!-- Secrétaire -->
          <div class="col-md-6 col-lg-3">
            <div class="card h-100 border-0 shadow-sm" style="border-radius: .8rem;">
              <div class="card-body text-center p-3">
                <div class="mb-3">
                  <img src="{{ asset('images/saint-michel-avatar.jpg') }}" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover; border: 2px solid var(--or);" alt="Membre du conseil">
                </div>
                <h6 class="mb-1" style="font-family: 'Cinzel', serif;">[Nom Prénom]</h6>
                <p class="text-muted small mb-2">Secrétaire</p>
                <a href="tel:+2250000000000" class="btn btn-sm btn-outline-dark" style="border-color: var(--or); color: var(--encre);">
                  <i class="bi bi-telephone me-1"></i>+225 00 00 00 00
                </a>
              </div>
            </div>
          </div>
          
          <!-- Trésorier -->
          <div class="col-md-6 col-lg-3">
            <div class="card h-100 border-0 shadow-sm" style="border-radius: .8rem;">
              <div class="card-body text-center p-3">
                <div class="mb-3">
                  <img src="{{ asset('images/saint-michel-avatar.jpg') }}" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover; border: 2px solid var(--or);" alt="Membre du conseil">
                </div>
                <h6 class="mb-1" style="font-family: 'Cinzel', serif;">[Nom Prénom]</h6>
                <p class="text-muted small mb-2">Trésorier</p>
                <a href="tel:+2250000000000" class="btn btn-sm btn-outline-dark" style="border-color: var(--or); color: var(--encre);">
                  <i class="bi bi-telephone me-1"></i>+225 00 00 00 00
                </a>
              </div>
            </div>
          </div>
          
          <!-- Membre -->
          <div class="col-md-6 col-lg-3">
            <div class="card h-100 border-0 shadow-sm" style="border-radius: .8rem;">
              <div class="card-body text-center p-3">
                <div class="mb-3">
                  <img src="{{ asset('images/saint-michel-avatar.jpg') }}" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover; border: 2px solid var(--or);" alt="Membre du conseil">
                </div>
                <h6 class="mb-1" style="font-family: 'Cinzel', serif;">[Nom Prénom]</h6>
                <p class="text-muted small mb-2">Membre</p>
                <a href="tel:+2250000000000" class="btn btn-sm btn-outline-dark" style="border-color: var(--or); color: var(--encre);">
                  <i class="bi bi-telephone me-1"></i>+225 00 00 00 00
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Responsables de mouvements -->
    <div class="card border-0 shadow-sm mt-4" style="border-radius: 1rem;">
      <div class="card-body p-4 p-lg-5">
        <h3 class="h4 mb-4" style="font-family: 'Cinzel', serif; color: var(--gold);">
          <i class="bi bi-music-note-beamed me-2"></i>Responsables de mouvements
        </h3>
        <p class="text-muted mb-4">
          Nos mouvements paroissiaux sont animés par des responsables dévoués qui organisent les activités spirituelles et sociales.
        </p>
        
        <div class="row g-4">
          <!-- Mouvement 1 -->
          <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm" style="border-radius: .8rem;">
              <div class="card-body p-3">
                <div class="d-flex align-items-start gap-3">
                  <div>
                    <img src="{{ asset('images/saint-michel-avatar.jpg') }}" class="rounded-circle" style="width: 60px; height: 60px; object-fit: cover; border: 2px solid var(--gold);" alt="Responsable">
                  </div>
                  <div class="flex-grow-1">
                    <span class="badge mb-1" style="background: var(--or); color: var(--nuit); font-size: 0.75rem;">Chorale</span>
                    <h6 class="mb-1" style="font-family: 'Cinzel', serif;">[Nom Prénom]</h6>
                    <a href="tel:+2250000000000" class="btn btn-sm btn-link p-0" style="color: var(--encre);">
                      <i class="bi bi-telephone me-1"></i>+225 00 00 00 00
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Mouvement 2 -->
          <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm" style="border-radius: .8rem;">
              <div class="card-body p-3">
                <div class="d-flex align-items-start gap-3">
                  <div>
                    <img src="{{ asset('images/saint-michel-avatar.jpg') }}" class="rounded-circle" style="width: 60px; height: 60px; object-fit: cover; border: 2px solid var(--gold);" alt="Responsable">
                  </div>
                  <div class="flex-grow-1">
                    <span class="badge mb-1" style="background: var(--or); color: var(--nuit); font-size: 0.75rem;">Legion de Marie</span>
                    <h6 class="mb-1" style="font-family: 'Cinzel', serif;">[Nom Prénom]</h6>
                    <a href="tel:+2250000000000" class="btn btn-sm btn-link p-0" style="color: var(--encre);">
                      <i class="bi bi-telephone me-1"></i>+225 00 00 00 00
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Mouvement 3 -->
          <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm" style="border-radius: .8rem;">
              <div class="card-body p-3">
                <div class="d-flex align-items-start gap-3">
                  <div>
                    <img src="{{ asset('images/saint-michel-avatar.jpg') }}" class="rounded-circle" style="width: 60px; height: 60px; object-fit: cover; border: 2px solid var(--gold);" alt="Responsable">
                  </div>
                  <div class="flex-grow-1">
                    <span class="badge mb-1" style="background: var(--or); color: var(--nuit); font-size: 0.75rem;">Serviteurs de l'Autel</span>
                    <h6 class="mb-1" style="font-family: 'Cinzel', serif;">[Nom Prénom]</h6>
                    <a href="tel:+2250000000000" class="btn btn-sm btn-link p-0" style="color: var(--encre);">
                      <i class="bi bi-telephone me-1"></i>+225 00 00 00 00
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Mouvement 4 -->
          <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm" style="border-radius: .8rem;">
              <div class="card-body p-3">
                <div class="d-flex align-items-start gap-3">
                  <div>
                    <img src="{{ asset('images/saint-michel-avatar.jpg') }}" class="rounded-circle" style="width: 60px; height: 60px; object-fit: cover; border: 2px solid var(--gold);" alt="Responsable">
                  </div>
                  <div class="flex-grow-1">
                    <span class="badge mb-1" style="background: var(--or); color: var(--nuit); font-size: 0.75rem;">CEB</span>
                    <h6 class="mb-1" style="font-family: 'Cinzel', serif;">[Nom Prénom]</h6>
                    <a href="tel:+2250000000000" class="btn btn-sm btn-link p-0" style="color: var(--encre);">
                      <i class="bi bi-telephone me-1"></i>+225 00 00 00 00
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Mouvement 5 -->
          <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm" style="border-radius: .8rem;">
              <div class="card-body p-3">
                <div class="d-flex align-items-start gap-3">
                  <div>
                    <img src="{{ asset('images/saint-michel-avatar.jpg') }}" class="rounded-circle" style="width: 60px; height: 60px; object-fit: cover; border: 2px solid var(--gold);" alt="Responsable">
                  </div>
                  <div class="flex-grow-1">
                    <span class="badge mb-1" style="background: var(--or); color: var(--nuit); font-size: 0.75rem;">Jeunesse</span>
                    <h6 class="mb-1" style="font-family: 'Cinzel', serif;">[Nom Prénom]</h6>
                    <a href="tel:+2250000000000" class="btn btn-sm btn-link p-0" style="color: var(--encre);">
                      <i class="bi bi-telephone me-1"></i>+225 00 00 00 00
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Mouvement 6 -->
          <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm" style="border-radius: .8rem;">
              <div class="card-body p-3">
                <div class="d-flex align-items-start gap-3">
                  <div>
                    <img src="{{ asset('images/saint-michel-avatar.jpg') }}" class="rounded-circle" style="width: 60px; height: 60px; object-fit: cover; border: 2px solid var(--gold);" alt="Responsable">
                  </div>
                  <div class="flex-grow-1">
                    <span class="badge mb-1" style="background: var(--or); color: var(--nuit); font-size: 0.75rem;">Charité</span>
                    <h6 class="mb-1" style="font-family: 'Cinzel', serif;">[Nom Prénom]</h6>
                    <a href="tel:+2250000000000" class="btn btn-sm btn-link p-0" style="color: var(--encre);">
                      <i class="bi bi-telephone me-1"></i>+225 00 00 00 00
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- ================= ANNONCES ================= --}}
<section id="annonces" class="block">
  <div class="container" style="max-width:1100px">
    <h2 class="section-title">Annonces et rendez-vous</h2>
    <p class="section-intro">Les dernières nouvelles de la paroisse et les prochaines dates à retenir.</p>
    
    <!-- Annonces avec affiches -->
    @if($annonces_avec_images->count() > 0)
    <div class="mb-5">
      <h3 class="h5 mb-3"><i class="bi bi-image-fill me-2" style="color:var(--gold)"></i>Affiches et annonces visuelles</h3>
      <div class="row g-3">
        @foreach($annonces_avec_images as $a)
        <div class="col-md-6 col-lg-4">
          <div class="card border-0 shadow-sm" style="border-radius: .8rem; overflow: hidden;">
            @if($a->image)
            <img src="{{ asset('storage/' . $a->image) }}" class="card-img-top annonce-card-img" style="height: 200px; object-fit: cover;" alt="{{ $a->titre }}">
            @endif
            <div class="card-body p-3">
              <h6 class="card-title mb-2">{{ $a->titre }}</h6>
              <p class="card-text small text-muted mb-2">{!! \Illuminate\Support\Str::limit(strip_tags($a->contenu), 100) !!}</p>
              <small class="text-muted"><i class="bi bi-calendar3"></i> {{ $a->publie_le->format('d/m/Y') }}</small>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
    @endif

    <div class="row g-4">
      <!-- Informations paroissiales -->
      <div class="col-lg-7">
        <h3 class="h5 mb-3"><i class="bi bi-megaphone-fill me-2" style="color:var(--gold)"></i>Informations paroissiales</h3>
        @forelse($annonces_sans_images as $a)
          <article class="annonce">
            <h3>{{ $a->titre }}</h3>
            <p class="mb-2">{!! nl2br(e($a->contenu)) !!}</p>
            <time><i class="bi bi-calendar3"></i> {{ $a->publie_le->format('d/m/Y') }}</time>
          </article>
        @empty
          <p class="empty">Aucune information pour le moment. Revenez bientôt.</p>
        @endforelse
      </div>
      
      <!-- Prochains rendez-vous -->
      <div class="col-lg-5">
        <div class="agenda">
          <h3><i class="bi bi-calendar-event-fill me-2" style="color:var(--gold)"></i>Prochains rendez-vous</h3>
          <ul>
            @forelse($evenements as $e)
              <li>
                <div class="event-date"><b>{{ $e->date_heure->format('d') }}</b><span>{{ $e->date_heure->translatedFormat('M') }}</span></div>
                <div>
                  <div class="fw-semibold">{{ $e->titre }}</div>
                  <small>{{ $e->date_heure->format('H:i') }}@if($e->lieu) · {{ $e->lieu }}@endif</small>
                </div>
              </li>
            @empty
              <li class="empty">Rien de programmé.</li>
            @endforelse
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- ================= CONTACT ================= --}}
<section id="contact" class="block">
  <div class="container" style="max-width:1100px">
    <h2 class="section-title">Nous contacter</h2>
    <p class="section-intro">Une question, une intention de prière, une demande de sacrement ? Écrivez-nous, nous vous répondrons.</p>
    <div class="row g-4">
      <div class="col-lg-5">
        <div class="contact-card h-100">
          <div class="contact-line"><i class="bi bi-geo-alt-fill"></i><div><b>Adresse</b><span>Paroisse Saint Michel Archange, BAE<br>Abidjan, Côte d'Ivoire</span></div></div>
          <div class="contact-line"><i class="bi bi-telephone-fill"></i><div><b>Téléphone</b><a href="tel:+2250000000000">+225 00 00 00 00 00</a></div></div>
          <div class="contact-line"><i class="bi bi-envelope-fill"></i><div><b>E-mail</b><a href="mailto:contact@paroisse-bae.ci">contact@paroisse-bae.ci</a></div></div>
          <div class="contact-line mb-0"><i class="bi bi-clock-fill"></i><div><b>Secrétariat</b><span>Lundi au vendredi, 09h00 – 17h00</span></div></div>
        </div>
      </div>
      <div class="col-lg-7">
        <div class="contact-card">
          @if(session('success'))<div class="alert-ok" role="status"><i class="bi bi-check-circle me-2"></i>{{ session('success') }}</div>@endif
          <form method="POST" action="{{ Route::has('contact.envoyer') ? route('contact.envoyer') : '#' }}">
            @csrf
            <div class="row g-3">
              <div class="col-md-6">
                <label for="nom" class="form-label">Nom complet</label>
                <input type="text" id="nom" name="nom" class="form-control" value="{{ old('nom') }}" required>
              </div>
              <div class="col-md-6">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required>
              </div>
              <div class="col-12">
                <label for="sujet" class="form-label">Sujet</label>
                <input type="text" id="sujet" name="sujet" class="form-control" value="{{ old('sujet') }}" required>
              </div>
              <div class="col-12">
                <label for="message" class="form-label">Message</label>
                <textarea id="message" name="message" rows="5" class="form-control" required>{{ old('message') }}</textarea>
              </div>
              <div class="col-12">
                <button type="submit" class="btn btn-gold btn-lg px-4"><i class="bi bi-send me-2"></i>Envoyer le message</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- ================= PIED DE PAGE ================= --}}
<footer class="site-foot">
  <div class="container" style="max-width:1100px;padding-top:3rem">
    <div class="row g-4">
      <!-- Newsletter -->
      <div class="col-lg-3 footer-section">
        <h4>Restez informé</h4>
        <p class="small text-muted mb-3">Recevez nos dernières annonces et événements.</p>
        <div class="footer-newsletter">
          <input type="email" placeholder="Votre email">
          <button type="button">S'ABONNER</button>
        </div>
        <div class="mt-3">
          <small class="text-muted">Diocèse de la BAE</small>
        </div>
      </div>

      <!-- Liens rapides -->
      <div class="col-lg-3 footer-section">
        <h4>Liens utiles</h4>
        <ul>
          <li><a href="#accueil">Accueil</a></li>
          <li><a href="#apropos">À propos</a></li>
          <li><a href="#annonces">Annonces</a></li>
          <li><a href="#contact">Contact</a></li>
          <li><a href="{{ route('login') }}">Espace de gestion</a></li>
        </ul>
      </div>

      <!-- Informations -->
      <div class="col-lg-3 footer-section">
        <h4>Informations</h4>
        <ul>
          <li><a href="#">Horaires des messes</a></li>
          <li><a href="#">Sacraments</a></li>
          <li><a href="#">Catéchèse</a></li>
          <li><a href="#">Mouvements</a></li>
          <li><a href="#">CEB</a></li>
        </ul>
        <div class="social-icons mt-3">
          <a href="#"><i class="bi bi-facebook"></i></a>
          <a href="#"><i class="bi bi-whatsapp"></i></a>
          <a href="#"><i class="bi bi-instagram"></i></a>
        </div>
      </div>

      <!-- Contact -->
      <div class="col-lg-3 footer-section">
        <h4>Contact</h4>
        <ul>
          <li><i class="bi bi-geo-alt me-2"></i>Paroisse Saint Michel Archange</li>
          <li><i class="bi bi-geo-alt me-2"></i>BAE, Abidjan</li>
          <li><i class="bi bi-telephone me-2"></i>+225 00 00 00 00 00</li>
          <li><i class="bi bi-envelope me-2"></i>contact@paroisse-bae.ci</li>
          <li><i class="bi bi-clock me-2"></i>Lun-Ven: 09h00-17h00</li>
        </ul>
      </div>
    </div>

    <!-- Footer bottom -->
    <div class="footer-bottom">
      <div class="row align-items-center">
        <div class="col-md-6">
          <p class="mb-1">© {{ now()->year }} Paroisse Saint Michel Archange de la BAE. Tous droits réservés.</p>
          <div class="developer-credit">
            <span>Développé par</span>
            <a href="https://wa.me/2250715085142" target="_blank" rel="noopener noreferrer" aria-label="Contacter le développeur sur WhatsApp" class="author-logo-wrap">
              <img src="{{ asset('images/codyng.png') }}" alt="Codyng - Yves Roland N." class="author-logo">
            </a>
            <br>
          </div>
        </div>
        <div class="col-md-6 text-md-end">
          <div class="payment-icons justify-content-md-end">
          </div>
        </div>
      </div>
    </div>
  </div>
</footer>



<a href="#accueil" class="to-top" id="toTop" aria-label="Retour en haut"><i class="bi bi-chevron-up"></i></a>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Lien actif dans le menu selon la section visible
  (function(){
    var links = document.querySelectorAll('.site-nav .nav-link');
    var ids = ['accueil','apropos','annonces','contact'];
    var toTop = document.getElementById('toTop');
    function onScroll(){
      var y = window.scrollY + 120, current = 'accueil';
      ids.forEach(function(id){
        var el = document.getElementById(id);
        if (el && el.offsetTop <= y) current = id;
      });
      links.forEach(function(a){ a.classList.toggle('active', a.getAttribute('href') === '#' + current); });
      toTop.classList.toggle('show', window.scrollY > 500);
    }
    window.addEventListener('scroll', onScroll, {passive:true});
    onScroll();
    // Referme le menu mobile après un clic
    links.forEach(function(a){
      a.addEventListener('click', function(){
        var m = document.getElementById('menu');
        if (m.classList.contains('show')) bootstrap.Collapse.getOrCreateInstance(m).hide();
      });
    });
  })();
</script>
</body>
</html>
