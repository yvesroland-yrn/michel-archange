@extends('layouts.paroisse')
@section('contenu')
<div class="d-flex justify-content-between mb-3">
  <h1 class="h3">Casuel</h1>
  <form class="d-flex gap-2">
    @if($mois)
      <input type="hidden" name="mois" value="{{ $mois }}">
      <a href="{{ route('casuels.index', ['type' => $type]) }}" class="btn btn-outline-success">Voir tout</a>
      <input type="month" name="mois" value="{{ $mois }}" class="form-control">
      <button type="submit" class="btn btn-outline-secondary">Voir mois</button>
    @else
      <input type="month" name="mois" value="{{ now()->format('Y-m') }}" class="form-control">
      <button type="submit" class="btn btn-outline-primary">Filtrer par mois</button>
    @endif
    <a class="btn btn-outline-dark" href="{{ route('fideles.index') }}">Retour aux fidèles</a>
    <a class="btn btn-outline-primary" target="_blank" href="{{ route('casuels.export-pdf', ['type' => $type, 'mois' => $mois]) }}">Export PDF</a>
  </form>
</div>

<!-- Type selection buttons -->
<div class="card mb-4">
  <div class="card-body">
    <div class="btn-group" role="group">
      <a href="{{ route('casuels.index', ['type' => 'bapteme']) }}" class="btn {{ $type === 'bapteme' ? 'btn-primary' : 'btn-outline-primary' }}">
        <i class="bi bi-droplet-half"></i> Baptême
      </a>
      <a href="{{ route('casuels.index', ['type' => 'confirmation']) }}" class="btn {{ $type === 'confirmation' ? 'btn-primary' : 'btn-outline-primary' }}">
        <i class="bi bi-cross"></i> Confirmation
      </a>
      <a href="{{ route('casuels.index', ['type' => 'mariage']) }}" class="btn {{ $type === 'mariage' ? 'btn-primary' : 'btn-outline-primary' }}">
        <i class="bi bi-heart"></i> Mariage
      </a>
      <a href="{{ route('casuels.index', ['type' => 'deces']) }}" class="btn {{ $type === 'deces' ? 'btn-primary' : 'btn-outline-primary' }}">
        <i class="bi bi-cross"></i> Décès
      </a>
    </div>
  </div>
</div>

<div class="alert alert-secondary">
  <strong>Total des {{ \App\Models\Casuel::getTypes()[$type] ?? $type }}{{ $mois ? ' pour ' . $mois : '' }} : {{ number_format($total,0,',',' ') }} FCFA</strong>
</div>

<div class="mb-3">
  <form method="GET" class="d-flex gap-2">
    <input type="hidden" name="type" value="{{ $type }}">
    @if($mois)
      <input type="hidden" name="mois" value="{{ $mois }}">
    @endif
    <input type="text" name="q" value="{{ request('q') }}" placeholder="Rechercher par nom, numéro..." class="form-control">
    <button type="submit" class="btn btn-primary">Rechercher</button>
    @if(request('q'))
      <a href="{{ route('casuels.index', ['type' => $type, 'mois' => $mois]) }}" class="btn btn-outline-secondary">Effacer</a>
    @endif
  </form>
</div>

