@extends('layouts.paroisse')
@section('contenu')

<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h2 class="h3">Tableau de Bord Budget</h2>
    <p class="text-muted">Vue d'ensemble du budget paroissial</p>
  </div>
  <div class="btn-group">
    <a href="{{ route('budget.lignes.index') }}" class="btn btn-outline-primary">
      <i class="bi bi-list-ul"></i> Lignes budgétaires
    </a>
    <a href="{{ route('budget.mouvements.index') }}" class="btn btn-outline-success">
      <i class="bi bi-cash-coin"></i> Mouvements
    </a>
    <a href="{{ route('budget.rapport.index') }}" class="btn btn-outline-info">
      <i class="bi bi-file-earmark-text"></i> Rapport
    </a>
  </div>
</div>

<!-- Filtres -->
<div class="card mb-4">
  <div class="card-body">
    <form method="GET" action="{{ route('budget.dashboard') }}" class="row g-3">
      <div class="col-md-4">
        <label class="form-label">Année</label>
        <select name="annee" class="form-select">
          @foreach($anneesDisponibles as $a)
            <option value="{{ $a }}" {{ $annee == $a ? 'selected' : '' }}>{{ $a }}</option>
          @endforeach
          <option value="{{ date('Y') }}" {{ $annee == date('Y') ? 'selected' : '' }}>{{ date('Y') }}</option>
        </select>
      </div>
      <div class="col-md-4">
        <label class="form-label">Mois (optionnel)</label>
        <select name="mois" class="form-select">
          <option value="">Toute l'année</option>
          <option value="1" {{ $mois == 1 ? 'selected' : '' }}>Janvier</option>
          <option value="2" {{ $mois == 2 ? 'selected' : '' }}>Février</option>
          <option value="3" {{ $mois == 3 ? 'selected' : '' }}>Mars</option>
          <option value="4" {{ $mois == 4 ? 'selected' : '' }}>Avril</option>
          <option value="5" {{ $mois == 5 ? 'selected' : '' }}>Mai</option>
          <option value="6" {{ $mois == 6 ? 'selected' : '' }}>Juin</option>
          <option value="7" {{ $mois == 7 ? 'selected' : '' }}>Juillet</option>
          <option value="8" {{ $mois == 8 ? 'selected' : '' }}>Août</option>
          <option value="9" {{ $mois == 9 ? 'selected' : '' }}>Septembre</option>
          <option value="10" {{ $mois == 10 ? 'selected' : '' }}>Octobre</option>
          <option value="11" {{ $mois == 11 ? 'selected' : '' }}>Novembre</option>
          <option value="12" {{ $mois == 12 ? 'selected' : '' }}>Décembre</option>
        </select>
      </div>
      <div class="col-md-4 d-flex align-items-end">
        <button type="submit" class="btn btn-primary">
          <i class="bi bi-search"></i> Filtrer
        </button>
      </div>
    </form>
  </div>
</div>

<!-- Statistiques globales -->
<div class="row g-3 mb-4">
  <div class="col-md-3">
    <div class="card bg-primary text-white">
      <div class="card-body">
        <h5 class="card-title">Total Prévu</h5>
        <h3 class="card-text">{{ number_format($totalPrevu, 0, ',', ' ') }} FCFA</h3>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card bg-success text-white">
      <div class="card-body">
        <h5 class="card-title">Total Réalisé</h5>
        <h3 class="card-text">{{ number_format($totalRealise, 0, ',', ' ') }} FCFA</h3>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card {{ $totalReste >= 0 ? 'bg-info' : 'bg-warning' }} text-white">
      <div class="card-body">
        <h5 class="card-title">Reste</h5>
        <h3 class="card-text">{{ number_format($totalReste, 0, ',', ' ') }} FCFA</h3>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card bg-secondary text-white">
      <div class="card-body">
        <h5 class="card-title">Taux Global</h5>
        <h3 class="card-text">{{ number_format($tauxGlobal, 1) }}%</h3>
      </div>
    </div>
  </div>
</div>

