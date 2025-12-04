<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Auteur;

class AuteurSeeder extends Seeder
{
    public function run(): void
    {
        $auteurs = [
            [
                'nom' => 'Alex Caron',
                'description' => 'Passionnée de tendances modernes et récits vibrants',
                'image' => 'images/auteurs/portrait-alex.jpg',
            ],
            [
                'nom' => 'Cyril Fontaine',
                'description' => 'Regard franc sur l’actualité culturelle contemporaine',
                'image' => 'images/auteurs/portrait-cyril.jpg',
            ],
            [
                'nom' => 'Marie Dubreuil',
                'description' => 'Curiosité insatiable pour les univers créatifs',
                'image' => 'images/auteurs/portrait-marie.jpg',
            ],
            [
                'nom' => 'Virginie Lemoine',
                'description' => 'Analyse sensible du monde pop quotidien',
                'image' => 'images/auteurs/portrait-virginie.jpg',
            ],
        ];

        foreach ($auteurs as $data) {
            Auteur::firstOrCreate(
                ['nom' => $data['nom']],
                [
                    'description' => $data['description'],
                    'image' => $data['image'],
                ]
            );
        }
    }
}
