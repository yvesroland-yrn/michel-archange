@extends('layouts.paroisse')
@section('contenu')

<!-- Filtres -->
<div class="card mb-4">
  <div class="card-header bg-info text-white">
    <h5 class="mb-0"><i class="bi bi-funnel"></i> Filtres d'exportation</h5>
  </div>
  <div class="card-body">
    <form method="GET" action="{{ route('reservations.admin') }}" id="filterForm">
      <div class="row g-3">
        <div class="col-md-3">
          <label class="form-label">Statut</label>
          <select name="statut" class="form-select" id="filterStatut">
            <option value="">Tous</option>
            <option value="en_attente" {{ request('statut') === 'en_attente' ? 'selected' : '' }}>En attente</option>
            <option value="confirmee" {{ request('statut') === 'confirmee' ? 'selected' : '' }}>Confirmée</option>
            <option value="annulee" {{ request('statut') === 'annulee' ? 'selected' : '' }}>Annulée</option>
          </select>
        </div>
        <div class="col-md-3">
          <label class="form-label">Paroisse</label>
          <select name="paroisse" class="form-select" id="filterParoisse">
            <option value="">Toutes</option>
            @foreach($allReservations->pluck('paroisse')->unique()->sort() as $paroisse)
              <option value="{{ $paroisse }}" {{ request('paroisse') === $paroisse ? 'selected' : '' }}>{{ $paroisse }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-3">
          <label class="form-label">Diocèse/Vicariat</label>
          <select name="diocese" class="form-select" id="filterDiocese">
            <option value="">Tous</option>
            @foreach($allReservations->pluck('diocese_vicariat')->filter()->unique()->sort() as $diocese)
              <option value="{{ $diocese }}" {{ request('diocese') === $diocese ? 'selected' : '' }}>{{ $diocese }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-1">
          <label class="form-label">Date début</label>
          <input type="date" name="date_debut" class="form-control" id="filterDateDebut" value="{{ request('date_debut') }}">
        </div>
        <div class="col-md-1">
          <label class="form-label">Date fin</label>
          <input type="date" name="date_fin" class="form-control" id="filterDateFin" value="{{ request('date_fin') }}">
        </div>
        <div class="col-md-1 d-flex align-items-end">
          <button type="submit" class="btn btn-primary me-1">
            <i class="bi bi-search"></i>
          </button>
          <a href="{{ route('reservations.admin') }}" class="btn btn-secondary">
            <i class="bi bi-x-lg"></i>
          </a>
        </div>
      </div>
    </form>
  </div>
</div>

<style>
.voir-btn {
  transition: all 0.3s ease;
  border: 2px solid #ff6b6b;
  font-weight: 600;
  color: #ff6b6b;
  background: linear-gradient(135deg, #fff5f5 0%, #fff 100%);
}

.voir-btn:hover {
  background: linear-gradient(135deg, #ff6b6b 0%, #ee5a5a 100%);
  color: white;
  transform: translateY(-2px) scale(1.05);
  box-shadow: 0 8px 20px rgba(255, 107, 107, 0.4);
  border-color: #ff6b6b;
}

.voir-btn:active {
  transform: translateY(0) scale(1);
  box-shadow: 0 4px 10px rgba(255, 107, 107, 0.3);
}

.voir-btn:focus {
  border-color: #ff6b6b;
  box-shadow: 0 0 0 0.25rem rgba(255, 107, 107, 0.25);
}

/* Modal styles */
#voirReservationModal .modal-header {
  background: linear-gradient(135deg, #ff6b6b 0%, #ee5a5a 50%, #ff8e8e 100%);
  color: white;
  border-radius: 1rem 1rem 0 0;
  padding: 1.5rem;
  border-bottom: 3px solid rgba(255, 255, 255, 0.2);
}

#voirReservationModal .modal-title {
  font-weight: 700;
  font-size: 1.4rem;
  text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

#voirReservationModal .btn-close {
  filter: brightness(0) invert(1);
  opacity: 0.9;
  transition: opacity 0.3s ease;
}

#voirReservationModal .btn-close:hover {
  opacity: 1;
}

#voirReservationModal .modal-body {
  padding: 2rem;
  background: linear-gradient(180deg, #fff5f5 0%, #ffffff 100%);
}

#voirReservationModal .modal-content {
  border: none;
  border-radius: 1rem;
  box-shadow: 0 20px 60px rgba(255, 107, 107, 0.2);
  overflow: hidden;
  border: 2px solid rgba(255, 107, 107, 0.1);
}

#voirReservationModal .row > div {
  background: linear-gradient(135deg, #ffffff 0%, #fef5f5 100%);
  padding: 1.25rem;
  border-radius: 0.75rem;
  box-shadow: 0 4px 12px rgba(255, 107, 107, 0.08);
  transition: all 0.3s ease;
  border: 1px solid rgba(255, 107, 107, 0.1);
}

#voirReservationModal .row > div:hover {
  transform: translateY(-4px) scale(1.02);
  box-shadow: 0 8px 24px rgba(255, 107, 107, 0.15);
  border-color: rgba(255, 107, 107, 0.3);
}

