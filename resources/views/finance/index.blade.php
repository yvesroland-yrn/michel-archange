@extends('layouts.paroisse')
@section('contenu')
<div class="d-flex justify-content-between mb-3">
  <h1 class="h3">Finances</h1>
  <form class="d-flex gap-2">
    @if($mois === 'tout')
      <input type="hidden" name="vue" value="mois">
      <button type="submit" class="btn btn-outline-primary">Vue mensuelle</button>
    @else
      <input type="hidden" name="vue" value="tout">
      <button type="submit" class="btn btn-outline-success">Voir tout</button>
      <input type="month" name="mois" value="{{ $mois }}" class="form-control">
      <button type="submit" class="btn btn-outline-secondary">Voir mois</button>
    @endif
    <select name="category_filter" class="form-select" style="width: auto;">
      <option value="tous">Toutes catégories</option>
      <option value="don">Dons</option>
      <option value="dime">Dîmes</option>
      <option value="quete">Quêtes</option>
      <option value="denier_culte">Denier du culte</option>
      <option value="offrande">Offrandes</option>
      <option value="autre">Autre</option>
    </select>
    <a class="btn btn-outline-dark text-nowrap" target="_blank" href="{{ route('finance.bilan', ['mois' => $mois, 'category' => 'tous']) }}" id="btn-bilan">Bilan PDF</a>
  </form>
</div>

<!-- Boutons de navigation vers les vues spécifiques -->
<div class="row g-2 mb-4">
  <div class="col-6 col-md">
    <a href="{{ route('finance.dons') }}" class="btn btn-primary w-100">
      <i class="bi bi-gift"></i> Dons
    </a>
  </div>
  <div class="col-6 col-md">
    <a href="{{ route('finance.dimes') }}" class="btn btn-success w-100">
      <i class="bi bi-cash-coin"></i> Dîmes
    </a>
  </div>
  <div class="col-6 col-md">
    <a href="{{ route('finance.offrandes') }}" class="btn btn-info w-100">
      <i class="bi bi-heart"></i> Offrandes
    </a>
  </div>
  <div class="col-6 col-md">
    <a href="{{ route('finance.quetes') }}" class="btn btn-warning w-100">
      <i class="bi bi-basket"></i> Quêtes
    </a>
  </div>
  <div class="col-6 col-md">
    <a href="{{ route('finance.denier-culte') }}" class="btn btn-secondary w-100">
      <i class="bi bi-church"></i> Denier du culte
    </a>
  </div>
</div>

@if($mois === 'tout')
  <div class="alert alert-info">
    <strong>Vue globale de toutes les finances</strong>
  </div>
  <div class="row g-3 mb-4">
    <div class="col-md-4">
      <div class="card bg-success text-white">
        <div class="card-body">
          <h5 class="card-title">Total Recettes</h5>
          <h3 class="card-text">{{ number_format($rec->sum('montant'),0,',',' ') }} FCFA</h3>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card bg-danger text-white">
        <div class="card-body">
          <h5 class="card-title">Total Dépenses</h5>
          <h3 class="card-text">{{ number_format($dep->sum('montant'),0,',',' ') }} FCFA</h3>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card bg-dark text-white">
        <div class="card-body">
          <h5 class="card-title">Solde Global</h5>
          <h3 class="card-text">{{ number_format($rec->sum('montant') - $dep->sum('montant'),0,',',' ') }} FCFA</h3>
        </div>
      </div>
    </div>
  </div>
  <div class="row g-3 mb-4">
    <div class="col-md-4">
      <div class="card bg-light">
        <div class="card-body">
          <h6 class="card-title">Quêtes</h6>
          <p class="card-text">{{ number_format($rec->where('type', 'quete')->sum('montant'),0,',',' ') }} FCFA</p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card bg-light">
        <div class="card-body">
          <h6 class="card-title">Deniers du culte</h6>
          <p class="card-text">{{ number_format($rec->where('type', 'denier_culte')->sum('montant'),0,',',' ') }} FCFA</p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card bg-light">
        <div class="card-body">
          <h6 class="card-title">Dîmes</h6>
          <p class="card-text">{{ number_format($rec->where('type', 'dime')->sum('montant'),0,',',' ') }} FCFA</p>
        </div>
      </div>
    </div>
  </div>
  <div class="row g-3 mb-4">
    <div class="col-md-4">
      <div class="card bg-light">
        <div class="card-body">
          <h6 class="card-title">Dons</h6>
          <p class="card-text">{{ number_format($rec->where('type', 'don')->sum('montant'),0,',',' ') }} FCFA</p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card bg-light">
        <div class="card-body">
          <h6 class="card-title">Offrandes de messe</h6>
          <p class="card-text">{{ number_format($rec->where('type', 'offrande_messe')->sum('montant'),0,',',' ') }} FCFA</p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card bg-light">
        <div class="card-body">
          <h6 class="card-title">Autres recettes</h6>
          <p class="card-text">{{ number_format($rec->where('type', 'autre')->sum('montant'),0,',',' ') }} FCFA</p>
        </div>
      </div>
    </div>
  </div>
