<!doctype html><html lang="fr"><head><meta charset="utf-8"><style>body{font-family:DejaVu Sans,sans-serif;font-size:12px;color:#222}.c{text-align:center}h1{color:#1F3A5F;letter-spacing:2px;font-size:22px}.box{border:3px double #B8892E;padding:28px}td,th{padding:5px 8px;vertical-align:top}.sig{margin-top:60px}table.g{width:100%;border-collapse:collapse}table.g td,table.g th{border:1px solid #bbb}table.g th{background:#1F3A5F;color:#fff}.logo{max-width:120px;height:auto;display:block;margin:0 auto 15px}</style></head><body><div class="box">
<div class="c"><img src="{{ asset('images/saint-michel-logo.png') }}" class="logo" alt="Saint Michel Archange"><strong>PAROISSE SAINT MICHEL ARCHANGE DE LA BAE</strong><h1>CERTIFICAT DE BAPTÊME</h1>N° {{ $b->numero_acte }}</div><br>
<p>Je soussigné, certifie que :</p>
<table><tr><td>Nom et prénoms</td><td><strong>{{ $b->fidele->nom_complet }}</strong></td></tr>
<tr><td>Né(e) le</td><td>{{ $b->fidele->date_naissance?->format('d/m/Y') }} à {{ $b->fidele->lieu_naissance }}</td></tr>
<tr><td>Fils / fille de</td><td>{{ $b->pere }} et {{ $b->mere }}</td></tr>
<tr><td>A reçu le baptême le</td><td>{{ $b->date_bapteme->format('d/m/Y') }} {{ $b->lieu ? 'à '.$b->lieu : '' }}</td></tr>
<tr><td>Des mains de</td><td>{{ $b->ministre }}</td></tr>
<tr><td>Parrain / Marraine</td><td>{{ $b->parrain }} / {{ $b->marraine }}</td></tr>
<tr><td>Registre</td><td>Livre {{ $b->livre }} — Folio {{ $b->folio }}</td></tr>
@isset($b->numero_carnet_bapteme)<tr><td>N° Carnet</td><td>{{ $b->numero_carnet_bapteme }}</td></tr>@endisset
</table>
<p class="sig">Délivré à Abidjan, le {{ now()->format('d/m/Y') }}<br><br><strong>Le Curé</strong></p></div></body></html>