#voirReservationModal .form-label {
  color: #ff6b6b;
  font-size: 0.7rem;
  text-transform: uppercase;
  letter-spacing: 1px;
  margin-bottom: 0.5rem;
  font-weight: 700;
}

#voirReservationModal .fw-semibold {
  color: #2d3436;
  font-size: 1rem;
  font-weight: 600;
}

#voirReservationModal .badge {
  font-size: 0.9rem;
  padding: 0.6rem 1.25rem;
  border-radius: 25px;
  font-weight: 600;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

#voirReservationModal .modal-footer {
  background: linear-gradient(180deg, #ffffff 0%, #fef5f5 100%);
  border-top: 2px solid rgba(255, 107, 107, 0.1);
  padding: 1.25rem 2rem;
}

#voirReservationModal .btn-secondary {
  border-radius: 25px;
  padding: 0.6rem 2rem;
  font-weight: 600;
  transition: all 0.3s ease;
  background: linear-gradient(135deg, #ff6b6b 0%, #ee5a5a 100%);
  border: none;
  color: white;
}

#voirReservationModal .btn-secondary:hover {
  background: linear-gradient(135deg, #ee5a5a 0%, #dd4a4a 100%);
  transform: translateY(-2px) scale(1.05);
  box-shadow: 0 8px 20px rgba(255, 107, 107, 0.4);
  color: white;
}
</style>
<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h2 class="h3">Réservations</h2>
    <p class="text-muted">Gestion des réservations du site web.</p>
  </div>
  <div class="btn-group">
    <a href="{{ route('dashboard') }}" class="btn btn-outline-primary">
      <i class="bi bi-arrow-left"></i> Retour
    </a>
    <button onclick="exportPdf()" class="btn btn-outline-success" target="_blank">
      <i class="bi bi-file-earmark-pdf"></i> PDF
    </button>
    <button onclick="exportWord()" class="btn btn-outline-info">
      <i class="bi bi-file-earmark-word"></i> Word
    </button>
  </div>
</div>

<!-- Statistiques globales -->
<div class="row g-3 mb-4">
  <div class="col-md-4">
    <div class="card bg-warning text-white">
      <div class="card-body">
        <h5 class="card-title">En attente</h5>
        <h3 class="card-text">{{ $reservations->filter(fn($r) => $r->statut === 'en_attente')->count() }}</h3>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card bg-success text-white">
      <div class="card-body">
        <h5 class="card-title">Confirmées</h5>
        <h3 class="card-text">{{ $reservations->filter(fn($r) => $r->statut === 'confirmee')->count() }}</h3>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card bg-danger text-white">
      <div class="card-body">
        <h5 class="card-title">Annulées</h5>
        <h3 class="card-text">{{ $reservations->filter(fn($r) => $r->statut === 'annulee')->count() }}</h3>
      </div>
    </div>
  </div>
</div>

