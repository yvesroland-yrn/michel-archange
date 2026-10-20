@extends('layouts.paroisse')
@section('contenu')

<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h2 class="h3">Nouvelle Catégorie</h2>
    <p class="text-muted">Créer une nouvelle catégorie budgétaire</p>
  </div>
  <a href="{{ route('budget.categories.index') }}" class="btn btn-outline-secondary">
    <i class="bi bi-arrow-left"></i> Retour
  </a>
</div>

<div class="card">
  <div class="card-body">
    <form method="POST" action="{{ route('budget.categories.store') }}">
      @csrf
      <div class="mb-3">
        <label class="form-label">Nom</label>
        <input type="text" name="nom" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Type</label>
        <select name="type" class="form-select" required>
          <option value="depense">Dépense</option>
          <option value="recette">Recette</option>
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="3"></textarea>
      </div>
      <div class="mb-3">
        <div class="form-check">
          <input type="checkbox" name="actif" id="actif" class="form-check-input" checked>
          <label class="form-check-label" for="actif">Actif</label>
        </div>
      </div>
      <button type="submit" class="btn btn-primary">
        <i class="bi bi-save"></i> Enregistrer
      </button>
    </form>
  </div>
</div>

@endsection
