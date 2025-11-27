<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article as ArticleBdd;
use App\Services\RssService;
use Illuminate\Support\Facades\Http as HttpClient;

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
        return view('article-create', compact('categories', 'rssBigTitles', 'rssCultureTitles', 'rssInternetTitles', 'rssMusiqueTitles', 'rssCinemaTitles', 'rssSportTitles'));
    }



    public function store(Request $request)
    {
        // normalize empty-string form inputs to null so `nullable|url` and `nullable|json` work
        $request->merge([
            'source_url' => $request->input('source_url') === '' ? null : $request->input('source_url'),
            'source_title' => $request->input('source_title') === '' ? null : $request->input('source_title'),
            'selected_words' => $request->input('selected_words') === '' ? null : $request->input('selected_words'),
        ]);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|array',
            'category.*' => 'string',
            'source_title' => 'nullable|string',
            'source_url' => 'nullable|url|max:2048',
            'selected_words' => 'nullable|json',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        $imagePath = null;
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        // ensure source_title is populated: if JS didn't set it but a source_url exists, try to extract the page title
        $sourceTitle = $request->input('source_title');
        $sourceUrl = $request->input('source_url');
        if (empty($sourceTitle) && ! empty($sourceUrl)) {
            try {
                $res = HttpClient::get($sourceUrl);
                if ($res->successful()) {
                    if (preg_match('/<title>(.*?)<\/title>/si', $res->body(), $m)) {
                        $sourceTitle = trim(html_entity_decode(strip_tags($m[1])));
                    }
                }
            } catch (\Exception $e) {
                // silent fallback — leave sourceTitle null
            }
        }

        $article = ArticleBdd::create([
            'title' => $validated['title'],
            'author' => $validated['author'],
            'content' => $validated['content'],
            'category' => $validated['category'],
            'image' => $imagePath,
            'source_title' => $sourceTitle,
            'source_url' => $sourceUrl,
            'selected_words' => $request->input('selected_words') ? json_decode($request->input('selected_words'), true) : null,
        ]);

        return redirect('/articles')->with('success', 'Article créé avec succès.');
    }
    public function update(Request $request, $id)
        {
        // normalize empty-string form inputs to null so `nullable|url` and `nullable|json` work
        $request->merge([
            'source_url' => $request->input('source_url') === '' ? null : $request->input('source_url'),
            'source_title' => $request->input('source_title') === '' ? null : $request->input('source_title'),
            'selected_words' => $request->input('selected_words') === '' ? null : $request->input('selected_words'),
        ]);

            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'author' => 'required|string|max:255',
                'content' => 'required|string',
                'category' => 'required|array',
                'category.*' => 'string',
                'source_title' => 'nullable|string',
                'source_url' => 'nullable|url|max:2048',
                'selected_words' => 'nullable|json',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
            ]);

            $article = ArticleBdd::findOrFail($id);

            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $imagePath = $request->file('image')->store('images', 'public');
                $article->image = $imagePath;
            }

            $article->title = $validated['title'];
            $article->author = $validated['author'];
            $article->content = $validated['content'];
            $article->category = $validated['category'];
            // update source fields if provided (and use fallback extraction when title missing)
            $sourceTitle = $request->input('source_title');
            $sourceUrl = $request->input('source_url');
            if (empty($sourceTitle) && ! empty($sourceUrl)) {
                try {
                    $res = HttpClient::get($sourceUrl);
                    if ($res->successful() && preg_match('/<title>(.*?)<\/title>/si', $res->body(), $m)) {
                        $sourceTitle = trim(html_entity_decode(strip_tags($m[1])));
                    }
                } catch (\Exception $e) {
                    // ignore
                }
            }
            $article->source_title = $sourceTitle;
            $article->source_url = $sourceUrl;
            $article->selected_words = $request->input('selected_words') ? json_decode($request->input('selected_words'), true) : null;
            $article->save();

            return redirect('/articles')->with('success', 'Article modifié avec succès.');
        }
    public function edit($id, RssService $rssService)
    {
        $article = ArticleBdd::findOrFail($id);
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
        return view('article-create', compact('categories', 'rssBigTitles', 'rssCultureTitles', 'rssInternetTitles', 'rssMusiqueTitles', 'rssCinemaTitles', 'rssSportTitles', 'article'));
    }
    
    public function destroy($id)
    {
        $article = ArticleBdd::findOrFail($id);
        $article->delete();
        return redirect('/articles')->with('success', 'Article supprimé avec succès.');
    }
}
