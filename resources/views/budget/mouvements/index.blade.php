@extends('layouts.paroisse')
@section('contenu')

<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h2 class="h3">Mouvements Budgétaires</h2>
    <p class="text-muted">Historique des dépenses et recettes</p>
  </div>
  <a href="{{ route('budget.mouvements.create') }}" class="btn btn-primary">
    <i class="bi bi-plus-circle"></i> Nouveau mouvement
  </a>
</div>

<!-- Filtres -->
<div class="card mb-4">
  <div class="card-body">
    <form method="GET" action="{{ route('budget.mouvements.index') }}" class="row g-3">
      <div class="col-md-3">
        <label class="form-label">Date début</label>
        <input type="date" name="date_debut" class="form-control" value="{{ request('date_debut') }}">
      </div>
      <div class="col-md-3">
        <label class="form-label">Date fin</label>
        <input type="date" name="date_fin" class="form-control" value="{{ request('date_fin') }}">
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
          <th>Date</th>
          <th>Ligne</th>
          <th>Catégorie</th>
          <th>Description</th>
          <th>Montant</th>
          <th>Bénéficiaire</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($mouvements as $mouvement)
        <tr>
          <td>{{ date('d/m/Y', strtotime($mouvement->date_operation)) }}</td>
          <td>{{ $mouvement->ligne->libelle }}</td>
          <td>{{ $mouvement->ligne->category->nom }}</td>
          <td>{{ $mouvement->description }}</td>
          <td class="fw-bold">{{ number_format($mouvement->montant, 0, ',', ' ') }} FCFA</td>
          <td>{{ $mouvement->beneficiaire ?? '-' }}</td>
          <td>
            <div class="btn-group">
              <a href="{{ route('budget.mouvements.show', $mouvement) }}" class="btn btn-sm btn-outline-info">
                <i class="bi bi-eye"></i>
              </a>
              <a href="{{ route('budget.mouvements.edit', $mouvement) }}" class="btn btn-sm btn-outline-primary">
                <i class="bi bi-pencil"></i>
              </a>
              <form method="POST" action="{{ route('budget.mouvements.destroy', $mouvement) }}" onsubmit="return confirm('Supprimer ce mouvement ?')" style="display:inline">
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
          <td colspan="7" class="text-center text-muted py-4">Aucun mouvement.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
    {{ $mouvements->links() }}
  </div>
</div>

@endsection
