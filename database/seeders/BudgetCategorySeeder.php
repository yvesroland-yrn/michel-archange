<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BudgetCategory;

class BudgetCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            // Dépenses
            ['nom' => 'Liturgie', 'type' => 'depense', 'description' => 'Dépenses liées à la liturgie (cierge, hosties, vin, etc.)'],
            ['nom' => 'Entretien', 'type' => 'depense', 'description' => 'Entretien des bâtiments et matériels'],
            ['nom' => 'Caritas', 'type' => 'depense', 'description' => 'Actions caritatives et aide aux nécessiteux'],
            ['nom' => 'Salaires et Indemnités', 'type' => 'depense', 'description' => 'Salaires du personnel et indemnités'],
            ['nom' => 'Catéchèse', 'type' => 'depense', 'description' => 'Formation catéchétique et matériel pédagogique'],
            ['nom' => 'Événements', 'type' => 'depense', 'description' => 'Organisation des événements paroissiaux'],
            ['nom' => 'Eau et Électricité', 'type' => 'depense', 'description' => 'Factures eau et électricité'],
            ['nom' => 'Communication', 'type' => 'depense', 'description' => 'Dépenses de communication et publicité'],
            ['nom' => 'Sécurité', 'type' => 'depense', 'description' => 'Gardiennage et sécurité'],
            ['nom' => 'Transport', 'type' => 'depense', 'description' => 'Frais de transport et déplacements'],
            ['nom' => 'Frais divers', 'type' => 'depense', 'description' => 'Autres dépenses non classifiées'],

            // Recettes
            ['nom' => 'Dons', 'type' => 'recette', 'description' => 'Dons des fidèles'],
            ['nom' => 'Quêtes', 'type' => 'recette', 'description' => 'Quêtes lors des messes'],
            ['nom' => 'Offrandes', 'type' => 'recette', 'description' => 'Offrandes et collectes'],
            ['nom' => 'Dîme', 'type' => 'recette', 'description' => 'Dîme des fidèles'],
            ['nom' => 'Locations', 'type' => 'recette', 'description' => 'Locations de salles et espaces'],
            ['nom' => 'Subventions', 'type' => 'recette', 'description' => 'Subventions reçues'],
            ['nom' => 'Recettes événementielles', 'type' => 'recette', 'description' => 'Recettes lors des événements'],
        ];

        foreach ($categories as $category) {
            BudgetCategory::firstOrCreate(
                ['nom' => $category['nom']],
                $category
            );
        }

        $this->command->info('Catégories budgétaires créées avec succès.');
    }
}
