@extends('layouts.paroisse')
@section('contenu')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Tirage des Intentions de Messe</h1>
    <div class="d-flex gap-2 flex-wrap">
        <form method="GET" action="{{ route('intentions.tirage') }}" class="d-flex gap-2">
            <input type="text" name="semaine" value="{{ $numeroSemaine }}"
                   placeholder="Format: 2026-W40" class="form-control" style="width: 120px;">
            <button type="submit" class="btn btn-outline-primary">Changer semaine</button>
        </form>
        <a href="{{ route('intentions.liste', ['semaine' => $numeroSemaine]) }}"
           class="btn btn-outline-success">
            <i class="bi bi-file-earmark-pdf"></i> Imprimer la liste
        </a>
        <div class="dropdown">
            <button class="btn btn-outline-warning dropdown-toggle" type="button" data-bs-toggle="dropdown">
                <i class="bi bi-download"></i> Exporter
            </button>
            <ul class="dropdown-menu">
                <li><h6 class="dropdown-header">Format CSV</h6></li>
                <li>
                    <a class="dropdown-item" href="{{ route('intentions.export', ['semaine' => $numeroSemaine, 'type' => 'tous']) }}">
                        <i class="bi bi-filetype-csv"></i> Toutes (CSV)
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('intentions.export', ['semaine' => $numeroSemaine, 'type' => 'action_grace']) }}">
                        <i class="bi bi-filetype-csv"></i> Actions de grâce (CSV)
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('intentions.export', ['semaine' => $numeroSemaine, 'type' => 'repos_eternel']) }}">
                        <i class="bi bi-filetype-csv"></i> Repos éternel (CSV)
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li><h6 class="dropdown-header">Format PDF</h6></li>
                <li>
                    <a class="dropdown-item" href="{{ route('intentions.export-pdf', ['semaine' => $numeroSemaine, 'type' => 'tous']) }}">
                        <i class="bi bi-filetype-pdf"></i> Toutes (PDF)
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('intentions.export-pdf', ['semaine' => $numeroSemaine, 'type' => 'action_grace']) }}">
                        <i class="bi bi-filetype-pdf"></i> Actions de grâce (PDF)
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('intentions.export-pdf', ['semaine' => $numeroSemaine, 'type' => 'repos_eternel']) }}">
                        <i class="bi bi-filetype-pdf"></i> Repos éternel (PDF)
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li><h6 class="dropdown-header">Format Word</h6></li>
                <li>
                    <a class="dropdown-item" href="{{ route('intentions.export-word', ['semaine' => $numeroSemaine, 'type' => 'tous']) }}">
                        <i class="bi bi-filetype-docx"></i> Toutes (Word)
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('intentions.export-word', ['semaine' => $numeroSemaine, 'type' => 'action_grace']) }}">
                        <i class="bi bi-filetype-docx"></i> Actions de grâce (Word)
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('intentions.export-word', ['semaine' => $numeroSemaine, 'type' => 'repos_eternel']) }}">
                        <i class="bi bi-filetype-docx"></i> Repos éternel (Word)
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="alert alert-info">
    <i class="bi bi-info-circle"></i>
    <strong>Semaine {{ $numeroSemaine }}</strong> - 
    Les intentions en attente seront réparties entre le samedi et le dimanche.
</div>

