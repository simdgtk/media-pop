<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Auteur;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $auteurs = Auteur::all();

        if ($auteurs->count() === 0) {
            $this->command->error("Aucun auteur trouvé. Lance d'abord le seeder AuteurSeeder !");
            return;
        }

        $articles = [
            [
                'title' => 'Ou Pourquoi le festival de Cannes ?',
                'author' => $auteurs->where('nom', 'Alex Caron')->first()->id,
                'published_at' => now()->subDays(2),
                'content' => '<p>La scène électro connaît une évolution majeure...</p>',
                'image' => 'images/articles/festival-cannes.jpg',
                'category' => ['cinema'],
                'source_title' => 'Sabotage au Festival de Cannes 2025',
                'source_url' => 'https://example.com/music-2025',
                'selected_words' => 'Festival de Cannes',
            ],
            [
                'title' => 'Ou Que signifie le prix Montgolfière d’or ?',
                'author' => $auteurs->where('nom', 'Cyril Fontaine')->first()->id,
                'published_at' => now()->subDays(5),
                'content' => '<p>Les nouveaux réalisateurs français osent davantage...</p>',
                'image' => 'images/articles/montgolfiere.jpg',
                'category' => ['cinema'],
                'source_title' => 'Festival des 3 Continents 2025 : Montgolfière d’or pour un film hors norme',
                'source_url' => 'https://example.com/cinema-fr',
                'selected_words' => 'Montgolfière d’or',
            ],
            [
                'title' => 'Pourquoi utiliser le terme huis clos ?',
                'author' => $auteurs->where('nom', 'Marie Dubreuil')->first()->id,
                'published_at' => now()->subDays(8),
                'content' => '<p>Les studios indépendants proposent des expériences profondes...</p>',
                'image' => 'images/articles/huis-clos.jpg',
                'category' => ['culture'],
                'source_title' => 'Le triomphe de La Maison vide — un huis clos familal sacré Goncourt 2025',
                'source_url' => 'https://example.com/games-2025',
                'selected_words' => 'huis clos',
            ],
            [
                'title' => 'D’ou le mot polar tire son origine ?',
                'author' => $auteurs->where('nom', 'Marie Dubreuil')->first()->id,
                'published_at' => now()->subDays(8),
                'content' => '<p>Les studios indépendants proposent des expériences profondes...</p>',
                'image' => 'images/articles/polar.jpg',
                'category' => ['culture'],
                'source_title' => 'Quand le polar brésilien s’immisce au cinéma avec L’Agent secret',
                'source_url' => 'https://example.com/games-2025',
                'selected_words' => 'polar',
            ],
            [
                'title' => 'Ça veut dire quoi Wrapped ?',
                'author' => $auteurs->where('nom', 'Virginie Lemoine')->first()->id,
                'published_at' => now()->subDays(10),
                'content' => '<p>L’art abstrait attire une nouvelle génération...</p>',
                'image' => 'images/articles/wrapped.jpg',
                'category' => ['musique'],
                'source_title' => 'Wrapped 2025 : le bilan planétaire du streaming révèle les géants de l’année',
                'source_url' => 'https://example.com/art-abstrait',
                'selected_words' => 'wrapped',
            ],
            [
                'title' => 'Pourquoi utiliser le terme concert-bibliothèque ?',
                'author' => $auteurs->where('nom', 'Alex Caron')->first()->id,
                'published_at' => now()->subDays(10),
                'content' => '<p>L’art abstrait attire une nouvelle génération...</p>',
                'image' => 'images/articles/concert-bibliothèque.jpg',
                'category' => ['musique'],
                'source_title' => 'Concert-bibliothèque : redécouvrir la chanson française dans un lieu insolite',
                'source_url' => 'https://example.com/art-abstrait',
                'selected_words' => 'Concert-bibliothèque',
            ],
            [
                'title' => 'Pourquoi le 7ème art ? ',
                'author' => $auteurs->where('nom', 'Alex Caron')->first()->id,
                'published_at' => now()->subDays(10),
                'content' => '<p>L’art abstrait attire une nouvelle génération...</p>',
                'image' => 'images/articles/art.jpg',
                'category' => ['actualite'],
                'source_title' => 'Focus sur le 7ᵉ art au Institut Lumière',
                'source_url' => 'https://example.com/art-abstrait',
                'selected_words' => '7ᵉ art',
            ],
            [
                'title' => 'Pourquoi utiliser le terme concert-bibliothèque ?',
                'author' => $auteurs->where('nom', 'Cyril Fontaine')->first()->id,
                'published_at' => now()->subDays(10),
                'content' => '<p>L’art abstrait attire une nouvelle génération...</p>',
                'image' => 'images/articles/concert-bibliothèque.jpg',
                'category' => ['actualite'],
                'source_title' => 'Concert-bibliothèque : redécouvrir la chanson française dans un lieu insolite',
                'source_url' => 'https://example.com/art-abstrait',
                'selected_words' => 'Concert-bibliothèque',
            ],
            [
                'title' => 'Comment différencier un club amateur d’un club pro ?',
                'author' => $auteurs->where('nom', 'Cyril Fontaine')->first()->id,
                'published_at' => now()->subDays(10),
                'content' => '<p>L’art abstrait attire une nouvelle génération...</p>',
                'image' => 'images/articles/club.jpg',
                'category' => ['sport'],
                'source_title' => 'Coupe de France 2025‑2026 : le PSG face à un club amateur',
                'source_url' => 'https://example.com/art-abstrait',
                'selected_words' => 'club amateur',
            ],
            [
                'title' => 'Pourquoi un duel triptyque ?',
                'author' => $auteurs->where('nom', 'Marie Dubreuil')->first()->id,
                'published_at' => now()->subDays(10),
                'content' => '<p>L’art abstrait attire une nouvelle génération...</p>',
                'image' => 'images/articles/duel-triptyque.jpg',
                'category' => ['sport'],
                'source_title' => '« Duel triptyque » : quand trois pilotes visent la gloire à Abu Dhabi ',
                'source_url' => 'https://example.com/art-abstrait',
                'selected_words' => 'Duel triptyque',
            ],
        ];

        foreach ($articles as $data) {
            Article::firstOrCreate(
                ['title' => $data['title']],
                $data
            );
        }

        $this->command->info("Articles insérés avec succès !");
    }
}
