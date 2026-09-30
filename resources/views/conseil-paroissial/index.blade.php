@extends('layouts.paroisse')
@section('contenu')
<div class="d-flex justify-content-between mb-3"><h1 class="h3">Conseil paroissial</h1><div><a href="{{ route('conseil-paroissial.create') }}" class="btn btn-primary">+ Nouveau membre</a></div></div>
<div class="table-responsive"><table class="table table-striped bg-white align-middle"><thead><tr><th>Photo</th><th>Nom complet</th><th>Rôle</th><th>Téléphone</th><th>Email</th><th>Statut</th><th></th></tr></thead><tbody>
@forelse($membres as $m)<tr>
<td>@if($m->photo)<img src="{{ asset('storage/' . $m->photo) }}" class="rounded-circle" style="width:50px;height:50px;object-fit:cover;" alt="{{ $m->nom_complet }}">@else<div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center" style="width:50px;height:50px;color:#fff;">{{ mb_strtoupper(mb_substr($m->prenom, 0, 1)) }}</div>@endif</td>
<td><strong>{{ $m->nom_complet }}</strong></td>
<td><span class="badge text-bg-info">{{ $m->role }}</span></td>
<td>{{ $m->telephone }}</td>
<td>{{ $m->email }}</td>
<td><span class="badge {{ $m->actif ? 'text-bg-success' : 'text-bg-secondary' }}">{{ $m->actif ? 'Actif' : 'Inactif' }}</span></td>
<td class="text-end"><a href="{{ route('conseil-paroissial.edit', $m) }}" class="btn btn-sm btn-outline-primary">Modifier</a>
<form method="POST" action="{{ route('conseil-paroissial.destroy', $m) }}" class="d-inline" onsubmit="return confirm('Supprimer ce membre du conseil ?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Supprimer</button></form></td></tr>
@empty<tr><td colspan="7" class="text-center text-muted">Aucun membre du conseil.</td></tr>@endforelse</tbody></table></div>
@endsection
