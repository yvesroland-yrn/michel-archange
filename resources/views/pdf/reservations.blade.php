<!doctype html><html lang="fr"><head><meta charset="utf-8"><style>body{font-family:DejaVu Sans,sans-serif;font-size:12px;color:#222}.c{text-align:center}h1{color:#1F3A5F;letter-spacing:2px;font-size:22px}.box{border:3px double #B8892E;padding:28px}td,th{padding:5px 8px;vertical-align:top}.sig{margin-top:60px}table.g{width:100%;border-collapse:collapse}table.g td,table.g th{border:1px solid #bbb}table.g th{background:#1F3A5F;color:#fff}.logo{max-width:80px;height:auto;display:block;margin:0 auto 15px;border-radius:50%;border:3px solid #B8892E}.summary{background:#f5f5f5;padding:15px;margin:15px 0;border-left:4px solid #B8892E}.badge{padding:3px 8px;border-radius:12px;font-size:10px;font-weight:bold;color:#fff}.badge-warning{background:#ffc107;color:#000}.badge-success{background:#28a745}.badge-danger{background:#dc3545}</style></head><body>
<div class="c"><img src="{{ $logoSrc }}" class="logo" alt="Sanctuaire Notre-Dame de Cana"><strong>SANCTUAIRE MARIAN NOTRE-DAME DE CANA SASSAKO</strong><h1>RAPPORT DES RÉSERVATIONS</h1></div>

<div class="summary">
  <h3 style="margin-top:0">Statistiques Globales</h3>
  <p><strong>Total Réservations :</strong> {{ $reservations->count() }}</p>
  <p><strong>En attente :</strong> {{ $reservations->where('statut', 'en_attente')->count() }}</p>
  <p><strong>Confirmées :</strong> {{ $reservations->where('statut', 'confirmee')->count() }}</p>
  <p><strong>Annulées :</strong> {{ $reservations->where('statut', 'annulee')->count() }}</p>
</div>

<h3>Bilan par Paroisse</h3><table class="g"><tr><th>Paroisse</th><th>Total</th><th>En attente</th><th>Confirmées</th><th>Annulées</th><th>Total Personnes</th></tr>
@foreach($statsParParoisse as $paroisse => $stats)<tr><td>{{ $paroisse }}</td><td>{{ $stats['total'] }}</td><td>{{ $stats['en_attente'] }}</td><td>{{ $stats['confirmee'] }}</td><td>{{ $stats['annulee'] }}</td><td>{{ number_format($stats['total_personnes'], 0, ',', ' ') }}</td></tr>@endforeach
</table>

@if($statsParDiocese->count() > 0)
<h3>Bilan par Diocèse/Vicariat</h3><table class="g"><tr><th>Diocèse/Vicariat</th><th>Total</th><th>En attente</th><th>Confirmées</th><th>Annulées</th><th>Total Personnes</th></tr>
@foreach($statsParDiocese as $diocese => $stats)<tr><td>{{ $diocese }}</td><td>{{ $stats['total'] }}</td><td>{{ $stats['en_attente'] }}</td><td>{{ $stats['confirmee'] }}</td><td>{{ $stats['annulee'] }}</td><td>{{ number_format($stats['total_personnes'], 0, ',', ' ') }}</td></tr>@endforeach
</table>
@endif

<h3>Liste des Réservations</h3><table class="g"><tr><th>Date</th><th>Nom</th><th>Paroisse</th><th>Diocèse</th><th>Téléphone</th><th>Date Réservation</th><th>Personnes</th><th>Statut</th></tr>
@foreach($reservations as $reservation)<tr><td>{{ date('d/m/Y H:i', strtotime($reservation->created_at)) }}</td><td>{{ $reservation->nom }}</td><td>{{ $reservation->paroisse }}</td><td>{{ $reservation->diocese_vicariat ?? '-' }}</td><td>{{ $reservation->telephone }}</td><td>{{ date('d/m/Y', strtotime($reservation->date_reservation)) }}</td><td>{{ $reservation->nombre_personnes }}</td><td>
@if($reservation->statut === 'en_attente')<span class="badge badge-warning">En attente</span>
@elseif($reservation->statut === 'confirmee')<span class="badge badge-success">Confirmée</span>
@else<span class="badge badge-danger">Annulée</span>
@endif
</td></tr>@endforeach
</table>

<div class="sig">
  <p style="margin-top:40px">Fait à Sassako, le {{ now()->format('d/m/Y') }}</p>
  <p style="margin-top:30px"><strong>Le Responsable des Réservations</strong></p>
</div>
</body></html>
