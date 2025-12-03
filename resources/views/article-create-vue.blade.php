<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Créer un article</title>
    @vite(['resources/css/main.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <create-article
            :categories='@json($categories)'
            :rss-big-titles='@json($rssBigTitles ?? [])'
            :rss-culture-titles='@json($rssCultureTitles ?? [])'
            :rss-internet-titles='@json($rssInternetTitles ?? [])'
            :rss-musique-titles='@json($rssMusiqueTitles ?? [])'
            :rss-cinema-titles='@json($rssCinemaTitles ?? [])'
            :rss-sport-titles='@json($rssSportTitles ?? [])'
        ></create-article>
    </div>
</body>
</html>
