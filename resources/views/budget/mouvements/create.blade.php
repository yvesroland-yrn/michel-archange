@extends('layouts.paroisse')
@section('contenu')

<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h2 class="h3">Nouveau Mouvement</h2>
    <p class="text-muted">Enregistrer une dépense ou recette</p>
  </div>
  <a href="{{ route('budget.mouvements.index') }}" class="btn btn-outline-secondary">
    <i class="bi bi-arrow-left"></i> Retour
  </a>
</div>

<div class="card">
  <div class="card-body">
    <form method="POST" action="{{ route('budget.mouvements.store') }}" enctype="multipart/form-data">
      @csrf
      <div class="mb-3">
        <label class="form-label">Ligne budgétaire</label>
        <select name="budget_ligne_id" class="form-select" required id="ligneSelect">
          @if(request('ligne'))
            <option value="{{ request('ligne') }}" selected>Ligne sélectionnée</option>
          @endif
          @foreach($lignes as $ligne)
            <option value="{{ $ligne->id }}" {{ request('ligne') == $ligne->id ? 'selected' : '' }}>
              {{ $ligne->libelle }} ({{ $ligne->category->nom }}) - {{ $ligne->annee }} {{ $ligne->mois ? '- Mois ' . $ligne->mois : '' }}
            </option>
          @endforeach
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label">Date de l'opération</label>
        <input type="date" name="date_operation" class="form-control" value="{{ date('Y-m-d') }}" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Montant (FCFA)</label>
        <input type="number" name="montant" class="form-control" required min="0" placeholder="Ex: 50000">
      </div>
      <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="3" required placeholder="Ex: Paiement facture électricité"></textarea>
      </div>
      <div class="mb-3">
        <label class="form-label">Référence (reçu/facture)</label>
        <input type="text" name="reference" class="form-control" placeholder="Ex: FAC-2026-001">
      </div>
      <div class="mb-3">
        <label class="form-label">Bénéficiaire</label>
        <input type="text" name="beneficiaire" class="form-control" placeholder="Ex: SENELEC">
      </div>
      <div class="mb-3">
        <label class="form-label">Justificatif (optionnel)</label>
        <input type="file" name="justificatif" class="form-control" accept=".jpg,.jpeg,.png,.pdf">
        <small class="text-muted">Formats acceptés: JPG, PNG, PDF (max 2 Mo)</small>
      </div>
      <button type="submit" class="btn btn-primary">
        <i class="bi bi-save"></i> Enregistrer
      </button>
    </form>
  </div>
</div>

@endsection
