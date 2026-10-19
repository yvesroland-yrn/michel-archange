@extends('layouts.paroisse')
@section('contenu')
<div class="welcome mb-4">
  <div class="motto"></div>
  <h2>Tableau de bord - Gestion du stock</h2>
  <p>Vue d'ensemble de la boutique paroissiale.</p>
</div>

<!-- Statistiques principales -->
<div class="row g-3 mb-4">
  <div class="col-6 col-xl-3">
    <div class="stat">
      <div class="ico"><i class="bi bi-box-seam-fill"></i></div>
      <div>
        <div class="val">{{ $totalProduits }}</div>
        <div class="lbl">Produits</div>
      </div>
    </div>
  </div>
  <div class="col-6 col-xl-3">
    <div class="stat green">
      <div class="ico"><i class="bi bi-layers-fill"></i></div>
      <div>
        <div class="val">{{ $totalStock }}</div>
        <div class="lbl">Unités en stock</div>
      </div>
    </div>
  </div>
  <div class="col-6 col-xl-3">
    <div class="stat gold">
      <div class="ico"><i class="bi bi-cash-coin"></i></div>
      <div>
        <div class="val" style="font-size:1.2rem">{{ number_format($valeurStock, 0, ',', ' ') }}</div>
        <div class="lbl">Valeur stock (FCFA)</div>
      </div>
    </div>
  </div>
  <div class="col-6 col-xl-3">
    <div class="stat {{ $stockBas > 0 ? 'red' : '' }}">
      <div class="ico"><i class="bi bi-exclamation-triangle-fill"></i></div>
      <div>
        <div class="val">{{ $stockBas }}</div>
        <div class="lbl">Stock bas</div>
      </div>
    </div>
  </div>
</div>

<div class="row g-3">
  <!-- Alertes de stock bas -->
  <div class="col-lg-6">
    <div class="card mb-4">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bi bi-exclamation-triangle-fill text-danger"></i> Alertes de stock bas</h5>
        <a href="{{ route('stock.index') }}" class="btn btn-sm btn-outline-primary">Voir tout</a>
      </div>
      <div class="card-body">
        @if($produitsEnRupture->count() > 0)
          <div class="table-responsive">
            <table class="table table-sm table-striped mb-0">
              <thead>
                <tr>
                  <th>Produit</th>
                  <th>Quantité</th>
                  <th>Seuil</th>
                  <th>Valeur</th>
                </tr>
              </thead>
              <tbody>
                @foreach($produitsEnRupture as $produit)
                  <tr>
                    <td>{{ $produit->nom }}</td>
                    <td><span class="badge bg-danger">{{ $produit->quantite }}</span></td>
                    <td>{{ $produit->seuil_alerte }}</td>
                    <td>{{ number_format($produit->prix * $produit->quantite, 0, ',', ' ') }} FCFA</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @else
          <p class="text-muted mb-0">Aucun produit en stock bas. ✓</p>
        @endif
      </div>
    </div>
  </div>

  <!-- Derniers produits ajoutés -->
  <div class="col-lg-6">
    <div class="card mb-4">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bi bi-clock-history"></i> Derniers produits ajoutés</h5>
        <a href="{{ route('stock.index') }}" class="btn btn-sm btn-outline-primary">Voir tout</a>
      </div>
      <div class="card-body">
        @if($derniersProduits->count() > 0)
          <div class="table-responsive">
            <table class="table table-sm table-striped mb-0">
              <thead>
                <tr>
                  <th>Produit</th>
                  <th>Catégorie</th>
                  <th>Prix unitaire</th>
                  <th>Quantité</th>
                  <th>Valeur</th>
                </tr>
              </thead>
              <tbody>
                @foreach($derniersProduits as $produit)
                  <tr>
                    <td>{{ $produit->nom }}</td>
                    <td>{{ $produit->categorie ?? '-' }}</td>
                    <td>{{ number_format($produit->prix, 0, ',', ' ') }} FCFA</td>
                    <td>{{ $produit->quantite }}</td>
                    <td>{{ number_format($produit->prix * $produit->quantite, 0, ',', ' ') }} FCFA</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @else
          <p class="text-muted mb-0">Aucun produit enregistré.</p>
        @endif
      </div>
    </div>
  </div>
</div>

<!-- Valeur du stock par produit -->
<div class="card mb-4">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0"><i class="bi bi-cash-coin"></i> Valeur du stock par produit</h5>
    <a href="{{ route('stock.index') }}" class="btn btn-sm btn-outline-primary">Voir tout</a>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-striped align-middle">
        <thead>
          <tr>
            <th>Produit</th>
            <th>Catégorie</th>
            <th>Prix unitaire</th>
            <th>Quantité</th>
            <th>Valeur totale</th>
            <th>Statut</th>
          </tr>
        </thead>
        <tbody>
          @php
            $tousProduits = \App\Models\Produit::orderBy('nom')->get();
          @endphp
          @forelse($tousProduits as $produit)
            <tr>
              <td>{{ $produit->nom }}</td>
              <td>{{ $produit->categorie ?? '-' }}</td>
              <td>{{ number_format($produit->prix, 0, ',', ' ') }} FCFA</td>
              <td>{{ $produit->quantite }}</td>
              <td><strong>{{ number_format($produit->prix * $produit->quantite, 0, ',', ' ') }} FCFA</strong></td>
              <td>
                @if($produit->estEnRupture())
                  <span class="badge bg-danger">Stock bas</span>
                @else
                  <span class="badge bg-success">OK</span>
                @endif
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-center text-muted">Aucun produit enregistré.</td>
            </tr>
          @endforelse
        </tbody>
        <tfoot>
          <tr class="table-primary">
            <td colspan="4" class="text-end"><strong>Total :</strong></td>
            <td><strong>{{ number_format($valeurStock, 0, ',', ' ') }} FCFA</strong></td>
            <td></td>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
</div>

<div class="text-center mt-4">
  <a href="{{ route('stock.index') }}" class="btn btn-lg btn-primary me-2">
    <i class="bi bi-box-seam"></i> Gérer le stock
  </a>
  <a href="{{ route('stock.rapport') }}" class="btn btn-lg btn-outline-primary me-2">
    <i class="bi bi-file-earmark-bar-graph"></i> Rapports
  </a>
  <a href="{{ route('stock.produits.pdf') }}" target="_blank" class="btn btn-lg btn-outline-success me-2">
    <i class="bi bi-file-earmark-spreadsheet"></i> Inventaire PDF
  </a>
  <a href="{{ route('stock.rapport.pdf') }}?vue=tout" target="_blank" class="btn btn-lg btn-outline-danger">
    <i class="bi bi-file-earmark-pdf"></i> Mouvements PDF
  </a>
</div>
@endsection