@else
  <div class="alert alert-dark">Solde du mois : <strong>{{ number_format($solde,0,',',' ') }} FCFA</strong></div>
@endif

<div class="row g-4">
<div class="col-lg-6">
  <h2 class="h5">Recettes ({{ number_format($rec->sum('montant'),0,',',' ') }})</h2>

  <!-- Boutons de sélection rapide de catégorie -->
  <div class="row g-2 mb-3">
    <div class="col-4">
      <button type="button" class="btn btn-outline-primary w-100 category-btn" data-category="don">
        <i class="bi bi-gift"></i> Dons
      </button>
    </div>
    <div class="col-4">
      <button type="button" class="btn btn-outline-success w-100 category-btn" data-category="dime">
        <i class="bi bi-cash-coin"></i> Dîmes
      </button>
    </div>
    <div class="col-4">
      <button type="button" class="btn btn-outline-warning w-100 category-btn" data-category="quete">
        <i class="bi bi-basket"></i> Quêtes
      </button>
    </div>
    <div class="col-4">
      <button type="button" class="btn btn-outline-secondary w-100 category-btn" data-category="denier_culte">
        <i class="bi bi-church"></i> Denier du culte
      </button>
    </div>
    <div class="col-4">
      <button type="button" class="btn btn-outline-info w-100 category-btn" data-category="offrande">
        <i class="bi bi-heart"></i> Offrandes
      </button>
    </div>
  </div>

  <form method="POST" action="{{ route('finance.recettes.store') }}" class="row g-2 mb-2">@csrf
  <div class="col-6"><input type="date" name="date" value="{{ now()->toDateString() }}" class="form-control"></div>
  <div class="col-6">
    <select name="type" id="type-select" class="form-select">
      <option value="">Sélectionner un type...</option>
      @foreach(\App\Models\Recette::TYPES as $k=>$l)
        <option value="{{ $k }}">{{ $l }}</option>
      @endforeach
    </select>
  </div>
  <div class="col-6"><input type="number" name="montant" min="0" placeholder="Montant" class="form-control" id="montant-input" required></div>
  <div class="col-6"><select name="fidele_id" class="form-select"><option value="">Donateur (facultatif)</option>@foreach($fideles as $id=>$n)<option value="{{ $id }}">{{ $n }}</option>@endforeach</select></div>
  <div class="col-12"><input name="note" placeholder="Note" class="form-control"></div><div class="col-12"><button class="btn btn-success w-100">Ajouter la recette</button></div></form>
  <div class="table-responsive"><table class="table table-sm bg-white"><thead><tr><th>Date</th><th>Type</th><th>Reçu</th><th class="text-end">Montant</th></tr></thead><tbody>@foreach($rec as $r)<tr><td>{{ $r->date->format('d/m/Y') }}</td><td>{!! $r->type === 'denier_culte' ? '<i class="bi bi-church"></i> ' : '' !!}{{ \App\Models\Recette::TYPES[$r->type] ?? $r->type }}</td><td><a target="_blank" href="{{ route('finance.recu', $r) }}">{{ $r->recu_numero }}</a></td><td class="text-end">{{ number_format($r->montant,0,',',' ') }}</td></tr>@endforeach</tbody></table></div>
