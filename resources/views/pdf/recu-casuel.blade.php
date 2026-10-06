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
  .logo {
    max-width: 80px;
    height: auto;
    display: block;
    margin: 0 auto 15px;
    border-radius: 50%;
    border: 3px solid #B8892E;
  }
  .info {
    margin: 20px 0;
    padding: 15px;
    background: #f5f5f5;
    border-left: 4px solid #1F3A5F;
  }
  .info p {
    margin: 5px 0;
  }
  .total {
    font-size: 18px;
    font-weight: bold;
    color: #1F3A5F;
  }
</style>
</head>
<body>
<div class="c">
  <img src="{{ public_path('images/saint.jpg') }}" class="logo" alt="Saint Michel Archange">
  <strong>PAROISSE SAINT MICHEL ARCHANGE DE LA BAE</strong>
  <h1>REÇU CASUEL - {{ $type }}</h1>
</div>

<div class="info">
  <p><strong>Numéro de reçu :</strong> {{ $numero }}</p>
  <p><strong>Date :</strong> {{ $date->format('d/m/Y') }}</p>
  <p><strong>Personne :</strong> {{ $personne }}</p>
  @if($personne2)
  <p><strong>Époux/se :</strong> {{ $personne2 }}</p>
  @endif
  @if($numero_reference)
  <p><strong>Numéro de référence :</strong> {{ $numero_reference }}</p>
  @endif
  @if($note)
  <p><strong>Note :</strong> {{ $note }}</p>
  @endif
</div>

<div class="c total">
  Montant : {{ number_format($montant, 0, ',', ' ') }} FCFA
</div>

<div class="c" style="margin-top: 50px; font-size: 10px; color: #666;">
  Reçu généré le {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}
</div>
</body>
</html>
