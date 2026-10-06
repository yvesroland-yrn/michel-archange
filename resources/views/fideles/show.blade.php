@extends('layouts.paroisse')
@section('contenu')
<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h1 class="h3 mb-1">{{ $f->nom_complet }}</h1>
    <p class="text-muted mb-0">Fiche détaillée du fidèle</p>
  </div>
  <a href="{{ route('fideles.edit', $f) }}" class="btn btn-primary">
    <i class="bi bi-pencil"></i> Modifier
  </a>
</div>

<div class="row g-4">
  <!-- Identité -->
  <div class="col-md-6">
    <div class="card border-0 shadow-sm h-100">
      <div class="card-header bg-primary text-white">
        <i class="bi bi-person-circle"></i> Identité
      </div>
      <div class="card-body">
        <div class="row g-3">
          <div class="col-6">
            <label class="text-muted small mb-1">Né(e) le</label>
            <div class="fw-semibold">{{ $f->date_naissance?->format('d/m/Y') ?? '—' }}</div>
          </div>
          <div class="col-6">
            <label class="text-muted small mb-1">Lieu de naissance</label>
            <div class="fw-semibold">{{ $f->lieu_naissance ?? '—' }}</div>
          </div>
          <div class="col-6">
            <label class="text-muted small mb-1">Téléphone</label>
            <div class="fw-semibold">{{ $f->telephone ?? '—' }}</div>
          </div>
          <div class="col-6">
            <label class="text-muted small mb-1">Email</label>
            <div class="fw-semibold">{{ $f->email ?? '—' }}</div>
          </div>
          <div class="col-6">
            <label class="text-muted small mb-1">Quartier</label>
            <div class="fw-semibold">{{ $f->quartier ?? '—' }}</div>
          </div>
          <div class="col-6">
            <label class="text-muted small mb-1">CEB</label>
            <div class="fw-semibold">{{ $f->ceb?->nom ?? '—' }}</div>
          </div>
          <div class="col-6">
            <label class="text-muted small mb-1">Profession</label>
            <div class="fw-semibold">{{ $f->profession ?? '—' }}</div>
          </div>
          <div class="col-6">
            <label class="text-muted small mb-1">Statut</label>
            <div>
              @if($f->statut === 'actif')
                <span class="badge bg-success">Actif</span>
              @elseif($f->statut === 'transfere')
                <span class="badge bg-warning">Transféré</span>
              @else
                <span class="badge bg-danger">Décédé</span>
              @endif
            </div>
          </div>
          <div class="col-12">
            <label class="text-muted small mb-1">N° Carnet Baptême</label>
            <div class="fw-semibold">{{ $f->numero_carnet_bapteme ?? '—' }}</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Sacrements -->
  <div class="col-md-6">
    <div class="card border-0 shadow-sm h-100">
      <div class="card-header bg-success text-white">
        <i class="bi bi-cross"></i> Sacrements
      </div>
      <div class="card-body">
        <div class="row g-3">
          <div class="col-6">
            <label class="text-muted small mb-1">Baptisé</label>
            <div>
              @if($f->baptise)
                <span class="badge bg-success"><i class="bi bi-check-circle"></i> Oui</span>
              @else
                <span class="badge bg-secondary"><i class="bi bi-x-circle"></i> Non</span>
              @endif
            </div>
          </div>
          <div class="col-6">
            <label class="text-muted small mb-1">Confirmé</label>
            <div>
              @if($f->confirme)
                <span class="badge bg-success"><i class="bi bi-check-circle"></i> Oui</span>
              @else
                <span class="badge bg-secondary"><i class="bi bi-x-circle"></i> Non</span>
              @endif
            </div>
          </div>
          <div class="col-6">
            <label class="text-muted small mb-1">Marié</label>
            <div>
              @if($f->marie)
                <span class="badge bg-success"><i class="bi bi-check-circle"></i> Oui</span>
              @else
                <span class="badge bg-secondary"><i class="bi bi-x-circle"></i> Non</span>
              @endif
            </div>
          </div>
          <div class="col-12">
            <label class="text-muted small mb-2">Sacrements à enregistrer</label>
            <div class="d-flex gap-2 flex-wrap">
              <!-- Baptême -->
              @if($f->bapteme)
                <div class="btn btn-sm btn-outline-success">
                  <i class="bi bi-check-circle"></i> Baptême ({{ $f->bapteme->date_bapteme->format('d/m/Y') }})
                  <a href="{{ route('baptemes.certificat', $f->bapteme) }}" target="_blank" class="ms-1">
                    <i class="bi bi-file-earmark-pdf"></i>
                  </a>
                </div>
              @else
                <a href="{{ route('baptemes.create', $f) }}" class="btn btn-sm btn-outline-warning">
                  <i class="bi bi-plus-circle"></i> Baptême
                </a>
              @endif

              <!-- Confirmation -->
              @php
                $confirmation = $f->sacrements->where('type', 'confirmation')->first();
              @endphp
              @if($confirmation)
                <div class="btn btn-sm btn-outline-success">
                  <i class="bi bi-check-circle"></i> Confirmation ({{ $confirmation->date_celebration->format('d/m/Y') }})
                  <a href="{{ route('sacrements.certificat-confirmation', $confirmation) }}" target="_blank" class="ms-1">
                    <i class="bi bi-file-earmark-pdf"></i>
                  </a>
                </div>
              @else
                <a href="{{ route('sacrements.create') }}?type=confirmation&fidele_id={{ $f->id }}" class="btn btn-sm btn-outline-warning">
                  <i class="bi bi-plus-circle"></i> Confirmation
                </a>
              @endif

              <!-- Mariage -->
              @php
                $mariage = $f->sacrements->where('type', 'mariage')->first();
              @endphp
              @if($mariage)
                <div class="btn btn-sm btn-outline-success">
                  <i class="bi bi-check-circle"></i> Mariage ({{ $mariage->date_celebration->format('d/m/Y') }})
                  <a href="{{ route('sacrements.certificat-mariage', $mariage) }}" target="_blank" class="ms-1">
                    <i class="bi bi-file-earmark-pdf"></i>
                  </a>
                </div>
              @else
                <a href="{{ route('sacrements.create') }}?type=mariage&fidele_id={{ $f->id }}" class="btn btn-sm btn-outline-warning">
                  <i class="bi bi-plus-circle"></i> Mariage
                </a>
              @endif
            </div>
          </div>
          @if($f->sacrements->whereNotIn('type', ['confirmation', 'mariage'])->count() > 0)
            <div class="col-12 mt-3">
              <label class="text-muted small mb-2">Autres sacrements</label>
              @foreach($f->sacrements->whereNotIn('type', ['confirmation', 'mariage']) as $s)
                <div class="card bg-light mb-2">
                  <div class="card-body py-2 px-3">
                    <div class="d-flex justify-content-between align-items-center">
                      <div>
                        <strong>{{ \App\Models\Sacrement::TYPES[$s->type] ?? $s->type }}</strong>
                        <div class="text-muted small">{{ $s->date_celebration->format('d/m/Y') }}</div>
                      </div>
                      <a href="{{ route('sacrements.certificat', $s) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-file-earmark-pdf"></i>
                      </a>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>

  <!-- Mouvements -->
  <div class="col-12">
    <div class="card border-0 shadow-sm">
      <div class="card-header bg-info text-white">
        <i class="bi bi-people"></i> Mouvements paroissiaux
      </div>
      <div class="card-body">
        @forelse($f->mouvements as $m)
          <div class="card bg-light mb-2">
            <div class="card-body py-2 px-3">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <strong>{{ $m->nom }}</strong>
                  <span class="badge bg-secondary ms-2">{{ $m->pivot->fonction }}</span>
                </div>
              </div>
            </div>
          </div>
        @empty
          <div class="text-center text-muted py-3">
            <i class="bi bi-inbox fs-4"></i>
            <p class="mb-0">Aucun mouvement paroissial</p>
          </div>
        @endforelse
      </div>
    </div>
  </div>
</div>
@endsection
