@extends('layouts.paroisse')
@section('contenu')
<div class="welcome mb-4">
  <div class="motto"></div>
  <h2>Tableau de bord {{ now()->year }}</h2>
  <p>Vue d'ensemble de la vie de la paroisse Saint Michel Archange de la BAE.</p>
</div>

@php
  $icons = ['bi-people-fill', 'bi-droplet-half', 'bi-mortarboard-fill', 'bi-envelope-heart-fill'];
  $tones = ['', 'gold', 'green', 'red'];
  $i = 0;
@endphp

<!-- Statistiques principales -->
<div class="row g-3 mb-4">
  @foreach($stats as $l => $v)
    <div class="col-6 col-xl-3">
      <div class="stat {{ $tones[$i % 4] }}">
        <div class="ico"><i class="bi {{ $icons[$i % 4] }}"></i></div>
        <div>
          <div class="val">{{ $v }}</div>
          <div class="lbl">{{ $l }}</div>
        </div>
      </div>
    </div>
    @php $i++; @endphp
  @endforeach
</div>

@if($financeVisible)
@php
  $fi = ['bi-arrow-down-circle-fill', 'bi-arrow-up-circle-fill', 'bi-wallet2'];
  $ft = ['green', 'red', 'gold'];
  $j = 0;
@endphp
<!-- Finances globales -->
<div class="row g-3 mb-4">
  @foreach($finances as $l => $v)
    <div class="col-md-4">
      <div class="stat {{ $ft[$j % 3] }}">
        <div class="ico"><i class="bi {{ $fi[$j % 3] }}"></i></div>
        <div>
          <div class="val" style="font-size:1.5rem">{{ number_format($v, 0, ',', ' ') }}</div>
          <div class="lbl">{{ $l }}</div>
        </div>
      </div>
    </div>
    @php $j++; @endphp
  @endforeach
</div>

<!-- Catégories de recettes -->
<div class="card mb-4">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0"><i class="bi bi-cash-coin"></i> Trésorerie - Enregistrement rapide</h5>
    <a href="{{ route('finance.index') }}" class="btn btn-sm btn-outline-primary">Vue complète</a>
  </div>
  <div class="card-body">
    <div class="row g-3">
      <div class="col-md-3 col-6">
        <div class="card border-primary">
          <div class="card-body text-center">
            <i class="bi bi-gift fs-2 text-primary"></i>
            <h6 class="card-title mt-2">Dons</h6>
            <p class="card-text">{{ number_format($categoryStats['don'] ?? 0, 0, ',', ' ') }} FCFA</p>
            <button class="btn btn-sm btn-primary w-100 mt-2" onclick="openRecetteModal('don')">
              <i class="bi bi-plus"></i> Enregistrer
            </button>
            <button class="btn btn-sm btn-outline-primary w-100 mt-1" onclick="openReportModal('don')">
              <i class="bi bi-file-earmark-pdf"></i> Rapport
            </button>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-6">
        <div class="card border-success">
          <div class="card-body text-center">
            <i class="bi bi-cash-coin fs-2 text-success"></i>
            <h6 class="card-title mt-2">Dîmes</h6>
            <p class="card-text">{{ number_format($categoryStats['dime'] ?? 0, 0, ',', ' ') }} FCFA</p>
            <button class="btn btn-sm btn-success w-100 mt-2" onclick="openRecetteModal('dime')">
              <i class="bi bi-plus"></i> Enregistrer
            </button>
            <button class="btn btn-sm btn-outline-success w-100 mt-1" onclick="openReportModal('dime')">
              <i class="bi bi-file-earmark-pdf"></i> Rapport
            </button>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-6">
        <div class="card border-warning">
          <div class="card-body text-center">
            <i class="bi bi-basket fs-2 text-warning"></i>
            <h6 class="card-title mt-2">Quêtes</h6>
            <p class="card-text">{{ number_format($categoryStats['quete'] ?? 0, 0, ',', ' ') }} FCFA</p>
            <button class="btn btn-sm btn-warning w-100 mt-2" onclick="openRecetteModal('quete')">
              <i class="bi bi-plus"></i> Enregistrer
            </button>
            <button class="btn btn-sm btn-outline-warning w-100 mt-1" onclick="openReportModal('quete')">
              <i class="bi bi-file-earmark-pdf"></i> Rapport
            </button>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-6">
        <div class="card border-info">
          <div class="card-body text-center">
            <i class="bi bi-heart fs-2 text-info"></i>
            <h6 class="card-title mt-2">Offrandes</h6>
            <p class="card-text">{{ number_format($categoryStats['offrande'] ?? 0, 0, ',', ' ') }} FCFA</p>
            <button class="btn btn-sm btn-info w-100 mt-2" onclick="openRecetteModal('offrande')">
              <i class="bi bi-plus"></i> Enregistrer
            </button>
            <button class="btn btn-sm btn-outline-info w-100 mt-1" onclick="openReportModal('offrande')">
              <i class="bi bi-file-earmark-pdf"></i> Rapport
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endif

