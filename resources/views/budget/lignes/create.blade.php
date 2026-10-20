@extends('layouts.paroisse')
@section('contenu')

<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h2 class="h3">Nouvelle Ligne Budgétaire</h2>
    <p class="text-muted">Créer une nouvelle ligne budgétaire</p>
  </div>
  <a href="{{ route('budget.lignes.index') }}" class="btn btn-outline-secondary">
    <i class="bi bi-arrow-left"></i> Retour
  </a>
</div>

<div class="card">
  <div class="card-body">
    <form method="POST" action="{{ route('budget.lignes.store') }}">
      @csrf
      <div class="mb-3">
        <label class="form-label">Catégorie</label>
        <div class="input-group">
          <select name="budget_category_id" class="form-select" required id="categorySelect">
            <option value="">Sélectionner une catégorie...</option>
            @foreach($categories as $category)
              <option value="{{ $category->id }}">{{ $category->nom }} ({{ $category->type === 'depense' ? 'Dépense' : 'Recette' }})</option>
            @endforeach
          </select>
          <button type="button" class="btn btn-outline-secondary" onclick="toggleNewCategory()">
            <i class="bi bi-plus"></i> Nouvelle
          </button>
        </div>
      </div>

      <!-- Formulaire de nouvelle catégorie (caché par défaut) -->
      <div id="newCategoryForm" class="mb-3 p-3 bg-light rounded" style="display: none;">
        <h6 class="mb-3">Créer une nouvelle catégorie</h6>
        <div class="mb-2">
          <label class="form-label small">Nom de la catégorie</label>
          <input type="text" name="new_category_nom" class="form-control form-control-sm" placeholder="Ex: Eau et électricité">
        </div>
        <div class="mb-2">
          <label class="form-label small">Type</label>
          <select name="new_category_type" class="form-select form-select-sm">
            <option value="depense">Dépense</option>
            <option value="recette">Recette</option>
          </select>
        </div>
        <div class="mb-2">
          <label class="form-label small">Description (optionnel)</label>
          <input type="text" name="new_category_description" class="form-control form-control-sm" placeholder="Description courte">
        </div>
      </div>

      <div class="mb-3">
        <label class="form-label">Libellé</label>
        <input type="text" name="libelle" class="form-control" required placeholder="Ex: Eau et électricité">
      </div>
      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label">Année</label>
          <input type="text" name="annee" class="form-control" value="{{ date('Y') }}" required placeholder="Ex: 2026 ou 2026-2027">
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label">Mois (optionnel)</label>
          <select name="mois" class="form-select">
            <option value="">Toute l'année</option>
            <option value="1">Janvier</option>
            <option value="2">Février</option>
            <option value="3">Mars</option>
            <option value="4">Avril</option>
            <option value="5">Mai</option>
            <option value="6">Juin</option>
            <option value="7">Juillet</option>
            <option value="8">Août</option>
            <option value="9">Septembre</option>
            <option value="10">Octobre</option>
            <option value="11">Novembre</option>
            <option value="12">Décembre</option>
          </select>
        </div>
      </div>
      <div class="mb-3">
        <label class="form-label">Montant prévu (FCFA)</label>
        <input type="number" name="montant_prevu" class="form-control" required min="0" placeholder="Ex: 150000">
      </div>
      <div class="mb-3">
        <label class="form-label">Note</label>
        <textarea name="note" class="form-control" rows="3"></textarea>
      </div>
      <button type="submit" class="btn btn-primary">
        <i class="bi bi-save"></i> Enregistrer
      </button>
    </form>
  </div>
</div>

<script>
function toggleNewCategory() {
  const form = document.getElementById('newCategoryForm');
  const select = document.getElementById('categorySelect');
  
  if (form.style.display === 'none') {
    form.style.display = 'block';
    select.value = '';
    select.required = false;
  } else {
    form.style.display = 'none';
    select.required = true;
  }
}
</script>

@endsection
