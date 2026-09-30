@extends('layouts.paroisse')
@section('contenu')
<div class="d-flex justify-content-between mb-3"><h1 class="h3">Clergé</h1><div><a href="{{ route('clerge.create') }}" class="btn btn-primary">+ Nouveau membre</a></div></div>
<div class="table-responsive"><table class="table table-striped bg-white align-middle"><thead><tr><th>Photo</th><th>Nom complet</th><th>Rôle</th><th>Téléphone</th><th>Email</th><th>Statut</th><th></th></tr></thead><tbody>
@forelse($clerges as $c)<tr>
<td>@if($c->photo)<img src="{{ asset('storage/' . $c->photo) }}" class="rounded-circle" style="width:50px;height:50px;object-fit:cover;" alt="{{ $c->nom_complet }}">@else<div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center" style="width:50px;height:50px;color:#fff;">{{ mb_strtoupper(mb_substr($c->prenom, 0, 1)) }}</div>@endif</td>
<td><strong>{{ $c->nom_complet }}</strong></td>
<td><span class="badge text-bg-info">{{ \App\Models\Clerge::ROLES[$c->role] ?? $c->role }}</span></td>
<td>{{ $c->telephone }}</td>
<td>{{ $c->email }}</td>
<td><span class="badge {{ $c->actif ? 'text-bg-success' : 'text-bg-secondary' }}">{{ $c->actif ? 'Actif' : 'Inactif' }}</span></td>
<td class="text-end"><a href="{{ route('clerge.edit', $c) }}" class="btn btn-sm btn-outline-primary">Modifier</a>
<form method="POST" action="{{ route('clerge.destroy', $c) }}" class="d-inline" onsubmit="return confirm('Supprimer ce membre du clergé ?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Supprimer</button></form></td></tr>
@empty<tr><td colspan="7" class="text-center text-muted">Aucun membre du clergé.</td></tr>@endforelse</tbody></table></div>
@endsection
