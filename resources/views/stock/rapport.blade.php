@extends('layouts.paroisse')
@section('contenu')
<div class="d-flex justify-content-between mb-3">
  <h1 class="h3">Rapport du stock</h1>
  <div>
    <a href="{{ route('stock.rapport.pdf') }}?{{ http_build_query(request()->except('page')) }}" target="_blank" class="btn btn-outline-danger"><i class="bi bi-file-earmark-pdf"></i> Exporter PDF</a>
    <a href="{{ route('stock.dashboard') }}" class="btn btn-outline-secondary"><i class="bi bi-grid-fill"></i> Tableau de bord</a>
  </div>
</div>

<!-- Filtres -->
<form class="card card-body mb-4" method="GET">
  <div class="row g-3 align-items-end">
    <div class="col-md-3">
      <label class="form-label">Période</label>
      @if($periode === 'tout')
        <input type="hidden" name="vue" value="mois">
        <button type="submit" class="btn btn-outline-primary w-100">Vue mensuelle</button>
      @else
        <input type="hidden" name="vue" value="tout">
        <button type="submit" class="btn btn-outline-success w-100">Voir tout</button>
      @endif
    </div>
    <div class="col-md-3">
      <label class="form-label">Type de période</label>
      <select name="vue" class="form-select">
        <option value="mois" {{ request('vue') === 'mois' ? 'selected' : '' }}>Mois</option>
        <option value="semaine" {{ request('vue') === 'semaine' ? 'selected' : '' }}>Semaine</option>
        <option value="annee" {{ request('vue') === 'annee' ? 'selected' : '' }}>Année</option>
        <option value="tout" {{ request('vue') === 'tout' ? 'selected' : '' }}>Tout</option>
      </select>
    </div>
    @if(request('vue') === 'mois')
    <div class="col-md-3">
      <label class="form-label">Mois</label>
      <input type="month" name="mois" value="{{ $periode }}" class="form-control">
    </div>
    @endif
    @if(request('vue') === 'annee')
    <div class="col-md-3">
      <label class="form-label">Année</label>
      <input type="number" name="annee" value="{{ $periode }}" class="form-control" min="2020" max="2030">
    </div>
    @endif
    <div class="col-md-3">
      <label class="form-label">Produit</label>
      <select name="produit_id" class="form-select">
        <option value="tous">Tous les produits</option>
        @foreach($produits as $produit)
          <option value="{{ $produit->id }}" {{ request('produit_id') == $produit->id ? 'selected' : '' }}>{{ $produit->nom }}</option>
        @endforeach
      </select>
    </div>
    <div class="col-md-3">
      <button type="submit" class="btn btn-primary w-100">Filtrer</button>
    </div>
  </div>
</form>

<!-- Statistiques -->
<div class="row g-3 mb-4">
  <div class="col-md-3">
    <div class="stat green">
      <div class="ico"><i class="bi bi-arrow-down-circle-fill"></i></div>
      <div>
        <div class="val">{{ $stats['total_entrees'] }}</div>
        <div class="lbl">Entrées totales</div>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="stat red">
      <div class="ico"><i class="bi bi-arrow-up-circle-fill"></i></div>
      <div>
        <div class="val">{{ $stats['total_sorties'] }}</div>
        <div class="lbl">Sorties totales</div>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="stat">
      <div class="ico"><i class="bi bi-plus-circle-fill"></i></div>
      <div>
        <div class="val">{{ $stats['nb_entrees'] }}</div>
        <div class="lbl">Nb. entrées</div>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="stat">
      <div class="ico"><i class="bi bi-dash-circle-fill"></i></div>
      <div>
        <div class="val">{{ $stats['nb_sorties'] }}</div>
        <div class="lbl">Nb. sorties</div>
      </div>
    </div>
  </div>
</div>

<!-- Tableau des mouvements -->
<div class="card">
  <div class="card-header">
    <h5 class="mb-0">Mouvements de stock</h5>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-striped align-middle">
        <thead>
          <tr>
            <th>Date</th>
            <th>Produit</th>
            <th>Type</th>
            <th>Quantité</th>
            <th>Raison</th>
            <th>Utilisateur</th>
          </tr>
        </thead>
        <tbody>
          @forelse($mouvements as $mouvement)
            <tr>
              <td>{{ $mouvement->date->format('d/m/Y') }}</td>
              <td>{{ $mouvement->produit->nom }}</td>
              <td>
                @if($mouvement->type === 'entree')
                  <span class="badge bg-success">Entrée</span>
                @else
                  <span class="badge bg-danger">Sortie</span>
                @endif
              </td>
              <td>{{ $mouvement->quantite }}</td>
              <td>{{ $mouvement->raison ?? '-' }}</td>
              <td>{{ $mouvement->user?->name ?? '-' }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-center text-muted">Aucun mouvement pour cette période.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
