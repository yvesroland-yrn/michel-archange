@extends('layouts.paroisse')
@section('contenu')

<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h2 class="h3">Rapport Budgétaire</h2>
    <p class="text-muted">Analyse budgétaire {{ $mois ? 'du mois ' . $mois : 'annuelle' }} {{ $annee }}</p>
  </div>
  <div class="btn-group">
    <a href="{{ route('budget.rapport.export-pdf', request()->all()) }}" class="btn btn-outline-success" target="_blank">
      <i class="bi bi-file-earmark-pdf"></i> PDF
    </a>
    <a href="{{ route('budget.rapport.export-excel', request()->all()) }}" class="btn btn-outline-info">
      <i class="bi bi-file-earmark-excel"></i> Excel
    </a>
  </div>
</div>

<!-- Filtres -->
<div class="card mb-4">
  <div class="card-body">
    <form method="GET" action="{{ route('budget.rapport.index') }}" class="row g-3">
      <div class="col-md-3">
        <label class="form-label">Année</label>
        <select name="annee" class="form-select">
          @foreach($anneesDisponibles as $a)
            <option value="{{ $a }}" {{ $annee == $a ? 'selected' : '' }}>{{ $a }}</option>
          @endforeach
          <option value="{{ date('Y') }}" {{ $annee == date('Y') ? 'selected' : '' }}>{{ date('Y') }}</option>
        </select>
      </div>
      <div class="col-md-3">
        <label class="form-label">Mois (optionnel)</label>
        <select name="mois" class="form-select">
          <option value="">Toute l'année</option>
          @for($i = 1; $i <= 12; $i++)
            <option value="{{ $i }}" {{ $mois == $i ? 'selected' : '' }}>{{ $i }}</option>
          @endfor
        </select>
      </div>
      <div class="col-md-3">
        <label class="form-label">Catégorie (optionnel)</label>
        <select name="category" class="form-select">
          <option value="">Toutes</option>
          @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ $category == $cat->id ? 'selected' : '' }}>{{ $cat->nom }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-3 d-flex align-items-end">
        <button type="submit" class="btn btn-primary">
          <i class="bi bi-search"></i> Générer
        </button>
      </div>
    </form>
  </div>
</div>

<!-- Synthèse -->
<div class="card mb-4">
  <div class="card-header bg-primary text-white">
    <h5 class="mb-0">Synthèse</h5>
  </div>
  <div class="card-body">
    <p class="mb-0">
      Sur {{ $lignes->count() }} lignes : {{ $lignesRespectees }} respectées, {{ $lignesDepassees }} dépassées, {{ $lignesNonConsommees }} non consommées.
    </p>
  </div>
</div>

<!-- Tableau par catégorie -->
@foreach($parCategorie as $categorieId => $lignesCat)
@php
$categorie = \App\Models\BudgetCategory::find($categorieId);
@endphp
<div class="card mb-4">
  <div class="card-header">
    <h5 class="mb-0">{{ $categorie->nom }} ({{ $categorie->type === 'depense' ? 'Dépense' : 'Recette' }})</h5>
  </div>
  <div class="card-body">
    <table class="table table-sm">
      <thead>
        <tr>
          <th>Libellé</th>
          <th>Prévu</th>
          <th>Réalisé</th>
          <th>Écart</th>
          <th>Taux</th>
          <th>Statut</th>
        </tr>
      </thead>
      <tbody>
        @foreach($lignesCat as $ligne)
        <tr>
          <td>{{ $ligne->libelle }}</td>
          <td>{{ number_format($ligne->montant_prevu, 0, ',', ' ') }}</td>
          <td>{{ number_format($ligne->montant_realise, 0, ',', ' ') }}</td>
          <td class="{{ $ligne->reste >= 0 ? 'text-success' : 'text-danger' }}">
            {{ number_format($ligne->reste, 0, ',', ' ') }}
          </td>
          <td>{{ number_format($ligne->taux, 1) }}%</td>
          <td>
            <span class="badge {{ $ligne->taux > 100 ? 'bg-danger' : ($ligne->taux >= 90 ? 'bg-warning' : 'bg-success') }}">
              {{ $ligne->statut }}
            </span>
          </td>
        </tr>
        @endforeach
      </tbody>
      <tfoot>
        <tr class="table-primary">
          <th>Sous-total {{ $categorie->nom }}</th>
          <th>{{ number_format($lignesCat->sum('montant_prevu'), 0, ',', ' ') }}</th>
          <th>{{ number_format($lignesCat->sum(function($l) { return $l->montant_realise; }), 0, ',', ' ') }}</th>
          <th>{{ number_format($lignesCat->sum(function($l) { return $l->reste; }), 0, ',', ' ') }}</th>
          <th>-</th>
          <th>-</th>
        </tr>
      </tfoot>
    </table>
  </div>
</div>
@endforeach

<!-- Total général -->
<div class="card mb-4">
  <div class="card-header bg-dark text-white">
    <h5 class="mb-0">Total Général</h5>
  </div>
  <div class="card-body">
    <div class="row text-center">
      <div class="col-md-4">
        <h5>Total Prévu</h5>
        <h3>{{ number_format($totalPrevu, 0, ',', ' ') }} FCFA</h3>
      </div>
      <div class="col-md-4">
        <h5>Total Réalisé</h5>
        <h3>{{ number_format($totalRealise, 0, ',', ' ') }} FCFA</h3>
      </div>
      <div class="col-md-4">
        <h5>Écart Global</h5>
        <h3 class="{{ ($totalPrevu - $totalRealise) >= 0 ? 'text-success' : 'text-danger' }}">
          {{ number_format($totalPrevu - $totalRealise, 0, ',', ' ') }} FCFA
        </h3>
      </div>
    </div>
  </div>
</div>

@endsection
