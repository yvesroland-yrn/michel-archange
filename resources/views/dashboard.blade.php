@extends('layouts.paroisse')
@section('contenu')
<div class="welcome mb-4">
  <div class="motto"></div>
  <h2>Tableau de bord {{ now()->year }}</h2>
  <p>Vue d'ensemble de la vie de la paroisse Saint Michel Archange de la BAE.</p>
</div>

@php
  $icons = ['bi-people-fill', 'bi-droplet-half', 'bi-mortarboard-fill', 'bi-envelope-heart-fill'];
  $tones = ['', 'gold', 'green', 'red'];
  $i = 0;
@endphp

<!-- Statistiques principales -->
<div class="row g-3 mb-4">
  @foreach($stats as $l => $v)
    <div class="col-6 col-xl-3">
      <div class="stat {{ $tones[$i % 4] }}">
        <div class="ico"><i class="bi {{ $icons[$i % 4] }}"></i></div>
        <div>
          <div class="val">{{ $v }}</div>
          <div class="lbl">{{ $l }}</div>
        </div>
      </div>
    </div>
    @php $i++; @endphp
  @endforeach
</div>

@if($financeVisible)
@php
  $fi = ['bi-arrow-down-circle-fill', 'bi-arrow-up-circle-fill', 'bi-wallet2'];
  $ft = ['green', 'red', 'gold'];
  $j = 0;
@endphp
<!-- Finances -->
<div class="row g-3 mb-4">
  @foreach($finances as $l => $v)
    <div class="col-md-4">
      <div class="stat {{ $ft[$j % 3] }}">
        <div class="ico"><i class="bi {{ $fi[$j % 3] }}"></i></div>
        <div>
          <div class="val" style="font-size:1.5rem">{{ number_format($v, 0, ',', ' ') }}</div>
          <div class="lbl">{{ $l }}</div>
        </div>
      </div>
    </div>
    @php $j++; @endphp
  @endforeach
</div>
@endif

<!-- Contenu principal -->
<div class="row g-4">
  @if(auth()->user()->hasPermission('fideles'))
  <!-- Derniers fidèles inscrits -->
  <div class="col-lg-7">
    <h2 class="h5 mb-3">Derniers fidèles inscrits</h2>
    <div class="table-responsive">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Nom</th>
            <th>Prénoms</th>
            <th>Téléphone</th>
            <th>Quartier</th>
          </tr>
        </thead>
        <tbody>
          @forelse($fideles as $f)
            <tr>
              <td class="fw-semibold">{{ $f->nom }}</td>
              <td>{{ $f->prenoms }}</td>
              <td>{{ $f->telephone ?? '-' }}</td>
              <td>{{ $f->quartier ?? '-' }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="4" class="text-center text-muted py-4">Aucun fidèle inscrit.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
  @endif

  @if(auth()->user()->hasPermission('evenements'))
  <!-- Prochains événements -->
  <div class="col-lg-5">
    <h2 class="h5 mb-3">Prochains événements</h2>
    <div class="card">
      <ul class="list-group list-group-flush rounded-4">
        @forelse($evenements as $e)
          <li class="list-group-item d-flex align-items-center gap-3 py-3">
            <div class="event-date">
              <b>{{ $e->date_heure->format('d') }}</b>
              <span>{{ $e->date_heure->translatedFormat('M') }}</span>
            </div>
            <div>
              <div class="fw-semibold">{{ $e->titre }}</div>
              <small class="text-muted">
                <i class="bi bi-clock"></i> {{ $e->date_heure->format('H:i') }}
                @if($e->lieu) · {{ $e->lieu }}@endif
              </small>
            </div>
          </li>
        @empty
          <li class="list-group-item text-muted text-center py-4">Aucun événement à venir.</li>
        @endforelse
      </ul>
    </div>
  </div>
  @endif
</div>

<!-- Actions rapides -->
<div class="row g-4 mt-4">
  <div class="col-12">
    <h2 class="h5 mb-3">Actions rapides</h2>
    <div class="row g-3">
      @if(auth()->user()->hasPermission('fideles'))
        <div class="col-md-3 col-6">
          <a href="{{ route('fideles.create') }}" class="btn btn-outline-primary w-100">
            <i class="bi bi-person-plus-fill me-2"></i>Nouveau fidèle
          </a>
        </div>
      @endif
      @if(auth()->user()->hasPermission('evenements'))
        <div class="col-md-3 col-6">
          <a href="{{ route('evenements.create') }}" class="btn btn-outline-success w-100">
            <i class="bi bi-calendar-plus-fill me-2"></i>Nouvel événement
          </a>
        </div>
      @endif
      @if(auth()->user()->hasPermission('annonces'))
        <div class="col-md-3 col-6">
          <a href="{{ route('annonces.create') }}" class="btn btn-outline-warning w-100">
            <i class="bi bi-megaphone-fill me-2"></i>Nouvelle annonce
          </a>
        </div>
      @endif
      @if(auth()->user()->hasPermission('finances'))
        <div class="col-md-3 col-6">
          <a href="{{ route('finance.index') }}" class="btn btn-outline-info w-100">
            <i class="bi bi-cash-coin me-2"></i>Gérer finances
          </a>
        </div>
      @endif
    </div>
  </div>
</div>

@endsection
