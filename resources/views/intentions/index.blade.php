@extends('layouts.paroisse')
@section('contenu')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">{{ $titre }}</h1>
    <div class="d-flex gap-2">
        <a href="{{ route($route.'.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Ajouter
        </a>
        <div class="dropdown">
            <button class="btn btn-outline-warning dropdown-toggle" type="button" data-bs-toggle="dropdown">
                <i class="bi bi-download"></i> Exporter
            </button>
            <ul class="dropdown-menu">
                <li><h6 class="dropdown-header">Format CSV</h6></li>
                <li>
                    <a class="dropdown-item" href="{{ route('intentions.export', ['type' => 'tous']) }}">
                        <i class="bi bi-filetype-csv"></i> Toutes (CSV)
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('intentions.export', ['type' => 'action_grace']) }}">
                        <i class="bi bi-filetype-csv"></i> Actions de grâce (CSV)
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('intentions.export', ['type' => 'repos_eternel']) }}">
                        <i class="bi bi-filetype-csv"></i> Repos éternel (CSV)
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li><h6 class="dropdown-header">Format PDF</h6></li>
                <li>
                    <a class="dropdown-item" href="{{ route('intentions.export-pdf', ['type' => 'tous']) }}">
                        <i class="bi bi-filetype-pdf"></i> Toutes (PDF)
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('intentions.export-pdf', ['type' => 'action_grace']) }}">
                        <i class="bi bi-filetype-pdf"></i> Actions de grâce (PDF)
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('intentions.export-pdf', ['type' => 'repos_eternel']) }}">
                        <i class="bi bi-filetype-pdf"></i> Repos éternel (PDF)
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li><h6 class="dropdown-header">Format Word</h6></li>
                <li>
                    <a class="dropdown-item" href="{{ route('intentions.export-word', ['type' => 'tous']) }}">
                        <i class="bi bi-filetype-docx"></i> Toutes (Word)
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('intentions.export-word', ['type' => 'action_grace']) }}">
                        <i class="bi bi-filetype-docx"></i> Actions de grâce (Word)
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('intentions.export-word', ['type' => 'repos_eternel']) }}">
                        <i class="bi bi-filetype-docx"></i> Repos éternel (Word)
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

@if($searchable)
<form class="mb-3">
    <div class="input-group">
        <input name="q" value="{{ request('q') }}" class="form-control" placeholder="Rechercher…">
        <button class="btn btn-outline-secondary">OK</button>
    </div>
</form>
@endif

<div class="table-responsive">
    <table class="table table-striped bg-white align-middle">
        <thead>
            <tr>
                @foreach($columns as $l => $c)
                    <th>{{ $l }}</th>
                @endforeach
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $item)
                <tr>
                    @foreach($columns as $c)
                        @php
                            $v = $c instanceof \Closure ? $c($item) : data_get($item, $c);
                            if ($v instanceof \Carbon\Carbon) {
                                $v = $v->format($v->format('H:i') === '00:00' ? 'd/m/Y' : 'd/m/Y H:i');
                            }
                        @endphp
                        <td>{!! $v !!}</td>
                    @endforeach
                    <td class="text-end text-nowrap">
                        @foreach($controller->linksFor($item) as $l => $u)
                            <a href="{{ $u }}" class="btn btn-sm btn-outline-secondary" @if(str_contains($l,'PDF')) target="_blank" @endif>{{ $l }}</a>
                        @endforeach
                        <a href="{{ route($route.'.edit', $item->id) }}" class="btn btn-sm btn-outline-primary">Modifier</a>
                        <form method="POST" action="{{ route($route.'.destroy', $item->id) }}" class="d-inline" onsubmit="return confirm('Supprimer cet élément ?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($columns) + 1 }}" class="text-center text-muted">Aucun enregistrement.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{ $items->links() }}
@endsection
