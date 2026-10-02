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
</style>
</head>
<body>
<div class="c">
  <img src="{{ public_path('images/saint.jpg') }}" class="logo" alt="Saint Michel Archange">
  <strong>PAROISSE SAINT MICHEL ARCHANGE DE LA BAE</strong>
  <h1>COMMUNAUTÉS ECCLÉSIALES DE BASE (CEB)</h1>
</div>

<table>
  <thead>
    <tr>
      <th>Nom</th>
      <th>Responsable</th>
      <th>Numéro du responsable</th>
      <th>Zone de couverture</th>
      <th>Nombre de fidèles</th>
    </tr>
  </thead>
  <tbody>
    @forelse($cebs as $c)
    <tr>
      <td><strong>{{ $c->nom }}</strong></td>
      <td>{{ $c->responsable }}</td>
      <td>{{ $c->numero_responsable }}</td>
      <td>{{ $c->zone_couverture }}</td>
      <td class="c">{{ $c->fideles->count() }}</td>
    </tr>
    @empty
    <tr>
      <td colspan="5" class="c">Aucune CEB.</td>
    </tr>
    @endforelse
  </tbody>
</table>

<div class="c" style="margin-top: 30px; font-size: 10px; color: #666;">
  Généré le {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}
</div>
</body>
</html>
