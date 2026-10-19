<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Inventaire du Stock</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 10px;
            color: #333;
            line-height: 1.3;
            background: #fff;
        }
        .page {
            max-width: 900px;
            margin: 0 auto;
            padding: 35px 25px;
        }

        /* ============ EN-TÊTE ============ */
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #B8892E;
        }
        .logo {
            max-width: 85px;
            height: auto;
            display: block;
            margin: 0 auto 10px;
            border-radius: 50%;
            border: 3px solid #B8892E;
        }
        .parish-name {
            font-size: 12px;
            font-weight: bold;
            color: #1F3A5F;
            letter-spacing: 1.5px;
            margin-bottom: 6px;
            text-transform: uppercase;
        }
        h1 {
            color: #1F3A5F;
            letter-spacing: 2px;
            font-size: 16px;
            margin: 6px 0;
            font-weight: 700;
        }

        /* ============ BARRE D'INFOS ============ */
        table.info-bar {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin: 20px 0;
            background: #f1f3f5;
            border-left: 5px solid #1F3A5F;
        }
        table.info-bar td {
            padding: 14px 18px;
            vertical-align: middle;
            color: #555;
        }
        table.info-bar td.info-right {
            text-align: right;
        }
        table.info-bar p {
            margin: 3px 0;
        }
        table.info-bar strong {
            color: #1F3A5F;
        }

        /* ============ SECTIONS ============ */
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
            letter-spacing: 0.6px;
            color: #666;
        }

        /* ============ TABLEAU DES PRODUITS ============ */
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .data-table th {
            background: #333;
            color: #666;
            padding: 11px 8px;
            text-align: left;
            font-weight: 600;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }
        .data-table td {
            padding: 10px 8px;
            border-bottom: 1px solid #e0e0e0;
        }
        .data-table tbody tr:nth-child(even) td {
            background: #f8f9fa;
        }
        .data-table tr.total-row td {
            background: #333;
            color: #666;
            font-weight: bold;
            border-bottom: none;
        }

        .badge {
            padding: 4px 10px;
            border-radius: 10px;
            font-size: 8px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }
        .badge-success   { background-color: #27ae60; color: #fff; }
        .badge-danger    { background-color: #e74c3c; color: #fff; }
        .badge-secondary { background-color: #6c757d; color: #fff; }

        .price {
            font-weight: bold;
            color: #1F3A5F;
        }
        .no-data {
            text-align: center;
            padding: 35px;
            color: #999;
            font-style: italic;
            font-size: 11px;
        }

        /* ============ PIED DE PAGE ============ */
        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #ddd;
            color: #777;
            font-size: 9px;
        }
        .footer p {
            margin: 3px 0;
        }
    </style>
</head>
<body>
    <div class="page">

        {{-- En-tête --}}
        <div class="header">
            <img src="{{ public_path('images/logo-sanctuaire.jpg') }}" class="logo" alt="Sanctuaire Notre-Dame de Cana">
            <div class="parish-name">Sanctuaire Marial Notre-Dame de Cana Sassako</div>
            <h1>Inventaire du Stock - Boutique</h1>
        </div>

        {{-- Barre d'infos --}}
        <table class="info-bar">
            <tr>
                <td>
                    <p><strong>Date d'édition :</strong> {{ now()->format('d/m/Y H:i') }}</p>
                    <p><strong>Type de document :</strong> Liste des produits enregistrés</p>
                </td>
                <td class="info-right">
                    <p><strong>Nombre de produits :</strong> {{ $totalProduits }}</p>
                </td>
            </tr>
        </table>

        {{-- Vue d'ensemble --}}
        <div class="section">
            <div class="section-title">Vue d'ensemble du Stock</div>

            <table class="kpi">
                <tr>
                    <td class="kpi-badge-cell"><span class="kpi-badge">A</span></td>
                    <td class="kpi-gap"></td>
                    <td class="kpi-badge-cell"><span class="kpi-badge">B</span></td>
                    <td class="kpi-gap"></td>
                    <td class="kpi-badge-cell"><span class="kpi-badge">C</span></td>
                    <td class="kpi-gap"></td>
                    <td class="kpi-badge-cell"><span class="kpi-badge">D</span></td>
                </tr>
                <tr>
                    <td class="kpi-card k1">
                        <div class="kpi-inner">
                            <div class="kpi-icon">☰</div>
                            <div class="kpi-value">{{ $totalProduits }}</div>
                            <div class="kpi-label">Produits</div>
                        </div>
                    </td>
                    <td class="kpi-link"><div class="kpi-bar b1"></div></td>

                    <td class="kpi-card k2">
                        <div class="kpi-inner">
                            <div class="kpi-icon">▥</div>
                            <div class="kpi-value">{{ $totalStock }}</div>
                            <div class="kpi-label">Unités en stock</div>
                        </div>
                    </td>
                    <td class="kpi-link"><div class="kpi-bar b2"></div></td>

                    <td class="kpi-card k3">
                        <div class="kpi-inner">
                            <div class="kpi-icon">⛁</div>
                            <div class="kpi-value kpi-value-sm">{{ number_format($valeurStock, 0, ',', ' ') }}</div>
                            <div class="kpi-label">Valeur (FCFA)</div>
                        </div>
                    </td>
                    <td class="kpi-link"><div class="kpi-bar b3"></div></td>

                    <td class="kpi-card k4" style="background: {{ $stockBas > 0 ? '#e74c3c' : '#3a96dc' }}">
                        <div class="kpi-inner">
                            <div class="kpi-icon">⚠</div>
                            <div class="kpi-value">{{ $stockBas }}</div>
                            <div class="kpi-label">Stock bas</div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        {{-- Liste des produits --}}
        <div class="section">
            <div class="section-title">Liste des Produits</div>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Produit</th>
                        <th>Catégorie</th>
                        <th>Prix unitaire</th>
                        <th>Quantité</th>
                        <th>Valeur totale</th>
                        <th>Seuil alerte</th>
                        <th>Statut</th>
                        <th>Actif</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($produits as $index => $produit)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><strong>{{ $produit->nom }}</strong></td>
                            <td>{{ $produit->categorie ?? '-' }}</td>
                            <td class="price">{{ number_format($produit->prix, 0, ',', ' ') }} FCFA</td>
                            <td style="font-weight: bold;">{{ $produit->quantite }}</td>
                            <td class="price">{{ number_format($produit->prix * $produit->quantite, 0, ',', ' ') }} FCFA</td>
                            <td>{{ $produit->seuil_alerte }}</td>
                            <td>
                                @if($produit->estEnRupture())
                                    <span class="badge badge-danger">Stock bas</span>
                                @else
                                    <span class="badge badge-success">OK</span>
                                @endif
                            </td>
                            <td>
                                @if($produit->actif)
                                    <span class="badge badge-success">Oui</span>
                                @else
                                    <span class="badge badge-secondary">Non</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="no-data">Aucun produit enregistré.</td>
                        </tr>
                    @endforelse

                    @if($produits->count() > 0)
                        <tr class="total-row">
                            <td colspan="5" style="text-align: right;">TOTAL GÉNÉRAL :</td>
                            <td>{{ number_format($valeurStock, 0, ',', ' ') }} FCFA</td>
                            <td colspan="3"></td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        {{-- Pied de page --}}
        <div class="footer">
            <p><strong>Sanctuaire Marial Notre-Dame de Cana Sassako</strong></p>
            <p>Système de Gestion Paroissiale - Gestion du Stock Boutique</p>
            <p>Document généré automatiquement le {{ now()->format('d/m/Y à H:i') }}</p>
        </div>

    </div>
</body>
</html>