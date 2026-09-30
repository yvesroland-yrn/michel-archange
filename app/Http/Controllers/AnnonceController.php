<?php
namespace App\Http\Controllers;
use App\Models\Annonce;
use Illuminate\Support\Facades\Storage;

class AnnonceController extends CrudController {
    protected string $model = Annonce::class; 
    protected string $route = 'annonces';
    protected string $titre = 'Annonces paroissiales'; 
    protected string $singulier = 'Annonce';
    protected array $searchable = ['titre', 'contenu'];
    
    protected function fields(): array { 
        return [
            'titre' => ['Titre', 'text', true], 
            'contenu' => ['Contenu', 'textarea', true], 
            'image' => ['Image (affiche)', 'file', false],
            'avec_image' => ['Afficher comme affiche', 'checkbox', false],
            'publie_le' => ['Publiée le', 'date', true], 
            'expire_le' => ['Expire le', 'date']
        ]; 
    }
    
    protected function columns(): array { 
        return [
            'Titre' => 'titre', 
            'Publiée le' => 'publie_le', 
            'Expire le' => 'expire_le', 
            'Avec image' => fn($item) => $item->avec_image ? '<span class="badge bg-success">Oui</span>' : '<span class="badge bg-secondary">Non</span>'
        ]; 
    }
    
    protected function extraRules($item = null): array
    {
        return [
            'image' => 'nullable|image|max:2048',
        ];
    }
    
    protected function prepare(array $data, $item = null): array
    {
        // Gestion de l'image
        if (request()->hasFile('image')) {
            if ($item && $item->image) {
                Storage::disk('public')->delete($item->image);
            }
            $data['image'] = request()->file('image')->store('annonces', 'public');
            $data['avec_image'] = true;
        } elseif (!request()->hasFile('image') && $item) {
            // Modification sans nouvelle image - garder l'image existante
            if (isset($item->image)) {
                $data['image'] = $item->image;
            }
            // Gérer le checkbox
            if (request()->has('avec_image')) {
                $data['avec_image'] = request()->boolean('avec_image');
            } else {
                $data['avec_image'] = $item->avec_image ?? false;
            }
        } else {
            // Nouvelle annonce sans image
            $data['avec_image'] = request()->boolean('avec_image', false);
        }
        
        return $data;
    }
    
    protected function after($item, bool $created): void
    {
        // Nettoyage : si avec_image est false mais image existe, supprimer l'image
        if (!$item->avec_image && $item->image) {
            Storage::disk('public')->delete($item->image);
            $item->image = null;
            $item->save();
        }
    }
}
