@extends('layouts.paroisse')
@section('contenu')
<div class="d-flex justify-content-between mb-3"><h1 class="h3">Fidèles</h1><div><a href="{{ route('fideles.export') }}" class="btn btn-outline-secondary">Export CSV</a> <a href="{{ route('fideles.create') }}" class="btn btn-primary">+ Nouveau fidèle</a></div></div>
<form class="row g-2 mb-3"><div class="col-md-5"><input name="q" value="{{ request('q') }}" class="form-control" placeholder="Nom, prénoms ou téléphone"></div>
<div class="col-md-4"><select name="ceb_id" class="form-select"><option value="">Toutes les CEB</option>@foreach($cebs as $c)<option value="{{ $c->id }}" @selected(request('ceb_id')==$c->id)>{{ $c->nom }}</option>@endforeach</select></div>
<div class="col-md-3"><button class="btn btn-outline-secondary w-100">Rechercher</button></div></form>
<div class="table-responsive"><table class="table table-striped bg-white align-middle"><thead><tr><th>Nom</th><th>Téléphone</th><th>CEB</th><th>Baptisé</th><th>Confirmé</th><th>Marié</th><th>Statut</th><th></th></tr></thead><tbody>
@forelse($fideles as $f)<tr><td>{{ $f->nom_complet }}</td><td>{{ $f->telephone }}</td><td>{{ $f->ceb?->nom }}</td>
<td>{{ $f->baptise ? '✓' : '✗' }}</td><td>{{ $f->confirme ? '✓' : '✗' }}</td><td>{{ $f->marie ? '✓' : '✗' }}</td>
<td><span class="badge text-bg-secondary">{{ $f->statut }}</span></td>
<td class="text-end"><a href="{{ route('fideles.show', $f) }}" class="btn btn-sm btn-outline-info" title="Voir détails"><i class="bi bi-folder"></i></a>
<a href="{{ route('fideles.edit', $f) }}" class="btn btn-sm btn-outline-primary">Modifier</a>
<form method="POST" action="{{ route('fideles.destroy', $f) }}" class="d-inline" onsubmit="return confirm('Supprimer ce fidèle ?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Supprimer</button></form></td></tr>
@empty<tr><td colspan="8" class="text-center text-muted">Aucun fidèle.</td></tr>@endforelse</tbody></table></div>{{ $fideles->links() }}
@endsection
