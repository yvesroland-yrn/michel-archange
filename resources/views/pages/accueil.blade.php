@extends('layouts.public')
@section('titre', 'Accueil - Paroisse Saint Michel Archange de la BAE')
@section('content')
<style>
  #apropos{background:var(--ivoire)}
  #annonces{background:var(--ivoire)}


      .hero-split{
      position:relative;
      display:flex;
      min-height:600px;
      max-height:750px;
      background:var(--nuit-deep);
      overflow:hidden;
    }

    /* Volet gauche : dégradé bleu nuit */
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

    .hero-actions{ display:flex; flex-wrap:wrap; gap:.65rem; }

    /* Volet droit : image */
    .hero-right{
      position:absolute;
      inset:0 0 0 45%;
      z-index:1;
      background-size:cover;
      background-position:center center;
    }

    /* Coupe diagonale : le bleu nuit « mord » sur l'image */
    .hero-left::after{
      content:"";
      position:absolute;
      top:0; right:-1px; bottom:0;
      width:70px;
      background:var(--archange);
      clip-path:polygon(0 0,100% 0,100% 100%,60% 100%);
      opacity:.9;
    }

    /* Mobile : image en haut, texte dessous */
    @media (max-width:991px){
      .hero-split{ flex-direction:column-reverse; min-height:auto; max-height:none; }
      .hero-left{ flex:none; padding:2rem 1.5rem; }
      .hero-left::after{ display:none; }
      .hero-right{ position:relative; inset:auto; height:220px; }
      .hero-content{ max-width:100%; }
    }

    /* Section Mot du curé */
    .ap-section{ padding: 4rem 0; }
    .ap-cure-photo{ text-align: center; }
    .ap-cure-photo img{
      width: 250px;
      height: 300px;
      object-fit: cover;
      border-radius: 1rem;
      border: 3px solid var(--or);
      box-shadow: 0 10px 30px rgba(212,169,55,.3);
    }
    .ap-title{
      font-family: 'Cinzel', serif;
      font-size: 2rem;
      color: var(--nuit);
      margin-bottom: 1.5rem;
    }
    .ap-title i{ color: var(--or); margin-right: .5rem; }
    .ap-quote{
      font-size: 1.1rem;
      line-height: 1.8;
      color: var(--brume);
      font-style: italic;
      border-left: 4px solid var(--or);
      padding-left: 1.5rem;
      margin: 1.5rem 0;
      background: rgba(212,169,55,.05);
      padding: 1.5rem;
      border-radius: .5rem;
    }
    @media (max-width: 767px){
      .ap-cure-photo img{ width: 150px; height: 150px; }
      .ap-title{ font-size: 1.5rem; }
      .ap-quote{ font-size: 1rem; }
    }


</style>


{{-- ================= ACCUEIL ================= --}}


<header id="accueil" class="hero-split">
  <div class="hero-left">
    <div class="hero-content">  
      <h1>Paroisse Saint Michel Archange</h1>
      <p class="sub">de la BAE</p>
      <span class="hero-line"></span>
      <p class="verse">
        «Saint Michel Archange , qui est comme Dieu.
      </p>
    </div>
  </div>

  <div class="hero-right" style="background-image:url('{{ asset('images/1.png') }}')"></div> 
</header>


{{-- Horaires (à adapter) --}}


