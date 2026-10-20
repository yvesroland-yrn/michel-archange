@extends('layouts.paroisse')
@section('contenu')

<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h2 class="h3">Catégories Budgétaires</h2>
    <p class="text-muted">Gestion des catégories de dépenses et recettes</p>
  </div>
  <a href="{{ route('budget.categories.create') }}" class="btn btn-primary">
    <i class="bi bi-plus-circle"></i> Nouvelle catégorie
  </a>
</div>

<div class="card">
  <div class="card-body">
    <table class="table table-hover">
      <thead>
        <tr>
          <th>Nom</th>
          <th>Type</th>
          <th>Description</th>
          <th>Statut</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($categories as $category)
        <tr>
          <td class="fw-bold">{{ $category->nom }}</td>
          <td>
            <span class="badge {{ $category->type === 'depense' ? 'bg-danger' : 'bg-success' }}">
              {{ $category->type === 'depense' ? 'Dépense' : 'Recette' }}
            </span>
          </td>
          <td>{{ $category->description ?? '-' }}</td>
          <td>
            <span class="badge {{ $category->actif ? 'bg-success' : 'bg-secondary' }}">
              {{ $category->actif ? 'Actif' : 'Inactif' }}
            </span>
          </td>
          <td>
            <div class="btn-group">
              <a href="{{ route('budget.categories.edit', $category) }}" class="btn btn-sm btn-outline-primary">
                <i class="bi bi-pencil"></i>
              </a>
              <form method="POST" action="{{ route('budget.categories.destroy', $category) }}" onsubmit="return confirm('Supprimer cette catégorie ?')" style="display:inline">
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
          <td colspan="5" class="text-center text-muted py-4">Aucune catégorie.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

@endsection
