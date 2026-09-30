<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role', 'permissions'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public const RUBRIQUES = [
        'fideles' => 'Fidèles',
        'sacrements' => 'Sacrements',
        'cebs' => 'CEB',
        'mouvements' => 'Mouvements',
        'clerge' => 'Clergé',
        'conseil_paroissial' => 'Conseil Paroissial',
        'mouvement_paroissial' => 'Mouvement Paroissial',
        'evenements' => 'Événements',
        'intentions' => 'Intentions de messe',
        'annonces' => 'Annonces',
        'classes_cate' => 'Classes de catéchèse',
        'catechumenes' => 'Catéchumènes',
        'finances' => 'Finances',
        'users' => 'Gestion des utilisateurs',
        'contacts' => 'Contact nous',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'permissions' => 'array',
        ];
    }

    public function hasPermission(string $rubrique): bool
    {
        if ($this->role === 'admin') {
            return true;
        }

        return in_array($rubrique, $this->permissions ?? []);
    }

    public function hasAnyPermission(array $rubriques): bool
    {
        if ($this->role === 'admin') {
            return true;
        }

        return !empty(array_intersect($rubriques, $this->permissions ?? []));
    }
}
