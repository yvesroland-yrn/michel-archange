<!doctype html><html lang="fr"><head><meta charset="utf-8"><style>body{font-family:DejaVu Sans,sans-serif;font-size:12px;color:#222}.c{text-align:center}h1{color:#1F3A5F;letter-spacing:2px;font-size:22px}.box{border:3px double #B8892E;padding:28px}td,th{padding:5px 8px;vertical-align:top}.sig{margin-top:60px}table.g{width:100%;border-collapse:collapse}table.g td,table.g th{border:1px solid #bbb}table.g th{background:#1F3A5F;color:#fff}.logo{max-width:120px;height:auto;display:block;margin:0 auto 15px}</style></head><body><div class="box">
<div class="c"><img src="{{ asset('images/saint-michel-logo.png') }}" class="logo" alt="Saint Michel Archange"><strong>PAROISSE SAINT MICHEL ARCHANGE DE LA BAE</strong><h1>CERTIFICAT DE MARIAGE</h1>N° {{ $s->numero_acte }}</div><br>
<p>Je soussigné, certifie que le mariage religieux a été célébré entre :</p>
<table><tr><td>Époux</td><td><strong>{{ $s->fidele->nom_complet }}</strong></td></tr>
<tr><td>Né le</td><td>{{ $s->fidele->date_naissance?->format('d/m/Y') }} à {{ $s->fidele->lieu_naissance }}</td></tr>
<tr><td>Épouse</td><td><strong>{{ $s->conjoint?->nom_complet ?? 'Non renseigné' }}</strong></td></tr>
<tr><td>Née le</td><td>{{ $s->conjoint?->date_naissance?->format('d/m/Y') ?? '-' }} à {{ $s->conjoint?->lieu_naissance ?? '-' }}</td></tr>
<tr><td>Le mariage a été célébré le</td><td>{{ $s->date_celebration->format('d/m/Y') }} {{ $s->lieu ? 'à '.$s->lieu : '' }}</td></tr>
<tr><td>Des mains de</td><td>{{ $s->ministre }}</td></tr>
<tr><td>Témoins</td><td>{{ $s->temoin1 }}{{ $s->temoin2 ? ' / '.$s->temoin2 : '' }}</td></tr>
@isset($s->observations)<tr><td>Observations</td><td>{{ $s->observations }}</td></tr>@endisset</table>
<p class="sig">Délivré à Abidjan, le {{ now()->format('d/m/Y') }}<br><br><strong>Le Curé</strong></p></div></body></html>
