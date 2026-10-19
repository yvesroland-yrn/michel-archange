@extends('layouts.paroisse')
@section('contenu')
<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h2 class="h3">Liste des Budgets</h2>
    <p class="text-muted">Historique complet des budgets annuels du sanctuaire.</p>
  </div>
  <div class="btn-group">
    <a href="{{ route('budget.tableau-de-bord') }}" class="btn btn-outline-primary">
      <i class="bi bi-speedometer2"></i> Tableau de bord
    </a>
    <a href="{{ route('budget.index') }}" class="btn btn-outline-success">
      <i class="bi bi-plus-circle"></i> Ajouter un budget
    </a>
  </div>
</div>

<!-- Liste des budgets -->
<div class="card mb-4">
  <div class="card-header">
    <h5 class="mb-0"><i class="bi bi-calendar3"></i> Budgets par année</h5>
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
            <th>Statut</th>
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
                @if($budget->solde >= 0)
                  <span class="badge bg-success">Excédent</span>
                @else
                  <span class="badge bg-danger">Déficit</span>
                @endif
              </td>
              <td>
                <div class="btn-group">
                  <a href="{{ route('budget.show', $budget->annee) }}" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-eye"></i> Détails
                  </a>
                  <button class="btn btn-sm btn-outline-warning" onclick="editBudget('{{ $budget->annee }}', '{{ $budget->notes ?? '' }}')">
                    <i class="bi bi-pencil"></i> Modifier
                  </button>
                  <form method="POST" action="{{ route('budget.destroy', $budget->annee) }}" onsubmit="return confirm('Supprimer ce budget ?')" style="display:inline">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-danger">
                      <i class="bi bi-trash"></i> Supprimer
                    </button>
                  </form>
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
              <td colspan="6" class="text-center text-muted py-4">Aucun budget disponible.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal pour modifier un budget -->
<div class="modal fade" id="editBudgetModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modifier le budget</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form method="POST" action="" id="editBudgetForm">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <input type="hidden" name="annee" id="editAnnee">
          <div class="mb-3">
            <label class="form-label">Année</label>
            <input type="text" name="annee_display" id="editAnneeDisplay" class="form-control" disabled>
          </div>
          <div class="mb-3">
            <label class="form-label">Notes</label>
            <textarea name="notes" id="editNotes" class="form-control" rows="3"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
          <button type="submit" class="btn btn-primary">Enregistrer</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function editBudget(annee, notes) {
  document.getElementById('editAnnee').value = annee;
  document.getElementById('editAnneeDisplay').value = annee;
  document.getElementById('editNotes').value = notes;
  document.getElementById('editBudgetForm').action = "/budget/" + annee;
  new bootstrap.Modal(document.getElementById('editBudgetModal')).show();
}
</script>

@endsection
