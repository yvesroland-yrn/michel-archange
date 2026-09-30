<?php
return [
    'required' => 'Le champ :attribute est obligatoire.',
    'email' => 'Le champ :attribute doit être une adresse e-mail valide.',
    'date' => 'Le champ :attribute n\'est pas une date valide.',
    'integer' => 'Le champ :attribute doit être un nombre entier.',
    'string' => 'Le champ :attribute doit être un texte.',
    'in' => 'La valeur choisie pour :attribute est invalide.',
    'exists' => 'La valeur choisie pour :attribute est invalide.',
    'unique' => 'La valeur de :attribute est déjà utilisée.',
    'min' => ['numeric' => ':attribute doit être au moins :min.', 'string' => ':attribute doit contenir au moins :min caractères.'],
    'max' => ['numeric' => ':attribute ne doit pas dépasser :max.', 'string' => ':attribute ne doit pas dépasser :max caractères.'],
    'attributes' => ['name' => 'nom', 'nom' => 'nom', 'prenoms' => 'prénoms', 'email' => 'e-mail', 'password' => 'mot de passe', 'date' => 'date',
        'montant' => 'montant', 'libelle' => 'libellé', 'ministre' => 'ministre', 'role' => 'rôle', 'fidele_id' => 'fidèle', 'type' => 'type'],
];
