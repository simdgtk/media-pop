<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        
        $selectedWords = null;
        if ($request->selected_words) {
            $decoded = json_decode($request->selected_words, true);
            $selectedWords = is_array($decoded) ? $decoded : [$request->selected_words];
        }

        $article = ArticleBdd::create([
            'title' => $validated['title'],
            'author' => $validated['author'],
            'content' => $validated['content'],
            'category' => $validated['category'],
            'image' => $imagePath,
            'source_title' => $validated['selected_article'] ?? null,
            'source_url' => $validated['selected_article_url'] ?? null,
            'selected_words' => $selectedWords
        ]);

        return redirect('/articles')->with('success', 'Article créé avec succès !');
    }


    public function destroy($id)
    {
        $article = ArticleBdd::findOrFail($id);
        $article->delete();

        return redirect('/articles')->with('success', 'Article supprimé avec succès.');
    }
}