<!-- Contenu principal -->
<div class="row g-4">
  @if(auth()->user()->hasPermission('fideles'))
  <!-- Derniers fidèles inscrits -->
  <div class="col-lg-7">
    <h2 class="h5 mb-3">Derniers fidèles inscrits</h2>
    <div class="table-responsive">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Nom</th>
            <th>Prénoms</th>
            <th>Téléphone</th>
            <th>Quartier</th>
          </tr>
        </thead>
        <tbody>
          @forelse($fideles as $f)
            <tr>
              <td class="fw-semibold">{{ $f->nom }}</td>
              <td>{{ $f->prenoms }}</td>
              <td>{{ $f->telephone ?? '-' }}</td>
              <td>{{ $f->quartier ?? '-' }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="4" class="text-center text-muted py-4">Aucun fidèle inscrit.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
  @endif

  @if(auth()->user()->hasPermission('evenements'))
  <!-- Prochains événements -->
  <div class="col-lg-5">
    <h2 class="h5 mb-3">Prochains événements</h2>
    <div class="card">
      <ul class="list-group list-group-flush rounded-4">
        @forelse($evenements as $e)
          <li class="list-group-item d-flex align-items-center gap-3 py-3">
            <div class="event-date">
              <b>{{ $e->date_heure->format('d') }}</b>
              <span>{{ $e->date_heure->translatedFormat('M') }}</span>
            </div>
            <div>
              <div class="fw-semibold">{{ $e->titre }}</div>
              <small class="text-muted">
                <i class="bi bi-clock"></i> {{ $e->date_heure->format('H:i') }}
                @if($e->lieu) · {{ $e->lieu }}@endif
              </small>
            </div>
          </li>
        @empty
          <li class="list-group-item text-muted text-center py-4">Aucun événement à venir.</li>
        @endforelse
      </ul>
    </div>
  </div>
  @endif
</div>

<!-- Messes et calendrier paroissial -->
@if(auth()->user()->hasPermission('evenements'))
<div class="row g-4 mt-4">
  <div class="col-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bi bi-calendar-event-fill"></i> Messes et calendrier paroissial</h5>
        <div class="d-flex gap-2">
          <a href="{{ route('evenements.pdf') }}" class="btn btn-sm btn-outline-success">
            <i class="bi bi-file-earmark-pdf"></i> Exporter PDF
          </a>
          <a href="{{ route('evenements.index') }}" class="btn btn-sm btn-outline-primary">Voir tout</a>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Date</th>
                <th>Titre</th>
                <th>Type</th>
                <th>Lieu</th>
                <th>Célébrant</th>
              </tr>
            </thead>
            <tbody>
              @forelse($evenements as $e)
                <tr>
                  <td>{{ $e->date_heure->format('d/m/Y H:i') }}</td>
                  <td class="fw-semibold">{{ $e->titre }}</td>
                  <td>{{ App\Models\Evenement::TYPES[$e->type] ?? $e->type }}</td>
                  <td>{{ $e->lieu ?? '-' }}</td>
                  <td>{{ $e->celebrant ?? '-' }}</td>
                </tr>
              @empty
                <tr>
                  <td colspan="5" class="text-center text-muted py-4">Aucun événement programmé.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endif

<!-- Mouvements paroissiaux -->
@if(auth()->user()->hasPermission('mouvement_paroissial'))
<div class="row g-4 mt-4">
  <div class="col-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bi bi-collection"></i> Mouvements paroissiaux</h5>
        <div class="d-flex gap-2">
          <a href="{{ route('mouvement-paroissial.pdf') }}" class="btn btn-sm btn-outline-success">
            <i class="bi bi-file-earmark-pdf"></i> Exporter PDF
          </a>
          <a href="{{ route('mouvement-paroissial.index') }}" class="btn btn-sm btn-outline-primary">Voir tout</a>
        </div>
      </div>
      <div class="card-body">
        <div class="row g-3">
          @forelse($mouvements as $m)
            <div class="col-md-6 col-lg-4">
              <div class="card h-100 border-primary">
                <div class="card-body text-center">
                  @if($m->icone)
                    <i class="bi {{ $m->icone }} fs-2 text-primary mb-2"></i>
                  @else
                    <i class="bi bi-gear fs-2 text-primary mb-2"></i>
                  @endif
                  <h6 class="card-title">{{ $m->nom }}</h6>
                  @if($m->responsable)
                    <p class="card-text small text-muted">
                      <i class="bi bi-person"></i> {{ $m->responsable }}
                    </p>
                  @endif
                  @if($m->telephone_responsable)
                    <p class="card-text small text-muted">
                      <i class="bi bi-telephone"></i> {{ $m->telephone_responsable }}
                    </p>
                  @endif
                </div>
              </div>
            </div>
          @empty
            <div class="col-12">
              <p class="text-center text-muted py-4">Aucun mouvement paroissial actif.</p>
            </div>
          @endforelse
        </div>
      </div>
    </div>
  </div>
</div>
@endif

<!-- Actions rapides -->
<div class="row g-4 mt-4">
  <div class="col-12">
    <h2 class="h5 mb-3">Actions rapides</h2>
    <div class="row g-3">
      @if(auth()->user()->hasPermission('fideles'))
        <div class="col-md-3 col-6">
          <a href="{{ route('fideles.create') }}" class="btn btn-outline-primary w-100">
            <i class="bi bi-person-plus-fill me-2"></i>Nouveau fidèle
          </a>
        </div>
      @endif
      @if(auth()->user()->hasPermission('evenements'))
        <div class="col-md-3 col-6">
          <a href="{{ route('evenements.create') }}" class="btn btn-outline-success w-100">
            <i class="bi bi-calendar-plus-fill me-2"></i>Nouvel événement
          </a>
        </div>
      @endif
      @if(auth()->user()->hasPermission('annonces'))
        <div class="col-md-3 col-6">
          <a href="{{ route('annonces.create') }}" class="btn btn-outline-warning w-100">
            <i class="bi bi-megaphone-fill me-2"></i>Nouvelle annonce
          </a>
        </div>
      @endif
      @if(auth()->user()->hasPermission('finances'))
        <div class="col-md-3 col-6">
          <a href="{{ route('finance.index') }}" class="btn btn-outline-info w-100">
            <i class="bi bi-cash-coin me-2"></i>Gérer finances
          </a>
        </div>
      @endif
      @if(auth()->user()->hasPermission('intentions'))
        <div class="col-md-3 col-6">
          <a href="{{ route('intentions.tirage') }}" class="btn btn-outline-warning w-100">
            <i class="bi bi-shuffle me-2"></i>Tirage intentions
          </a>
        </div>
      @endif
    </div>
  </div>
</div>

<!-- Modal d'enregistrement de recette -->
<div class="modal fade" id="recetteModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Enregistrer une recette</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form method="POST" action="{{ route('finance.recettes.store') }}">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Date</label>
            <input type="date" name="date" value="{{ now()->toDateString() }}" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Type</label>
            <select name="type" id="modal-type-select" class="form-select" required>
              <option value="">Sélectionner un type...</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Montant (FCFA)</label>
            <input type="number" name="montant" min="1" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Donateur (facultatif)</label>
            <select name="fidele_id" class="form-select">
              <option value="">Aucun</option>
              @foreach($fideles as $id=>$n)
                <option value="{{ $id }}">{{ $n }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Note</label>
            <input name="note" class="form-control">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
          <button type="submit" class="btn btn-success">Enregistrer</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal de rapport -->
<div class="modal fade" id="reportModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Générer un rapport</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form method="GET" action="{{ route('finance.bilan') }}">
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Période</label>
            <select name="mois" id="report-mois" class="form-select">
              <option value="tout">Tout</option>
              @for($i = 1; $i <= 12; $i++)
                <option value="{{ now()->year }}-{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}">{{ now()->year }}-{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
              @endfor
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Filtrer par catégorie</label>
            <select name="category" id="report-category" class="form-select">
              <option value="tous">Toutes les recettes</option>
              <option value="don">Dons</option>
              <option value="dime">Dîmes</option>
              <option value="quete">Quêtes</option>
              <option value="offrande">Offrandes</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
          <button type="submit" class="btn btn-primary">Générer PDF</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
const categoryTypes = {
  'don': ['don'],
  'dime': ['dime'],
  'quete': ['quete_ordinaire', 'quete_speciale', 'quete_imperative', 'quete_semaine', 'denier_culte'],
  'offrande': ['offrande_messe'],
  'autre': ['autre']
};

function openRecetteModal(category) {
  const modal = new bootstrap.Modal(document.getElementById('recetteModal'));
  const typeSelect = document.getElementById('modal-type-select');
  
  // Réinitialiser le select
  typeSelect.innerHTML = '<option value="">Sélectionner un type...</option>';
  
  // Ajouter les options de la catégorie
  const types = categoryTypes[category] || [];
  types.forEach(type => {
    const option = document.createElement('option');
    option.value = type;
    option.textContent = type.charAt(0).toUpperCase() + type.slice(1).replace(/_/g, ' ');
    typeSelect.appendChild(option);
  });
  
  // Sélectionner le premier type par défaut
  if (types.length > 0) {
    typeSelect.value = types[0];
  }
  
  modal.show();
}

function openReportModal(category) {
  const modal = new bootstrap.Modal(document.getElementById('reportModal'));
  const categorySelect = document.getElementById('report-category');
  
  // Sélectionner la catégorie
  categorySelect.value = category;
  
  modal.show();
}
</script>

@endsection
