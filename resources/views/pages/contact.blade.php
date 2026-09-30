@extends('layouts.public')
@section('titre', 'Contact - Paroisse Saint Michel Archange de la BAE')
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

  #contact{background:var(--ivoire)}

.map-wrap iframe{
  border-radius:14px;
  box-shadow:0 6px 24px rgba(0,0,0,.10);
  min-height:320px;
  display:block;
}

</style>

{{-- ================= HERO BANNER ================= --}}
<header id="accueil" class="hero-split">
  <div class="hero-left">
    <div class="hero-content">
      <h1>Contactez-Nous</h1>
      <p class="sub">Paroisse Saint Michel Archange BAE</p>
      <span class="hero-line"></span>
      <p class="verse">
        « Saint Michel Archange, défendez-nous dans le combat. »
      </p>
    </div>
  </div>
  <div class="hero-right" style="background-image:url('{{ asset('images/banniere.jpg') }}')"></div>
</header>



</style>

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
          <form method="POST" action="{{ route('contact.envoyer') }}">
            @csrf
            <div class="row g-3">
              <div class="col-md-6">
                <label for="nom" class="form-label">Nom complet</label>
                <input type="text" id="nom" name="nom" class="form-control" value="{{ old('nom') }}" required>
              </div>
              <div class="col-md-6">
                <label for="telephone" class="form-label">Téléphone</label>
                <input type="tel" id="telephone" name="telephone" class="form-control" value="{{ old('telephone') }}" required>
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

 {{-- ================= CARTE ================= --}}
    <div class="map-wrap mt-4">
      <iframe
        title="Localisation de l'Église Catholique Saint-Michel Archange"
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63557.381310619516!2d-4.1293644300250145!3d5.365561648492812!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xfc1ea64d785bc3f%3A0x4ffcf28d2595e43c!2s%C3%89glise%20Catholique%20Saint-Michel%20Archange!5e0!3m2!1sfr!2sci!4v1790763036017!5m2!1sfr!2sci"
        width="100%" height="450" style="border:0;" allowfullscreen loading="lazy"
        referrerpolicy="strict-origin-when-cross-origin"></iframe>
      <a class="btn btn-gold mt-3"
         href="https://www.google.com/maps/search/?api=1&query={{ urlencode('Église Catholique Saint-Michel Archange Abidjan') }}&query_place_id=ChIJP1u4baYeD78RPOWVKdjP_E8"
         target="_blank" rel="noopener">
        <i class="bi bi-signpost-split me-2"></i>Obtenir l'itinéraire
      </a>
    </div>

  </div>


</section>

@endsection