<div class="times">
  <div class="container" style="max-width:1100px">
    <div class="times-card">
      <div class="row g-0">
        <div class="col-md-4 time-item"><i class="bi bi-brightness-high"></i><div><b>Messe dominicale</b><span>Dimanche 07h00 et 9h00</span></div></div>
        <div class="col-md-4 time-item"><i class="bi bi-book"></i><div><b>Messe en semaine</b><span>Du mardi au vendredi à 06h30 et 19h00</span></div></div>
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
          @forelse($clerge as $membre)
          <div class="col-md-6 col-lg-4">
            <div class="text-center">
              <div class="mb-3">
                @if($membre->photo)
                <img src="{{ asset('storage/' . $membre->photo) }}" class="rounded-circle" style="width: 120px; height: 120px; object-fit: cover; border: 3px solid var(--or);" alt="{{ $membre->nom_complet }}">
                @else
                <img src="{{ asset('images/michel.jfif') }}" class="rounded-circle" style="width: 120px; height: 120px; object-fit: cover; border: 3px solid var(--or);" alt="{{ $membre->nom_complet }}">
                @endif
              </div>
              <h5 class="mb-1" style="font-family: 'Cinzel', serif;">Père {{ $membre->nom_complet }}</h5>
              <p class="text-muted small mb-2">{{ \App\Models\Clerge::ROLES[$membre->role] ?? $membre->role }}</p>
              <p class="small text-muted">{{ $membre->biographie ?? 'Membre du clergé de la paroisse.' }}</p>
            </div>
          </div>
          @empty
          <div class="col-12">
            <p class="text-muted text-center">Aucun membre du clergé enregistré pour le moment.</p>
          </div>
          @endforelse
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
          @forelse($conseil as $membre)
          <div class="col-md-6 col-lg-3">
            <div class="card h-100 border-0 shadow-sm" style="border-radius: .8rem;">
              <div class="card-body text-center p-3">
                <div class="mb-3">
                  @if($membre->photo)
                  <img src="{{ asset('storage/' . $membre->photo) }}" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover; border: 2px solid var(--or);" alt="{{ $membre->nom_complet }}">
                  @else
                  <img src="{{ asset('images/michel.jfif') }}" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover; border: 2px solid var(--or);" alt="{{ $membre->nom_complet }}">
                  @endif
                </div>
                <h6 class="mb-1" style="font-family: 'Cinzel', serif;">{{ $membre->nom_complet }}</h6>
                <p class="text-muted small mb-2">{{ $membre->role }}</p>
                @if($membre->telephone)
                <a href="tel:{{ preg_replace('/\s+/', '', $membre->telephone) }}" class="btn btn-sm btn-outline-dark" style="border-color: var(--or); color: var(--encre);">
                  <i class="bi bi-telephone me-1"></i>{{ $membre->telephone }}
                </a>
                @endif
              </div>
            </div>
          </div>
          @empty
          <div class="col-12">
            <p class="text-muted text-center">Aucun membre du conseil enregistré.</p>
          </div>
          @endforelse
        </div>
      </div>
    </div>

    <!-- Responsables de mouvements -->
    <div class="card border-0 shadow-sm mt-4" style="border-radius: 1rem;">
      <div class="card-body p-4 p-lg-5">
        <h3 class="h4 mb-4" style="font-family: 'Cinzel', serif; color: var(--or);">
          <i class="bi bi-music-note-beamed me-2"></i>Responsables de mouvements
        </h3>
        <p class="text-muted mb-4">
          Nos mouvements paroissiaux sont animés par des responsables dévoués qui organisent les activités spirituelles et sociales.
        </p>

        <div class="row g-4">
          @forelse($mouvements as $mouvement)
          <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm" style="border-radius: .8rem;">
              <div class="card-body p-3">
                <div class="d-flex align-items-start gap-3">
                  <div>
                    @if($mouvement->photo)
                    <img src="{{ asset('storage/' . $mouvement->photo) }}" class="rounded-circle" style="width: 60px; height: 60px; object-fit: cover; border: 2px solid var(--or);" alt="{{ $mouvement->nom }}">
                    @else
                    <img src="{{ asset('images/michel.jfif') }}" class="rounded-circle" style="width: 60px; height: 60px; object-fit: cover; border: 2px solid var(--or);" alt="{{ $mouvement->nom }}">
                    @endif
                  </div>
                  <div class="flex-grow-1">
                    <span class="badge mb-1" style="background: var(--or); color: var(--nuit); font-size: 0.75rem;">{{ $mouvement->nom }}</span>
                    <h6 class="mb-1" style="font-family: 'Cinzel', serif;">{{ $mouvement->responsable }}</h6>
                    @if($mouvement->telephone_responsable)
                    <a href="tel:{{ preg_replace('/\s+/', '', $mouvement->telephone_responsable) }}" class="btn btn-sm btn-link p-0" style="color: var(--encre);">
                      <i class="bi bi-telephone me-1"></i>{{ $mouvement->telephone_responsable }}
                    </a>
                    @endif
                  </div>
                </div>
              </div>
            </div>
          </div>
          @empty
          <div class="col-12">
            <p class="text-muted text-center">Aucun mouvement paroissial enregistré.</p>
          </div>
          @endforelse
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

    <div class="row g-5">

      {{-- Prochains rendez-vous --}}
      <aside class="col-lg-4 order-first order-lg-last" aria-label="Prochains rendez-vous">
        <div class="an-agenda">
          <h3><i class="bi bi-calendar-event-fill"></i>Prochains rendez-vous</h3>
          <p class="an-intro">Les événements à venir :</p>
          <ul>
            @if(isset($evenements))
              @forelse($evenements as $e)
                <li>
                  <div class="an-date" aria-hidden="true">{{ $e->date_heure->format('d') }}</div>
                  <div>
                    <div class="fw-semibold">{{ $e->titre }}</div>
                    <small>{{ $e->date_heure->format('H:i') }}@if($e->lieu) · {{ $e->lieu }}@endif</small>
                  </div>
                </li>
              @empty
                <li class="an-vide">Rien de programmé.</li>
              @endforelse
            @else
              <li class="an-vide">Rien de programmé.</li>
            @endif
          </ul>
        </div>
      </aside>

      {{-- Colonne principale --}}
      <div class="col-lg-8">

        @if(isset($annonces_avec_images) && $annonces_avec_images->count() > 0)
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
        @if(isset($annonces_sans_images))
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
        @else
          <p class="an-vide">Aucune information pour le moment. Revenez bientôt.</p>
        @endif

      </div>
    </div>
  </div>
</section>


@endsection