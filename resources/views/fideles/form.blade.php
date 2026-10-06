@extends('layouts.paroisse')
@section('contenu')
<h1 class="h3 mb-3">{{ $fidele->exists ? 'Modifier' : 'Nouveau' }} fidèle</h1>
<form method="POST" action="{{ $fidele->exists ? route('fideles.update', $fidele) : route('fideles.store') }}" class="card card-body row g-3 mx-0">
@csrf @if($fidele->exists) @method('PUT') @endif
@php $champs = ['nom'=>'Nom','prenoms'=>'Prénoms','lieu_naissance'=>'Lieu de naissance','telephone'=>'Téléphone','email'=>'E-mail','profession'=>'Profession','quartier'=>'Quartier','situation_matrimoniale'=>'Situation matrimoniale']; @endphp
@foreach($champs as $k => $l)<div class="col-md-6"><label class="form-label">{{ $l }}</label><input name="{{ $k }}" value="{{ old($k, $fidele->$k) }}" class="form-control"></div>@endforeach
<div class="col-md-4"><label class="form-label">Sexe</label><select name="sexe" class="form-select">@foreach(['M'=>'Masculin','F'=>'Féminin'] as $k=>$l)<option value="{{ $k }}" @selected(old('sexe',$fidele->sexe)==$k)>{{ $l }}</option>@endforeach</select></div>
<div class="col-md-4"><label class="form-label">Date de naissance</label><input type="date" name="date_naissance" value="{{ old('date_naissance', $fidele->date_naissance?->format('Y-m-d')) }}" class="form-control"></div>
<div class="col-md-4"><label class="form-label">CEB</label><select name="ceb_id" class="form-select"><option value="">—</option>@foreach($cebs as $c)<option value="{{ $c->id }}" @selected(old('ceb_id',$fidele->ceb_id)==$c->id)>{{ $c->nom }}</option>@endforeach</select></div>
<div class="col-md-4"><label class="form-label">Statut</label><select name="statut" class="form-select">@foreach(['actif','transfere','decede'] as $s)<option @selected(old('statut',$fidele->statut)==$s)>{{ $s }}</option>@endforeach</select></div>
<div class="col-md-4"><label class="form-label">N° Carnet Baptême</label><input type="text" name="numero_carnet_bapteme" value="{{ old('numero_carnet_bapteme', $fidele->numero_carnet_bapteme) }}" class="form-control"></div>
<div class="col-md-4"><label class="form-label">Sacrements</label><div class="form-check"><input type="checkbox" name="baptise" class="form-check-input" @checked(old('baptise', $fidele->baptise))><label class="form-check-label">Baptisé</label></div><div class="form-check"><input type="checkbox" name="confirme" class="form-check-input" @checked(old('confirme', $fidele->confirme))><label class="form-check-label">Confirmé</label></div><div class="form-check"><input type="checkbox" name="marie" class="form-check-input" @checked(old('marie', $fidele->marie))><label class="form-check-label">Marié</label></div></div>
<div class="col-12"><button class="btn btn-primary">Enregistrer</button> <a href="{{ route('fideles.index') }}" class="btn btn-link">Annuler</a></div></form>
@endsection
