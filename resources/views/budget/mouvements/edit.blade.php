@extends('layouts.paroisse')
@section('contenu')

<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h2 class="h3">Modifier Mouvement</h2>
    <p class="text-muted">Modifier le mouvement du {{ date('d/m/Y', strtotime($mouvement->date_operation)) }}</p>
  </div>
  <a href="{{ route('budget.mouvements.index') }}" class="btn btn-outline-secondary">
    <i class="bi bi-arrow-left"></i> Retour
  </a>
</div>

<div class="card">
  <div class="card-body">
    <form method="POST" action="{{ route('budget.mouvements.update', $mouvement) }}" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <div class="mb-3">
        <label class="form-label">Ligne budgétaire</label>
        <select name="budget_ligne_id" class="form-select" required>
          @foreach($lignes as $ligne)
            <option value="{{ $ligne->id }}" {{ $mouvement->budget_ligne_id == $ligne->id ? 'selected' : '' }}>
              {{ $ligne->libelle }} ({{ $ligne->category->nom }}) - {{ $ligne->annee }} {{ $ligne->mois ? '- Mois ' . $ligne->mois : '' }}
            </option>
          @endforeach
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label">Date de l'opération</label>
        <input type="date" name="date_operation" class="form-control" value="{{ $mouvement->date_operation }}" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Montant (FCFA)</label>
        <input type="number" name="montant" class="form-control" value="{{ $mouvement->montant }}" required min="0">
      </div>
      <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="3" required>{{ $mouvement->description }}</textarea>
      </div>
      <div class="mb-3">
        <label class="form-label">Référence (reçu/facture)</label>
        <input type="text" name="reference" class="form-control" value="{{ $mouvement->reference }}">
      </div>
      <div class="mb-3">
        <label class="form-label">Bénéficiaire</label>
        <input type="text" name="beneficiaire" class="form-control" value="{{ $mouvement->beneficiaire }}">
      </div>
      <div class="mb-3">
        <label class="form-label">Justificatif</label>
        <input type="file" name="justificatif" class="form-control" accept=".jpg,.jpeg,.png,.df">
        @if($mouvement->justificatif)
        <small class="text-muted">
          Fichier actuel: <a href="{{ asset('storage/' . $mouvement->justificatif) }}" target="_blank">Voir</a>
        </small>
        @endif
      </div>
      <button type="submit" class="btn btn-primary">
        <i class="bi bi-save"></i> Enregistrer
      </button>
    </form>
  </div>
</div>

@endsection
