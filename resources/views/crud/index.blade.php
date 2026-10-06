@extends('layouts.paroisse')
@section('contenu')
<div class="d-flex justify-content-between align-items-center mb-3"><h1 class="h3 mb-0">{{ $titre }}</h1><div><a href="{{ route($route.'.create') }}" class="btn btn-primary">+ Ajouter</a> @if($route === 'cebs')<a href="{{ route('cebs.pdf') }}" target="_blank" class="btn btn-outline-dark">Export PDF</a>@endif @if($route === 'catechumenes')
<a href="{{ route('catechese.dashboard') }}" class="btn btn-outline-secondary">Tableau de bord (Exports)</a>
@endif @if($route === 'catechistes')
<a href="{{ route('catechese.dashboard') }}" class="btn btn-outline-secondary">Tableau de bord (Exports)</a>
@endif</div></div>
@if($searchable)<form class="mb-3"><div class="input-group"><input name="q" value="{{ request('q') }}" class="form-control" placeholder="Rechercher…"><button class="btn btn-outline-secondary">OK</button></div></form>@endif
<div class="table-responsive"><table class="table table-striped bg-white align-middle"><thead><tr>@foreach($columns as $l => $c)<th>{{ $l }}</th>@endforeach<th></th></tr></thead><tbody>
@forelse($items as $item)<tr>
@foreach($columns as $c)@php $v = $c instanceof \Closure ? $c($item) : data_get($item, $c); if ($v instanceof \Carbon\Carbon) $v = $v->format($v->format('H:i') === '00:00' ? 'd/m/Y' : 'd/m/Y H:i'); @endphp<td>{!! $v !!}</td>@endforeach
<td class="text-end text-nowrap">
@foreach($controller->linksFor($item) as $l => $u)<a href="{{ $u }}" class="btn btn-sm btn-outline-secondary" @if(str_contains($l,'PDF')) target="_blank" @endif>{{ $l }}</a> @endforeach
@if($route === 'annonces' && $item->image)<a href="{{ asset('storage/' . $item->image) }}" target="_blank" class="btn btn-sm btn-outline-info" title="Voir l'image"><i class="bi bi-image"></i></a> @endif
<a href="{{ route($route.'.edit', $item->id) }}" class="btn btn-sm btn-outline-primary">Modifier</a>
<form method="POST" action="{{ route($route.'.destroy', $item->id) }}" class="d-inline" onsubmit="return confirm('Supprimer cet élément ?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Supprimer</button></form>
</td></tr>
@empty<tr><td colspan="{{ count($columns) + 1 }}" class="text-center text-muted">Aucun enregistrement.</td></tr>@endforelse</tbody></table></div>
{{ $items->links() }}
@endsection
