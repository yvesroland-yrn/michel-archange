<!doctype html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Connexion — Paroisse Saint Michel Archange</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<link href="{{ asset('css/paroisse.css') }}" rel="stylesheet">

<style>
:root{
  --nuit: #0B1B3A;
  --nuit-deep: #07122B;
  --archange: #2748B8;
  --or: #D4A937;
  --or-clair: #F2D98A;
  --ivoire: #FAF7F0;
  --carte: #FFFFFF;
  --encre: #1B2233;
  --brume: #6B7590;
  --parchemin: #E6E1D3;
  --grad-ciel: linear-gradient(135deg, #07122B 0%, #0B1B3A 40%, #2748B8 100%);
}
*{box-sizing:border-box}
.login-body{margin:0;font-family:'Inter',sans-serif;background:var(--ivoire);overflow-x:hidden}

.login-page{
  min-height:100vh;display:flex;align-items:center;
  background:
    radial-gradient(700px 500px at 100% 0%, rgba(212,169,55,.18), transparent 60%),
    radial-gradient(600px 500px at 90% 100%, rgba(39,72,184,.12), transparent 60%),
    var(--ivoire);
}

/* =============== IMAGE (gauche, cadre arrondi) =============== */
.art{
  position:relative;flex:0 0 50%;
  height:calc(100vh - 48px);margin:24px 0 24px 24px;
  border-radius:30px;overflow:hidden;
  box-shadow:0 30px 60px rgba(11,27,58,.35), 0 0 0 1px rgba(212,169,55,.6);
  isolation:isolate;
}
.art-img{
  position:absolute;inset:0;
  background-size:contain;background-position:center center;background-repeat:no-repeat;
  background-color:var(--nuit-deep);
  animation:kenburns 22s ease-in-out infinite alternate;
  z-index:-2;
}
@keyframes kenburns{from{transform:scale(1)}to{transform:scale(1.09)}}

/* voile dégradé bleu nuit */
.art::before{
  content:"";position:absolute;inset:0;z-index:-1;
  background:
    linear-gradient(0deg, rgba(7,18,43,.75) 0%, rgba(7,18,43,.35) 32%, rgba(7,18,43,0) 55%),
    linear-gradient(135deg, rgba(39,72,184,.15), transparent 50%);
}
/* liseré doré intérieur */
.art::after{
  content:"";position:absolute;inset:14px;border-radius:20px;
  border:1px solid rgba(242,217,138,.55);pointer-events:none;
}

.art-caption{position:absolute;left:0;right:0;bottom:0;padding:44px 46px;color:#fff}
.art-caption .tag{
  display:inline-flex;align-items:center;gap:8px;
  font-size:.7rem;letter-spacing:3px;text-transform:uppercase;color:var(--or-clair);
}
.art-caption .tag::before,.art-caption .tag::after{content:"";width:26px;height:1px;background:var(--or)}
.art-caption h2{
  font-family:'Cinzel',serif;font-weight:800;font-size:2.3rem;line-height:1.15;
  margin:12px 0 10px;text-shadow:0 4px 18px rgba(0,0,0,.55);
}
.art-caption h2 span{color:var(--or)}
.art-caption p{
  font-family:'Cinzel',serif;font-size:.95rem;line-height:1.7;color:rgba(255,255,255,.88);
  max-width:440px;margin:0;border-left:2px solid var(--or);padding-left:14px;
}

/* =============== FORMULAIRE (droite) =============== */
.side{flex:1;display:flex;align-items:center;justify-content:center;padding:40px 30px}
.box{width:100%;max-width:370px;text-align:center;animation:fadeUp .9s cubic-bezier(.2,.7,.2,1) both}
@keyframes fadeUp{from{opacity:0;transform:translateY(26px)}to{opacity:1;transform:none}}

/* blason avec halo doré */
.crest-wrap{position:relative;width:92px;height:92px;margin:0 auto 16px}
.crest-wrap::before{
  content:"";position:absolute;inset:-14px;border-radius:50%;
  background:radial-gradient(circle,rgba(212,169,55,.55),transparent 68%);
  animation:pulse 3.2s ease-in-out infinite;
}
.crest-wrap img{
  position:relative;width:100%;height:100%;object-fit:cover;border-radius:50%;
  border:3px solid var(--or);box-shadow:0 10px 24px rgba(11,27,58,.35);
}
@keyframes pulse{0%,100%{transform:scale(.92);opacity:.7}50%{transform:scale(1.1);opacity:1}}

.brand{font-family:'Cinzel',serif;font-size:1.25rem;font-weight:500;color:var(--encre);letter-spacing:.4px}
.brand b{color:var(--archange);font-weight:700}

.orn{display:flex;align-items:center;justify-content:center;gap:10px;margin:12px 0 4px;color:var(--or)}
.orn::before,.orn::after{content:"";width:46px;height:1px;background:linear-gradient(90deg,transparent,var(--or))}
.orn::after{transform:scaleX(-1)}

.box h1{font-family:'Cinzel',serif;font-weight:800;font-size:2.5rem;color:var(--nuit);margin:6px 0 8px}
.hint{font-size:.83rem;color:var(--brume);line-height:1.55;margin-bottom:26px}

.pill-field{
  display:flex;align-items:center;gap:12px;background:#fff;border-radius:50px;
  padding:0 20px;height:54px;margin-bottom:16px;
  border:1.5px solid transparent;
  box-shadow:0 10px 24px rgba(11,27,58,.10);
  transition:border-color .2s, box-shadow .2s, transform .2s;
}
.pill-field:focus-within{
  border-color:var(--or);transform:translateY(-1px);
  box-shadow:0 14px 28px rgba(212,169,55,.30);
}
.pill-field i{color:var(--archange);font-size:1.05rem}
.pill-field input{flex:1;min-width:0;border:0;outline:0;background:transparent;font-size:.92rem;color:var(--encre)}
.pill-field input::placeholder{color:var(--brume)}
.toggle-pw{border:0;background:none;padding:0;cursor:pointer}
.toggle-pw i{color:var(--brume)}

.row-opts{display:flex;justify-content:space-between;align-items:center;font-size:.75rem;color:var(--brume);margin:2px 8px 24px}
.row-opts a{color:var(--archange);font-weight:500;text-decoration:none}
.row-opts a:hover{color:var(--or);text-decoration:underline}
.row-opts input{accent-color:var(--or);margin-right:6px}

.btn-login{
  position:relative;overflow:hidden;
  width:100%;height:54px;border:0;border-radius:50px;cursor:pointer;
  background:linear-gradient(135deg,var(--archange) 0%,var(--nuit) 100%);
  color:#fff;font-weight:600;font-size:1rem;letter-spacing:.4px;
  box-shadow:0 12px 26px rgba(11,27,58,.40), inset 0 0 0 1.5px rgba(212,169,55,.7);
  transition:transform .18s, box-shadow .18s;
}
.btn-login i{margin-right:8px;color:var(--or)}
.btn-login::after{ /* reflet doré qui balaie */
  content:"";position:absolute;top:0;left:-70%;width:50%;height:100%;
  background:linear-gradient(100deg,transparent,rgba(242,217,138,.45),transparent);
  transform:skewX(-20deg);transition:left .6s;
}
.btn-login:hover{transform:translateY(-2px);box-shadow:0 16px 30px rgba(11,27,58,.5), inset 0 0 0 1.5px var(--or)}
.btn-login:hover::after{left:130%}

.back-link{display:inline-block;margin-top:22px;font-size:.83rem;color:var(--archange);text-decoration:none}
.back-link:hover{color:var(--or);text-decoration:underline}
.copy{margin:24px 0 0;font-size:.72rem;color:var(--brume)}

/* =============== RESPONSIVE =============== */
@media(max-width:991px){
  .login-page{flex-direction:column;align-items:stretch}
  .art{flex:none;width:auto;height:36vh;margin:14px 14px 0;border-radius:24px}
  .art-caption{padding:22px 24px}
  .art-caption h2{font-size:1.5rem}
  .art-caption p{display:none}
  .side{padding:30px 20px 50px}
}
</style>
</head>

<body class="login-body">
<div class="login-page">

  {{-- ========== IMAGE À GAUCHE ========== --}}
  <section class="art">
    <div class="art-img" style="background-image:url('{{ asset('images/saint.jpg') }}')"></div>
    <div class="art-caption">
      <span class="tag">Paroisse de la BAE</span>
      <h2>Saint <span>Michel</span><br>Archange</h2>
      <p>Défends-nous dans le combat. Sois notre secours contre la malice et les embûches du démon.</p>
    </div>
  </section>

  {{-- ========== FORMULAIRE À DROITE ========== --}}
  <main class="side">
    <div class="box">

      <div class="brand">Saint <b>Michel</b> Archange</div>
      <div class="orn"><i class="bi bi-plus-lg"></i></div>

      <h1>Connexion</h1>
      <p class="hint">Espace de gestion de la paroisse.<br>Connectez-vous pour accéder à votre espace.</p>

      @if($errors->any())
        <div class="alert alert-danger py-2 small text-start">
          <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ $errors->first() }}
        </div>
      @endif

      <form method="POST" action="{{ url('connexion') }}">
        @csrf

        <div class="pill-field">
          <i class="bi bi-person-fill"></i>
          <input type="email" name="email" value="{{ old('email') }}" placeholder="vous@paroisse.ci" required autofocus>
        </div>

        <div class="pill-field">
          <i class="bi bi-lock-fill"></i>
          <input type="password" name="password" id="pw" placeholder="Mot de passe" required>
          <button type="button" class="toggle-pw" aria-label="Afficher le mot de passe"
            onclick="var p=document.getElementById('pw');var s=p.type=='password';p.type=s?'text':'password';this.firstElementChild.className=s?'bi bi-eye-slash':'bi bi-eye'">
            <i class="bi bi-eye"></i>
          </button>
        </div>

        <div class="row-opts">
          <label><input type="checkbox" name="remember"> Se souvenir de moi</label>
          <a href="#">Mot de passe oublié ?</a>
        </div>

        <button class="btn-login"><i class="bi bi-box-arrow-in-right"></i> Se connecter</button>
      </form>

      <a href="{{ route('home') }}" class="back-link"><i class="bi bi-arrow-left"></i> Retour au site de la paroisse</a>
      <p class="copy">© {{ date('Y') }} Paroisse Saint Michel Archange de la BAE</p>
    </div>
  </main>

</div>
</body>
</html>