<!doctype html>
<html lang="fr"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="{{ asset('images/saint.jpg') }}" type="image/jpeg">
<link rel="preconnect" href="https://fonts.googleapis.com"><link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<link href="{{ asset('css/paroisse.css') }}" rel="stylesheet">
<title>@yield('titre', 'Paroisse Saint Michel Archange')</title></head>
<body>
@php
  $user = auth()->user(); $role = $user->role;
  $is = fn (...$r) => $role === 'admin' || in_array($role, $r);
  $a = fn ($p) => request()->routeIs($p) ? 'active' : '';
  $roles = ['admin' => 'Administrateur', 'cure' => 'Curé / Vicaire', 'secretaire' => 'Secrétaire', 'tresorier' => 'Trésorier', 'catechiste' => 'Catéchiste'];
  $can = fn ($p) => $user->hasPermission($p);
@endphp
<div class="side-overlay" id="ov" onclick="toggleSide()"></div>
<aside class="sidebar" id="side">
  <a class="brand" href="{{ route('dashboard') }}"><img src="{{ asset('images/michel.jfif') }}" alt="">
    <div><div class="brand-title">Saint Michel<br>Archange</div><small>Paroisse de la BAE</small></div></a>
  <nav class="side-nav">
    <div class="side-label">Principal</div>
    <a class="side-link {{ $a('dashboard') }}" href="{{ route('dashboard') }}"><i class="bi bi-speedometer2"></i>Tableau de bord</a>

    @if($can('fideles') || $can('sacrements'))
    <div class="side-label">Paroissiens</div>
    @if($can('fideles'))
    <a class="side-link {{ $a('fideles.*') }}" href="{{ route('fideles.index') }}"><i class="bi bi-people-fill"></i>Fidèles</a>
    @endif
    @if($can('sacrements'))
    <a class="side-link {{ $a('sacrements.*') }}" href="{{ route('sacrements.index') }}"><i class="bi bi-droplet-half"></i>Sacrements</a>
    @endif
    @endif

    @if($can('classes_cate') || $can('catechumenes'))
    <div class="side-label">Catéchèse</div>
    @if($can('classes_cate'))
    <a class="side-link {{ $a('classes-cate.*') }}" href="{{ route('classes-cate.index') }}"><i class="bi bi-mortarboard-fill"></i>Classes</a>
    @endif
    @if($can('catechumenes'))
    <a class="side-link {{ $a('catechumenes.*') }}" href="{{ route('catechumenes.index') }}"><i class="bi bi-journal-bookmark-fill"></i>Catéchumènes</a>
    @endif
    @endif

    @if($can('cebs') || $can('mouvements') || $can('clerge') || $can('conseil_paroissial') || $can('mouvement_paroissial') || $can('evenements') || $can('intentions') || $can('annonces'))
    <div class="side-label">Vie paroissiale</div>
    @if($can('cebs'))
    <a class="side-link {{ $a('cebs.*') }}" href="{{ route('cebs.index') }}"><i class="bi bi-diagram-3-fill"></i>CEB</a>
    @endif
    @if($can('mouvements'))
    <a class="side-link {{ $a('mouvements.*') }}" href="{{ route('mouvements.index') }}"><i class="bi bi-music-note-beamed"></i>Mouvements</a>
    @endif
    @if($can('clerge'))
    <a class="side-link {{ $a('clerge.*') }}" href="{{ route('clerge.index') }}"><i class="bi bi-people-fill"></i>Clergé</a>
    @endif
    @if($can('conseil_paroissial'))
    <a class="side-link {{ $a('conseil-paroissial.*') }}" href="{{ route('conseil-paroissial.index') }}"><i class="bi bi-person-workspace"></i>Conseil paroissial</a>
    @endif
    @if($can('mouvement_paroissial'))
    <a class="side-link {{ $a('mouvement-paroissial.*') }}" href="{{ route('mouvement-paroissial.index') }}"><i class="bi bi-collection"></i>Mouvements paroissiaux</a>
    @endif
    @if($can('evenements'))
    <a class="side-link {{ $a('evenements.*') }}" href="{{ route('evenements.index') }}"><i class="bi bi-calendar-event-fill"></i>Messes & calendrier</a>
    @endif
    @if($can('intentions'))
    <a class="side-link {{ $a('intentions.*') }}" href="{{ route('intentions.index') }}"><i class="bi bi-envelope-heart-fill"></i>Intentions de messe</a>
    @endif
    @if($can('annonces'))
    <a class="side-link {{ $a('annonces.*') }}" href="{{ route('annonces.index') }}"><i class="bi bi-megaphone-fill"></i>Annonces</a>
    @endif
    @endif

    @if($can('finances'))
    <div class="side-label">Trésorerie</div>
    <a class="side-link {{ $a('finance.*') }}" href="{{ route('finance.index') }}"><i class="bi bi-cash-coin"></i>Finances</a>
    @endif

    @if($can('users') || $can('contacts'))
    <div class="side-label">Administration</div>
    @if($can('users'))
    <a class="side-link {{ $a('users.*') }}" href="{{ route('users.index') }}"><i class="bi bi-shield-lock-fill"></i>Utilisateurs</a>
    @endif
    @if($can('contacts'))
    <a class="side-link {{ $a('contacts.*') }}" href="{{ route('contacts.index') }}">
      <i class="bi bi-envelope-fill"></i>Contact Nous
      @if(isset($messagesNonLus) && $messagesNonLus > 0)
      <span class="badge bg-danger rounded-pill ms-auto">{{ $messagesNonLus }}</span>
      @endif
    </a>
    @endif
    @endif

    <div class="side-label">Liens</div>
    <a class="side-link" href="{{ route('home') }}" target="_blank"><i class="bi bi-globe2"></i>Site public</a>
  </nav>
  <div class="side-user">
    <div class="avatar">{{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}</div>
    <div class="who"><b>{{ $user->name }}</b><span>{{ $roles[$role] ?? $role }}</span></div>
    <form method="POST" action="{{ route('logout') }}">@csrf<button title="Déconnexion"><i class="bi bi-box-arrow-right"></i></button></form>
  </div>
</aside>

<div class="main">
  <header class="topbar">
    <div class="d-flex align-items-center gap-3"><button class="menu-btn" onclick="toggleSide()"><i class="bi bi-list"></i></button>
      <div><div class="hello">Bienvenue, {{ \Illuminate\Support\Str::before($user->name, ' ') }}</div><div class="date">{{ now()->translatedFormat('l d F Y') }}</div></div></div>
    <span class="badge text-bg-light border d-none d-sm-inline"><i class="bi bi-shield-check text-success"></i> {{ $roles[$role] ?? $role }}</span>
  </header>
  <main class="content">
    @if(session('ok'))<div class="alert alert-success alert-dismissible fade show"><i class="bi bi-check-circle-fill me-2"></i>{{ session('ok') }}<button class="btn-close" data-bs-dismiss="alert"></button></div>@endif
    @if($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
    @yield('contenu')
  </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>function toggleSide(){document.getElementById('side').classList.toggle('open');document.getElementById('ov').classList.toggle('show')}</script>
</body></html>
