@extends('layouts.paroisse')
@section('contenu')

<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h2 class="h3">Modifier Ligne Budgétaire</h2>
    <p class="text-muted">Modifier : {{ $ligne->libelle }}</p>
  </div>
  <a href="{{ route('budget.lignes.index') }}" class="btn btn-outline-secondary">
    <i class="bi bi-arrow-left"></i> Retour
  </a>
</div>

<div class="card mb-4">
  <div class="card-body">
    <form method="POST" action="{{ route('budget.lignes.update', $ligne) }}">
      @csrf
      @method('PUT')
      <div class="mb-3">
        <label class="form-label">Catégorie</label>
        <select name="budget_category_id" class="form-select" required>
          @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ $ligne->budget_category_id == $category->id ? 'selected' : '' }}>
              {{ $category->nom }} ({{ $category->type === 'depense' ? 'Dépense' : 'Recette' }})
            </option>
          @endforeach
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label">Libellé</label>
        <input type="text" name="libelle" class="form-control" value="{{ $ligne->libelle }}" required>
      </div>
      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label">Année</label>
          <input type="text" name="annee" class="form-control" value="{{ $ligne->annee }}" required placeholder="Ex: 2026 ou 2026-2027">
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label">Mois (optionnel)</label>
          <select name="mois" class="form-select">
            <option value="">Toute l'année</option>
            <option value="1" {{ $ligne->mois == 1 ? 'selected' : '' }}>Janvier</option>
            <option value="2" {{ $ligne->mois == 2 ? 'selected' : '' }}>Février</option>
            <option value="3" {{ $ligne->mois == 3 ? 'selected' : '' }}>Mars</option>
            <option value="4" {{ $ligne->mois == 4 ? 'selected' : '' }}>Avril</option>
            <option value="5" {{ $ligne->mois == 5 ? 'selected' : '' }}>Mai</option>
            <option value="6" {{ $ligne->mois == 6 ? 'selected' : '' }}>Juin</option>
            <option value="7" {{ $ligne->mois == 7 ? 'selected' : '' }}>Juillet</option>
            <option value="8" {{ $ligne->mois == 8 ? 'selected' : '' }}>Août</option>
            <option value="9" {{ $ligne->mois == 9 ? 'selected' : '' }}>Septembre</option>
            <option value="10" {{ $ligne->mois == 10 ? 'selected' : '' }}>Octobre</option>
            <option value="11" {{ $ligne->mois == 11 ? 'selected' : '' }}>Novembre</option>
            <option value="12" {{ $ligne->mois == 12 ? 'selected' : '' }}>Décembre</option>
          </select>
        </div>
      </div>
      <div class="mb-3">
        <label class="form-label">Montant prévu (FCFA)</label>
        <input type="number" name="montant_prevu" class="form-control" value="{{ $ligne->montant_prevu }}" required min="0">
      </div>
      <div class="mb-3">
        <label class="form-label">Note</label>
        <textarea name="note" class="form-control" rows="3">{{ $ligne->note }}</textarea>
      </div>
      <button type="submit" class="btn btn-primary">
        <i class="bi bi-save"></i> Enregistrer
      </button>
    </form>
  </div>
</div>

<!-- Duplication -->
<div class="card">
  <div class="card-header">
    <h5 class="mb-0">Dupliquer cette ligne</h5>
  </div>
  <div class="card-body">
    <form method="POST" action="{{ route('budget.lignes.duplicate', $ligne) }}">
      @csrf
      <div class="row">
        <div class="col-md-4 mb-3">
          <label class="form-label">Année cible</label>
          <input type="text" name="annee" class="form-control" value="{{ $ligne->annee }}" required placeholder="Ex: 2026 ou 2026-2027">
        </div>
        <div class="col-md-4 mb-3">
          <label class="form-label">Mois cible (optionnel)</label>
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
        <div class="col-md-4 mb-3 d-flex align-items-end">
          <button type="submit" class="btn btn-success">
            <i class="bi bi-copy"></i> Dupliquer
          </button>
        </div>
      </div>
      <div class="form-check">
        <input type="checkbox" name="dupliquer_tous_les_mois" id="dupliquer_tous_les_mois" class="form-check-input">
        <label class="form-check-label" for="dupliquer_tous_les_mois">Dupliquer pour les 12 mois de l'année</label>
      </div>
    </form>
  </div>
</div>

@endsection
