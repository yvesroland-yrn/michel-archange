@extends('layouts.paroisse')
@section('contenu')
<h1 class="h3 mb-4">Tableau de bord Catéchèse</h1>

<div class="card mb-4">
  <div class="card-header bg-white">
    <h5 class="card-title mb-0">Exports</h5>
  </div>
  <div class="card-body">
    <div class="row g-3">
      <div class="col-md-6">
        <h6 class="fw-bold mb-3">Catéchumènes</h6>
        <div class="d-flex flex-wrap gap-2 align-items-center">
          <select id="exportCatechumenesType" class="form-select w-auto">
            <option value="">Type d'export…</option>
            <optgroup label="Par classe">
              <option value="pdf-par-classe">PDF par classe</option>
              <option value="word-par-classe">Word par classe</option>
            </optgroup>
            <optgroup label="Par année">
              <option value="pdf-par-annee">PDF par année</option>
              <option value="word-par-annee">Word par année</option>
            </optgroup>
          </select>
          <select id="exportCatechumenesClasse" class="form-select w-auto" style="display:none;">
            <option value="">Sélectionner une classe…</option>
            @foreach(\App\Models\ClasseCate::with('anneeCatechetique')->orderByDesc('id')->get() as $classe)
            <option value="{{ $classe->id }}">{{ $classe->anneeCatechetique ? $classe->anneeCatechetique->libelle : '—' }} — {{ $classe->niveau }}{{ $classe->code ? " {$classe->code}" : '' }} ({{ \App\Models\ClasseCate::getSections()[$classe->section] ?? $classe->section }})</option>
            @endforeach
          </select>
          <select id="exportCatechumenesAnnee" class="form-select w-auto" style="display:none;">
            <option value="">Sélectionner une année…</option>
            @foreach(\App\Models\AnneeCatechetique::orderByDesc('date_debut')->get() as $annee)
            <option value="{{ $annee->id }}">{{ $annee->libelle }}</option>
            @endforeach
          </select>
          <button id="exportCatechumenesBtn" class="btn btn-primary" style="display:none;">Exporter</button>
        </div>
      </div>
      <div class="col-md-6">
        <h6 class="fw-bold mb-3">Catéchistes/Animateurs</h6>
        <div class="d-flex flex-wrap gap-2 align-items-center">
          <select id="exportCatechistesType" class="form-select w-auto">
            <option value="">Type d'export…</option>
            <optgroup label="Par classe">
              <option value="pdf-par-classe">PDF par classe</option>
              <option value="word-par-classe">Word par classe</option>
            </optgroup>
            <optgroup label="Par année">
              <option value="pdf-par-annee">PDF par année</option>
              <option value="word-par-annee">Word par année</option>
            </optgroup>
            <optgroup label="Par section">
              <option value="pdf-par-section">PDF par section</option>
              <option value="word-par-section">Word par section</option>
            </optgroup>
          </select>
          <select id="exportCatechistesClasse" class="form-select w-auto" style="display:none;">
            <option value="">Sélectionner une classe…</option>
            @foreach(\App\Models\ClasseCate::with('anneeCatechetique')->orderByDesc('id')->get() as $classe)
            <option value="{{ $classe->id }}">{{ $classe->anneeCatechetique ? $classe->anneeCatechetique->libelle : '—' }} — {{ $classe->niveau }}{{ $classe->code ? " {$classe->code}" : '' }} ({{ \App\Models\ClasseCate::getSections()[$classe->section] ?? $classe->section }})</option>
            @endforeach
          </select>
          <select id="exportCatechistesAnnee" class="form-select w-auto" style="display:none;">
            <option value="">Sélectionner une année…</option>
            @foreach(\App\Models\AnneeCatechetique::orderByDesc('date_debut')->get() as $annee)
            <option value="{{ $annee->id }}">{{ $annee->libelle }}</option>
            @endforeach
          </select>
          <select id="exportCatechistesSection" class="form-select w-auto" style="display:none;">
            <option value="">Sélectionner une section…</option>
            @foreach(\App\Models\Catechiste::getSections() as $key => $label)
            <option value="{{ $key }}">{{ $label }}</option>
            @endforeach
          </select>
          <button id="exportCatechistesBtn" class="btn btn-primary" style="display:none;">Exporter</button>
        </div>
      </div>
    </div>
  </div>
