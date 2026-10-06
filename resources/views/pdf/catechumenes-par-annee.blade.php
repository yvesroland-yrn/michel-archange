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
  .classe-header {
    background: #E8F4FD;
    padding: 10px;
    margin: 20px 0 10px;
    border-left: 4px solid #1F3A5F;
  }
</style>
</head>
<body>
<div class="c">
  <img src="{{ public_path('images/saint.jpg') }}" class="logo" alt="Saint Michel Archange">
  <strong>PAROISSE SAINT MICHEL ARCHANGE DE LA BAE</strong>
  <h1>CATÉCHUMÈNES PAR ANNÉE CATÉCHÉTIQUE</h1>
</div>

<div class="info">
  <strong>Année catéchétique :</strong> {{ $annee->libelle }}<br>
  <strong>Total :</strong> {{ $classes->sum(function($classe) { return $classe->catechumenes->count(); }) }} catéchumène(s)
</div>

@foreach($classes as $classe)
  @if($classe->catechumenes->isNotEmpty())
    <div class="classe-header">
      <strong>{{ $classe->niveau }}{{ $classe->code ? " {$classe->code}" : '' }} - {{ \App\Models\ClasseCate::getSections()[$classe->section] ?? $classe->section }}</strong><br>
      <em>Effectif : {{ $classe->catechumenes->count() }} catéchumène(s)</em>
    </div>

    <table>
      <thead>
        <tr>
          <th>Nom & Prénoms</th>
          <th>Téléphone</th>
          <th>Statut</th>
          <th>Montant payé</th>
          <th>Baptisé</th>
        </tr>
      </thead>
      <tbody>
        @foreach($classe->catechumenes as $catechumene)
        <tr>
          <td>
            @if($catechumene->fidele)
              <strong>{{ $catechumene->fidele->nom }} {{ $catechumene->fidele->prenoms }}</strong>
            @else
              <strong>{{ $catechumene->nom }} {{ $catechumene->prenoms }}</strong>
            @endif
          </td>
          <td>{{ $catechumene->fidele ? $catechumene->fidele->telephone : $catechumene->telephone }}</td>
          <td>{{ ucfirst($catechumene->statut) }}</td>
          <td>{{ $catechumene->montant_a_payer ? number_format($catechumene->montant_a_payer, 0, '', ' ') . ' FCFA' : '—' }}</td>
          <td>{{ $catechumene->bapte ? 'Oui' : 'Non' }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  @endif
@endforeach

<div class="c" style="margin-top: 30px; font-size: 10px; color: #666;">
  Généré le {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}
</div>
</body>
</html>
