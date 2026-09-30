@extends('layouts.paroisse')
@section('contenu')
<div class="d-flex justify-content-between mb-3">
  <h1 class="h3">Finances</h1>
  <form class="d-flex gap-2">
    @if($mois === 'tout')
      <input type="hidden" name="vue" value="mois">
      <button type="submit" class="btn btn-outline-primary">Vue mensuelle</button>
    @else
      <input type="hidden" name="vue" value="tout">
      <button type="submit" class="btn btn-outline-success">Voir tout</button>
      <input type="month" name="mois" value="{{ $mois }}" class="form-control">
      <button type="submit" class="btn btn-outline-secondary">Voir mois</button>
    @endif
    <a class="btn btn-outline-dark text-nowrap" target="_blank" href="{{ route('finance.bilan', ['mois' => $mois]) }}">Bilan PDF</a>
  </form>
</div>

@if($mois === 'tout')
  <div class="alert alert-info">
    <strong>Vue globale de toutes les finances</strong>
  </div>
  <div class="row g-3 mb-4">
    <div class="col-md-4">
      <div class="card bg-success text-white">
        <div class="card-body">
          <h5 class="card-title">Total Recettes</h5>
          <h3 class="card-text">{{ number_format($rec->sum('montant'),0,',',' ') }} FCFA</h3>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card bg-danger text-white">
        <div class="card-body">
          <h5 class="card-title">Total Dépenses</h5>
          <h3 class="card-text">{{ number_format($dep->sum('montant'),0,',',' ') }} FCFA</h3>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card bg-dark text-white">
        <div class="card-body">
          <h5 class="card-title">Solde Global</h5>
          <h3 class="card-text">{{ number_format($rec->sum('montant') - $dep->sum('montant'),0,',',' ') }} FCFA</h3>
        </div>
      </div>
    </div>
  </div>
  <div class="row g-3 mb-4">
    <div class="col-md-4">
      <div class="card bg-light">
        <div class="card-body">
          <h6 class="card-title">Quêtes</h6>
          <p class="card-text">{{ number_format($rec->where('type', 'quete')->sum('montant'),0,',',' ') }} FCFA</p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card bg-light">
        <div class="card-body">
          <h6 class="card-title">Deniers du culte</h6>
          <p class="card-text">{{ number_format($rec->where('type', 'denier_culte')->sum('montant'),0,',',' ') }} FCFA</p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card bg-light">
        <div class="card-body">
          <h6 class="card-title">Dîmes</h6>
          <p class="card-text">{{ number_format($rec->where('type', 'dime')->sum('montant'),0,',',' ') }} FCFA</p>
        </div>
      </div>
    </div>
  </div>
  <div class="row g-3 mb-4">
    <div class="col-md-4">
      <div class="card bg-light">
        <div class="card-body">
          <h6 class="card-title">Dons</h6>
          <p class="card-text">{{ number_format($rec->where('type', 'don')->sum('montant'),0,',',' ') }} FCFA</p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card bg-light">
        <div class="card-body">
          <h6 class="card-title">Offrandes de messe</h6>
          <p class="card-text">{{ number_format($rec->where('type', 'offrande_messe')->sum('montant'),0,',',' ') }} FCFA</p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card bg-light">
        <div class="card-body">
          <h6 class="card-title">Autres recettes</h6>
          <p class="card-text">{{ number_format($rec->where('type', 'autre')->sum('montant'),0,',',' ') }} FCFA</p>
        </div>
      </div>
    </div>
  </div>
@else
  <div class="alert alert-dark">Solde du mois : <strong>{{ number_format($solde,0,',',' ') }} FCFA</strong></div>
@endif

<div class="row g-4">
<div class="col-lg-6"><h2 class="h5">Recettes ({{ number_format($rec->sum('montant'),0,',',' ') }})</h2>
<form method="POST" action="{{ route('finance.recettes.store') }}" class="row g-2 mb-2">@csrf
<div class="col-6"><input type="date" name="date" value="{{ now()->toDateString() }}" class="form-control"></div>
<div class="col-6"><select name="type" class="form-select">@foreach(\App\Models\Recette::TYPES as $k=>$l)<option value="{{ $k }}">{{ $l }}</option>@endforeach</select></div>
<div class="col-6"><input type="number" name="montant" min="1" placeholder="Montant" class="form-control" required></div>
<div class="col-6"><select name="fidele_id" class="form-select"><option value="">Donateur (facultatif)</option>@foreach($fideles as $id=>$n)<option value="{{ $id }}">{{ $n }}</option>@endforeach</select></div>
<div class="col-12"><input name="note" placeholder="Note" class="form-control"></div><div class="col-12"><button class="btn btn-success w-100">Ajouter la recette</button></div></form>
<div class="table-responsive"><table class="table table-sm bg-white"><thead><tr><th>Date</th><th>Type</th><th>Reçu</th><th class="text-end">Montant</th></tr></thead><tbody>@foreach($rec as $r)<tr><td>{{ $r->date->format('d/m/Y') }}</td><td>{{ \App\Models\Recette::TYPES[$r->type] ?? $r->type }}</td><td><a target="_blank" href="{{ route('finance.recu', $r) }}">{{ $r->recu_numero }}</a></td><td class="text-end">{{ number_format($r->montant,0,',',' ') }}</td></tr>@endforeach</tbody></table></div></div>
<div class="col-lg-6"><h2 class="h5">Dépenses ({{ number_format($dep->sum('montant'),0,',',' ') }})</h2>
<form method="POST" action="{{ route('finance.depenses.store') }}" class="row g-2 mb-2">@csrf
<div class="col-6"><input type="date" name="date" value="{{ now()->toDateString() }}" class="form-control"></div>
<div class="col-6"><select name="categorie" class="form-select">@foreach(\App\Models\Depense::CATEGORIES as $k=>$l)<option value="{{ $k }}">{{ $l }}</option>@endforeach</select></div>
<div class="col-6"><input name="libelle" placeholder="Libellé" class="form-control" required></div>
<div class="col-6"><input type="number" name="montant" min="1" placeholder="Montant" class="form-control" required></div><div class="col-12"><button class="btn btn-danger w-100">Ajouter la dépense</button></div></form>
<div class="table-responsive"><table class="table table-sm bg-white"><thead><tr><th>Date</th><th>Libellé</th><th class="text-end">Montant</th></tr></thead><tbody>@foreach($dep as $d)<tr><td>{{ $d->date->format('d/m/Y') }}</td><td>{{ $d->libelle }}</td><td class="text-end">{{ number_format($d->montant,0,',',' ') }}</td></tr>@endforeach</tbody></table></div></div>
</div>
@endsection
