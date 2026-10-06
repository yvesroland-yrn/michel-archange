@extends('layouts.paroisse')
@section('contenu')
<div class="d-flex justify-content-between mb-3">
  <h1 class="h3">Denier du Culte</h1>
  <form class="d-flex gap-2">
    @if($mois)
      <input type="hidden" name="mois" value="{{ $mois }}">
      <a href="{{ route('deniers-culte.index') }}" class="btn btn-outline-success">Voir tout</a>
      <input type="month" name="mois" value="{{ $mois }}" class="form-control">
      <button type="submit" class="btn btn-outline-secondary">Voir mois</button>
    @else
      <input type="month" name="mois" value="{{ now()->format('Y-m') }}" class="form-control">
      <button type="submit" class="btn btn-outline-primary">Filtrer par mois</button>
    @endif
    <a class="btn btn-outline-dark" href="{{ route('fideles.index') }}">Retour aux fidèles</a>
    <a class="btn btn-outline-primary" target="_blank" href="{{ route('deniers-culte.export-pdf', ['mois' => $mois]) }}">Export PDF</a>
  </form>
</div>

<div class="alert alert-secondary">
  <strong>Total du denier du culte{{ $mois ? ' pour ' . $mois : '' }} : {{ number_format($total,0,',',' ') }} FCFA</strong>
</div>

<div class="mb-3">
  <form method="GET" class="d-flex gap-2">
    @if($mois)
      <input type="hidden" name="mois" value="{{ $mois }}">
    @endif
    <input type="text" name="q" value="{{ request('q') }}" placeholder="Rechercher par nom, numéro de carnet de baptême..." class="form-control">
    <button type="submit" class="btn btn-primary">Rechercher</button>
    @if(request('q'))
      <a href="{{ route('deniers-culte.index', ['mois' => $mois]) }}" class="btn btn-outline-secondary">Effacer</a>
    @endif
  </form>
</div>

<div class="row g-4">
<div class="col-lg-12">
  <h2 class="h5">Enregistrer un denier du culte</h2>
  <form method="POST" action="{{ route('deniers-culte.store') }}" class="row g-2 mb-4">@csrf
  <div class="col-6"><input type="date" name="date_paiement" value="{{ now()->toDateString() }}" class="form-control" required></div>
  <div class="col-6"><input type="number" name="montant" min="1" placeholder="Montant (FCFA)" class="form-control" required></div>
  <div class="col-6"><select name="periode" class="form-select" required>@foreach(\App\Models\DenierCulte::getPeriodes() as $key => $label)<option value="{{ $key }}">{{ $label }}</option>@endforeach</select></div>
  <div class="col-6"><select name="fidele_id" class="form-select" id="fidele-select"><option value="">Fidèle (facultatif)</option>@foreach($fideles as $id=>$n)<option value="{{ $id }}">{{ $n }}</option>@endforeach</select></div>
  <div class="col-12"><input name="donateur_nom" id="donateur-nom" placeholder="Nom du donateur (si non fidèle)" class="form-control"></div>
  <div class="col-12"><input name="numero_carnet_bapteme" id="numero-carnet-bapteme" placeholder="Numéro de carnet de baptême" class="form-control"></div>
  <div class="col-12"><input name="note" placeholder="Note (facultatif)" class="form-control"></div>
  <div class="col-12"><button class="btn btn-secondary w-100">Ajouter le denier du culte</button></div></form>

  <h2 class="h5">Liste des deniers du culte ({{ number_format($total,0,',',' ') }} FCFA)</h2>
  <div class="table-responsive"><table class="table table-sm bg-white"><thead><tr><th>Date</th><th>Période</th><th>Donateur</th><th>N° Carnet Baptême</th><th>Note</th><th class="text-end">Montant</th><th>Actions</th></tr></thead><tbody>@forelse($deniers as $d)<tr><td>{{ $d->date_paiement->format('d/m/Y') }}</td><td>{{ \App\Models\DenierCulte::getPeriodes()[$d->periode] ?? $d->periode }}</td><td>{{ $d->fidele ? $d->fidele->nom_complet : $d->donateur_nom }}</td><td>{{ $d->numero_carnet_bapteme ?? '-' }}</td><td>{{ $d->note ?? '-' }}</td><td class="text-end">{{ number_format($d->montant,0,',',' ') }}</td><td><a target="_blank" href="{{ route('deniers-culte.recu', $d) }}" class="btn btn-sm btn-outline-secondary">Reçu</a> <form method="POST" action="{{ route('deniers-culte.destroy', $d) }}" class="d-inline" onsubmit="return confirm('Supprimer ce denier du culte ?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Supprimer</button></form></td></tr>@empty<tr><td colspan="7" class="text-center text-muted">Aucun denier du culte enregistré.</td></tr>@endforelse</tbody></table></div>
  {{ $deniers->links() }}

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fideleSelect = document.getElementById('fidele-select');
    const donateurNom = document.getElementById('donateur-nom');
    const numeroCarnet = document.getElementById('numero-carnet-bapteme');

    if (fideleSelect && donateurNom) {
        fideleSelect.addEventListener('change', function() {
            if (this.value) {
                donateurNom.value = '';
            }
        });

        donateurNom.addEventListener('input', function() {
            if (this.value) {
                fideleSelect.value = '';
            }
        });
    }
});
</script>
</div>
</div>
@endsection
