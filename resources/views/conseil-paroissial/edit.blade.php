@extends('layouts.paroisse')
@section('contenu')
<h1 class="h3 mb-3">Modifier {{ $conseilParoissial->nom_complet }}</h1>
<form method="POST" action="{{ route('conseil-paroissial.update', $conseilParoissial) }}" class="card card-body row g-3 mx-0" enctype="multipart/form-data">
@csrf @method('PUT')
<div class="col-md-6"><label class="form-label">Nom <span class="text-danger">*</span></label><input type="text" name="nom" value="{{ old('nom', $conseilParoissial->nom) }}" class="form-control" required></div>
<div class="col-md-6"><label class="form-label">Prénom <span class="text-danger">*</span></label><input type="text" name="prenom" value="{{ old('prenom', $conseilParoissial->prenom) }}" class="form-control" required></div>
<div class="col-md-6"><label class="form-label">Rôle <span class="text-danger">*</span></label><input type="text" name="role" value="{{ old('role', $conseilParoissial->role) }}" class="form-control" placeholder="Ex: Président, Secrétaire, Trésorier, Membre" required></div>
<div class="col-md-6"><label class="form-label">Téléphone</label><input type="text" name="telephone" value="{{ old('telephone', $conseilParoissial->telephone) }}" class="form-control"></div>
<div class="col-md-6"><label class="form-label">Email</label><input type="email" name="email" value="{{ old('email', $conseilParoissial->email) }}" class="form-control"></div>
<div class="col-12"><label class="form-label">Description</label><textarea name="description" rows="4" class="form-control">{{ old('description', $conseilParoissial->description) }}</textarea></div>
<div class="col-md-6"><label class="form-label">Photo</label><input type="file" name="photo" class="form-control" accept="image/*">@if($conseilParoissial->photo)<div class="mt-2"><img src="{{ asset('storage/' . $conseilParoissial->photo) }}" alt="Photo actuelle" style="max-height: 100px; border-radius: 4px;"><small class="text-muted d-block">Photo actuelle</small></div>@endif</div>
<div class="col-md-6"><label class="form-label">Statut</label><div class="form-check"><input type="checkbox" name="actif" class="form-check-input" id="actif" value="1" @if($conseilParoissial->actif) checked @endif><label class="form-check-label" for="actif">Actif</label></div></div>
<div class="col-12"><button class="btn btn-primary">Enregistrer</button> <a href="{{ route('conseil-paroissial.index') }}" class="btn btn-link">Annuler</a></div></form>
@endsection
