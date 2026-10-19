<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Rapport du Stock</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 11px;
            color: #333;
            line-height: 1.4;
            background: #fff;
        }
        .page {
            max-width: 800px;
            margin: 0 auto;
            padding: 40px 30px;
        }
        .header {
            text-align: center;
            margin-bottom: 35px;
            padding-bottom: 25px;
            border-bottom: 3px solid #B8892E;
        }
        .logo {
            max-width: 90px;
            height: auto;
            display: block;
            margin: 0 auto 12px;
            border-radius: 50%;
            border: 3px solid #B8892E;
        }
        .parish-name {
            font-size: 13px;
            font-weight: bold;
            color: #1F3A5F;
            letter-spacing: 1.5px;
            margin-bottom: 8px;
            text-transform: uppercase;
        }
        h1 {
            color: #1F3A5F;
            letter-spacing: 3px;
            font-size: 18px;
            margin: 8px 0;
            font-weight: 700;
        }
        .info-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 20px 0;
            padding: 15px 18px;
            background: #f1f3f5;
            border-left: 5px solid #1F3A5F;
            border-radius: 4px;
        }
        .info-bar div {
            flex: 1;
        }
        .info-bar p {
            margin: 3px 0;
            color: #555;
        }
        .info-bar strong {
            color: #1F3A5F;
        }
        .info-bar-right {
            text-align: right;
        }
        .section {
            margin: 25px 0;
        }
        .section-title {
            font-size: 12px;
            font-weight: bold;
            color: #1F3A5F;
            margin-bottom: 15px;
            padding-bottom: 6px;
            border-bottom: 2px solid #B8892E;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* ============ CARTES KPI ============ */
        table.kpi {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }
        table.kpi td {
            padding: 0;
            border: none;
        }

        /* Badges A B C D */
        .kpi-badge-cell {
            text-align: center;
            padding-bottom: 6px;
        }
        .kpi-badge {
            display: inline-block;
            width: 22px;
            height: 22px;
            line-height: 22px;
            border-radius: 50%;
            background: #333;
            color: #fff;
            font-size: 10px;
            font-weight: bold;
            text-align: center;
            border: 2px solid #fff;
        }

        /* Espace + liaison entre cartes */
        .kpi-gap  { width: 14px; }
        .kpi-link { width: 14px; vertical-align: middle; }
        .kpi-bar  { height: 22px; }
        .b1 { background: #999; }
        .b2 { background: #999; }
        .b3 { background: #999; }

        /* Cartes */
        table.kpi td.kpi-card {
            width: 23%;
            border-radius: 14px;
            padding: 8px;
            text-align: center;
            color: #333;
            background: #f5f5f5;
            border: 1px solid #ddd;
        }

        /* Cadre intérieur arrondi */
        .kpi-inner {
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            padding: 14px 6px 12px;
        }
        .kpi-icon {
            font-size: 22px;
            line-height: 1;
            margin-bottom: 8px;
            color: #666;
        }
        .kpi-value {
            font-size: 20px;
            font-weight: bold;
            color: #333;
            margin-bottom: 4px;
        }
        .kpi-value-sm {
            font-size: 13px;
            padding: 4px 0;
        }
        .kpi-label {
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        th {
            background: linear-gradient(135deg, #1F3A5F 0%, #2c5282 100%);
            color: white;
            padding: 14px 12px;
            text-align: left;
            font-weight: 600;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        td {
            padding: 12px;
            border-bottom: 1px solid #e0e0e0;
        }
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        tr:hover {
            background-color: #e3f2fd;
        }
        .badge {
            padding: 5px 12px;
            border-radius: 12px;
            font-size: 9px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .badge-success {
            background-color: #27ae60;
            color: white;
        }
        .badge-danger {
            background-color: #e74c3c;
            color: white;
        }
        .footer {
            text-align: center;
            margin-top: 45px;
            padding-top: 25px;
            border-top: 2px solid #ddd;
            color: #777;
            font-size: 9px;
        }
        .footer p {
            margin: 4px 0;
        }
        .no-data {
            text-align: center;
            padding: 40px;
            color: #999;
            font-style: italic;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="header">
            <img src="{{ public_path('images/logo-sanctuaire.jpg') }}" class="logo" alt="Sanctuaire Notre-Dame de Cana">
            <div class="parish-name">Sanctuaire Marial Notre-Dame de Cana Sassako</div>
            <h1>Rapport du Stock</h1>
        </div>

        <div class="info-bar">
            <div>
                <p><strong>Période :</strong> {{ $periodeLabel }}</p>
                <p><strong>Date d'édition :</strong> {{ now()->format('d/m/Y H:i') }}</p>
            </div>
            <div class="info-bar-right">
                <p><strong>Nombre de mouvements :</strong> {{ $mouvements->count() }}</p>
            </div>
        </div>

        <div class="section">
            <div class="section-title">Statistiques des Mouvements</div>
            <table class="kpi">
                <tr>
                    <td class="kpi-card k1">
                        <div class="kpi-inner">
                            <div class="kpi-badge">01</div>
                            <div class="kpi-value">{{ $stats['total_entrees'] }}</div>
                            <div class="kpi-label">Entrées totales</div>
                        </div>
                    </td>
                    <td class="kpi-gap"></td>
                    <td class="kpi-link">
                        <div class="kpi-bar b1"></div>
                    </td>
                    <td class="kpi-gap"></td>
                    <td class="kpi-card k2">
                        <div class="kpi-inner">
                            <div class="kpi-badge">02</div>
                            <div class="kpi-value">{{ $stats['total_sorties'] }}</div>
                            <div class="kpi-label">Sorties totales</div>
                        </div>
                    </td>
                    <td class="kpi-gap"></td>
                    <td class="kpi-link">
                        <div class="kpi-bar b2"></div>
                    </td>
                    <td class="kpi-gap"></td>
                    <td class="kpi-card k3">
                        <div class="kpi-inner">
                            <div class="kpi-badge">03</div>
                            <div class="kpi-value">{{ $stats['nb_entrees'] }}</div>
                            <div class="kpi-label">Nb. entrées</div>
                        </div>
                    </td>
                    <td class="kpi-gap"></td>
                    <td class="kpi-link">
                        <div class="kpi-bar b3"></div>
                    </td>
                    <td class="kpi-gap"></td>
                    <td class="kpi-card k4">
                        <div class="kpi-inner">
                            <div class="kpi-badge">04</div>
                            <div class="kpi-value">{{ $stats['nb_sorties'] }}</div>
                            <div class="kpi-label">Nb. sorties</div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <div class="section">
            <div class="section-title">Détail des Mouvements de Stock</div>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Produit</th>
                        <th>Type</th>
                        <th>Quantité</th>
                        <th>Raison</th>
                        <th>Utilisateur</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mouvements as $mouvement)
                        <tr>
                            <td>{{ $mouvement->date->format('d/m/Y') }}</td>
                            <td><strong>{{ $mouvement->produit->nom }}</strong></td>
                            <td>
                                @if($mouvement->type === 'entree')
                                    <span class="badge badge-success">Entrée</span>
                                @else
                                    <span class="badge badge-danger">Sortie</span>
                                @endif
                            </td>
                            <td style="font-weight: bold;">{{ $mouvement->quantite }}</td>
                            <td>{{ $mouvement->raison ?? '-' }}</td>
                            <td>{{ $mouvement->user?->name ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="no-data">Aucun mouvement enregistré pour cette période.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="footer">
            <p><strong>Sanctuaire Marial Notre-Dame de Cana Sassako</strong></p>
            <p>Système de Gestion Paroissiale</p>
            <p>Document généré automatiquement le {{ now()->format('d/m/Y à H:i') }}</p>
        </div>
    </div>
</body>
</html>
