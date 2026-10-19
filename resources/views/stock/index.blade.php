@extends('layouts.paroisse')
@section('contenu')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">{{ $titre }}</h1>
    <div>
        <a href="{{ route('stock.dashboard') }}" class="btn btn-outline-secondary"><i class="bi bi-grid-fill"></i> Tableau de bord</a>
        <a href="{{ route('stock.rapport') }}" class="btn btn-outline-info"><i class="bi bi-file-earmark-bar-graph"></i> Rapports</a>
        <a href="{{ route('stock.produits.pdf') }}" target="_blank" class="btn btn-outline-success"><i class="bi bi-file-earmark-spreadsheet"></i> Inventaire</a>
        <a href="{{ route('stock.rapport.pdf') }}?vue=tout" target="_blank" class="btn btn-outline-danger"><i class="bi bi-file-earmark-pdf"></i> Mouvements</a>
        <a href="{{ route($route.'.create') }}" class="btn btn-primary">+ Ajouter un produit</a>
    </div>
</div>

@if($searchable)
<form class="mb-3">
    <div class="input-group">
        <input name="q" value="{{ request('q') }}" class="form-control" placeholder="Rechercher un produit…">
        <button class="btn btn-outline-secondary">OK</button>
    </div>
</form>
@endif

<!-- Alertes de stock bas -->
@if($items->contains(function($item) { return $item->estEnRupture(); }))
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <i class="bi bi-exclamation-triangle-fill"></i>
    <strong>Attention :</strong> Certains produits sont en stock bas (en dessous du seuil d'alerte).
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="table-responsive">
    <table class="table table-striped bg-white align-middle">
        <thead>
            <tr>
                @foreach($columns as $l => $c)
                    <th>{{ $l }}</th>
                @endforeach
                <th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $item)
                <tr>
                    @foreach($columns as $c)
                        @php
                            $v = $c instanceof \Closure ? $c($item) : data_get($item, $c);
                            if ($v instanceof \Carbon\Carbon) {
                                $v = $v->format($v->format('H:i') === '00:00' ? 'd/m/Y' : 'd/m/Y H:i');
                            }
                        @endphp
                        <td>{!! $v !!}</td>
                    @endforeach
                    <td class="text-end text-nowrap">
                        <!-- Boutons d'ajout/retrait rapide -->
                        <div class="btn-group mb-1">
                            <button type="button" class="btn btn-sm btn-outline-success dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="bi bi-plus"></i> Stock
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <form method="POST" action="{{ route('stock.add', $item->id) }}" class="px-3 py-2">
                                        @csrf
                                        <div class="mb-2">
                                            <input type="number" name="quantite" class="form-control form-control-sm" min="1" value="1" placeholder="Quantité" required>
                                        </div>
                                        <div class="mb-2">
                                            <input type="text" name="raison" class="form-control form-control-sm" placeholder="Raison (optionnel)">
                                        </div>
                                        <button type="submit" class="btn btn-success btn-sm w-100">Ajouter</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                        <div class="btn-group mb-1">
                            <button type="button" class="btn btn-sm btn-outline-warning dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="bi bi-dash"></i> Stock
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <form method="POST" action="{{ route('stock.remove', $item->id) }}" class="px-3 py-2">
                                        @csrf
                                        <div class="mb-2">
                                            <input type="number" name="quantite" class="form-control form-control-sm" min="1" value="1" placeholder="Quantité" required>
                                        </div>
                                        <div class="mb-2">
                                            <input type="text" name="raison" class="form-control form-control-sm" placeholder="Raison (optionnel)">
                                        </div>
                                        <button type="submit" class="btn btn-warning btn-sm w-100">Retirer</button>
                                    </form>
                                </li>
                            </ul>
                        </div>

                        <a href="{{ route($route.'.edit', $item->id) }}" class="btn btn-sm btn-outline-primary">Modifier</a>
                        <form method="POST" action="{{ route($route.'.destroy', $item->id) }}" class="d-inline" onsubmit="return confirm('Supprimer ce produit ?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($columns) + 1 }}" class="text-center text-muted">
                        Aucun produit enregistré.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{ $items->links() }}
@endsection