<!-- Intentions en attente -->
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="bi bi-clock-history"></i> Intentions en attente ({{ $intentionsEnAttente->count() }})
        </h5>
        @if($intentionsEnAttente->count() > 0)
            <form method="POST" action="{{ route('intentions.effectuer-tirage') }}">
                @csrf
                <input type="hidden" name="semaine" value="{{ $numeroSemaine }}">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-shuffle"></i> Effectuer le tirage
                </button>
            </form>
        @endif
    </div>
    <div class="card-body">
        @if($intentionsEnAttente->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Reçu</th>
                            <th>Demandeur</th>
                            <th>Type</th>
                            <th>Intention</th>
                            <th>Offrande</th>
                            <th>Date souhaitée</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($intentionsEnAttente as $intention)
                            <tr>
                                <td><code>{{ $intention->recu_numero }}</code></td>
                                <td>{{ $intention->demandeur }}</td>
                                <td>
                                    <span class="badge bg-{{ $intention->type === 'action_grace' ? 'success' : ($intention->type === 'repos_eternel' ? 'dark' : 'secondary') }}">
                                        {{ $intention->type_libelle }}
                                    </span>
                                </td>
                                <td>{{ str($intention->intention)->limit(60) }}</td>
                                <td>{{ number_format($intention->offrande, 0, ',', ' ') }} FCFA</td>
                                <td>{{ $intention->date_messe ? $intention->date_messe->format('d/m/Y') : '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-muted text-center py-4">Aucune intention en attente pour cette semaine.</p>
        @endif
    </div>
</div>

<!-- Intentions tirées -->
@if($intentionsTirees->count() > 0)
<div class="row">
    <!-- Samedi -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">
                    <i class="bi bi-calendar-week"></i> Samedi ({{ $samediIntentions->count() }})
                </h5>
            </div>
            <div class="card-body">
                @if($samediIntentions->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Demandeur</th>
                                    <th>Type</th>
                                    <th>Intention</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($samediIntentions as $intention)
                                    <tr>
                                        <td>{{ $intention->demandeur }}</td>
                                        <td>
                                            <span class="badge bg-{{ $intention->type === 'action_grace' ? 'success' : ($intention->type === 'repos_eternel' ? 'dark' : 'secondary') }}">
                                                {{ $intention->type_libelle }}
                                            </span>
                                        </td>
                                        <td>{{ str($intention->intention)->limit(40) }}</td>
                                        <td>
                                            @if($intention->statut === 'tiree')
                                                <a href="{{ route('intentions.celebrer', $intention->id) }}" 
                                                   class="btn btn-sm btn-outline-success">
                                                    <i class="bi bi-check-circle"></i> Célébrer
                                                </a>
                                            @else
                                                <span class="badge bg-success">Célébrée</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted text-center py-3">Aucune intention pour le samedi.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Dimanche -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="bi bi-calendar-week"></i> Dimanche ({{ $dimancheIntentions->count() }})
                </h5>
            </div>
            <div class="card-body">
                @if($dimancheIntentions->count() > 0)
                    @php
                        $dimanche7h = $dimancheIntentions->where('jour_messe_detaille', 'dimanche_7h');
                        $dimanche9h = $dimancheIntentions->where('jour_messe_detaille', 'dimanche_9h');
                        $dimancheAutre = $dimancheIntentions->whereNotIn('jour_messe_detaille', ['dimanche_7h', 'dimanche_9h']);
                    @endphp
                    @if($dimanche7h->count() > 0)
                        <h6 class="text-primary mb-2"><strong>Dimanche 7h ({{ $dimanche7h->count() }})</strong></h6>
                        <div class="table-responsive mb-3">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Demandeur</th>
                                        <th>Type</th>
                                        <th>Intention</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($dimanche7h as $intention)
                                        <tr>
                                            <td>{{ $intention->demandeur }}</td>
                                            <td>
                                                <span class="badge bg-{{ $intention->type === 'action_grace' ? 'success' : ($intention->type === 'repos_eternel' ? 'dark' : 'secondary') }}">
                                                    {{ $intention->type_libelle }}
                                                </span>
                                            </td>
                                            <td>{{ str($intention->intention)->limit(40) }}</td>
                                            <td>
                                                @if($intention->statut === 'tiree')
                                                    <a href="{{ route('intentions.celebrer', $intention->id) }}"
                                                       class="btn btn-sm btn-outline-success">
                                                        <i class="bi bi-check-circle"></i> Célébrer
                                                    </a>
                                                @else
                                                    <span class="badge bg-success">Célébrée</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                    @if($dimanche9h->count() > 0)
                        <h6 class="text-primary mb-2"><strong>Dimanche 9h ({{ $dimanche9h->count() }})</strong></h6>
                        <div class="table-responsive mb-3">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Demandeur</th>
                                        <th>Type</th>
                                        <th>Intention</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($dimanche9h as $intention)
                                        <tr>
                                            <td>{{ $intention->demandeur }}</td>
                                            <td>
                                                <span class="badge bg-{{ $intention->type === 'action_grace' ? 'success' : ($intention->type === 'repos_eternel' ? 'dark' : 'secondary') }}">
                                                    {{ $intention->type_libelle }}
                                                </span>
                                            </td>
                                            <td>{{ str($intention->intention)->limit(40) }}</td>
                                            <td>
                                                @if($intention->statut === 'tiree')
                                                    <a href="{{ route('intentions.celebrer', $intention->id) }}"
                                                       class="btn btn-sm btn-outline-success">
                                                        <i class="bi bi-check-circle"></i> Célébrer
                                                    </a>
                                                @else
                                                    <span class="badge bg-success">Célébrée</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                    @if($dimancheAutre->count() > 0)
                        <h6 class="text-primary mb-2"><strong>Autre ({{ $dimancheAutre->count() }})</strong></h6>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Demandeur</th>
                                        <th>Type</th>
                                        <th>Intention</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($dimancheAutre as $intention)
                                        <tr>
                                            <td>{{ $intention->demandeur }}</td>
                                            <td>
                                                <span class="badge bg-{{ $intention->type === 'action_grace' ? 'success' : ($intention->type === 'repos_eternel' ? 'dark' : 'secondary') }}">
                                                    {{ $intention->type_libelle }}
                                                </span>
                                            </td>
                                            <td>{{ str($intention->intention)->limit(40) }}</td>
                                            <td>
                                                @if($intention->statut === 'tiree')
                                                    <a href="{{ route('intentions.celebrer', $intention->id) }}"
                                                       class="btn btn-sm btn-outline-success">
                                                        <i class="bi bi-check-circle"></i> Célébrer
                                                    </a>
                                                @else
                                                    <span class="badge bg-success">Célébrée</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                @else
                    <p class="text-muted text-center py-3">Aucune intention pour le dimanche.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endif

@endsection
