@extends('layouts.paroisse')
@section('contenu')
<div class="d-flex justify-content-between mb-3">
  <h1 class="h3">Dîmes</h1>
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
    <a class="btn btn-outline-dark text-nowrap" href="{{ route('finance.index') }}">Retour aux finances</a>
    <a class="btn btn-outline-primary text-nowrap" target="_blank" href="{{ route('finance.bilan', ['mois' => $mois, 'category' => 'dime']) }}">Export PDF</a>
  </form>
</div>

<div class="alert alert-success">
  <strong>Total des dîmes : {{ number_format($solde,0,',',' ') }} FCFA</strong>
</div>

<div class="row g-4">
<div class="col-lg-12">
  <h2 class="h5">Enregistrer une dîme</h2>
  <form method="POST" action="{{ route('finance.recettes.store') }}" class="row g-2 mb-4">@csrf
  <div class="col-6"><input type="date" name="date" value="{{ now()->toDateString() }}" class="form-control"></div>
  <div class="col-6">
    <select name="type" class="form-select">
      <option value="dime" selected>Dîme</option>
    </select>
  </div>
  <div class="col-6"><input type="number" name="montant" min="1" placeholder="Montant" class="form-control" required></div>
  <div class="col-6"><select name="fidele_id" class="form-select" id="fidele-select"><option value="">Donateur (facultatif)</option>@foreach($fideles as $id=>$n)<option value="{{ $id }}">{{ $n }}</option>@endforeach</select></div>
  <div class="col-12"><input name="donateur_nom" id="donateur-nom" placeholder="Nom du donateur (si non fidèle)" class="form-control"></div>
  <div class="col-12"><input name="note" placeholder="Note (nature de la dîme)" class="form-control"></div><div class="col-12"><button class="btn btn-success w-100">Ajouter la dîme</button></div></form>

  <h2 class="h5">Liste des dîmes ({{ number_format($rec->sum('montant'),0,',',' ') }} FCFA)</h2>
  <div class="table-responsive"><table class="table table-sm bg-white"><thead><tr><th>Date</th><th>Type</th><th>Reçu</th><th>Donateur</th><th>Note</th><th class="text-end">Montant</th></tr></thead><tbody>@foreach($rec as $r)<tr><td>{{ $r->date->format('d/m/Y') }}</td><td>{{ \App\Models\Recette::TYPES[$r->type] ?? $r->type }}</td><td><a target="_blank" href="{{ route('finance.recu', $r) }}">{{ $r->recu_numero }}</a></td><td>{{ $r->donateur_nom }}</td><td>{{ $r->note ?? '-' }}</td><td class="text-end">{{ number_format($r->montant,0,',',' ') }}</td></tr>@endforeach</tbody></table></div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fideleSelect = document.getElementById('fidele-select');
    const donateurNom = document.getElementById('donateur-nom');

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