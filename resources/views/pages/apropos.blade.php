@extends('layouts.public')
@section('titre', 'À propos - Paroisse Saint Michel Archange de la BAE')
@section('content')

@php
  $avatar = asset('images/michel.jfif');
@endphp

{{-- ================= HERO BANNER ================= --}}
<header id="accueil" class="hero-split">
  <div class="hero-left">
    <div class="hero-content">
      <h1>A Propos</h1>
      <p class="sub">Paroisse Saint Michel Archange BAE</p>
      <span class="hero-line"></span>
      <p class="verse">
        « Saint Michel Archange, défendez-nous dans le combat. »
      </p>
    </div>
  </div>
  <div class="hero-right" style="background-image:url('{{ asset('images/banniere.jpg') }}')"></div>
</header>

<style>
  html { scroll-behavior: smooth; }
  @media (prefers-reduced-motion: reduce) { html { scroll-behavior: auto; } }

  /* Hero Banner */
  .hero-split{
    position:relative;
    display:flex;
    min-height:600px;
    max-height:750px;
    background:var(--nuit-deep);
    overflow:hidden;
  }
  .hero-left{
    position:relative;
    z-index:2;
    flex:0 0 55%;
    display:flex;
    align-items:center;
    justify-content: center;
    background:var(--grad-ciel);
    padding:3rem 2.5rem 3rem clamp(1.5rem,6vw,6rem);
  }
  .hero-content{ max-width:480px; color:#fff; text-align: center; }
  .hero-split .crest{
    width:64px; height:64px; object-fit:cover;
    border-radius:50%;
    border:2px solid var(--or);
    margin-bottom:1rem;
  }
  .hero-split h1{
    font-family:'Cinzel',serif;
    font-weight:900;
    font-size:clamp(1.8rem,3.8vw,3rem);
    line-height:1.1;
    margin:0;
    color:#fff;
  }
  .hero-split .sub{
    margin:.3rem 0 0;
    font-weight:700;
    font-size:1rem;
    color:var(--or-clair);
  }
  .hero-line{
    display:block;
    width:40px; height:3px;
    background:var(--or);
    margin:.8rem 0 1rem;
    border-radius:2px;
  }
  .hero-split .verse{
    font-size:.9rem;
    line-height:1.7;
    color:rgba(255,255,255,.9);
    margin-bottom:1.4rem;
  }
  .hero-split .verse b{ display:block; color:var(--or); margin-top:.3rem; }
  .hero-right{
    position:absolute;
    inset:0 0 0 45%;
    z-index:1;
    background-size:cover;
    background-position:center center;
  }
  .hero-left::after{
    content:"";
    position:absolute;
    top:0; right:-1px; bottom:0;
    width:70px;
    background:var(--archange);
    clip-path:polygon(0 0,100% 0,100% 100%,60% 100%);
    opacity:.9;
  }
  @media (max-width:991px){
    .hero-split{ flex-direction:column-reverse; min-height:auto; max-height:none; }
    .hero-left{ flex:none; padding:2rem 1.5rem; }
    .hero-left::after{ display:none; }
    .hero-right{ position:relative; inset:auto; height:220px; }
    .hero-content{ max-width:100%; }
  }

  .ap-section { scroll-margin-top: 90px; padding-block: 3rem; background: var(--ivoire); }
  .ap-section + .ap-section { border-top: 1px solid var(--parchemin); }
  .ap-title { font-family: 'Cinzel', serif; color: var(--nuit); font-size: 1.6rem; margin-bottom: .35rem; }
  .ap-title i { color: var(--or); margin-right: .5rem; }
  .ap-lead { color: var(--brume); max-width: 60ch; margin-bottom: 2rem; }

  /* Navigation interne */
  .ap-nav { position: sticky; top: 0; z-index: 20; background: rgba(255,255,255,.95); backdrop-filter: blur(6px);
            border-bottom: 1px solid rgba(0,0,0,.08); }
  .ap-nav .inner { display: flex; gap: .5rem; overflow-x: auto; padding: .75rem 0; scrollbar-width: none; }
  .ap-nav .inner::-webkit-scrollbar { display: none; }
  .ap-nav a { white-space: nowrap; padding: .4rem 1rem; border-radius: 999px; border: 1px solid var(--or);
              color: var(--encre); text-decoration: none; font-size: .9rem; }
  .ap-nav a:hover, .ap-nav a:focus-visible { background: var(--or); color: var(--nuit); outline: none; }

  /* Mot du curé */
  .ap-cure-photo { position: relative; }
  .ap-cure-photo::before { content: ""; position: absolute; inset: 14px -14px -14px 14px; border: 2px solid var(--gold);
                           border-radius: 1rem; z-index: 0; }
  .ap-cure-photo img { position: relative; z-index: 1; width: 100%; aspect-ratio: 4/5; object-fit: cover; border-radius: 1rem; }
  .ap-quote { border-left: 4px solid var(--gold); padding-left: 1.25rem; font-size: 1.15rem; line-height: 1.8; font-style: italic; }

  /* Clergé */
  .ap-person img { width: 100%; object-fit: cover; }
  .ap-clergy-main img { aspect-ratio: 4/3; border-radius: 1rem 1rem 0 0; }
  .ap-clergy-side img { width: 96px; height: 96px; border-radius: 50%; border: 3px solid var(--gold); flex-shrink: 0; }
  .ap-role { display: inline-block; background: var(--or); color: var(--nuit); border-radius: 999px;
             padding: .15rem .75rem; font-size: .8rem; margin-bottom: .5rem; }

  /* Conseil : lignes */
  .ap-row { display: flex; align-items: center; gap: 1rem; padding: 1rem 0; border-bottom: 1px solid rgba(0,0,0,.08); }
  .ap-row:last-child { border-bottom: 0; }
  .ap-row .role { width: 130px; flex-shrink: 0; color: var(--gold); font-family: 'Cinzel', serif; font-weight: 600; }
  .ap-row .nom { flex: 1; font-weight: 600; }
  .ap-row img { width: 48px; height: 48px; border-radius: 50%; object-fit: cover; border: 2px solid var(--gold); }
  @media (max-width: 575.98px) {
    .ap-row { flex-wrap: wrap; }
    .ap-row .role { width: 100%; }
    .ap-row .nom { flex: 1 1 60%; }
  }

  /* Mouvements */
  .ap-mvt { height: 100%; border: 1px solid rgba(0,0,0,.08); border-radius: .9rem; padding: 1.25rem; background: #fff; }
  .ap-mvt .icone { width: 44px; height: 44px; border-radius: 50%; background: var(--nuit); color: var(--or);
                   display: grid; place-items: center; font-size: 1.2rem; margin-bottom: .75rem; }
  .ap-mvt h3 { font-family: 'Cinzel', serif; font-size: 1.05rem; margin-bottom: .15rem; }

  .ap-tel { color: var(--encre); text-decoration: none; font-size: .9rem; white-space: nowrap; }
  .ap-tel:hover, .ap-tel:focus-visible { color: var(--archange); text-decoration: underline; }
</style>

{{-- ============ En-tête + navigation interne ============ --}}
<header class="container" style="max-width:1100px; padding-top:3rem;">
  <h1 class="section-title mb-2">Paroisse Saint Michel Archnage De La BAE</h1>
  <p class="section-intro mb-4">Le mot de notre curé, ceux qui nous guident et les personnes à contacter.</p>
</header>

<div class="container" style="max-width:1100px">

  {{-- ============ Mot du curé ============ --}}
  <section id="cure" class="ap-section">
    <div class="row g-5 align-items-center">
      <div class="col-md-5 col-lg-4">
        <div class="ap-cure-photo">
          <img src="{{ asset('images/cure.jpeg') }}" alt="Le curé de la paroisse">
        </div>
      </div>
      <div class="col-md-7 col-lg-8">
        <h2 class="ap-title"><i class="bi bi-quote"></i>Mot du curé</h2>
        <blockquote class="ap-quote mt-4 mb-4">
          Chers paroissiens, que la paix du Christ soit avec vous. Notre paroisse est une famille où chacun trouve sa place.
          Ensemble, nous vivons notre foi à travers la prière, les sacrements et le service fraternel.
          Saint Michel Archange, notre patron, nous inspire à combattre le mal et à servir Dieu avec courage.
        </blockquote>
        <p>Bienvenue dans notre communauté. Que votre visite sur ce site soit une bénédiction pour vous.</p>
        <p class="mb-0">
          <strong style="font-family:'Cinzel',serif;">Père Bienvenu DJEA</strong><br>
          <small class="text-muted">Curé de la paroisse Saint Michel Archange de la BAE</small>
        </p>
      </div>
    </div>
  </section>

  {{-- ============ Clergé : le curé en avant, ses collaborateurs à côté ============ --}}
  <section id="clerge" class="ap-section">
    <h2 class="ap-title"><i class="bi bi-people-fill"></i>Notre clergé</h2>
    <p class="ap-lead">Au service spirituel et pastoral de la communauté.</p>

    @forelse($clerge as $membre)
    @if($loop->first)
    <div class="row g-4">
      <div class="col-lg-6">
        <article class="card border-0 shadow-sm h-100 ap-person ap-clergy-main" style="border-radius:1rem;">
          @if($membre->photo)
          <img src="{{ asset('storage/' . $membre->photo) }}" alt="{{ $membre->nom_complet }}">
          @else
          <img src="{{ $avatar }}" alt="{{ $membre->nom_complet }}">
          @endif
          <div class="card-body p-4">
            <span class="ap-role">{{ \App\Models\Clerge::ROLES[$membre->role] ?? $membre->role }}</span>
            <h3 class="h5" style="font-family:'Cinzel',serif;">Père {{ $membre->nom_complet }}</h3>
            <p class="text-muted mb-0">{{ $membre->biographie ?? 'Membre du clergé de la paroisse.' }}</p>
          </div>
        </article>
      </div>

      <div class="col-lg-6 d-flex flex-column gap-4">
    @else
        <article class="card border-0 shadow-sm flex-fill ap-person ap-clergy-side" style="border-radius:1rem;">
          <div class="card-body p-4 d-flex gap-3 align-items-center">
            @if($membre->photo)
            <img src="{{ asset('storage/' . $membre->photo) }}" alt="{{ $membre->nom_complet }}">
            @else
            <img src="{{ $avatar }}" alt="{{ $membre->nom_complet }}">
            @endif
            <div>
              <span class="ap-role">{{ \App\Models\Clerge::ROLES[$membre->role] ?? $membre->role }}</span>
              <h3 class="h6 mb-1" style="font-family:'Cinzel',serif;">Père {{ $membre->nom_complet }}</h3>
              <p class="small text-muted mb-0">{{ $membre->biographie ?? 'Membre du clergé de la paroisse.' }}</p>
            </div>
          </div>
        </article>
    @endif
    @if($loop->last && !$loop->first)
      </div>
    @endif
    @if($loop->last)
    </div>
    @endif
    @empty
    <p class="text-muted text-center">Aucun membre du clergé enregistré pour le moment.</p>
    @endforelse
  </section>

  {{-- ============ Conseil paroissial : liste lisible, un contact par ligne ============ --}}
  <section id="conseil" class="ap-section">
    <div class="row g-5">
      <div class="col-lg-4">
        <h2 class="ap-title"><i class="bi bi-person-workspace"></i>Conseil paroissial</h2>
        <p class="ap-lead mb-0">Il assiste le curé dans la gestion administrative et pastorale de la paroisse.</p>
      </div>
      <div class="col-lg-8">
        <div class="card border-0 shadow-sm" style="border-radius:1rem;">
          <div class="card-body px-4 py-2">
            @forelse($conseil as $membre)
              <div class="ap-row">
                <span class="role">{{ $membre->role }}</span>
                @if($membre->photo)
                <img src="{{ asset('storage/' . $membre->photo) }}" alt="{{ $membre->nom_complet }}">
                @else
                <img src="{{ $avatar }}" alt="{{ $membre->nom_complet }}">
                @endif
                <span class="nom">{{ $membre->nom_complet }}</span>
                @if($membre->telephone)
                <a class="ap-tel" href="tel:{{ preg_replace('/\s+/', '', $membre->telephone) }}">
                  <i class="bi bi-telephone me-1"></i>{{ $membre->telephone }}
                </a>
                @endif
              </div>
            @empty
              <p class="text-muted text-center">Aucun membre du conseil enregistré.</p>
            @endforelse
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- ============ Mouvements ============ --}}
  <section id="mouvements" class="ap-section">
    <h2 class="ap-title"><i class="bi bi-music-note-beamed"></i>Responsables de mouvements</h2>
    <p class="ap-lead">Chaque mouvement organise ses activités spirituelles et sociales. Contactez son responsable pour le rejoindre.</p>

    <div class="row g-3">
      @forelse($mouvements as $m)
        <div class="col-sm-6 col-lg-4">
          <article class="ap-mvt">
            <div class="icone"><i class="bi {{ $m->icone }}"></i></div>
            <h3>{{ $m->nom }}</h3>
            <p class="mb-2 text-muted">{{ $m->responsable }}</p>
            @if($m->telephone_responsable)
            <a class="ap-tel" href="tel:{{ preg_replace('/\s+/', '', $m->telephone_responsable) }}">
              <i class="bi bi-telephone me-1"></i>{{ $m->telephone_responsable }}
            </a>
            @endif
          </article>
        </div>
      @empty
        <div class="col-12">
          <p class="text-muted text-center">Aucun mouvement paroissial enregistré.</p>
        </div>
      @endforelse
    </div>
  </section>

</div>
@endsection