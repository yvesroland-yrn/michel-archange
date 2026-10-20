@extends('layouts.paroisse')
@section('contenu')

<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h2 class="h3">Détails du Mouvement</h2>
    <p class="text-muted">Informations détaillées du mouvement budgétaire</p>
  </div>
  <a href="{{ route('budget.mouvements.index') }}" class="btn btn-outline-secondary">
    <i class="bi bi-arrow-left"></i> Retour
  </a>
</div>

<div class="row">
  <div class="col-lg-8">
    <div class="card mb-4">
      <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Informations générales</h5>
      </div>
      <div class="card-body">
        <table class="table table-borderless">
          <tr>
            <th style="width: 30%">Date de l'opération</th>
            <td>{{ date('d/m/Y', strtotime($mouvement->date_operation)) }}</td>
          </tr>
          <tr>
            <th>Ligne budgétaire</th>
            <td>{{ $mouvement->ligne->libelle }}</td>
          </tr>
          <tr>
            <th>Catégorie</th>
            <td>
              <span class="badge {{ $mouvement->ligne->category->type === 'recette' ? 'bg-success' : 'bg-danger' }}">
                {{ $mouvement->ligne->category->nom }}
              </span>
            </td>
          </tr>
          <tr>
            <th>Type</th>
            <td>
              <span class="badge {{ $mouvement->ligne->category->type === 'recette' ? 'bg-success' : 'bg-danger' }}">
                {{ $mouvement->ligne->category->type === 'recette' ? 'Recette' : 'Dépense' }}
              </span>
            </td>
          </tr>
          <tr>
            <th>Montant</th>
            <td class="fw-bold {{ $mouvement->ligne->category->type === 'recette' ? 'text-success' : 'text-danger' }}">
              {{ number_format($mouvement->montant, 0, ',', ' ') }} FCFA
            </td>
          </tr>
          <tr>
            <th>Bénéficiaire</th>
            <td>{{ $mouvement->beneficiaire ?? '-' }}</td>
          </tr>
          <tr>
            <th>Description</th>
            <td>{{ $mouvement->description ?? '-' }}</td>
          </tr>
          <tr>
            <th>Créé par</th>
            <td>{{ $mouvement->createdBy->name ?? '-' }}</td>
          </tr>
          <tr>
            <th>Date de création</th>
            <td>{{ $mouvement->created_at->format('d/m/Y H:i') }}</td>
          </tr>
          @if($mouvement->updated_at && $mouvement->updated_at != $mouvement->created_at)
          <tr>
            <th>Dernière modification</th>
            <td>{{ $mouvement->updated_at->format('d/m/Y H:i') }}</td>
          </tr>
          @endif
        </table>
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="card mb-4">
      <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-gear me-2"></i>Actions</h5>
      </div>
      <div class="card-body">
        <div class="d-grid gap-2">
          <a href="{{ route('budget.mouvements.edit', $mouvement) }}" class="btn btn-primary">
            <i class="bi bi-pencil me-2"></i>Modifier
          </a>
          <form method="POST" action="{{ route('budget.mouvements.destroy', $mouvement) }}" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce mouvement ?')">
            @method('DELETE')
            @csrf
            <button type="submit" class="btn btn-danger">
              <i class="bi bi-trash me-2"></i>Supprimer
            </button>
          </form>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-clipboard-data me-2"></i>Résumé</h5>
      </div>
      <div class="card-body">
        <div class="mb-3">
          <small class="text-muted">Type d'opération</small>
          <div class="fw-bold {{ $mouvement->ligne->category->type === 'recette' ? 'text-success' : 'text-danger' }}">
            {{ $mouvement->ligne->category->type === 'recette' ? 'RECETTE' : 'DÉPENSE' }}
          </div>
        </div>
        <div class="mb-3">
          <small class="text-muted">Catégorie</small>
          <div class="fw-bold">{{ $mouvement->ligne->category->nom }}</div>
        </div>
        <div>
          <small class="text-muted">Montant</small>
          <div class="fw-bold {{ $mouvement->ligne->category->type === 'recette' ? 'text-success' : 'text-danger' }} fs-4">
            {{ number_format($mouvement->montant, 0, ',', ' ') }} FCFA
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
