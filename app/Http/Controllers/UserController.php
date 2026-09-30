<?php
namespace App\Http\Controllers;
use App\Models\User;
class UserController extends CrudController {
    protected string $model = User::class; protected string $route = 'users';
    protected string $titre = 'Utilisateurs'; protected string $singulier = 'Utilisateur';
    protected array $searchable = ['name', 'email'];
    public const ROLES = ['admin' => 'Administrateur', 'cure' => 'Curé / Vicaire', 'secretaire' => 'Secrétaire', 'tresorier' => 'Trésorier', 'catechiste' => 'Catéchiste'];
    protected function fields(): array {
        return [
            'name' => ['Nom complet', 'text', true],
            'email' => ['E-mail', 'email', true],
            'role' => ['Rôle', 'select', true, self::ROLES],
            'permissions' => ['Rubriques accessibles (laisser vide pour aucune)', 'checkbox', false, User::RUBRIQUES],
            'password' => ['Mot de passe (laisser vide pour ne pas changer)', 'password'],
        ];
    }
    protected function columns(): array {
        return [
            'Nom' => 'name',
            'E-mail' => 'email',
            'Rôle' => fn ($u) => self::ROLES[$u->role] ?? $u->role,
            'Permissions' => fn ($u) => $u->role === 'admin' ? 'Tout accès' : ($u->permissions ? implode(', ', $u->permissions) : 'Aucune'),
        ];
    }
    protected function extraRules($item = null): array {
        return [
            'email' => 'required|email|unique:users,email,'.($item?->id ?? 'NULL'),
            'password' => ($item ? 'nullable' : 'required').'|string|min:8',
            'permissions' => 'nullable|array',
            'permissions.*' => 'string|in:'.implode(',', array_keys(User::RUBRIQUES)),
        ];
    }
    protected function prepare(array $d, $item = null): array {
        if (empty($d['password'])) unset($d['password']);
        if (isset($d['permissions']) && empty($d['permissions'])) {
            $d['permissions'] = null;
        }
        return $d;
    }
    public function destroy($id) {
        if ((int) $id === auth()->id()) return back()->withErrors('Vous ne pouvez pas supprimer votre propre compte.');
        return parent::destroy($id);
    }
}
