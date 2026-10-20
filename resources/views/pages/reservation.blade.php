@extends('layouts.public')
@section('titre', 'Réservation - Sanctuaire Marial Notre-Dame de Cana Sassako')
@section('content')
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
    justify-content:center;
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
    background-position:center 30%;
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

  #reservation{background:var(--ivoire)}
</style>

{{-- ================= HERO BANNER ================= --}}
<header id="accueil" class="hero-split">
  <div class="hero-left">
    <div class="hero-content">
      <h1>Réservation</h1>
      <p class="sub">Sanctuaire Marial Notre-Dame de Cana Sassako</p>
      <span class="hero-line"></span>
      <p class="verse">
        « Réservez votre visite au sanctuaire. »
      </p>
    </div>
  </div>
  <div class="hero-right" style="background-image:url('{{ asset('images/banniere-sanctuaire.png') }}')"></div>
</header>

{{-- ================= FORMULAIRE DE RÉSERVATION ================= --}}
<section id="reservation" class="block">
  <div class="container" style="max-width:1100px">
    <h2 class="section-title">Formulaire de Réservation</h2>
    <p class="section-intro">Remplissez ce formulaire pour réserver votre visite au sanctuaire. Nous vous contacterons pour confirmer votre réservation.</p>
    
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="contact-card">
          @if(session('ok'))<div class="alert-ok" role="status"><i class="bi bi-check-circle me-2"></i>{{ session('ok') }}</div>@endif
          @if($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
          
          <form method="POST" action="{{ route('reservation.store') }}">
            @csrf
            <div class="row g-3">
              <div class="col-md-6">
                <label for="nom" class="form-label">Nom complet *</label>
                <input type="text" id="nom" name="nom" class="form-control" value="{{ old('nom') }}" required placeholder="Votre nom et prénom">
              </div>
              <div class="col-md-6">
                <label for="telephone" class="form-label">Téléphone *</label>
                <input type="tel" id="telephone" name="telephone" class="form-control" value="{{ old('telephone') }}" required placeholder="+225 XX XX XX XX XX">
              </div>
              <div class="col-md-6">
                <label for="paroisse" class="form-label">Paroisse *</label>
                <input type="text" id="paroisse" name="paroisse" class="form-control" value="{{ old('paroisse') }}" required placeholder="Nom de votre paroisse">
              </div>
              <div class="col-md-6">
                <label for="diocese_vicariat" class="form-label">Diocèse / Vicariat</label>
                <input type="text" id="diocese_vicariat" name="diocese_vicariat" class="form-control" value="{{ old('diocese_vicariat') }}" placeholder="Optionnel">
              </div>
              <div class="col-md-6">
                <label for="date_reservation" class="form-label">Date de réservation *</label>
                <input type="date" id="date_reservation" name="date_reservation" class="form-control" value="{{ old('date_reservation') }}" required min="{{ now()->addDay()->format('Y-m-d') }}">
              </div>
              <div class="col-md-6">
                <label for="nombre_personnes" class="form-label">Nombre de personnes *</label>
                <input type="number" id="nombre_personnes" name="nombre_personnes" class="form-control" value="{{ old('nombre_personnes') }}" required min="1" max="500" placeholder="Ex: 15">
              </div>
              <div class="col-12">
                <label for="message" class="form-label">Message (optionnel)</label>
                <textarea id="message" name="message" rows="4" class="form-control" placeholder="Précisez toute information utile...">{{ old('message') }}</textarea>
              </div>
              <div class="col-12">
                <button type="submit" class="btn btn-gold btn-lg px-4">
                  <i class="bi bi-calendar-check me-2"></i>Envoyer la réservation
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection
