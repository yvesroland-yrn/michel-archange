@extends('layouts.paroisse')
@section('contenu')
<div class="d-flex justify-content-between mb-3">
  <h1 class="h3">Contact Nous</h1>
  <div>
    <span class="badge text-bg-secondary">{{ $contacts->total() }} message(s)</span>
  </div>
</div>
<div class="table-responsive">
  <table class="table table-striped bg-white align-middle">
    <thead>
      <tr>
        <th>Date</th>
        <th>Nom</th>
        <th>Téléphone</th>
        <th>Sujet</th>
        <th>Statut</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      @forelse($contacts as $contact)
        <tr class="{{ $contact->lu ? '' : 'table-primary' }}">
          <td>{{ $contact->created_at->format('d/m/Y H:i') }}</td>
          <td><strong>{{ $contact->nom }}</strong></td>
          <td>{{ $contact->telephone }}</td>
          <td>{{ $contact->sujet }}</td>
          <td>
            @if($contact->lu)
              <span class="badge text-bg-success">Lu</span>
            @else
              <span class="badge text-bg-primary">Non lu</span>
            @endif
          </td>
          <td class="text-end">
            <a href="{{ route('contacts.show', $contact) }}" class="btn btn-sm btn-outline-primary">Voir</a>
            <form method="POST" action="{{ route('contacts.destroy', $contact) }}" class="d-inline" onsubmit="return confirm('Supprimer ce message ?')">
              @csrf @method('DELETE')
              <button class="btn btn-sm btn-outline-danger">Supprimer</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="6" class="text-center text-muted">Aucun message.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
{{ $contacts->links() }}
@endsection
