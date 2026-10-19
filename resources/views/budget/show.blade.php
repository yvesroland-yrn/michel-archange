@extends('layouts.paroisse')
@section('contenu')
<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h2 class="h3">Budget du Sanctuaire - {{ $budget->annee }}</h2>
    <p class="text-muted">Rapport budgétaire pour l'année {{ $budget->annee }}</p>
  </div>
  <div class="btn-group">
    <a href="{{ route('budget.liste') }}" class="btn btn-outline-primary">
      <i class="bi bi-list-ul"></i> Liste des budgets
    </a>
    <a href="{{ route('budget.export-pdf', $budget->annee) }}" class="btn btn-outline-success" target="_blank">
      <i class="bi bi-file-earmark-pdf"></i> Exporter PDF
    </a>
    <a href="{{ route('budget.export-word', $budget->annee) }}" class="btn btn-outline-info">
      <i class="bi bi-file-earmark-word"></i> Exporter Word
    </a>
  </div>
</div>

<!-- Résumé financier -->
<div class="row g-3 mb-4">
  <div class="col-md-4">
    <div class="card bg-success text-white">
      <div class="card-body">
        <h5 class="card-title">Total Entrées</h5>
        <h3 class="card-text">{{ number_format($budget->recettes_totales, 0, ',', ' ') }} FCFA</h3>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card bg-danger text-white">
      <div class="card-body">
        <h5 class="card-title">Total Sorties</h5>
        <h3 class="card-text">{{ number_format($budget->depenses_totales, 0, ',', ' ') }} FCFA</h3>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card {{ $budget->solde >= 0 ? 'bg-primary' : 'bg-warning' }} text-white">
      <div class="card-body">
        <h5 class="card-title">Solde</h5>
        <h3 class="card-text">{{ number_format($budget->solde, 0, ',', ' ') }} FCFA</h3>
      </div>
    </div>
  </div>
</div>

<!-- Notes -->
<div class="card mb-4">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0"><i class="bi bi-pencil-square"></i> Notes</h5>
    <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#addLigneModal">
      <i class="bi bi-plus"></i> Ajouter une ligne
    </button>
  </div>
  <div class="card-body">
    <form method="POST" action="{{ route('budget.update-notes', $budget->annee) }}">
      @method('PUT')
      @csrf
      <div class="mb-3">
        <textarea name="notes" class="form-control" rows="3" placeholder="Ajoutez vos notes...">{{ $budget->notes ?? '' }}</textarea>
      </div>
      <button type="submit" class="btn btn-primary">
        <i class="bi bi-save"></i> Enregistrer
      </button>
    </form>
  </div>
</div>

<!-- Lignes de budget -->
<div class="card mb-4">
  <div class="card-header">
    <h5 class="mb-0"><i class="bi bi-list-check"></i> Détail du budget</h5>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Nom</th>
            <th>Type</th>
            <th>Montant</th>
            <th>Réalisé</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($budget->lignes as $ligne)
            <tr>
              <td class="fw-semibold">{{ $ligne->nom }}</td>
              <td>
                @if($ligne->type === 'recette')
                  <span class="badge bg-success">Entrée</span>
                @else
                  <span class="badge bg-danger">Sortie</span>
                @endif
              </td>
              <td class="{{ $ligne->type === 'recette' ? 'text-success' : 'text-danger' }}">
                {{ number_format($ligne->montant, 0, ',', ' ') }} FCFA
              </td>
              <td>
                @if($ligne->realise)
                  <span class="badge bg-success">Oui</span>
                @else
                  <span class="badge bg-secondary">Non</span>
                @endif
              </td>
              <td>
                <div class="btn-group">
                  <form method="POST" action="{{ route('budget.ligne.toggle-realise', $ligne->id) }}" style="display:inline">
                    @method('PUT')
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-primary" title="{{ $ligne->realise ? 'Marquer non réalisé' : 'Marquer réalisé' }}">
                      <i class="bi bi-{{ $ligne->realise ? 'x-circle' : 'check-circle' }}"></i>
                    </button>
                  </form>
                  <form method="POST" action="{{ route('budget.ligne.destroy', $ligne->id) }}" onsubmit="return confirm('Supprimer cette ligne ?')" style="display:inline">
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
              <td colspan="5" class="text-center text-muted py-4">Aucune ligne de budget ajoutée.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal pour ajouter une ligne de budget -->
<div class="modal fade" id="addLigneModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Ajouter une ligne de budget</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form method="POST" action="{{ route('budget.ligne.store') }}">
        @csrf
        <div class="modal-body">
          <input type="hidden" name="annee" value="{{ $budget->annee }}">
          <div class="mb-3">
            <label class="form-label">Nom de la ligne</label>
            <input type="text" name="nom" class="form-control" placeholder="Ex: Salaires, Entretien, Dons..." required>
          </div>
          <div class="mb-3">
            <label class="form-label">Montant (FCFA)</label>
            <input type="number" name="montant" class="form-control" min="0" step="0.01" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Type</label>
            <select name="type" class="form-select" required>
              <option value="depense">Sortie</option>
              <option value="recette">Entrée</option>
            </select>
          </div>
          <div class="mb-3">
            <div class="form-check">
              <input type="checkbox" name="realise" id="realise" class="form-check-input">
              <label class="form-check-label" for="realise">Réalisé</label>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
          <button type="submit" class="btn btn-primary">Ajouter</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection
