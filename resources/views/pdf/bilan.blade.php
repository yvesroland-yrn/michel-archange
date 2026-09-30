<!doctype html><html lang="fr"><head><meta charset="utf-8"><style>body{font-family:DejaVu Sans,sans-serif;font-size:12px;color:#222}.c{text-align:center}h1{color:#1F3A5F;letter-spacing:2px;font-size:22px}.box{border:3px double #B8892E;padding:28px}td,th{padding:5px 8px;vertical-align:top}.sig{margin-top:60px}table.g{width:100%;border-collapse:collapse}table.g td,table.g th{border:1px solid #bbb}table.g th{background:#1F3A5F;color:#fff}.logo{max-width:80px;height:auto;display:block;margin:0 auto 15px;border-radius:50%;border:3px solid #B8892E}</style></head><body>
<div class="c"><img src="{{ public_path('images/saint.jpg') }}" class="logo" alt="Saint Michel Archange"><strong>PAROISSE SAINT MICHEL ARCHANGE DE LA BAE</strong><h1>BILAN FINANCIER — {{ $mois }}</h1></div>
<h3>Recettes</h3><table class="g"><tr><th>Date</th><th>Nature</th><th>Reçu</th><th>Montant (FCFA)</th></tr>
@foreach($rec as $r)<tr><td>{{ $r->date->format('d/m/Y') }}</td><td>{{ \App\Models\Recette::TYPES[$r->type] ?? $r->type }}</td><td>{{ $r->recu_numero }}</td><td style="text-align:right">{{ number_format($r->montant, 0, ',', ' ') }}</td></tr>@endforeach
<tr><td colspan="3"><strong>Total recettes</strong></td><td style="text-align:right"><strong>{{ number_format($rec->sum('montant'), 0, ',', ' ') }}</strong></td></tr></table>
<h3>Dépenses</h3><table class="g"><tr><th>Date</th><th>Catégorie</th><th>Libellé</th><th>Montant (FCFA)</th></tr>
@foreach($dep as $d)<tr><td>{{ $d->date->format('d/m/Y') }}</td><td>{{ \App\Models\Depense::CATEGORIES[$d->categorie] ?? $d->categorie }}</td><td>{{ $d->libelle }}</td><td style="text-align:right">{{ number_format($d->montant, 0, ',', ' ') }}</td></tr>@endforeach
<tr><td colspan="3"><strong>Total dépenses</strong></td><td style="text-align:right"><strong>{{ number_format($dep->sum('montant'), 0, ',', ' ') }}</strong></td></tr></table>
<h2>Solde du mois : {{ number_format($rec->sum('montant') - $dep->sum('montant'), 0, ',', ' ') }} FCFA</h2>
<div style="display: flex; justify-content: space-between; margin-top: 80px;">
  <div style="width: 35%; border: 2px solid #1F3A5F; padding: 20px; height: 100px; text-align: center;">
    <strong>Le Trésorier</strong><br><br><br>Signature et cachet
  </div>
  <div style="width: 55%; border: 2px solid #1F3A5F; padding: 20px; height: 100px; text-align: center;">
    <strong>Vu et approuvé : le Curé</strong><br><br><br>Signature et cachet
  </div>
</div></body></html>
