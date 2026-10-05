@extends('layouts.paroisse')
@section('contenu')
<h1 class="h3 mb-3">{{ $item->exists ? 'Modifier' : 'Ajouter' }} — {{ $singulier }}</h1>
<form method="POST" action="{{ $item->exists ? route($route.'.update', $item->id) : route($route.'.store') }}" class="card card-body row g-3 mx-0" enctype="multipart/form-data" id="crud-form">
@csrf @if($item->exists) @method('PUT') @endif
@foreach($fields as $k => [$label, $t, $req, $opts])
@php $v = $t === 'password' ? '' : old($k, $item->$k ?? null); if ($v instanceof \Carbon\Carbon) $v = $v->format($t === 'datetime' ? 'Y-m-d\TH:i' : 'Y-m-d'); @endphp
<div class="{{ $t === 'textarea' || $t === 'file' || ($t === 'checkbox' && is_array($opts)) ? 'col-12' : 'col-md-6' }}" id="field-{{ $k }}"><label class="form-label">{{ $label }} @if($req)<span class="text-danger">*</span>@endif</label>
@if($t === 'select')<select name="{{ $k }}" class="form-select" @required($req) id="select-{{ $k }}"><option value="">—</option>@foreach($opts as $ov => $ol)<option value="{{ $ov }}" @selected((string) $v === (string) $ov)>{{ $ol }}</option>@endforeach</select>
@elseif($t === 'textarea')<textarea name="{{ $k }}" rows="4" class="form-control" @required($req)>{{ $v }}</textarea>
@elseif($t === 'file')
<input type="file" name="{{ $k }}" class="form-control" @if(!$req) @endif accept="image/*">
@if($item->$k && $item->$k !== '')
<div class="mt-2">
  <img src="{{ asset('storage/' . $item->$k) }}" alt="Image actuelle" style="max-height: 100px; border-radius: 4px;">
  <small class="text-muted d-block">Image actuelle</small>
</div>
@endif
@elseif($t === 'checkbox')
@if(is_array($opts))
<div class="card">
  <div class="card-header py-2">
    <label class="form-label mb-0 fw-semibold">{{ $label }}</label>
  </div>
  <div class="card-body">
    <div class="row g-2">
      @foreach($opts as $ov => $ol)
      <div class="col-md-6 col-lg-4">
        <div class="form-check form-check-card">
          <input type="checkbox" name="{{ $k }}[]" class="form-check-input" id="{{ $k }}_{{ $ov }}" value="{{ $ov }}" @if(is_array($v) && in_array($ov, $v)) checked @endif>
          <label class="form-check-label" for="{{ $k }}_{{ $ov }}">{{ $ol }}</label>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</div>
@else
<div class="form-check">
  <input type="checkbox" name="{{ $k }}" class="form-check-input" id="{{ $k }}" @if($v) checked @endif value="1">
  <label class="form-check-label" for="{{ $k }}">{{ $label }}</label>
</div>
@endif
@else<input type="{{ ['datetime' => 'datetime-local', 'number' => 'number'][$t] ?? $t }}" name="{{ $k }}" value="{{ $v }}" class="form-control" @required($req) @if($t==='number') min="0" @endif autocomplete="off">@endif</div>
@endforeach
<div class="col-12"><button class="btn btn-primary">Enregistrer</button> <a href="{{ route($route.'.index') }}" class="btn btn-link">Annuler</a></div></form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.getElementById('select-type');
    if (typeSelect) {
        function toggleMarriageFields() {
            const isMariage = typeSelect.value === 'mariage';
            const conjointField = document.getElementById('field-conjoint_id');
            const nomEpouseField = document.getElementById('field-nom_epouse');
            const temoin1Field = document.getElementById('field-temoin1');
            const temoin2Field = document.getElementById('field-temoin2');
            const numeroRegistreField = document.getElementById('field-numero_registre_mariage');

            if (conjointField) {
                conjointField.style.display = isMariage ? 'block' : 'none';
                const conjointSelect = conjointField.querySelector('select');
                if (conjointSelect) {
                    if (isMariage) {
                        conjointSelect.required = false;
                    } else {
                        conjointSelect.required = false;
                        conjointSelect.value = '';
                    }
                }
            }

            if (nomEpouseField) {
                nomEpouseField.style.display = isMariage ? 'block' : 'none';
                const nomEpouseInput = nomEpouseField.querySelector('input');
                if (nomEpouseInput) {
                    if (!isMariage) {
                        nomEpouseInput.value = '';
                    }
                }
            }

            if (temoin1Field) {
                temoin1Field.style.display = isMariage ? 'block' : 'none';
                const temoin1Input = temoin1Field.querySelector('input');
                if (temoin1Input) {
                    if (isMariage) {
                        temoin1Input.required = true;
                    } else {
                        temoin1Input.required = false;
                        temoin1Input.value = '';
                    }
                }
            }

            if (temoin2Field) {
                temoin2Field.style.display = isMariage ? 'block' : 'none';
                const temoin2Input = temoin2Field.querySelector('input');
                if (temoin2Input) {
                    if (isMariage) {
                        temoin2Input.required = true;
                    } else {
                        temoin2Input.required = false;
                        temoin2Input.value = '';
                    }
                }
            }

            if (numeroRegistreField) {
                numeroRegistreField.style.display = isMariage ? 'block' : 'none';
                const numeroRegistreInput = numeroRegistreField.querySelector('input');
                if (numeroRegistreInput) {
                    if (!isMariage) {
                        numeroRegistreInput.value = '';
                    }
                }
            }
        }

        typeSelect.addEventListener('change', toggleMarriageFields);
        toggleMarriageFields();

        // Clear nom_epouse when conjoint_id is selected, and vice versa
        const conjointSelect = document.getElementById('select-conjoint_id');
        const nomEpouseInput = document.getElementById('nom_epouse');
        if (conjointSelect && nomEpouseInput) {
            conjointSelect.addEventListener('change', function() {
                if (this.value) {
                    nomEpouseInput.value = '';
                }
            });
            nomEpouseInput.addEventListener('input', function() {
                if (this.value) {
                    conjointSelect.value = '';
                }
            });
        }
    }
});
</script>
@endsection
