<!doctype html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('titre', 'Paroisse Saint Michel Archange de la BAE')</title>
<meta name="description" content="Site de la paroisse Saint Michel Archange de la BAE : horaires des messes, annonces, rendez-vous et contact.">
<link rel="icon" href="{{ asset('images/saint.jpg') }}" type="image/jpeg">

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
  .site-nav {
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(250, 247, 240, 0.95) 100%);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    padding: .7rem 0;
    box-shadow: 0 4px 20px rgba(11, 27, 58, 0.08), 0 0 0 1px rgba(212, 169, 55, 0.1);
    border-bottom: 2px solid transparent;
    transition: all 0.3s ease;
  }
  .site-nav:hover {
    border-bottom-color: var(--or);
    box-shadow: 0 6px 30px rgba(11, 27, 58, 0.12), 0 0 0 1px rgba(212, 169, 55, 0.2);
  }

  /* Logo + nom */
  .site-nav .brand-logo {
    height: 50px;
    width: auto;
    border-radius: 12px;
    object-fit: cover;
    box-shadow: 0 4px 12px rgba(212, 169, 55, 0.2);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }
  .site-nav .brand-logo:hover {
    transform: scale(1.05) rotate(2deg);
    box-shadow: 0 6px 20px rgba(212, 169, 55, 0.4);
  }
  .site-nav .brand-name {
    display: flex;
    flex-direction: column;
    font-weight: 800;
    font-size: 1.1rem;
    letter-spacing: .12em;
    color: var(--nuit);
    line-height: 1.1;
    transition: color 0.3s ease;
  }
  .site-nav .brand-name:hover {
    color: var(--archange);
  }
  .site-nav .brand-name small {
    font-size: .58rem;
    font-weight: 600;
    letter-spacing: .08em;
    text-transform: uppercase;
    color: var(--nuit);
    opacity: .85;
    transition: opacity 0.3s ease;
  }
  .site-nav .brand-name:hover small {
    opacity: 1;
  }

  /* Liens */
  .site-nav .nav-link {
    color: var(--encre);
    font-weight: 600;
    font-size: .93rem;
    padding: .6rem 1rem;
    border-radius: 8px;
    position: relative;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    overflow: hidden;
  }
  .site-nav .nav-link::before {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    width: 0;
    height: 2px;
    background: var(--or);
    transition: all 0.3s ease;
    transform: translateX(-50%);
  }
  .site-nav .nav-link:hover {
    background: linear-gradient(135deg, rgba(212, 169, 55, 0.1) 0%, rgba(242, 217, 138, 0.15) 100%);
    color: var(--archange);
    transform: translateY(-2px);
  }
  .site-nav .nav-link:hover::before {
    width: 80%;
  }
  .site-nav .nav-link.active {
    background: linear-gradient(135deg, var(--or) 0%, var(--or-clair) 100%);
    color: var(--nuit);
    box-shadow: 0 4px 15px rgba(212, 169, 55, 0.4);
    transform: translateY(-2px);
  }
  .site-nav .nav-link.active::before {
    width: 0;
  }

  /* Boutons pilule */
  .btn-nav {
    border: 0;
    border-radius: 999px;
    padding: .6rem 1.3rem;
    font-weight: 700;
    font-size: .9rem;
    color: #fff;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
  }
  .btn-nav::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    transform: translate(-50%, -50%);
    transition: width 0.6s ease, height 0.6s ease;
  }
  .btn-nav:hover::before {
    width: 300px;
    height: 300px;
  }
  .btn-nav:hover { color: #fff; transform: translateY(-3px) scale(1.02); box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2); }
  .btn-nav:active { transform: translateY(-1px) scale(0.98); }
  .btn-nav-gold {
    background: linear-gradient(135deg, var(--or) 0%, var(--or-clair) 100%);
    box-shadow: 0 4px 15px rgba(212, 169, 55, 0.3);
  }
  .btn-nav-gold:hover {
    background: linear-gradient(135deg, var(--nuit) 0%, var(--nuit-deep) 100%);
    box-shadow: 0 6px 20px rgba(11, 27, 58, 0.4);
  }
  .btn-nav-archange {
    background: linear-gradient(135deg, var(--archange) 0%, #3a5bc8 100%);
    box-shadow: 0 4px 15px rgba(39, 72, 184, 0.3);
  }
  .btn-nav-archange:hover {
    background: linear-gradient(135deg, var(--nuit-deep) 0%, var(--nuit) 100%);
    box-shadow: 0 6px 20px rgba(11, 27, 58, 0.4);
  }
  .btn-nav-flamme {
    background: linear-gradient(135deg, var(--flamme) 0%, #e0453d 100%);
    box-shadow: 0 4px 15px rgba(200, 50, 43, 0.3);
  }
  .btn-nav-flamme:hover {
    background: linear-gradient(135deg, #a82820 0%, #8f221a 100%);
    box-shadow: 0 6px 20px rgba(168, 40, 32, 0.4);
  }
  .btn-gold{background:linear-gradient(135deg,var(--or) 0%,var(--or-clair) 100%);color:var(--nuit);font-weight:600;border:0;box-shadow:0 4px 15px rgba(212,169,55,0.3);transition:all 0.3s ease}
  .btn-gold:hover,.btn-gold:focus{background:linear-gradient(135deg,var(--nuit) 0%,var(--nuit-deep) 100%);color:var(--or-clair);transform:translateY(-2px);box-shadow:0 6px 20px rgba(11,27,58,0.4)}

  /* Navbar toggler button */
  .navbar-toggler {
    border: 2px solid var(--or);
    border-radius: 8px;
    padding: 0.5rem 0.75rem;
    transition: all 0.3s ease;
  }
  .navbar-toggler:hover {
    background: var(--or);
    transform: rotate(180deg);
  }
  .navbar-toggler:hover .navbar-toggler-icon {
    filter: brightness(0);
  }
  .navbar-toggler-icon {
    width: 1.25rem;
    height: 1.25rem;
    transition: filter 0.3s ease;
  }

  /* Mobile */
  @media (max-width: 991.98px) {
    .site-nav .nav-link { padding: .65rem .85rem; }

    /* Barre de navigation mobile fixe en bas - Dock arrondi moderne */
    .mobile-nav-dock {
      position: fixed;
      bottom: 1.5rem;
      left: 50%;
      transform: translateX(-50%);
      background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(250, 247, 240, 0.95) 100%);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border: 1px solid rgba(212, 169, 55, 0.2);
      padding: 0.8rem 1.2rem;
      z-index: 1000;
      display: flex;
      justify-content: space-around;
      align-items: center;
      box-shadow: 0 8px 32px rgba(11, 27, 58, 0.15), 0 0 0 1px rgba(212, 169, 55, 0.1);
      border-radius: 28px;
      gap: 0.5rem;
      animation: slideUp 0.6s cubic-bezier(0.4, 0, 0.2, 1);
      max-width: 95%;
      overflow: hidden;
    }

    @keyframes slideUp {
      from {
        transform: translateX(-50%) translateY(100%);
        opacity: 0;
      }
      to {
        transform: translateX(-50%) translateY(0);
        opacity: 1;
      }
    }

    .mobile-nav-item {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      text-decoration: none;
      color: var(--encre);
      padding: 0;
      border-radius: 50%;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      width: 64px;
      height: 64px;
      position: relative;
      flex-shrink: 0;
    }

    .mobile-nav-item i {
      font-size: 1.7rem;
      color: var(--brume);
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .mobile-nav-item > div {
      position: relative;
      display: inline-block;
    }

    .mobile-nav-item > div + span {
      margin-top: 0.2rem;
    }

    .mobile-nav-item > i + span {
      margin-top: 0.2rem;
    }

    .mobile-nav-item span {
      font-size: 0.65rem;
      font-weight: 600;
      color: var(--brume);
      text-transform: uppercase;
      letter-spacing: 0.2px;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .mobile-nav-item.active {
      background: linear-gradient(135deg, var(--or) 0%, var(--or-clair) 100%);
      box-shadow: 0 4px 12px rgba(212, 169, 55, 0.4);
      transform: translateY(-2px);
    }

    .mobile-nav-item.active i,
    .mobile-nav-item.active span {
      color: var(--nuit);
    }

    .mobile-nav-item:hover {
      background: rgba(212, 169, 55, 0.1);
      transform: translateY(-1px);
    }

    .mobile-nav-item:hover i {
      color: var(--archange);
    }

    .mobile-nav-item:hover span {
      color: var(--archange);
    }

    /* Badge de notification */
    .mobile-nav-badge {
      position: absolute;
      top: -0.4rem;
      right: -0.5rem;
      background: var(--flamme);
      color: #fff;
      font-size: 0.6rem;
      font-weight: 700;
      width: 16px;
      height: 16px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      border: 2px solid #fff;
      box-shadow: 0 2px 6px rgba(200, 50, 43, 0.4);
      animation: pulse 2s infinite;
      z-index: 1;
    }

    @keyframes pulse {
      0%, 100% {
        transform: scale(1);
      }
      50% {
        transform: scale(1.1);
      }
    }

    /* Cacher la navbar traditionnelle sur mobile */
    .site-nav .navbar-collapse {
      display: none !important;
    }

    .site-nav .navbar-toggler {
      display: none !important;
    }

    /* Ajuster le padding du contenu pour éviter que le dock ne cache le contenu */
    body {
      padding-bottom: 120px;
    }
  }

  /* ---------- Sections ---------- */
  section.block{padding:5rem 0;background:var(--ivoire)}
  .section-title{font-size:clamp(1.6rem,3.2vw,2.2rem);font-weight:700;color:var(--nuit);margin-bottom:.4rem}
  .section-title::after{content:"";display:block;width:56px;height:3px;background:var(--or);margin-top:.7rem;border-radius:2px}
  .section-intro{color:var(--brume);max-width:40rem;margin-bottom:2.2rem}

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

  /* Annonces */
  #annonces{background:var(--ivoire);border-top:1px solid var(--parchemin);border-bottom:1px solid var(--parchemin)}
  .an-title { font-family: 'Cinzel', serif; color: var(--nuit); font-size: 1.35rem; margin-bottom: 1.25rem; }
  .an-title i { color: var(--or); margin-right: .5rem; }

  /* Affiches : colonnes "maçonnerie", les affiches gardent leur format d'origine */
  .an-affiches { column-count: 2; column-gap: 1rem; }
  @media (max-width: 575.98px) { .an-affiches { column-count: 1; } }
  .an-affiche { break-inside: avoid; margin-bottom: 1rem; background: var(--carte); border-radius: .9rem; overflow: hidden;
                box-shadow: 0 .125rem .5rem rgba(0,0,0,.08); }
  .an-affiche img { display: block; width: 100%; height: auto; }
  .an-affiche .corps { padding: .9rem 1rem 1rem; }
  .an-affiche h4 { font-size: 1rem; margin-bottom: .35rem; }

  /* Informations : fil chronologique, date à gauche */
  .an-item { display: grid; grid-template-columns: 96px 1fr; gap: 1.25rem; padding: 1.25rem 0; border-bottom: 1px solid rgba(0,0,0,.08); }
  .an-item:first-child { padding-top: 0; }
  .an-item:last-child { border-bottom: 0; }
  .an-item time { color: var(--or); font-family: 'Cinzel', serif; font-weight: 600; font-size: .9rem; line-height: 1.3; }
  .an-item h4 { font-size: 1.1rem; margin-bottom: .4rem; }
  .an-item p { margin-bottom: 0; max-width: 70ch; }
  @media (max-width: 575.98px) { .an-item { grid-template-columns: 1fr; gap: .25rem; } }

  /* Agenda : colonne latérale qui reste visible au défilement */
  .an-agenda { background: var(--nuit); color: #fff; border-radius: 1rem; padding: 1.5rem; }
  @media (min-width: 992px) { .an-agenda { position: sticky; top: 90px; } }
  .an-agenda h3 { font-family: 'Cinzel', serif; font-size: 1.15rem; margin-bottom: 1.25rem; }
  .an-agenda h3 i { color: var(--or); margin-right: .5rem; }
  .an-agenda ul { list-style: none; padding: 0; margin: 0; }
  .an-agenda li { display: flex; gap: 1rem; align-items: center; padding: .85rem 0; border-top: 1px solid rgba(255,255,255,.15); }
  .an-agenda li:first-child { border-top: 0; padding-top: 0; }
  .an-agenda .an-intro { color: rgba(255,255,255,.8); margin-bottom: 1rem; }
  .an-date { width: 54px; flex-shrink: 0; text-align: center; background: var(--or); color: var(--nuit); border-radius: .6rem; padding: .6rem 0; line-height: 1; font-weight: 700; }
  .an-agenda small { color: rgba(255,255,255,.75); }

  .an-vide { color: #6c757d; padding: 1.5rem; border: 1px dashed rgba(0,0,0,.2); border-radius: .9rem; margin: 0; }
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
    box-shadow: 0 0 0 2px rgba(212,169,55,0.35);
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
  .whatsapp-cta:hover{ background: var(--or); color: var(--nuit); }
  .whatsapp-cta i{ font-size: 16px; }

  /* Bouton retour en haut */
  .to-top{position:fixed;right:1rem;bottom:1rem;width:44px;height:44px;border-radius:50%;background:var(--or);color:var(--nuit);display:grid;place-items:center;text-decoration:none;box-shadow:var(--ombre);opacity:0;pointer-events:none;transition:opacity .2s}
  .to-top.show{opacity:1;pointer-events:auto}

  @media (prefers-reduced-motion:reduce){html{scroll-behavior:auto}.to-top{transition:none}}
</style>
</head>
<body>

{{-- ================= NAVIGATION ================= --}}
<nav class="navbar navbar-expand-lg navbar-light site-nav sticky-top">
  <div class="container" style="max-width:1100px">
    <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
      <img src="{{ asset('images/michel.jfif') }}" alt="Saint Michel Archange" class="brand-logo">
      <span class="brand-name">
        SAINT MICHEL ARCHANGE
        <small>Paroisse de la BAE</small>
      </span>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu" aria-controls="menu" aria-expanded="false" aria-label="Ouvrir le menu">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="menu">
      <ul class="navbar-nav mx-lg-auto align-items-lg-center gap-lg-1">
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}"><i class="bi bi-house-door-fill me-1"></i>Accueil</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('apropos') ? 'active' : '' }}" href="{{ route('apropos') }}"><i class="bi bi-info-circle-fill me-1"></i>À propos</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('annonces') ? 'active' : '' }}" href="{{ route('annonces') }}"><i class="bi bi-megaphone-fill me-1"></i>Annonces</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}"><i class="bi bi-envelope-fill me-1"></i>Contact</a></li>
      </ul>

      <div class="d-flex align-items-center gap-2 mt-3 mt-lg-0">
        <a href="{{ route('login') }}" class="btn btn-nav btn-nav-gold">
          <i class="bi bi-person-fill me-1"></i>Espace de gestion
        </a>
        {{-- Optionnel : second bouton rouge comme "Contribuer" sur la capture --}}
        {{-- <a href="#" class="btn btn-nav btn-nav-red"><i class="bi bi-heart-fill me-1"></i>Faire un don</a> --}}
      </div>
    </div>
  </div>
</nav>

{{-- ================= NAVIGATION MOBILE (DOCK) ================= --}}
<nav class="mobile-nav-dock d-lg-none">
  <a href="{{ route('home') }}" class="mobile-nav-item {{ request()->routeIs('home') ? 'active' : '' }}" aria-label="Accueil">
    <i class="bi bi-house-door-fill"></i>
  </a>
  <a href="{{ route('apropos') }}" class="mobile-nav-item {{ request()->routeIs('apropos') ? 'active' : '' }}" aria-label="À propos">
    <i class="bi bi-info-circle-fill"></i>
  </a>
  <a href="{{ route('annonces') }}" class="mobile-nav-item {{ request()->routeIs('annonces') ? 'active' : '' }}" aria-label="Annonces">
    <div style="position: relative;">
      <i class="bi bi-megaphone-fill"></i>
      <span class="mobile-nav-badge">3</span>
    </div>
  </a>
  <a href="{{ route('contact') }}" class="mobile-nav-item {{ request()->routeIs('contact') ? 'active' : '' }}" aria-label="Contact">
    <i class="bi bi-envelope-fill"></i>
  </a>
  <a href="{{ route('login') }}" class="mobile-nav-item {{ request()->routeIs('login') ? 'active' : '' }}" aria-label="Compte">
    <i class="bi bi-person-fill"></i>
  </a>
</nav>


@yield('content')


{{-- ================= PIED DE PAGE ================= --}}
<footer class="site-foot">
  <div class="container" style="max-width:1100px;padding-top:3rem">
    <div class="row g-4">
      <!-- Newsletter -->
      <div class="col-lg-3 footer-section">
        <h4>Restez informé</h4>
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
          <li><a href="{{ route('home') }}">Accueil</a></li>
          <li><a href="{{ route('apropos') }}">À propos</a></li>
          <li><a href="{{ route('annonces') }}">Annonces</a></li>
          <li><a href="{{ route('contact') }}">Contact</a></li>
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
          </div>
        </div>
        </div>
      </div>
    </div>
  </div>
</footer>

<a href="#accueil" class="to-top" id="toTop" aria-label="Retour en haut"><i class="bi bi-chevron-up"></i></a>

{{-- ================= BARRE DE NAVIGATION MOBILE ================= --}}
<div class="mobile-nav-dock d-lg-none">
  <a href="{{ route('home') }}" class="mobile-nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
    <i class="bi bi-house-fill"></i>
    <span>Accueil</span>
  </a>
  <a href="{{ route('apropos') }}" class="mobile-nav-item {{ request()->routeIs('apropos') ? 'active' : '' }}">
    <i class="bi bi-info-circle-fill"></i>
    <span>À propos</span>
  </a>
  <a href="{{ route('annonces') }}" class="mobile-nav-item {{ request()->routeIs('annonces') ? 'active' : '' }}">
    <i class="bi bi-megaphone-fill"></i>
    <span>Annonces</span>
  </a>
  <a href="{{ route('contact') }}" class="mobile-nav-item {{ request()->routeIs('contact') ? 'active' : '' }}">
    <i class="bi bi-envelope-fill"></i>
    <span>Contact</span>
  </a>
  <a href="{{ route('login') }}" class="mobile-nav-item">
    <i class="bi bi-person-fill"></i>
    <span>Connexion</span>
  </a>
</div>

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