<!-- Graphiques -->
<div class="row g-3 mb-4">
  <div class="col-md-6">
    <div class="card">
      <div class="card-header">
        <h5 class="mb-0">Prévu vs Réalisé par mois</h5>
      </div>
      <div class="card-body">
        <canvas id="chartMois"></canvas>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="card">
      <div class="card-header">
        <h5 class="mb-0">Répartition par catégorie</h5>
      </div>
      <div class="card-body">
        <canvas id="chartCategorie"></canvas>
      </div>
    </div>
  </div>
</div>

<!-- Alertes -->
@if($lignesDepassees->count() > 0)
<div class="card mb-4 border-danger">
  <div class="card-header bg-danger text-white">
    <h5 class="mb-0"><i class="bi bi-exclamation-triangle"></i> Lignes dépassées</h5>
  </div>
  <div class="card-body">
    <ul class="list-group list-group-flush">
      @foreach($lignesDepassees as $ligne)
      <li class="list-group-item d-flex justify-content-between align-items-center">
        <div>
          <strong>{{ $ligne->libelle }}</strong> ({{ $ligne->category->nom }})
          <br>
          <small class="text-muted">Prévu: {{ number_format($ligne->montant_prevu, 0, ',', ' ') }} | Réalisé: {{ number_format($ligne->montant_realise, 0, ',', ' ') }}</small>
        </div>
        <span class="badge bg-danger">{{ number_format($ligne->taux, 1) }}%</span>
      </li>
      @endforeach
    </ul>
  </div>
</div>
@endif

@if($lignesPresqueAtteintes->count() > 0)
<div class="card mb-4 border-warning">
  <div class="card-header bg-warning text-dark">
    <h5 class="mb-0"><i class="bi bi-exclamation-circle"></i> Lignes presque atteintes (90-100%)</h5>
  </div>
  <div class="card-body">
    <ul class="list-group list-group-flush">
      @foreach($lignesPresqueAtteintes as $ligne)
      <li class="list-group-item d-flex justify-content-between align-items-center">
        <div>
          <strong>{{ $ligne->libelle }}</strong> ({{ $ligne->category->nom }})
          <br>
          <small class="text-muted">Prévu: {{ number_format($ligne->montant_prevu, 0, ',', ' ') }} | Réalisé: {{ number_format($ligne->montant_realise, 0, ',', ' ') }}</small>
        </div>
        <span class="badge bg-warning text-dark">{{ number_format($ligne->taux, 1) }}%</span>
      </li>
      @endforeach
    </ul>
  </div>
</div>
@endif

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctxMois = document.getElementById('chartMois').getContext('2d');
new Chart(ctxMois, {
  type: 'bar',
  data: {
    labels: @json_encode(array_keys($parMois)),
    datasets: [
      {
        label: 'Prévu',
        data: @json_encode(array_column($parMois, 'prevu')),
        backgroundColor: 'rgba(54, 162, 235, 0.5)',
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 1
      },
      {
        label: 'Réalisé',
        data: @json_encode(array_column($parMois, 'realise')),
        backgroundColor: 'rgba(75, 192, 192, 0.5)',
        borderColor: 'rgba(75, 192, 192, 1)',
        borderWidth: 1
      }
    ]
  },
  options: {
    responsive: true,
    scales: {
      y: {
        beginAtZero: true
      }
    }
  }
});

const ctxCategorie = document.getElementById('chartCategorie').getContext('2d');
new Chart(ctxCategorie, {
  type: 'doughnut',
  data: {
    labels: @json_encode(array_keys($parCategorie)),
    datasets: [{
      data: @json_encode(array_column($parCategorie, 'prevu')),
      backgroundColor: [
        'rgba(255, 99, 132, 0.5)',
        'rgba(54, 162, 235, 0.5)',
        'rgba(255, 206, 86, 0.5)',
        'rgba(75, 192, 192, 0.5)',
        'rgba(153, 102, 255, 0.5)',
        'rgba(255, 159, 64, 0.5)'
      ]
    }]
  },
  options: {
    responsive: true
  }
});
</script>
@endsection
