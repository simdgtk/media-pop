<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Article as ArticleBdd;


class Article extends Controller
{
    public function index()
    {
        $articles = ArticleBdd::all();
        return view('articles', ['articles' => $articles]);
    }

    public function create() {
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
        return view('article-create', compact('categories'));
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
