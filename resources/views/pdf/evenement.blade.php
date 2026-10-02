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
  .messe {
    color: #1F3A5F;
    font-weight: bold;
  }
</style>
</head>
<body>
<div class="c">
  <img src="{{ public_path('images/saint.jpg') }}" class="logo" alt="Saint Michel Archange">
  <strong>PAROISSE SAINT MICHEL ARCHANGE DE LA BAE</strong>
  <h1>MESSES ET CALENDRIER PAROISSIAL</h1>
</div>

<table>
  <thead>
    <tr>
      <th>Date</th>
      <th>Titre</th>
      <th>Type</th>
      <th>Lieu</th>
      <th>Célébrant</th>
      <th>Description</th>
    </tr>
  </thead>
  <tbody>
    @forelse($evenements as $e)
    <tr>
      <td><strong>{{ $e->date_heure->format('d/m/Y H:i') }}</strong></td>
      <td>{{ $e->titre }}</td>
      <td>{{ App\Models\Evenement::TYPES[$e->type] ?? $e->type }}</td>
      <td>{{ $e->lieu }}</td>
      <td>{{ $e->celebrant }}</td>
      <td>{{ $e->description }}</td>
    </tr>
    @empty
    <tr>
      <td colspan="6" class="c">Aucun événement programmé.</td>
    </tr>
    @endforelse
  </tbody>
</table>

<div class="c" style="margin-top: 30px; font-size: 10px; color: #666;">
  Généré le {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}
</div>
</body>
</html>
