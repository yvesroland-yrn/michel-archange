@extends('layouts.paroisse')
@section('contenu')
<h1 class="h3 mb-3">{{ $item->exists ? 'Modifier' : 'Ajouter' }} — {{ $singulier }}</h1>
<form method="POST" action="{{ $item->exists ? route($route.'.update', $item->id) : route($route.'.store') }}" class="card card-body row g-3 mx-0" enctype="multipart/form-data">
@csrf @if($item->exists) @method('PUT') @endif
@foreach($fields as $k => [$label, $t, $req, $opts])
@php $v = $t === 'password' ? '' : old($k, $item->$k ?? null); if ($v instanceof \Carbon\Carbon) $v = $v->format($t === 'datetime' ? 'Y-m-d\TH:i' : 'Y-m-d'); @endphp
<div class="{{ $t === 'textarea' || $t === 'file' || ($t === 'checkbox' && is_array($opts)) ? 'col-12' : 'col-md-6' }}"><label class="form-label">{{ $label }} @if($req)<span class="text-danger">*</span>@endif</label>
@if($t === 'select')<select name="{{ $k }}" class="form-select" @required($req)><option value="">—</option>@foreach($opts as $ov => $ol)<option value="{{ $ov }}" @selected((string) $v === (string) $ov)>{{ $ol }}</option>@endforeach</select>
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
@endsection
