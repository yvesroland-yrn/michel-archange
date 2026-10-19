@extends('layouts.paroisse')
@section('contenu')


<div class="welcome mb-4">
  <div class="motto"></div>
  <h2>Tableau de Bord Budget du Sanctuaire</h2>
  <p>Vue d'ensemble des finances du Sanctuaire Marial Notre-Dame de Cana Sassako.</p>
</div>

<!-- Statistiques globales -->
<div class="row g-3 mb-4">
  <div class="col-md-4">
    <div class="card bg-success text-white">
      <div class="card-body">
        <h5 class="card-title">Total Recettes (toutes années)</h5>
        <h3 class="card-text">{{ number_format($totalRecettes, 0, ',', ' ') }} FCFA</h3>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card bg-danger text-white">
      <div class="card-body">
        <h5 class="card-title">Total Dépenses (toutes années)</h5>
        <h3 class="card-text">{{ number_format($totalDepenses, 0, ',', ' ') }} FCFA</h3>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card {{ $soldeGlobal >= 0 ? 'bg-primary' : 'bg-warning' }} text-white">
      <div class="card-body">
        <h5 class="card-title">Solde Global</h5>
        <h3 class="card-text">{{ number_format($soldeGlobal, 0, ',', ' ') }} FCFA</h3>
      </div>
    </div>
  </div>
</div>

<!-- Évolution par année -->
<div class="card mb-4">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0"><i class="bi bi-graph-up"></i> Évolution budgétaire par année</h5>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Année</th>
            <th>Recettes</th>
            <th>Dépenses</th>
            <th>Solde</th>
            <th>Taux</th>
          </tr>
        </thead>
        <tbody>
          @forelse($budgets as $budget)
            <tr>
              <td class="fw-bold">{{ $budget->annee }}</td>
              <td class="text-success">{{ number_format($budget->recettes_totales, 0, ',', ' ') }} FCFA</td>
              <td class="text-danger">{{ number_format($budget->depenses_totales, 0, ',', ' ') }} FCFA</td>
              <td class="{{ $budget->solde >= 0 ? 'text-success' : 'text-danger' }}">
                {{ number_format($budget->solde, 0, ',', ' ') }} FCFA
              </td>
              <td>
                @if($budget->recettes_totales > 0)
                  <div class="progress" style="height: 20px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ ($budget->recettes_totales / $totalRecettes) * 100 }}%">
                      {{ round(($budget->recettes_totales / $totalRecettes) * 100, 1) }}%
                    </div>
                  </div>
                @else
                  -
                @endif
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="text-center text-muted py-4">Aucune donnée budgétaire disponible.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Actions rapides -->
<div class="row g-3">
  <div class="col-md-4">
    <a href="{{ route('budget.liste') }}" class="btn btn-outline-primary w-100">
      <i class="bi bi-list-ul"></i> Voir la liste des budgets
    </a>
  </div>
  <div class="col-md-4">
    <a href="{{ route('budget.index') }}" class="btn btn-outline-success w-100">
      <i class="bi bi-plus-circle"></i> Ajouter un budget
    </a>
  </div>
</div>


@endsection
