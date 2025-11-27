<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Articles</title>
        @vite(['resources/css/main.scss', 'resources/js/app.js'])
</head>

<body>
    <h1>Liste des articles</h1>
    @foreach($articles as $article)
    <div class="article">
        <h2>{{ $article->title }}</h2>
        <p><strong>Auteur :</strong> {{ $article->author }}</p>
        <p><strong>Catégorie :</strong> {{ is_array($article->category) ? implode(', ', $article->category) : $article->category }}</p>
        @if($article->image_url)
        <img src="{{ $article->image_url }}" alt="Image de l'article" />
        @endif
        <p>{{ $article->content }}</p>
        <form action="/article/{{ $article->id }}" method="POST" style="display:inline">
            @csrf
            @method('DELETE')
            <button type="submit" onclick="return confirm('Supprimer cet article ?')">Supprimer</button>
        </form>
    </div>
    @endforeach
</body>

</html>
