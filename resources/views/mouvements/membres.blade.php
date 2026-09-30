@extends('layouts.paroisse')
@section('contenu')
<h1 class="h3 mb-3">Membres — {{ $mouvement->nom }}</h1>
<form method="POST" action="{{ route('mouvements.membres.ajouter', $mouvement) }}" class="row g-2 mb-3">@csrf
<div class="col-md-5"><select name="fidele_id" class="form-select" required><option value="">Choisir un fidèle…</option>@foreach($fideles as $id => $n)<option value="{{ $id }}">{{ $n }}</option>@endforeach</select></div>
<div class="col-md-4"><input name="fonction" class="form-control" placeholder="Fonction (Président, Choriste…)"></div><div class="col-md-3"><button class="btn btn-primary w-100">Ajouter</button></div></form>
<table class="table table-striped bg-white"><thead><tr><th>Nom</th><th>Fonction</th><th></th></tr></thead><tbody>
@forelse($mouvement->membres as $m)<tr><td>{{ $m->nom_complet }}</td><td>{{ $m->pivot->fonction }}</td><td class="text-end"><form method="POST" action="{{ route('mouvements.membres.retirer', [$mouvement, $m]) }}" onsubmit="return confirm('Retirer ce membre ?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Retirer</button></form></td></tr>
@empty<tr><td colspan="3" class="text-center text-muted">Aucun membre.</td></tr>@endforelse</tbody></table><a href="{{ route('mouvements.index') }}">← Retour</a>
@endsection