</div>

@if($anneeActive)
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h6 class="card-title">Année active</h6>
                <h3 class="mb-0">{{ $stats['annee'] }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h6 class="card-title">Total inscrits</h6>
                <h3 class="mb-0">{{ $stats['total_inscrits'] }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h6 class="card-title">Total classes</h6>
                <h3 class="mb-0">{{ $stats['total_classes'] }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-dark">
            <div class="card-body">
                <h6 class="card-title">Moyenne/classe</h6>
                <h3 class="mb-0">{{ $stats['total_classes'] > 0 ? round($stats['total_inscrits'] / $stats['total_classes'], 1) : 0 }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">Inscrits par niveau</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Niveau</th>
                            <th class="text-end">Inscrits</th>
                            <th class="text-end">%</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($stats['par_niveau'] as $niveau => $count)
                        <tr>
                            <td><strong>{{ $niveau }}</strong></td>
                            <td class="text-end"><strong>{{ $count }}</strong></td>
                            <td class="text-end">{{ $stats['total_inscrits'] > 0 ? round(($count / $stats['total_inscrits']) * 100, 1) : 0 }}%</td>
                        </tr>
                        @endforeach
                        <tr class="table-dark">
                            <td><strong>Total</strong></td>
                            <td class="text-end"><strong>{{ $stats['total_inscrits'] }}</strong></td>
                            <td class="text-end"><strong>100%</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">Détail des classes</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Niveau</th>
                                <th>Section</th>
                                <th>Catéchiste</th>
                                <th class="text-end">Inscrits</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($stats['classes'] as $classe)
                            <tr>
                                <td><strong>{!! $classe->niveau !!}{!! $classe->code ? " <span class='badge bg-primary'>{$classe->code}</span>" : '' !!}</strong></td>
                                <td>{{ \App\Models\ClasseCate::getSections()[$classe->section] ?? $classe->section }}</td>
                                <td>{{ $classe->catechistes->count() > 0 ? implode(', ', $classe->catechistes->map(fn ($c) => $c->nom . ' ' . $c->prenoms)->toArray()) : '—' }}</td>
                                <td class="text-end"><strong>{{ $classe->catechumenes()->count() }}</strong></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="alert alert-warning">
    <i class="bi bi-exclamation-triangle-fill me-2"></i>
    Aucune année catéchétique active. Veuillez <a href="{{ route('annees-catechetiques.create') }}" class="alert-link">créer une année catéchétique</a> pour voir les statistiques.
</div>
@endif

<div class="mt-4">
    <div class="card">
        <div class="card-header bg-white">
            <h5 class="card-title mb-0">Toutes les années catéchétiques</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Libellé</th>
                            <th>Date de début</th>
                            <th>Date de fin</th>
                            <th>Statut</th>
                            <th>Classes</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($annees as $annee)
                        <tr>
                            <td>{{ $annee->libelle }}</td>
                            <td>{{ $annee->date_debut->format('d/m/Y') }}</td>
                            <td>{{ $annee->date_fin->format('d/m/Y') }}</td>
                            <td>
                                @if($annee->statut === 'actif')
                                <span class="badge bg-success">Actif</span>
                                @else
                                <span class="badge bg-secondary">Clôturé</span>
                                @endif
                            </td>
                            <td>{{ $annee->classes()->count() }}</td>
                            <td>
                                <a href="{{ route('annees-catechetiques.edit', $annee->id) }}" class="btn btn-sm btn-outline-primary">Modifier</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Catéchumenes exports
const catechumenesType = document.getElementById('exportCatechumenesType');
const catechumenesClasse = document.getElementById('exportCatechumenesClasse');
const catechumenesAnnee = document.getElementById('exportCatechumenesAnnee');
const catechumenesBtn = document.getElementById('exportCatechumenesBtn');

catechumenesType.addEventListener('change', function() {
  const value = this.value;
  catechumenesClasse.style.display = 'none';
  catechumenesAnnee.style.display = 'none';
  catechumenesBtn.style.display = 'none';

  if (value.includes('par-classe')) {
    catechumenesClasse.style.display = 'block';
    catechumenesBtn.style.display = 'block';
  } else if (value.includes('par-annee')) {
    catechumenesAnnee.style.display = 'block';
    catechumenesBtn.style.display = 'block';
  }
});

catechumenesBtn.addEventListener('click', function() {
  const type = catechumenesType.value;
  if (!type) return;

  if (type.includes('par-classe')) {
    const classeId = catechumenesClasse.value;
    if (!classeId) return alert('Veuillez sélectionner une classe.');
    
    if (type.startsWith('pdf')) {
      window.location.href = '{{ route('catechumenes.export-pdf-par-classe') }}?classe_id=' + classeId;
    } else {
      window.location.href = '{{ route('catechumenes.export-word-par-classe') }}?classe_id=' + classeId;
    }
  } else if (type.includes('par-annee')) {
    const anneeId = catechumenesAnnee.value;
    if (!anneeId) return alert('Veuillez sélectionner une année.');
    
    if (type.startsWith('pdf')) {
      window.location.href = '{{ route('catechumenes.export-pdf-par-annee') }}?annee_id=' + anneeId;
    } else {
      window.location.href = '{{ route('catechumenes.export-word-par-annee') }}?annee_id=' + anneeId;
    }
  }
});

// Catéchistes exports
const catechistesType = document.getElementById('exportCatechistesType');
const catechistesClasse = document.getElementById('exportCatechistesClasse');
const catechistesAnnee = document.getElementById('exportCatechistesAnnee');
const catechistesSection = document.getElementById('exportCatechistesSection');
const catechistesBtn = document.getElementById('exportCatechistesBtn');

catechistesType.addEventListener('change', function() {
  const value = this.value;
  catechistesClasse.style.display = 'none';
  catechistesAnnee.style.display = 'none';
  catechistesSection.style.display = 'none';
  catechistesBtn.style.display = 'none';

  if (value.includes('par-classe')) {
    catechistesClasse.style.display = 'block';
    catechistesBtn.style.display = 'block';
  } else if (value.includes('par-annee')) {
    catechistesAnnee.style.display = 'block';
    catechistesBtn.style.display = 'block';
  } else if (value.includes('par-section')) {
    catechistesSection.style.display = 'block';
    catechistesBtn.style.display = 'block';
  }
});

catechistesBtn.addEventListener('click', function() {
  const type = catechistesType.value;
  if (!type) return;

  if (type.includes('par-classe')) {
    const classeId = catechistesClasse.value;
    if (!classeId) return alert('Veuillez sélectionner une classe.');
    
    if (type.startsWith('pdf')) {
      window.location.href = '{{ route('catechistes.export-pdf-par-classe') }}?classe_id=' + classeId;
    } else {
      window.location.href = '{{ route('catechistes.export-word-par-classe') }}?classe_id=' + classeId;
    }
  } else if (type.includes('par-annee')) {
    const anneeId = catechistesAnnee.value;
    if (!anneeId) return alert('Veuillez sélectionner une année.');
    
    if (type.startsWith('pdf')) {
      window.location.href = '{{ route('catechistes.export-pdf-par-annee') }}?annee_id=' + anneeId;
    } else {
      window.location.href = '{{ route('catechistes.export-word-par-annee') }}?annee_id=' + anneeId;
    }
  } else if (type.includes('par-section')) {
    const section = catechistesSection.value;
    if (!section) return alert('Veuillez sélectionner une section.');
    
    if (type.startsWith('pdf')) {
      window.location.href = '{{ route('catechistes.export-pdf-par-section') }}?section=' + section;
    } else {
      window.location.href = '{{ route('catechistes.export-word-par-section') }}?section=' + section;
    }
  }
});
</script>
@endpush
@endsection
