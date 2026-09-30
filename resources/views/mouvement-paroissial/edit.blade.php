@extends('layouts.paroisse')
@section('contenu')
<h1 class="h3 mb-3">Modifier {{ $mouvementParoissial->nom }}</h1>
<form method="POST" action="{{ route('mouvement-paroissial.update', $mouvementParoissial) }}" class="card card-body row g-3 mx-0" enctype="multipart/form-data">
@csrf @method('PUT')
<div class="col-md-6"><label class="form-label">Nom <span class="text-danger">*</span></label><input type="text" name="nom" value="{{ old('nom', $mouvementParoissial->nom) }}" class="form-control" required></div>
<div class="col-md-6"><label class="form-label">Icône <span class="text-danger">*</span></label><select name="icone" class="form-select" required>@foreach(\App\Models\MouvementParoissial::ICONES as $k => $v)<option value="{{ $k }}" @selected(old('icone', $mouvementParoissial->icone)==$k)>{{ $v }}</option>@endforeach</select></div>
<div class="col-md-6"><label class="form-label">Responsable</label><input type="text" name="responsable" value="{{ old('responsable', $mouvementParoissial->responsable) }}" class="form-control"></div>
<div class="col-md-6"><label class="form-label">Téléphone du responsable</label><input type="text" name="telephone_responsable" value="{{ old('telephone_responsable', $mouvementParoissial->telephone_responsable) }}" class="form-control"></div>
<div class="col-12"><label class="form-label">Description</label><textarea name="description" rows="4" class="form-control">{{ old('description', $mouvementParoissial->description) }}</textarea></div>
<div class="col-md-6"><label class="form-label">Photo</label><input type="file" name="photo" class="form-control" accept="image/*">@if($mouvementParoissial->photo)<div class="mt-2"><img src="{{ asset('storage/' . $mouvementParoissial->photo) }}" alt="Photo actuelle" style="max-height: 100px; border-radius: 4px;"><small class="text-muted d-block">Photo actuelle</small></div>@endif</div>
<div class="col-md-6"><label class="form-label">Statut</label><div class="form-check"><input type="checkbox" name="actif" class="form-check-input" id="actif" value="1" @if($mouvementParoissial->actif) checked @endif><label class="form-check-label" for="actif">Actif</label></div></div>
<div class="col-12"><button class="btn btn-primary">Enregistrer</button> <a href="{{ route('mouvement-paroissial.index') }}" class="btn btn-link">Annuler</a></div></form>
@endsection
