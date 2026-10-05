@extends('layouts.paroisse')
@section('contenu')
<h1 class="h3 mb-1">Acte de baptême</h1><p class="text-muted">{{ $fidele->nom_complet }} — n° {{ $numero }}</p>
<form method="POST" action="{{ route('baptemes.store', $fidele) }}" class="card card-body row g-3 mx-0">@csrf
@foreach(['date_bapteme'=>'Date du baptême','lieu'=>'Lieu','ministre'=>'Ministre (célébrant)','parrain'=>'Parrain','marraine'=>'Marraine','pere'=>'Père','mere'=>'Mère','numero_carnet_bapteme'=>'Numéro de carnet de baptême'] as $k=>$l)
<div class="col-md-6"><label class="form-label">{{ $l }}</label><input @if($k=='date_bapteme') type="date" @endif name="{{ $k }}" value="{{ old($k) }}" class="form-control"></div>@endforeach
<div class="col-12"><button class="btn btn-primary">Enregistrer</button> <a href="{{ route('fideles.index') }}" class="btn btn-link">Annuler</a></div></form>
@endsection
