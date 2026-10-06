<!doctype html>
<html lang="fr">
<head>
<meta charset="utf-8">
<style>
  body {
    font-family: DejaVu Sans, sans-serif;
    font-size: 12px;
    color: #222;
  }
  .c {
    text-align: center;
  }
  h1 {
    color: #1F3A5F;
    letter-spacing: 2px;
    font-size: 22px;
  }
  table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
  }
  td, th {
    padding: 8px 10px;
    vertical-align: top;
    border: 1px solid #bbb;
  }
  th {
    background: #1F3A5F;
    color: #fff;
  }
  .logo {
    max-width: 80px;
    height: auto;
    display: block;
    margin: 0 auto 15px;
    border-radius: 50%;
    border: 3px solid #B8892E;
  }
  .info {
    margin: 15px 0;
    padding: 10px;
    background: #f5f5f5;
    border-left: 4px solid #1F3A5F;
  }
  .total {
    font-size: 16px;
    font-weight: bold;
    color: #1F3A5F;
  }
</style>
</head>
<body>
<div class="c">
  <img src="{{ public_path('images/saint.jpg') }}" class="logo" alt="Saint Michel Archange">
  <strong>PAROISSE SAINT MICHEL ARCHANGE DE LA BAE</strong>
  <h1>LISTE DES DENIERS DU CULTE</h1>
</div>

<div class="info">
  <strong>Période :</strong> {{ $mois ? $mois : 'Toutes périodes' }}<br>
  <strong>Total :</strong> {{ number_format($total, 0, ',', ' ') }} FCFA
</div>

<table>
  <thead>
    <tr>
      <th>Date</th>
      <th>Période</th>
      <th>Donateur</th>
      <th>N° Carnet Baptême</th>
      <th>Note</th>
      <th class="text-end">Montant</th>
    </tr>
  </thead>
  <tbody>
    @forelse($deniers as $d)
    <tr>
      <td>{{ $d->date_paiement->format('d/m/Y') }}</td>
      <td>{{ \App\Models\DenierCulte::getPeriodes()[$d->periode] ?? $d->periode }}</td>
      <td>{{ $d->fidele ? $d->fidele->nom_complet : $d->donateur_nom }}</td>
      <td>{{ $d->numero_carnet_bapteme ?? '-' }}</td>
      <td>{{ $d->note ?? '-' }}</td>
      <td class="text-end">{{ number_format($d->montant, 0, ',', ' ') }}</td>
    </tr>
    @empty
    <tr>
      <td colspan="6" class="c">Aucun denier du culte enregistré.</td>
    </tr>
    @endforelse
    <tr class="table-dark">
      <td colspan="5" class="c"><strong>Total</strong></td>
      <td class="c"><strong>{{ number_format($total, 0, ',', ' ') }}</strong></td>
    </tr>
  </tbody>
</table>

<div class="c" style="margin-top: 30px; font-size: 10px; color: #666;">
  Généré le {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}
</div>
</body>
</html>
