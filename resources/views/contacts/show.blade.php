@extends('layouts.paroisse')
@section('contenu')
<div class="d-flex justify-content-between mb-3">
  <h1 class="h3">Message de {{ $contact->nom }}</h1>
  <div>
    <a href="{{ route('contacts.index') }}" class="btn btn-outline-secondary">Retour</a>
    <form method="POST" action="{{ route('contacts.destroy', $contact) }}" class="d-inline" onsubmit="return confirm('Supprimer ce message ?')">
      @csrf @method('DELETE')
      <button class="btn btn-outline-danger">Supprimer</button>
    </form>
  </div>
</div>
<div class="card card-body">
  <div class="row mb-3">
    <div class="col-md-6">
      <strong>Nom :</strong> {{ $contact->nom }}
    </div>
    <div class="col-md-6">
      <strong>Téléphone :</strong> {{ $contact->telephone }}
    </div>
  </div>
  <div class="row mb-3">
    <div class="col-md-6">
      <strong>Sujet :</strong> {{ $contact->sujet }}
    </div>
    <div class="col-md-6">
      <strong>Date :</strong> {{ $contact->created_at->format('d/m/Y H:i') }}
    </div>
  </div>
  <div class="mb-3">
    <strong>Message :</strong>
    <div class="mt-2 p-3 bg-light rounded">{{ $contact->message }}</div>
  </div>
  <div class="mt-4">
    <form method="POST" action="{{ route('contacts.marquer-lu', $contact) }}">
      @csrf
      <button type="submit" class="btn {{ $contact->lu ? 'btn-outline-secondary' : 'btn-primary' }}">
        {{ $contact->lu ? 'Marquer comme non lu' : 'Marquer comme lu' }}
      </button>
    </form>
  </div>
</div>
@endsection
