<?php
namespace Database\Seeders;
use App\Models\{User, Ceb};
use Illuminate\Database\Seeder;
class DatabaseSeeder extends Seeder {
    public function run(): void {
        User::updateOrCreate(['email' => 'admin@paroisse.test'], ['name' => 'Administrateur', 'password' => 'password', 'role' => 'admin']);
        foreach (['CEB Saint Joseph', 'CEB Sainte Marie', 'CEB Saint Pierre'] as $n) Ceb::firstOrCreate(['nom' => $n]);
    }
}
