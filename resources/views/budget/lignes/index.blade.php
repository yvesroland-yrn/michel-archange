@extends('layouts.paroisse')
@section('contenu')

<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h2 class="h3">Lignes Budgétaires</h2>
    <p class="text-muted">Gestion des lignes budgétaires</p>
  </div>
  <a href="{{ route('budget.lignes.create') }}" class="btn btn-primary">
    <i class="bi bi-plus-circle"></i> Nouvelle ligne
  </a>
</div>

<!-- Filtres -->
<div class="card mb-4">
  <div class="card-body">
    <form method="GET" action="{{ route('budget.lignes.index') }}" class="row g-3">
      <div class="col-md-3">
        <label class="form-label">Année</label>
        <select name="annee" class="form-select">
          <option value="">Toutes</option>
          @foreach($annees as $a)
            <option value="{{ $a }}" {{ request('annee') == $a ? 'selected' : '' }}>{{ $a }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-3">
        <label class="form-label">Mois</label>
        <select name="mois" class="form-select">
          <option value="">Tous</option>
          <option value="1" {{ request('mois') == 1 ? 'selected' : '' }}>Janvier</option>
          <option value="2" {{ request('mois') == 2 ? 'selected' : '' }}>Février</option>
          <option value="3" {{ request('mois') == 3 ? 'selected' : '' }}>Mars</option>
          <option value="4" {{ request('mois') == 4 ? 'selected' : '' }}>Avril</option>
          <option value="5" {{ request('mois') == 5 ? 'selected' : '' }}>Mai</option>
          <option value="6" {{ request('mois') == 6 ? 'selected' : '' }}>Juin</option>
          <option value="7" {{ request('mois') == 7 ? 'selected' : '' }}>Juillet</option>
          <option value="8" {{ request('mois') == 8 ? 'selected' : '' }}>Août</option>
          <option value="9" {{ request('mois') == 9 ? 'selected' : '' }}>Septembre</option>
          <option value="10" {{ request('mois') == 10 ? 'selected' : '' }}>Octobre</option>
          <option value="11" {{ request('mois') == 11 ? 'selected' : '' }}>Novembre</option>
          <option value="12" {{ request('mois') == 12 ? 'selected' : '' }}>Décembre</option>
        </select>
      </div>
      <div class="col-md-3">
        <label class="form-label">Catégorie</label>
        <select name="category" class="form-select">
          <option value="">Toutes</option>
          @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->nom }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-3 d-flex align-items-end">
        <button type="submit" class="btn btn-primary">
          <i class="bi bi-search"></i> Filtrer
        </button>
      </div>
    </form>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <table class="table table-hover">
      <thead>
        <tr>
          <th>Libellé</th>
          <th>Catégorie</th>
          <th>Année</th>
          <th>Mois</th>
          <th>Prévu</th>
          <th>Réalisé</th>
          <th>Reste</th>
          <th>Taux</th>
          <th>Statut</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($lignes as $ligne)
        <tr>
          <td class="fw-bold">{{ $ligne->libelle }}</td>
          <td>{{ $ligne->category->nom }}</td>
          <td>{{ $ligne->annee }}</td>
          <td>{{ $ligne->mois ?? 'Annuel' }}</td>
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
          <td>
            <div class="btn-group">
              <a href="{{ route('budget.lignes.show', $ligne) }}" class="btn btn-sm btn-outline-info">
                <i class="bi bi-eye"></i>
              </a>
              <a href="{{ route('budget.lignes.edit', $ligne) }}" class="btn btn-sm btn-outline-primary">
                <i class="bi bi-pencil"></i>
              </a>
              <form method="POST" action="{{ route('budget.lignes.destroy', $ligne) }}" onsubmit="return confirm('Supprimer cette ligne ?')" style="display:inline">
                @method('DELETE')
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-danger">
                  <i class="bi bi-trash"></i>
                </button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="10" class="text-center text-muted py-4">Aucune ligne budgétaire.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

@endsection
