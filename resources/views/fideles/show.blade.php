@extends('layouts.paroisse')
@section('contenu')
<div class="d-flex justify-content-between mb-3"><h1 class="h3">{{ $f->nom_complet }}</h1><a href="{{ route('fideles.edit', $f) }}" class="btn btn-outline-primary">Modifier</a></div>
<div class="row g-3"><div class="col-md-6"><div class="card"><div class="card-header">Identité</div><ul class="list-group list-group-flush">
<li class="list-group-item">Né(e) le : {{ $f->date_naissance?->format('d/m/Y') ?? '—' }} à {{ $f->lieu_naissance ?? '—' }}</li><li class="list-group-item">Téléphone : {{ $f->telephone ?? '—' }}</li>
<li class="list-group-item">Quartier : {{ $f->quartier ?? '—' }} · CEB : {{ $f->ceb?->nom ?? '—' }}</li><li class="list-group-item">Profession : {{ $f->profession ?? '—' }} · Statut : {{ $f->statut }}</li></ul></div></div>
<div class="col-md-6"><div class="card"><div class="card-header">Sacrements</div><ul class="list-group list-group-flush">
<li class="list-group-item">Baptisé : {{ $f->baptise ? '✓ Oui' : '✗ Non' }}</li>
<li class="list-group-item">Confirmé : {{ $f->confirme ? '✓ Oui' : '✗ Non' }}</li>
<li class="list-group-item">Marié : {{ $f->marie ? '✓ Oui' : '✗ Non' }}</li>
<li class="list-group-item">Baptême : @if($f->bapteme){{ $f->bapteme->date_bapteme->format('d/m/Y') }} — <a href="{{ route('baptemes.certificat', $f->bapteme) }}" target="_blank">certificat</a>@else <a href="{{ route('baptemes.create', $f) }}">à enregistrer</a>@endif</li>
@foreach($f->sacrements as $s)<li class="list-group-item">{{ \App\Models\Sacrement::TYPES[$s->type] ?? $s->type }} : {{ $s->date_celebration->format('d/m/Y') }} — <a href="{{ route('sacrements.certificat', $s) }}" target="_blank">certificat</a></li>@endforeach</ul></div>
<div class="card mt-3"><div class="card-header">Mouvements</div><ul class="list-group list-group-flush">@forelse($f->mouvements as $m)<li class="list-group-item">{{ $m->nom }} ({{ $m->pivot->fonction }})</li>@empty<li class="list-group-item text-muted">Aucun.</li>@endforelse</ul></div></div></div>
@endsection
