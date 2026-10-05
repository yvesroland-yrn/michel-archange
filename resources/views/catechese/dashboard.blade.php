@extends('layouts.paroisse')
@section('contenu')
<h1 class="h3 mb-4">Tableau de bord Catéchèse</h1>

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
                                <td>{{ $classe->catechiste ? $classe->catechiste->nom . ' ' . $classe->catechiste->prenoms : '—' }}</td>
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
@endsection
