<!doctype html><html lang="fr"><head><meta charset="utf-8"><style>body{font-family:DejaVu Sans,sans-serif;font-size:12px;color:#222}.c{text-align:center}h1{color:#1F3A5F;letter-spacing:2px;font-size:22px}.box{border:3px double #B8892E;padding:28px}td,th{padding:5px 8px;vertical-align:top}.sig{margin-top:60px}table.g{width:100%;border-collapse:collapse}table.g td,table.g th{border:1px solid #bbb}table.g th{background:#1F3A5F;color:#fff}.logo{max-width:80px;height:auto;display:block;margin:0 auto 15px;border-radius:50%;border:3px solid #B8892E}</style></head><body><div class="box">
<div class="c"><img src="{{ public_path('images/saint.jpg') }}" class="logo" alt="Saint Michel Archange"><strong>PAROISSE SAINT MICHEL ARCHANGE DE LA BAE</strong><h1>REÇU N° {{ $numero }}</h1></div><br>
<table><tr><td>Date</td><td>{{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</td></tr><tr><td>Reçu de</td><td><strong>{{ $de }}</strong></td></tr>
<tr><td>Motif</td><td>{{ $motif }}</td></tr><tr><td>Montant</td><td><strong>{{ number_format($montant, 0, ',', ' ') }} FCFA</strong></td></tr></table>
<div style="display: flex; justify-content: space-between; margin-top: 80px;">
  <div style="width: 35%; border: 2px solid #1F3A5F; padding: 20px; height: 100px; text-align: center;">
    <strong>Le Trésorier / L'Économe</strong><br><br><br>Signature et cachet
  </div>
  <div style="width: 55%; border: 2px solid #1F3A5F; padding: 20px; height: 100px; text-align: center;">
    <strong>Vu et approuvé : le Curé</strong><br><br><br>Signature et cachet
  </div>
</div></div></body></html>
