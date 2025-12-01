<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Article as ArticleBdd;
use App\Services\RssService;

class Article extends Controller
{
    public function index()
    {
        $articles = ArticleBdd::all();
        return view('articles', ['articles' => $articles]);
    }

    public function create(RssService $rssService)
    {
        $rssBigTitles = $rssService->fetch('https://www.franceinfo.fr/titres.rss');
        $rssCultureTitles = $rssService->fetch('https://www.franceinfo.fr/culture.rss');
        $rssInternetTitles = $rssService->fetch('https://www.franceinfo.fr/internet.rss');
        $rssMusiqueTitles = $rssService->fetch('https://www.franceinfo.fr/culture/musique.rss');
        $rssCinemaTitles = $rssService->fetch('https://www.franceinfo.fr/culture/cinema.rss');
        $rssSportTitles = $rssService->fetch('https://www.franceinfo.fr/sports.rss');

        $categories = [
            'actualite',
            'culture',
            'sport',
            'politique',
            'science',
            'sante',
            'economie',
            'technologie',
            'divertissement',
        ];

        return view('article-create', compact(
            'categories',
            'rssBigTitles',
            'rssCultureTitles',
            'rssInternetTitles',
            'rssMusiqueTitles',
            'rssCinemaTitles',
            'rssSportTitles'
        ));
    }



    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|array',
            'category.*' => 'string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'selected_article' => 'nullable|string',
            'selected_article_url' => 'nullable|string',
            'selected_words' => 'nullable'
        ]);

        $imagePath = null;
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imagePath = $request->file('image')->store('images', 'public');
        }
        
        $selectedWordsString = null;
        if ($request->filled('selected_words')) {
            $selectedWordsString = trim((string) $request->input('selected_words'));
            if ($selectedWordsString === '') {
                $selectedWordsString = null;
            }
        }

        $article = ArticleBdd::create([
            'title' => $validated['title'],
            'author' => $validated['author'],
            'content' => $validated['content'],
            'category' => $validated['category'],
            'image' => $imagePath,
            'source_title' => $validated['selected_article'] ?? null,
            'source_url' => $validated['selected_article_url'] ?? null,
            'selected_words' => $selectedWordsString
        ]);

        return redirect('/articles')->with('success', 'Article créé avec succès !');
    }


    public function destroy($id)
    {
        $article = ArticleBdd::findOrFail($id);
        $article->delete();

        return redirect('/articles')->with('success', 'Article supprimé avec succès.');
    }

    public function latest(Request $request)
    {
        $query = ArticleBdd::orderByDesc('created_at')->limit(5);

        if ($request->has('category') && $request->category) {
            $category = $request->category;
            $query->whereJsonContains('category', $category);
        }

        $articles = $query->get();

        $payload = $articles->map(function ($article) {
            return [
                'id' => $article->id,
                'title' => $article->title,
                'source_title' => $article->source_title ? $this->highlightWords($article->source_title, $article->selected_words) : '',
                'excerpt' => \Illuminate\Support\Str::limit(strip_tags($article->content), 140),
                'image_url' => $article->image_url,
                'source_url' => $article->source_url,
                'created_at' => $article->created_at,
                'category' => $article->category,
            ];
        });

        return response()->json($payload);
    }


    private function highlightWords(?string $text, ?string $words): ?string
    {
        if (!$text || !$words) {
            return $text;
        }

        $list = preg_split('/\s+/', trim($words));

        foreach ($list as $word) {
            if ($word === '') continue;

            $escaped = preg_quote($word, '/');

            $text = preg_replace(
                '/(' . $escaped . ')/iu',
                '<span class="highlight">$1</span>',
                $text
            );
        }

        return $text;
    }



}
