<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un article</title>
</head>

<body>
    <h1>{{ isset($article) ? 'Modifier' : 'Créer' }} un article</h1>

    <form action="{{ isset($article) ? url('/article/' . $article->id) : url('/article') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($article))
            @method('PUT')
        @endif
        {{-- validation errors (summary) --}}
        @if ($errors->any())
            <div style="color: red; margin-bottom: 1rem;">
                <strong>Il y a des erreurs dans le formulaire :</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="attribute">
            <input type="hidden" id="source_url" value="{{ old('source_url', $article->source_url ?? '') }}">
            <input type="hidden" name="source_title" id="source_title" value="{{ old('source_title', $article->source_title ?? '') }}">
            <input type="hidden" name="selected_words" id="selected_words_input" value='{{ old('selected_words', json_encode($article->selected_words ?? [])) }}'>
            <label for="title">Titre :</label><br>
            <input type="text" id="title" name="title" value="{{ old('title', $article->title ?? '') }}" required>
            @error('title')
                <div style="color: red; font-size: 0.9rem; margin-top:0.25rem">{{ $message }}</div>
            @enderror
        </div>
        <div class="attribute">
            <label for="author">Auteur :</label><br>
            <input type="text" id="author" name="author" value="{{ old('author', $article->author ?? '') }}" required>
            @error('author')
                <div style="color: red; font-size: 0.9rem; margin-top:0.25rem">{{ $message }}</div>
            @enderror
        </div>
        <div class="attribute">
            <label for="image">Image :</label><br>
            <input type="file" id="image" name="image" accept="image/*">
            @if(isset($article) && $article->image_url)
                <br><img src="{{ $article->image_url }}" alt="Image actuelle" style="max-width:150px;max-height:150px;" />
            @endif
            @error('image')
                <div style="color: red; font-size: 0.9rem; margin-top:0.25rem">{{ $message }}</div>
            @enderror
        </div>
        <div class="attribute">
            <label for="category">Catégories :</label><br>
            <select name="category[]" id="category" multiple size="4">
                @foreach ($categories as $category)
                <option value="{{ $category }}" {{ (collect(old('category', $article->category ?? []))->contains($category)) ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $category)) }}</option>
                @endforeach
            </select>
            @error('category')
                <div style="color: red; font-size: 0.9rem; margin-top:0.25rem">{{ $message }}</div>
            @enderror
            @error('category.*')
                <div style="color: red; font-size: 0.9rem; margin-top:0.25rem">{{ $message }}</div>
            @enderror
        </div>
        <div class="attribute">
            @if(isset($rssBigTitles))
            <select id="select-title" name="source_url">
                <option disabled>--- Les gros titres ---</option>
                @foreach ($rssBigTitles as $item)
                <option value="{{ $item['link'] }}" {{ (old('source_url', $article->source_url ?? '') == $item['link']) ? 'selected' : '' }}>{{ $item['title'] }}</option>
                @endforeach
                @endif
                <option disabled>--- La culture ---</option>
                @if(isset($rssCultureTitles))
                @foreach ($rssCultureTitles as $item)
                <option value="{{ $item['link'] }}" {{ (old('source_url', $article->source_url ?? '') == $item['link']) ? 'selected' : '' }}>{{ $item['title'] }}</option>
                @endforeach
                @endif
                <option disabled>--- Internet ---</option>
                @if(isset($rssInternetTitles))
                @foreach ($rssInternetTitles as $item)
                <option value="{{ $item['link'] }}" {{ (old('source_url', $article->source_url ?? '') == $item['link']) ? 'selected' : '' }}>{{ $item['title'] }}</option>
                @endforeach
                @endif
                <option disabled>--- Musique ---</option>
                @if(isset($rssMusiqueTitles))
                @foreach ($rssMusiqueTitles as $item)
                <option value="{{ $item['link'] }}" {{ (old('source_url', $article->source_url ?? '') == $item['link']) ? 'selected' : '' }}>{{ $item['title'] }}</option>
                @endforeach
                @endif
                <option disabled>--- Cinema ---</option>
                @if(isset($rssCinemaTitles))
                @foreach ($rssCinemaTitles as $item)
                <option value="{{ $item['link'] }}" {{ (old('source_url', $article->source_url ?? '') == $item['link']) ? 'selected' : '' }}>{{ $item['title'] }}</option>
                @endforeach
                @endif
                <option disabled>--- Sport ---</option>
                @if(isset($rssSportTitles))
                @foreach ($rssSportTitles as $item)
                <option value="{{ $item['link'] }}" {{ (old('source_url', $article->source_url ?? '') == $item['link']) ? 'selected' : '' }}>{{ $item['title'] }}</option>
                @endforeach
                @endif
            </select>
            <p>article choisi : <span id="selected-article"></span></p>
            <p>mots choisis : <span id="selected-words"></span></p>
        </div>
        <div class="attribute">
            <label for="content">Contenu :</label><br>
            <textarea id="content" name="content" rows="8" required>{{ old('content', $article->content ?? '') }}</textarea>
            @error('content')
                <div style="color: red; font-size: 0.9rem; margin-top:0.25rem">{{ $message }}</div>
            @enderror
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

        const selectTitle = document.getElementById('select-title');
        const sourceUrlInput = document.getElementById('source_url');
        const sourceTitleInput = document.getElementById('source_title');
        const selectedWordsInput = document.getElementById('selected_words_input');

        // Pre-fill selected-article and selected-words from existing values (edit mode)
        document.addEventListener('DOMContentLoaded', function() {
            const existingTitle = sourceTitleInput ? sourceTitleInput.value : '';
            const existingWords = selectedWordsInput && selectedWordsInput.value ? JSON.parse(selectedWordsInput.value) : [];
            if (existingTitle) {
                const articleContainer = document.getElementById('selected-article');
                articleContainer.textContent = existingTitle;
            }

            if (existingWords && existingWords.length) {
                const wordsContainer = document.getElementById('selected-words');
                existingWords.forEach(word => {
                    if (word.trim()) {
                        const wordSpan = document.createElement('span');
                        wordSpan.className = 'word';
                        wordSpan.textContent = word;
                        if (wordsContainer.innerHTML) {
                            wordsContainer.appendChild(document.createTextNode(' '));
                        }
                        wordsContainer.appendChild(wordSpan);
                    }
                });
            }
        });

        selectTitle.addEventListener('change', function() {
            const selectedText = this.options[this.selectedIndex].text;
            const selectedValue = this.value;

            const articleContainer = document.getElementById('selected-article');
            const wordsContainer = document.getElementById('selected-words');

            wordsContainer.innerHTML = '';

            if (selectedValue) {
                articleContainer.textContent = selectedText;
                if (sourceUrlInput) sourceUrlInput.value = selectedValue;
                if (sourceTitleInput) sourceTitleInput.value = selectedText;
            } else {
                articleContainer.textContent = '';
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
                const words = selectedText.split(' ');

                words.forEach(word => {
                    if (word.trim()) {
                        const wordSpan = document.createElement('span');
                        wordSpan.className = 'word';
                        wordSpan.textContent = word;

                        if (wordsContainer.innerHTML) {
                            wordsContainer.appendChild(document.createTextNode(' '));
                        }
                        wordsContainer.appendChild(wordSpan);
                    }
                });
            // update hidden input with currently selected words
            if (selectedWordsInput) {
                const wordsArray = Array.from(wordsContainer.querySelectorAll('.word')).map(s => s.textContent);
                selectedWordsInput.value = JSON.stringify(wordsArray);
            }
            }
        });
    </script>
</body>

</html>
