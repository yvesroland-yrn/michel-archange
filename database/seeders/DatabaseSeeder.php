<?php
namespace Database\Seeders;
use App\Models\{User, Ceb};
use Illuminate\Database\Seeder;
class DatabaseSeeder extends Seeder {
    public function run(): void {
        User::updateOrCreate(['email' => 'admin@paroisse.test'], [
            'name' => 'Administrateur',
            'password' => 'password',
            'role' => 'admin',
            'permissions' => ['fideles', 'sacrements', 'cebs', 'mouvements', 'clerge', 'conseil_paroissial', 'mouvement_paroissial', 'evenements', 'intentions', 'annonces', 'annees_catechetiques', 'classes_cate', 'catechistes', 'catechumenes', 'finances', 'users', 'contacts']
        ]);
        foreach (['CEB Saint Joseph', 'CEB Sainte Marie', 'CEB Saint Pierre'] as $n) Ceb::firstOrCreate(['nom' => $n]);
    }
}
