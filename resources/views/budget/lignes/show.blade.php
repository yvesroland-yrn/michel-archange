@extends('layouts.paroisse')
@section('contenu')

<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h2 class="h3">{{ $ligne->libelle }}</h2>
    <p class="text-muted">{{ $ligne->category->nom }} - {{ $ligne->annee }} {{ $ligne->mois ? '- Mois ' . $ligne->mois : '(Annuel)' }}</p>
  </div>
  <div class="btn-group">
    <a href="{{ route('budget.lignes.edit', $ligne) }}" class="btn btn-outline-primary">
      <i class="bi bi-pencil"></i> Modifier
    </a>
    <a href="{{ route('budget.mouvements.create') }}?ligne={{ $ligne->id }}" class="btn btn-outline-success">
      <i class="bi bi-plus-circle"></i> Ajouter mouvement
    </a>
  </div>
</div>

<!-- Résumé -->
<div class="row g-3 mb-4">
  <div class="col-md-3">
    <div class="card bg-primary text-white">
      <div class="card-body">
        <h5 class="card-title">Prévu</h5>
        <h3 class="card-text">{{ number_format($ligne->montant_prevu, 0, ',', ' ') }} FCFA</h3>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card bg-success text-white">
      <div class="card-body">
        <h5 class="card-title">Réalisé</h5>
        <h3 class="card-text">{{ number_format($ligne->montant_realise, 0, ',', ' ') }} FCFA</h3>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card {{ $ligne->reste >= 0 ? 'bg-info' : 'bg-warning' }} text-white">
      <div class="card-body">
        <h5 class="card-title">Reste</h5>
        <h3 class="card-text">{{ number_format($ligne->reste, 0, ',', ' ') }} FCFA</h3>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card bg-secondary text-white">
      <div class="card-body">
        <h5 class="card-title">Taux</h5>
        <h3 class="card-text">{{ number_format($ligne->taux, 1) }}%</h3>
      </div>
    </div>
  </div>
</div>

@if($ligne->note)
<div class="card mb-4">
  <div class="card-header">
    <h5 class="mb-0">Note</h5>
  </div>
  <div class="card-body">
    {{ $ligne->note }}
  </div>
</div>
@endif

<!-- Mouvements -->
<div class="card">
  <div class="card-header">
    <h5 class="mb-0">Mouvements</h5>
  </div>
  <div class="card-body">
    @if($ligne->mouvements->count() > 0)
    <table class="table table-hover">
      <thead>
        <tr>
          <th>Date</th>
          <th>Description</th>
          <th>Montant</th>
          <th>Bénéficiaire</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($ligne->mouvements as $mouvement)
        <tr>
          <td>{{ date('d/m/Y', strtotime($mouvement->date_operation)) }}</td>
          <td>{{ $mouvement->description }}</td>
          <td>{{ number_format($mouvement->montant, 0, ',', ' ') }} FCFA</td>
          <td>{{ $mouvement->beneficiaire ?? '-' }}</td>
          <td>
            <a href="{{ route('budget.mouvements.show', $mouvement) }}" class="btn btn-sm btn-outline-info">
              <i class="bi bi-eye"></i>
            </a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    @else
    <p class="text-muted">Aucun mouvement enregistré.</p>
    @endif
  </div>
</div>

@endsection