<!-- Bilan par paroisse -->
<div class="card mb-4">
  <div class="card-header bg-primary text-white">
    <h5 class="mb-0"><i class="bi bi-building"></i> Bilan par Paroisse</h5>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Paroisse</th>
            <th>Total Réservations</th>
            <th>En attente</th>
            <th>Confirmées</th>
            <th>Annulées</th>
            <th>Total Personnes</th>
          </tr>
        </thead>
        <tbody>
          @forelse($statsParParoisse as $paroisse => $stats)
            <tr>
              <td class="fw-bold">{{ $paroisse }}</td>
              <td>{{ $stats['total'] }}</td>
              <td><span class="badge bg-warning">{{ $stats['en_attente'] }}</span></td>
              <td><span class="badge bg-success">{{ $stats['confirmee'] }}</span></td>
              <td><span class="badge bg-danger">{{ $stats['annulee'] }}</span></td>
              <td>{{ number_format($stats['total_personnes'], 0, ',', ' ') }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-center text-muted py-4">Aucune donnée disponible.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Bilan par diocèse/vicariat -->
@if($statsParDiocese->count() > 0)
<div class="card mb-4">
  <div class="card-header bg-info text-white">
    <h5 class="mb-0"><i class="bi bi-diagram-3"></i> Bilan par Diocèse/Vicariat</h5>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Diocèse/Vicariat</th>
            <th>Total Réservations</th>
            <th>En attente</th>
            <th>Confirmées</th>
            <th>Annulées</th>
            <th>Total Personnes</th>
          </tr>
        </thead>
        <tbody>
          @forelse($statsParDiocese as $diocese => $stats)
            <tr>
              <td class="fw-bold">{{ $diocese }}</td>
              <td>{{ $stats['total'] }}</td>
              <td><span class="badge bg-warning">{{ $stats['en_attente'] }}</span></td>
              <td><span class="badge bg-success">{{ $stats['confirmee'] }}</span></td>
              <td><span class="badge bg-danger">{{ $stats['annulee'] }}</span></td>
              <td>{{ number_format($stats['total_personnes'], 0, ',', ' ') }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-center text-muted py-4">Aucune donnée disponible.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endif

<!-- Liste des réservations -->
<div class="card mb-4">
  <div class="card-header">
    <h5 class="mb-0"><i class="bi bi-calendar-check"></i> Toutes les réservations</h5>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Date</th>
            <th>Nom</th>
            <th>Paroisse</th>
            <th>Diocèse/Vicariat</th>
            <th>Téléphone</th>
            <th>Date réservation</th>
            <th>Personnes</th>
            <th>Statut</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($reservations as $reservation)
            <tr>
              <td>{{ date('d/m/Y H:i', strtotime($reservation->created_at)) }}</td>
              <td class="fw-semibold">{{ $reservation->nom }}</td>
              <td>{{ $reservation->paroisse }}</td>
              <td>{{ $reservation->diocese_vicariat ?? '-' }}</td>
              <td>{{ $reservation->telephone }}</td>
              <td>{{ date('d/m/Y', strtotime($reservation->date_reservation)) }}</td>
              <td>{{ $reservation->nombre_personnes }}</td>
              <td>
                @if($reservation->statut === 'en_attente')
                  <span class="badge bg-warning">En attente</span>
                @elseif($reservation->statut === 'confirmee')
                  <span class="badge bg-success">Confirmée</span>
                @else
                  <span class="badge bg-danger">Annulée</span>
                @endif
              </td>
              <td>
                <div class="btn-group">
                  <button class="btn btn-sm btn-outline-info voir-btn" onclick="voirReservation({{ $reservation->id }})">
                    <i class="bi bi-eye"></i> Voir
                  </button>
                  <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="bi bi-gear"></i>
                  </button>
                  <ul class="dropdown-menu">
                    <li>
                      <form method="POST" action="{{ route('reservations.update-statut', $reservation->id) }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="statut" value="en_attente">
                        <button type="submit" class="dropdown-item {{ $reservation->statut === 'en_attente' ? 'active' : '' }}">
                          <i class="bi bi-clock me-2"></i>En attente
                        </button>
                      </form>
                    </li>
                    <li>
                      <form method="POST" action="{{ route('reservations.update-statut', $reservation->id) }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="statut" value="confirmee">
                        <button type="submit" class="dropdown-item {{ $reservation->statut === 'confirmee' ? 'active' : '' }}">
                          <i class="bi bi-check-circle me-2"></i>Confirmer
                        </button>
                      </form>
                    </li>
                    <li>
                      <form method="POST" action="{{ route('reservations.update-statut', $reservation->id) }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="statut" value="annulee">
                        <button type="submit" class="dropdown-item {{ $reservation->statut === 'annulee' ? 'active' : '' }}">
                          <i class="bi bi-x-circle me-2"></i>Annuler
                        </button>
                      </form>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                      <form method="POST" action="{{ route('reservations.destroy', $reservation->id) }}" onsubmit="return confirm('Supprimer cette réservation ?')">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">
                          <i class="bi bi-trash me-2"></i>Supprimer
                        </button>
                      </form>
                    </li>
                  </ul>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="9" class="text-center text-muted py-4">Aucune réservation.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal pour voir les détails d'une réservation -->
<div class="modal fade" id="voirReservationModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
          <i class="bi bi-calendar-check me-2"></i>Détails de la réservation
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label fw-bold text-muted small">Nom complet</label>
            <p id="voir-nom" class="mb-0 fw-semibold"></p>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-bold text-muted small">Paroisse</label>
            <p id="voir-paroisse" class="mb-0 fw-semibold"></p>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-bold text-muted small">Diocèse / Vicariat</label>
            <p id="voir-diocese" class="mb-0 fw-semibold"></p>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-bold text-muted small">Téléphone</label>
            <p id="voir-telephone" class="mb-0 fw-semibold"></p>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-bold text-muted small">Date de réservation</label>
            <p id="voir-date" class="mb-0 fw-semibold"></p>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-bold text-muted small">Nombre de personnes</label>
            <p id="voir-personnes" class="mb-0 fw-semibold"></p>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-bold text-muted small">Statut</label>
            <p id="voir-statut" class="mb-0"></p>
          </div>
          <div class="col-12">
            <label class="form-label fw-bold text-muted small">Message</label>
            <p id="voir-message" class="mb-0 fw-semibold"></p>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>

@endsection

<script>
const reservationsData = {
  @foreach($reservations as $reservation)
  {{ $reservation->id }}: {
    nom: '{{ $reservation->nom }}',
    paroisse: '{{ $reservation->paroisse }}',
    diocese_vicariat: '{{ $reservation->diocese_vicariat ?? '' }}',
    telephone: '{{ $reservation->telephone }}',
    date: '{{ date('d/m/Y', strtotime($reservation->date_reservation)) }}',
    personnes: {{ $reservation->nombre_personnes }},
    message: '{{ $reservation->message ?? '' }}',
    statut: '{{ $reservation->statut }}'
  },
  @endforeach
};

function voirReservation(id) {
  const data = reservationsData[id];
  if (!data) return;

  document.getElementById('voir-nom').textContent = data.nom;
  document.getElementById('voir-paroisse').textContent = data.paroisse;
  document.getElementById('voir-diocese').textContent = data.diocese_vicariat || 'Non renseigné';
  document.getElementById('voir-telephone').textContent = data.telephone;
  document.getElementById('voir-date').textContent = data.date;
  document.getElementById('voir-personnes').textContent = data.personnes + ' personne(s)';
  document.getElementById('voir-message').textContent = data.message || 'Aucun message';

  let statutText = '';
  if (data.statut === 'en_attente') {
    statutText = 'En attente';
  } else if (data.statut === 'confirmee') {
    statutText = 'Confirmée';
  } else {
    statutText = 'Annulée';
  }
  document.getElementById('voir-statut').innerHTML = '<span class="badge ' + (data.statut === 'en_attente' ? 'bg-warning' : (data.statut === 'confirmee' ? 'bg-success' : 'bg-danger')) + '">' + statutText + '</span>';

  new bootstrap.Modal(document.getElementById('voirReservationModal')).show();
}

function exportPdf() {
  const params = new URLSearchParams();
  const statut = document.getElementById('filterStatut').value;
  const paroisse = document.getElementById('filterParoisse').value;
  const diocese = document.getElementById('filterDiocese').value;
  const dateDebut = document.getElementById('filterDateDebut').value;
  const dateFin = document.getElementById('filterDateFin').value;

  if (statut) params.append('statut', statut);
  if (paroisse) params.append('paroisse', paroisse);
  if (diocese) params.append('diocese', diocese);
  if (dateDebut) params.append('date_debut', dateDebut);
  if (dateFin) params.append('date_fin', dateFin);

  window.open('{{ route('reservations.export-pdf') }}?' + params.toString(), '_blank');
}

function exportWord() {
  const params = new URLSearchParams();
  const statut = document.getElementById('filterStatut').value;
  const paroisse = document.getElementById('filterParoisse').value;
  const diocese = document.getElementById('filterDiocese').value;
  const dateDebut = document.getElementById('filterDateDebut').value;
  const dateFin = document.getElementById('filterDateFin').value;

  if (statut) params.append('statut', statut);
  if (paroisse) params.append('paroisse', paroisse);
  if (diocese) params.append('diocese', diocese);
  if (dateDebut) params.append('date_debut', dateDebut);
  if (dateFin) params.append('date_fin', dateFin);

  window.location.href = '{{ route('reservations.export-word') }}?' + params.toString();
}
</script>