</div>
<div class="col-lg-6"><h2 class="h5">Dépenses ({{ number_format($dep->sum('montant'),0,',',' ') }})</h2>
<form method="POST" action="{{ route('finance.depenses.store') }}" class="row g-2 mb-2">@csrf
<div class="col-6"><input type="date" name="date" value="{{ now()->toDateString() }}" class="form-control"></div>
<div class="col-6"><select name="categorie" class="form-select">@foreach(\App\Models\Depense::CATEGORIES as $k=>$l)<option value="{{ $k }}">{{ $l }}</option>@endforeach</select></div>
<div class="col-6"><input name="libelle" placeholder="Libellé" class="form-control" required></div>
<div class="col-6"><input type="number" name="montant" min="1" placeholder="Montant" class="form-control" required></div><div class="col-12"><button class="btn btn-danger w-100">Ajouter la dépense</button></div></form>
<div class="table-responsive"><table class="table table-sm bg-white"><thead><tr><th>Date</th><th>Libellé</th><th class="text-end">Montant</th></tr></thead><tbody>@foreach($dep as $d)<tr><td>{{ $d->date->format('d/m/Y') }}</td><td>{{ $d->libelle }}</td><td class="text-end">{{ number_format($d->montant,0,',',' ') }}</td></tr>@endforeach</tbody></table></div></div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const categoryTypes = {
        'don': ['don'],
        'dime': ['dime'],
        'quete': ['quete_ordinaire', 'quete_speciale', 'quete_imperative', 'quete_semaine'],
        'denier_culte': ['denier_culte'],
        'offrande': ['offrande_messe'],
        'autre': ['autre']
    };

    const typeSelect = document.getElementById('type-select');

    document.querySelectorAll('.category-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const category = this.dataset.category;
            const types = categoryTypes[category] || [];

            // Réinitialiser le select
            typeSelect.innerHTML = '<option value="">Sélectionner un type...</option>';

            // Ajouter les options de la catégorie
            types.forEach(type => {
                const option = document.createElement('option');
                option.value = type;
                option.textContent = type.charAt(0).toUpperCase() + type.slice(1).replace(/_/g, ' ');
                typeSelect.appendChild(option);
            });

            // Sélectionner le premier type par défaut
            if (types.length > 0) {
                typeSelect.value = types[0];
            }
        });
    });

    // Rendre le montant optionnel pour les offrandes
    typeSelect.addEventListener('change', function() {
        const montantInput = document.getElementById('montant-input');
        if (this.value === 'offrande_messe') {
            montantInput.removeAttribute('required');
            montantInput.placeholder = 'Montant (facultatif)';
        } else {
            montantInput.setAttribute('required', 'required');
            montantInput.placeholder = 'Montant';
        }
    });
    
    // Afficher une icône pour denier_culte
    const queteIcon = document.querySelector('.category-btn[data-category="quete"] i');
    typeSelect.addEventListener('change', function() {
        if (this.value === 'denier_culte' && queteIcon) {
            queteIcon.className = 'bi bi-church';
        } else if (queteIcon) {
            queteIcon.className = 'bi bi-basket';
        }
    });
    
    // Filtrer par catégorie et mettre à jour le lien du bilan PDF
    const categoryFilter = document.querySelector('select[name="category_filter"]');
    const btnBilan = document.getElementById('btn-bilan');
    const recetteTable = document.querySelector('.table-responsive tbody');
    
    // Stocker toutes les lignes de recettes
    const allRecetteRows = Array.from(recetteTable.querySelectorAll('tr'));
    
    categoryFilter.addEventListener('change', function() {
        const selectedCategory = this.value;
        
        // Mettre à jour le lien du bilan PDF
        const currentUrl = new URL(btnBilan.href);
        currentUrl.searchParams.set('category', selectedCategory);
        btnBilan.href = currentUrl.toString();
        
        // Filtrer le tableau des recettes
        allRecetteRows.forEach(row => {
            const typeCell = row.querySelector('td:nth-child(2)');
            if (!typeCell) return;
            
            const typeText = typeCell.textContent.trim();
            let shouldShow = true;
            
            if (selectedCategory !== 'tous') {
                const categoryTypeMap = {
                    'don': ['Don'],
                    'dime': ['Dîme'],
                    'quete': ['Quête ordinaire', 'Quête spéciale', 'Quête impérative', 'Quête en semaine'],
                    'denier_culte': ['Denier du culte'],
                    'offrande': ['Offrande de messe'],
                    'autre': ['Autre']
                };
                
                const allowedTypes = categoryTypeMap[selectedCategory] || [];
                shouldShow = allowedTypes.some(type => typeText.includes(type));
            }
            
            row.style.display = shouldShow ? '' : 'none';
        });
    });
});
</script>
@endsection
