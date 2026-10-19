@extends('layouts.paroisse')
@section('contenu')
<div class="welcome mb-4">
  <div class="motto"></div>
  <h2>Budget du Sanctuaire</h2>
  <p>Historique budgétaire du Sanctuaire Marial Notre-Dame de Cana Sassako depuis sa création.</p>
</div>

<!-- Résumé global -->
<div class="row g-3 mb-4">
  <div class="col-md-4">
    <div class="card bg-success text-white">
      <div class="card-body">
        <h5 class="card-title">Total Recettes (toutes années)</h5>
        <h3 class="card-text">{{ number_format($budgets->sum('recettes_totales'), 0, ',', ' ') }} FCFA</h3>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card bg-danger text-white">
      <div class="card-body">
        <h5 class="card-title">Total Dépenses (toutes années)</h5>
        <h3 class="card-text">{{ number_format($budgets->sum('depenses_totales'), 0, ',', ' ') }} FCFA</h3>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card bg-dark text-white">
      <div class="card-body">
        <h5 class="card-title">Solde Global</h5>
        <h3 class="card-text">{{ number_format($budgets->sum('solde'), 0, ',', ' ') }} FCFA</h3>
      </div>
    </div>
  </div>
</div>

<!-- Liste des budgets par année -->
<div class="card mb-4">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0"><i class="bi bi-calendar3"></i> Budgets par année</h5>
    <div class="btn-group">
      <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#addLigneModal">
        <i class="bi bi-plus"></i> Ajouter une ligne
      </button>
      <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addBudgetModal">
        <i class="bi bi-plus-circle"></i> Nouvelle année
      </button>
    </div>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Année</th>
            <th>Recettes</th>
            <th>Dépenses</th>
            <th>Solde</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($budgets as $budget)
            <tr>
              <td class="fw-bold">{{ $budget->annee }}</td>
              <td class="text-success">{{ number_format($budget->recettes_totales, 0, ',', ' ') }} FCFA</td>
              <td class="text-danger">{{ number_format($budget->depenses_totales, 0, ',', ' ') }} FCFA</td>
              <td class="{{ $budget->solde >= 0 ? 'text-success' : 'text-danger' }}">
                {{ number_format($budget->solde, 0, ',', ' ') }} FCFA
              </td>
              <td>
                <div class="btn-group">
                  <a href="{{ route('budget.show', $budget->annee) }}" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-eye"></i> Détails
                  </a>
                  <a href="{{ route('budget.export-pdf', $budget->annee) }}" class="btn btn-sm btn-outline-success" target="_blank">
                    <i class="bi bi-file-earmark-pdf"></i> PDF
                  </a>
                  <a href="{{ route('budget.export-word', $budget->annee) }}" class="btn btn-sm btn-outline-info">
                    <i class="bi bi-file-earmark-word"></i> Word
                  </a>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="text-center text-muted py-4">Aucune donnée budgétaire disponible.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal pour ajouter un budget -->
<div class="modal fade" id="addBudgetModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Ajouter un budget annuel</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form method="POST" action="{{ route('budget.store') }}">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Année (ex: 2026-2027)</label>
            <input type="text" name="annee" class="form-control" placeholder="2026-2027" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Notes (facultatif)</label>
            <textarea name="notes" class="form-control" rows="3"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
          <button type="submit" class="btn btn-primary">Créer le budget</button>
        </div>
      </form>
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
          <div class="mb-3">
            <label class="form-label">Année</label>
            <select name="annee" class="form-select" required>
              <option value="">Sélectionner une année...</option>
              @foreach($budgets as $budget)
                <option value="{{ $budget->annee }}">{{ $budget->annee }}</option>
              @endforeach
            </select>
          </div>
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
              <option value="depense">Dépense</option>
              <option value="recette">Recette</option>
            </select>
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
