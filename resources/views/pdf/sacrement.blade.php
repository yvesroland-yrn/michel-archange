<!doctype html><html lang="fr"><head><meta charset="utf-8"><style>body{font-family:DejaVu Sans,sans-serif;font-size:12px;color:#222}.c{text-align:center}h1{color:#1F3A5F;letter-spacing:2px;font-size:22px}.box{border:3px double #B8892E;padding:28px}td,th{padding:5px 8px;vertical-align:top}.sig{margin-top:60px}table.g{width:100%;border-collapse:collapse}table.g td,table.g th{border:1px solid #bbb}table.g th{background:#1F3A5F;color:#fff}.logo{max-width:80px;height:auto;display:block;margin:0 auto 15px;border-radius:50%;border:3px solid #B8892E}</style></head><body><div class="box">
<div class="c"><img src="{{ public_path('images/saint.jpg') }}" class="logo" alt="Saint Michel Archange"><strong>PAROISSE SAINT MICHEL ARCHANGE DE LA BAE</strong><h1>CERTIFICAT — {{ mb_strtoupper($libelle) }}</h1>N° {{ $s->numero_acte }}</div><br>
<p>Je soussigné, certifie que :</p>
<table>
@if($s->type === 'mariage')<tr><td>Époux</td><td><strong>{{ $s->fidele->nom_complet }}</strong></td></tr><tr><td>Épouse</td><td><strong>{{ $s->conjoint?->nom_complet }}</strong></td></tr>
@else<tr><td>Nom et prénoms</td><td><strong>{{ $s->fidele->nom_complet }}</strong></td></tr><tr><td>Né(e) le</td><td>{{ $s->fidele->date_naissance?->format('d/m/Y') }} à {{ $s->fidele->lieu_naissance }}</td></tr>@endif
<tr><td>Sacrement</td><td>{{ $libelle }}</td></tr><tr><td>Célébré le</td><td>{{ $s->date_celebration->format('d/m/Y') }} {{ $s->lieu ? 'à '.$s->lieu : '' }}</td></tr>
<tr><td>Ministre</td><td>{{ $s->ministre }}</td></tr>
@if($s->temoin1 || $s->temoin2)<tr><td>Témoins</td><td>{{ $s->temoin1 }} / {{ $s->temoin2 }}</td></tr>@endif</table>
<p style="margin-top: 40px;">Délivré à Abidjan, le {{ now()->format('d/m/Y') }}</p>
<div style="display: flex; justify-content: space-between; margin-top: 80px;">
  <div style="width: 35%; border: 2px solid #1F3A5F; padding: 20px; height: 100px; text-align: center;">
    <strong>Le Trésorier</strong><br><br><br>Signature et cachet
  </div>
  <div style="width: 55%; border: 2px solid #1F3A5F; padding: 20px; height: 100px; text-align: center;">
    <strong>Le Curé</strong><br><br><br>Signature et cachet
  </div>
</div></div></body></html>
