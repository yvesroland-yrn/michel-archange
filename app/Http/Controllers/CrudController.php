<?php
namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

/**
 * Contrôleur CRUD générique piloté par la définition des champs.
 * fields() : nom => [libellé, type, requis, options]  (types : text, textarea, date, datetime, number, email, select, password, file, checkbox)
 */
abstract class CrudController extends Controller
{
    protected string $model;
    protected string $route;      // préfixe des routes (ex. 'cebs')
    protected string $titre;      // titre pluriel
    protected string $singulier;  // titre singulier
    protected array $searchable = [];
    protected array $with = [];
    protected string $order = 'id';
    protected string $dir = 'desc';

    abstract protected function fields(): array;
    abstract protected function columns(): array; // libellé => clé (dot notation) ou Closure

    protected function links($item): array { return []; }          // liens supplémentaires par ligne
    protected function extraRules($item = null): array { return []; }
    protected function prepare(array $data, $item = null): array { return $data; }
    protected function after($item, bool $created): void {}

    protected function normalized(): array
    {
        return collect($this->fields())->map(fn ($f) => array_pad($f, 4, null))->all();
    }

    protected function rules($item = null): array
    {
        $rules = [];
        foreach ($this->normalized() as $name => [$label, $type, $required, $options]) {
            $r = [$required ? 'required' : 'nullable'];
            $r[] = match ($type) {
                'date' => 'date', 'datetime' => 'date', 'number' => 'integer|min:0', 'email' => 'email|max:255',
                'textarea' => 'string|max:5000', 'select' => 'in:'.implode(',', array_keys($options ?? [])),
                'file' => 'file|max:2048',
                'checkbox' => is_array($options) ? 'array' : 'boolean',
                default => 'string|max:255',
            };
            $rules[$name] = implode('|', $r);
        }
        return array_merge($rules, $this->extraRules($item));
    }

    protected function view(string $name, array $data)
    {
        return view($name, $data + ['route' => $this->route, 'titre' => $this->titre, 'singulier' => $this->singulier, 'fields' => $this->normalized()]);
    }

    public function index(Request $r)
    {
        $q = ($this->model)::with($this->with);
        if ($r->filled('q') && $this->searchable) {
            $q->where(fn ($w) => collect($this->searchable)->each(fn ($c) => $w->orWhere($c, 'like', '%'.$r->q.'%')));
        }
        $items = $q->orderBy($this->order, $this->dir)->paginate(20)->withQueryString();
        return $this->view('crud.index', ['items' => $items, 'columns' => $this->columns(), 'controller' => $this, 'searchable' => (bool) $this->searchable]);
    }

    public function linksFor($item): array { return $this->links($item); }

    public function create() { return $this->view('crud.form', ['item' => new ($this->model)()]); }

    public function store(Request $r)
    {
        $validated = $r->validate($this->rules());
        $prepared = $this->prepare($validated, null);
        $item = ($this->model)::create($prepared);
        $this->after($item, true);
        return redirect()->route($this->route.'.index')->with('ok', $this->singulier.' enregistré(e).');
    }

    public function edit($id) { return $this->view('crud.form', ['item' => ($this->model)::findOrFail($id)]); }

    public function update(Request $r, $id)
    {
        $item = ($this->model)::findOrFail($id);
        $validated = $r->validate($this->rules($item));
        $prepared = $this->prepare($validated, $item);
        $item->update($prepared);
        $this->after($item, false);
        return redirect()->route($this->route.'.index')->with('ok', $this->singulier.' mis(e) à jour.');
    }

    public function destroy($id)
    {
        try { 
            $item = ($this->model)::findOrFail($id);
            // Supprimer l'image si elle existe
            if (isset($item->image) && $item->image) {
                Storage::disk('public')->delete($item->image);
            }
            $item->delete(); 
        }
        catch (QueryException) { return back()->withErrors('Suppression impossible : cet élément est utilisé ailleurs.'); }
        return back()->with('ok', 'Élément supprimé.');
    }
}
