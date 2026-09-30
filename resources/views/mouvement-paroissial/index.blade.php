@extends('layouts.paroisse')
@section('contenu')
<div class="d-flex justify-content-between mb-3"><h1 class="h3">Mouvements paroissiaux</h1><div><a href="{{ route('mouvement-paroissial.create') }}" class="btn btn-primary">+ Nouveau mouvement</a></div></div>
<div class="table-responsive"><table class="table table-striped bg-white align-middle"><thead><tr><th>Photo</th><th>Nom</th><th>Responsable</th><th>Téléphone</th><th>Statut</th><th></th></tr></thead><tbody>
@forelse($mouvements as $m)<tr>
<td>@if($m->photo)<img src="{{ asset('storage/' . $m->photo) }}" class="rounded" style="width:50px;height:50px;object-fit:cover;" alt="{{ $m->nom }}">@else<div class="rounded bg-secondary d-flex align-items-center justify-content-center" style="width:50px;height:50px;color:#fff;"><i class="bi {{ $m->icone }}"></i></div>@endif</td>
<td><strong>{{ $m->nom }}</strong></td>
<td>{{ $m->responsable }}</td>
<td>{{ $m->telephone_responsable }}</td>
<td><span class="badge {{ $m->actif ? 'text-bg-success' : 'text-bg-secondary' }}">{{ $m->actif ? 'Actif' : 'Inactif' }}</span></td>
<td class="text-end"><a href="{{ route('mouvement-paroissial.edit', $m) }}" class="btn btn-sm btn-outline-primary">Modifier</a>
<form method="POST" action="{{ route('mouvement-paroissial.destroy', $m) }}" class="d-inline" onsubmit="return confirm('Supprimer ce mouvement ?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Supprimer</button></form></td></tr>
@empty<tr><td colspan="6" class="text-center text-muted">Aucun mouvement paroissial.</td></tr>@endforelse</tbody></table></div>
@endsection
