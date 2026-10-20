<!doctype html><html lang="fr"><head><meta charset="utf-8"><style>body{font-family:DejaVu Sans,sans-serif;font-size:12px;color:#222}.c{text-align:center}h1{color:#1F3A5F;letter-spacing:2px;font-size:22px}.box{border:3px double #B8892E;padding:28px}td,th{padding:5px 8px;vertical-align:top}.sig{margin-top:60px}table.g{width:100%;border-collapse:collapse}table.g td,table.g th{border:1px solid #bbb}table.g th{background:#1F3A5F;color:#fff}.logo{max-width:80px;height:auto;display:block;margin:0 auto 15px;border-radius:50%;border:3px solid #B8892E}.summary{background:#f5f5f5;padding:15px;margin:15px 0;border-left:4px solid #B8892E}.badge{padding:3px 8px;border-radius:12px;font-size:10px;font-weight:bold;color:#fff}.badge-success{background:#28a745}.badge-warning{background:#ffc107;color:#000}.badge-danger{background:#dc3545}</style></head><body>
<div class="c"><img src="{{ $logoSrc }}" class="logo" alt="Sanctuaire Notre-Dame de Cana"><strong>SANCTUAIRE MARIAN NOTRE-DAME DE CANA SASSAKO</strong><h1>RAPPORT BUDGÉTAIRE — {{ $annee }}{{ $mois ? ' - Mois ' . $mois : '' }}</h1></div>

<div class="summary">
  <h3 style="margin-top:0">Synthèse</h3>
  <p>Sur {{ $lignes->count() }} lignes : {{ $lignes->filter(fn($l) => $l->taux <= 100 && $l->category->type === 'depense')->count() }} respectées, {{ $lignes->filter(fn($l) => $l->taux > 100 && $l->category->type === 'depense')->count() }} dépassées, {{ $lignes->filter(fn($l) => $l->taux == 0)->count() }} non consommées.</p>
</div>

@foreach($parCategorie as $categorieId => $lignesCat)
@php
$categorie = \App\Models\BudgetCategory::find($categorieId);
@endphp
<h3>{{ $categorie->nom }} ({{ $categorie->type === 'depense' ? 'Dépense' : 'Recette' }})</h3><table class="g"><tr><th>Libellé</th><th>Prévu</th><th>Réalisé</th><th>Écart</th><th>Taux</th><th>Statut</th></tr>
@foreach($lignesCat as $ligne)<tr><td>{{ $ligne->libelle }}</td><td>{{ number_format($ligne->montant_prevu, 0, ',', ' ') }}</td><td>{{ number_format($ligne->montant_realise, 0, ',', ' ') }}</td><td>{{ number_format($ligne->reste, 0, ',', ' ') }}</td><td>{{ number_format($ligne->taux, 1) }}%</td><td>
@if($ligne->taux > 100)<span class="badge badge-danger">Dépassé</span>
@elseif($ligne->taux >= 90)<span class="badge badge-warning">Presque atteint</span>
@else<span class="badge badge-success">En cours</span>
@endif
</td></tr>@endforeach
<tr class="table-primary"><th>Sous-total {{ $categorie->nom }}</th><th>{{ number_format($lignesCat->sum('montant_prevu'), 0, ',', ' ') }}</th><th>{{ number_format($lignesCat->sum(function($l) { return $l->montant_realise; }), 0, ',', ' ') }}</th><th>{{ number_format($lignesCat->sum(function($l) { return $l->reste; }), 0, ',', ' ') }}</th><th>-</th><th>-</th></tr></table>
@endforeach

<h3>Total Général</h3><table class="g"><tr><th>Total Prévu</th><th>Total Réalisé</th><th>Écart Global</th></tr><tr><td>{{ number_format($totalPrevu, 0, ',', ' ') }} FCFA</td><td>{{ number_format($totalRealise, 0, ',', ' ') }} FCFA</td><td>{{ number_format($totalPrevu - $totalRealise, 0, ',', ' ') }} FCFA</td></tr></table>

<div class="sig">
  <p style="margin-top:40px">Fait à Sassako, le {{ now()->format('d/m/Y') }}</p>
  <p style="margin-top:30px"><strong>Le Responsable Financier</strong></p>
</div>
</body></html>
