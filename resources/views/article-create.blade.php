<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un article</title>
        @vite(['resources/css/main.scss', 'resources/js/app.js'])
</head>

<body>
    <h1>Créer un nouvel article</h1>

    <form action="/article" method="POST" enctype="multipart/form-data">
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
            <label for="image">Image :</label><br>
            <input type="file" id="image" name="image" accept="image/*">
        </div>
        <div class="attribute">
            <label for="category">Catégories :</label><br>
            <select name="category[]" id="category" multiple size="4">
                @foreach ($categories as $category)
                <option value="{{ $category }}">{{ ucfirst(str_replace('_', ' ', $category)) }}</option>
                @endforeach
            </select>
        </div>
        <div class="attribute">
            @if(isset($rssBigTitles))
            <select id="select-title">
                <option value="">--- Les gros titres ---</option>
                @foreach ($rssBigTitles as $item)
                <option value="{{ $item['link'] }}">{{ $item['title'] }}</option>
                @endforeach
                @endif
                <option value="">--- La culture ---</option>
                @if(isset($rssCultureTitles))
                @foreach ($rssCultureTitles as $item)
                <option value="{{ $item['link'] }}">{{ $item['title'] }}</option>
                @endforeach
                @endif
                <option value="">--- Internet ---</option>
                @if(isset($rssInternetTitles))
                @foreach ($rssInternetTitles as $item)
                <option value="{{ $item['link'] }}">{{ $item['title'] }}</option>
                @endforeach
                @endif
                <option value="">--- Musique ---</option>
                @if(isset($rssMusiqueTitles))
                @foreach ($rssMusiqueTitles as $item)
                <option value="{{ $item['link'] }}">{{ $item['title'] }}</option>
                @endforeach
                @endif
                <option value="">--- Cinema ---</option>
                @if(isset($rssCinemaTitles))
                @foreach ($rssCinemaTitles as $item)
                <option value="{{ $item['link'] }}">{{ $item['title'] }}</option>
                @endforeach
                @endif
                <option value="">--- Sport ---</option>
                @if(isset($rssSportTitles))
                @foreach ($rssSportTitles as $item)
                <option value="{{ $item['link'] }}">{{ $item['title'] }}</option>
                @endforeach
                @endif
            </select>
            <p>article choisi : <span id="selected-article"></span></p>
            <p>mots choisis : <span id="selected-words"></span></p>
            <input type="hidden" name="selected_article" id="input-selected-article">
            <input type="hidden" name="selected_article_url" id="input-selected-article-url">
            <input type="hidden" name="selected_words" id="input-selected-words">

        </div>
        <div class="attribute">
            <label for="content">Contenu :</label><br>
            <textarea id="content" name="content" rows="8" required></textarea>
        </div>

        <button type="submit">Créer</button>
        <a href="/articles">Annuler</a>
    </form>

    <script>
        function getSelectionText() {
            let text = "";

            if (window.getSelection) {
                text = window.getSelection().toString();
            } else if (document.selection && document.selection.type != "Control") {
                text = document.selection.createRange().text;
            }

            return text;
        }

        document.getElementById('select-title').addEventListener('change', function() {
            const selectedText = this.options[this.selectedIndex].text;
            const selectedValue = this.value;

            document.getElementById('input-selected-article').value = selectedText;
            document.getElementById('input-selected-article-url').value = selectedValue;

            const articleContainer = document.getElementById('selected-article');
            const wordsContainer = document.getElementById('selected-words');

            wordsContainer.innerHTML = '';

            if (selectedValue) {
                articleContainer.textContent = selectedText;

                document.getElementById('input-selected-article').value = selectedText;

            } else {
                articleContainer.textContent = '';
                document.getElementById('input-selected-article').value = '';
            }
        });

        document.getElementById('selected-article').addEventListener('mousedown', function() {
            const wordsContainer = document.getElementById('selected-words');
            wordsContainer.innerHTML = '';
        });

        document.getElementById('selected-article').addEventListener('mouseup', function() {
            const selectedText = getSelectionText();

            if (selectedText) {
                const wordsContainer = document.getElementById('selected-words');
                const words = selectedText.split(' ').filter(w => w.trim());

                wordsContainer.innerHTML = '';

                words.forEach(word => {
                    const wordSpan = document.createElement('span');
                    wordSpan.className = 'word';
                    wordSpan.textContent = word;

                    if (wordsContainer.innerHTML) {
                        wordsContainer.appendChild(document.createTextNode(' '));
                    }
                    wordsContainer.appendChild(wordSpan);
                });

                document.getElementById('input-selected-words').value = JSON.stringify(words);
            }
        });
    </script>
</body>

</html>