<div class="row g-4">
<div class="col-lg-12">
  <h2 class="h5">Enregistrer un {{ \App\Models\Casuel::getTypes()[$type] ?? $type }}</h2>
  <form method="POST" action="{{ route('casuels.store') }}" class="row g-2 mb-4">@csrf
  <input type="hidden" name="type" value="{{ $type }}">
  <div class="col-6"><input type="date" name="date_paiement" value="{{ now()->toDateString() }}" class="form-control" required></div>
  <div class="col-6"><input type="number" name="montant" min="1" placeholder="Montant (FCFA)" class="form-control" required></div>

  <div class="col-12"><hr><strong>Personne 1</strong></div>
  <div class="col-6"><select name="fidele_id" class="form-select" id="fidele-select"><option value="">Fidèle existant (facultatif)</option>@foreach($fideles as $id=>$n)<option value="{{ $id }}">{{ $n }}</option>@endforeach</select></div>
  <div class="col-6"><input name="numero" id="numero" placeholder="Numéro de référence" class="form-control"></div>
  <div class="col-12"><input name="nom" id="nom" placeholder="Nom (si non fidèle)" class="form-control"></div>
  <div class="col-12"><input name="prenoms" id="prenoms" placeholder="Prénoms (si non fidèle)" class="form-control"></div>
  <div class="col-6"><input type="date" name="date_naissance" id="date_naissance" placeholder="Date de naissance" class="form-control"></div>
  <div class="col-6"><input name="profession" id="profession" placeholder="Profession (facultatif)" class="form-control"></div>

  @if($type === 'mariage')
  <div class="col-12"><hr><strong>Personne 2 (Époux/se)</strong></div>
  <div class="col-6"><select name="fidele_id_2" class="form-select" id="fidele-select-2"><option value="">Fidèle existant (facultatif)</option>@foreach($fideles as $id=>$n)<option value="{{ $id }}">{{ $n }}</option>@endforeach</select></div>
  <div class="col-12"><input name="nom_2" id="nom_2" placeholder="Nom (si non fidèle)" class="form-control"></div>
  <div class="col-12"><input name="prenoms_2" id="prenoms_2" placeholder="Prénoms (si non fidèle)" class="form-control"></div>
  <div class="col-6"><input type="date" name="date_naissance_2" id="date_naissance_2" placeholder="Date de naissance" class="form-control"></div>
  <div class="col-6"><input name="profession_2" id="profession_2" placeholder="Profession (facultatif)" class="form-control"></div>
  @endif

  <div class="col-12"><input name="note" placeholder="Note (facultatif)" class="form-control"></div>
  <div class="col-12"><button class="btn btn-secondary w-100">Ajouter le {{ \App\Models\Casuel::getTypes()[$type] ?? $type }}</button></div></form>

  <h2 class="h5">Liste des {{ \App\Models\Casuel::getTypes()[$type] ?? $type }} ({{ number_format($total,0,',',' ') }} FCFA)</h2>
  <div class="table-responsive"><table class="table table-sm bg-white"><thead><tr><th>Date</th><th>Personne(s)</th><th>N° Référence</th><th>Profession</th><th>Note</th><th class="text-end">Montant</th><th>Actions</th></tr></thead><tbody>@forelse($casuels as $c)<tr><td>{{ $c->date_paiement->format('d/m/Y') }}</td><td>{{ $c->fidele ? $c->fidele->nom_complet : ($c->nom . ' ' . $c->prenoms) }}@if($c->type === 'mariage' && ($c->fidele2 || $c->nom_2))<br><small>&amp; {{ $c->fidele2 ? $c->fidele2->nom_complet : ($c->nom_2 . ' ' . $c->prenoms_2) }}</small>@endif</td><td>{{ $c->numero ?? '-' }}</td><td>{{ $c->profession ?? '-' }}</td><td>{{ $c->note ?? '-' }}</td><td class="text-end">{{ number_format($c->montant,0,',',' ') }}</td><td><a target="_blank" href="{{ route('casuels.recu', $c) }}" class="btn btn-sm btn-outline-secondary">Reçu</a> <form method="POST" action="{{ route('casuels.destroy', $c) }}" class="d-inline" onsubmit="return confirm('Supprimer ce casuel ?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Supprimer</button></form></td></tr>@empty<tr><td colspan="7" class="text-center text-muted">Aucun {{ \App\Models\Casuel::getTypes()[$type] ?? $type }} enregistré.</td></tr>@endforelse</tbody></table></div>
  {{ $casuels->links() }}

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fideleSelect = document.getElementById('fidele-select');
    const nom = document.getElementById('nom');
    const prenoms = document.getElementById('prenoms');
    const dateNaissance = document.getElementById('date_naissance');
    const profession = document.getElementById('profession');

    if (fideleSelect && nom) {
        fideleSelect.addEventListener('change', function() {
            if (this.value) {
                nom.value = '';
                prenoms.value = '';
                dateNaissance.value = '';
                profession.value = '';
            }
        });

        nom.addEventListener('input', function() {
            if (this.value) {
                fideleSelect.value = '';
            }
        });

        prenoms.addEventListener('input', function() {
            if (this.value) {
                fideleSelect.value = '';
            }
        });
    }

    // Pour la deuxième personne (mariage)
    const fideleSelect2 = document.getElementById('fidele-select-2');
    const nom2 = document.getElementById('nom_2');
    const prenoms2 = document.getElementById('prenoms_2');
    const dateNaissance2 = document.getElementById('date_naissance_2');
    const profession2 = document.getElementById('profession_2');

    if (fideleSelect2 && nom2) {
        fideleSelect2.addEventListener('change', function() {
            if (this.value) {
                nom2.value = '';
                prenoms2.value = '';
                dateNaissance2.value = '';
                profession2.value = '';
            }
        });

        nom2.addEventListener('input', function() {
            if (this.value) {
                fideleSelect2.value = '';
            }
        });

        prenoms2.addEventListener('input', function() {
            if (this.value) {
                fideleSelect2.value = '';
            }
        });
    }
});
</script>
</div>
</div>
@endsection
