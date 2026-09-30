@extends('layouts.public')
@section('titre', 'Annonces - Paroisse Saint Michel Archange de la BAE')
@section('content')

@php
  // Jours de réception du curé, à modifier ici
  $receptions = [
    ['jour' => 'Mardi', 'debut' => '8h', 'fin' => '17h'],
    ['jour' => 'Jeudi', 'debut' => '8h', 'fin' => '17h'],
  ];
@endphp

<style>
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

  .an-title { font-family: 'Cinzel', serif; color: var(--nuit); font-size: 1.35rem; margin-bottom: 1.25rem; }
  .an-title i { color: var(--or); margin-right: .5rem; }
  .an-title { font-family: 'Cinzel', serif; color: var(--nuit); font-size: 1.35rem; margin-bottom: 1.25rem; }
  .an-title i { color: var(--or); margin-right: .5rem; }

  /* Affiches : colonnes "maçonnerie", les affiches gardent leur format d'origine */
  .an-affiches { column-count: 2; column-gap: 1rem; }
  @media (max-width: 575.98px) { .an-affiches { column-count: 1; } }
  .an-affiche { break-inside: avoid; margin-bottom: 1rem; background: var(--ivoire); border-radius: .9rem; overflow: hidden;
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
</style>

{{-- ================= HERO BANNER ================= --}}
<header id="accueil" class="hero-split">
  <div class="hero-left">
    <div class="hero-content">
      <h1>Nos Annonces </h1>
      <p class="sub">Paroisse Saint Michel Archange BAE</p>
      <span class="hero-line"></span>
      <p class="verse">
        « Saint Michel Archange, défendez-nous dans le combat. »
      </p>
    </div>
  </div>
  <div class="hero-right" style="background-image:url('{{ asset('images/banniere.jpg') }}')"></div>
</header>

<section id="annonces" class="block">
  <div class="container" style="max-width:1100px">
    <h1 class="section-title">Annonces</h1>
    <p class="section-intro">Les dernières nouvelles de la paroisse et les jours de réception du curé.</p>

    <div class="row g-5">

      {{-- Réception du curé : en premier sur mobile, à droite sur ordinateur --}}
      <aside class="col-lg-4 order-first order-lg-last" aria-label="Jours de réception du curé">
        <div class="an-agenda">
          <h3><i class="bi bi-clock-fill"></i>Réception du curé</h3>
          <p class="an-intro">Le curé reçoit les paroissiens :</p>
          <ul>
            @foreach($receptions as $r)
              <li>
                <div class="an-date" aria-hidden="true">{{ mb_substr($r['jour'], 0, 3) }}</div>
                <div>
                  <div class="fw-semibold">{{ $r['jour'] }}</div>
                  <small>de {{ $r['debut'] }} à {{ $r['fin'] }}</small>
                </div>
              </li>
            @endforeach
          </ul>
        </div>
      </aside>

      {{-- Colonne principale --}}
      <div class="col-lg-8">

        @if($annonces_avec_images->count() > 0)
          <div class="mb-5">
            <h2 class="an-title"><i class="bi bi-image-fill"></i>Affiches</h2>
            <div class="an-affiches">
              @foreach($annonces_avec_images as $a)
                <article class="an-affiche">
                  @if($a->image)
                    <a href="{{ asset('storage/' . $a->image) }}" target="_blank" rel="noopener">
                      <img src="{{ asset('storage/' . $a->image) }}" alt="Affiche : {{ $a->titre }}" loading="lazy">
                    </a>
                  @endif
                  <div class="corps">
                    <h4>{{ $a->titre }}</h4>
                    <p class="small text-muted mb-2">{{ \Illuminate\Support\Str::limit(strip_tags($a->contenu), 100) }}</p>
                    <small class="text-muted">
                      <i class="bi bi-calendar3"></i>
                      <time datetime="{{ $a->publie_le->toDateString() }}">{{ $a->publie_le->translatedFormat('j F Y') }}</time>
                    </small>
                  </div>
                </article>
              @endforeach
            </div>
          </div>
        @endif

        <h2 class="an-title"><i class="bi bi-megaphone-fill"></i>Informations paroissiales</h2>
        @forelse($annonces_sans_images as $a)
          <article class="an-item">
            <time datetime="{{ $a->publie_le->toDateString() }}">{{ $a->publie_le->translatedFormat('j F Y') }}</time>
            <div>
              <h4>{{ $a->titre }}</h4>
              <p>{!! nl2br(e($a->contenu)) !!}</p>
            </div>
          </article>
        @empty
          <p class="an-vide">Aucune information pour le moment. Revenez bientôt.</p>
        @endforelse

      </div>
    </div>
  </div>
</section>
@endsection