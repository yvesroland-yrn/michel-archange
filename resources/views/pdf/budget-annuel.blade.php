<!doctype html><html lang="fr"><head><meta charset="utf-8"><style>body{font-family:DejaVu Sans,sans-serif;font-size:12px;color:#222}.c{text-align:center}h1{color:#1F3A5F;letter-spacing:2px;font-size:22px}.box{border:3px double #B8892E;padding:28px}td,th{padding:5px 8px;vertical-align:top}.sig{margin-top:60px}table.g{width:100%;border-collapse:collapse}table.g td,table.g th{border:1px solid #bbb}table.g th{background:#1F3A5F;color:#fff}.logo{max-width:80px;height:auto;display:block;margin:0 auto 15px;border-radius:50%;border:3px solid #B8892E}.summary{background:#f5f5f5;padding:15px;margin:15px 0;border-left:4px solid #B8892E}</style></head><body>
<div class="c"><img src="{{ $logoSrc }}" class="logo" alt="Sanctuaire Notre-Dame de Cana"><strong>SANCTUAIRE MARIAN NOTRE-DAME DE CANA SASSAKO</strong><h1>BUDGET ANNUEL — {{ $budget->annee }}</h1></div>

<div class="summary">
  <h3 style="margin-top:0">Résumé Financier</h3>
  <p><strong>Total Entrées :</strong> {{ number_format($budget->recettes_totales, 0, ',', ' ') }} FCFA</p>
  <p><strong>Total Sorties :</strong> {{ number_format($budget->depenses_totales, 0, ',', ' ') }} FCFA</p>
  <p><strong>Solde :</strong> {{ number_format($budget->solde, 0, ',', ' ') }} FCFA</p>
  @if($budget->notes)
  <p><strong>Notes :</strong> {{ $budget->notes }}</p>
  @endif
</div>

<h3>Détail du Budget</h3><table class="g"><tr><th>Nom</th><th>Type</th><th>Montant (FCFA)</th><th>Réalisé</th></tr>
@foreach($budget->lignes as $ligne)<tr><td>{{ $ligne->nom }}</td><td>{{ $ligne->type === 'recette' ? 'Entrée' : 'Sortie' }}</td><td style="text-align:right">{{ number_format($ligne->montant, 0, ',', ' ') }}</td><td style="text-align:center">{{ $ligne->realise ? 'Oui' : 'Non' }}</td></tr>@endforeach
<tr><td colspan="3"><strong>Solde</strong></td><td style="text-align:right"><strong>{{ number_format($budget->solde, 0, ',', ' ') }}</strong></td></tr></table>

<h2>Solde de l'année : {{ number_format($budget->solde, 0, ',', ' ') }} FCFA</h2>

<div class="sig">
  <p style="margin-top:40px">Fait à Sassako, le {{ now()->format('d/m/Y') }}</p>
  <p style="margin-top:30px"><strong>Le Responsable Financier</strong></p>
</div>
</body></html>
