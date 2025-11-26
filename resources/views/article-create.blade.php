<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un article</title>
</head>

<body>
    <h1>Créer un nouvel article</h1>

    <form action="/article" method="POST">
        @csrf
        <div class="attribute">
            <label for="title">Titre :</label><br>
            <input type="text" id="title" name="title" required>
        </div>
        <div class="attribute">
            <label for="author">Auteur :</label><br>
            <input type="text" id="author" name="author" required>
        </div>
        <div class="attribute">
            <label for="content">Contenu :</label><br>
            <input type="text" id="content" name="content" required>
        </div>
        <div class="attribute">
            <label for="image">Image :</label><br>
            <input type="text" id="image" name="image" required>
        </div>
        <div class="attribute">
            <label for="category">Catégorie :</label><br>
            <select name="category" id="category">
                <option value="">Choisir une catégorie</option>
                @foreach ($categories as $category)
                <option value="{{ $category }}">{{ ucfirst(str_replace('_', ' ', $category)) }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit">Créer</button>
        <a href="/articles">Annuler</a>
    </form>
</body>

</html>
