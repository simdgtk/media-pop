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
        return view('article-create', compact('categories', 'rssBigTitles', 'rssCultureTitles', 'rssInternetTitles', 'rssMusiqueTitles', 'rssCinemaTitles', 'rssSportTitles'));
    }

    public function store(Request $request)
    {
        $article = ArticleBdd::create([
            'title' => $request->title,
            'author' => $request->author,
            'content' => $request->content,
            'image' => $request->image,
            'category' => $request->category,
        ]);

        return redirect('/articles');
    }
}
