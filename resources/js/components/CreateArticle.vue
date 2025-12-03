<template>
  <div class="create-article">
    <h1>Créer un nouvel article</h1>

    <form @submit.prevent="submitForm" enctype="multipart/form-data">
      <input type="hidden" name="_token" :value="csrfToken">

      <div class="attribute">
        <label for="title">Titre :</label><br>
        <input
          type="text"
          id="title"
          v-model="formData.title"
          required
        >
      </div>

      <div class="attribute">
        <label for="author">Auteur :</label><br>
        <input
          type="text"
          id="author"
          v-model="formData.author"
          required
        >
      </div>

      <div class="attribute">
        <label for="image">Image :</label><br>
        <input
          type="file"
          id="image"
          @change="handleImageUpload"
          accept="image/*"
        >
      </div>

      <div class="attribute">
        <label for="category">Catégories :</label><br>
        <select v-model="formData.category" id="category" multiple size="4">
          <option
            v-for="cat in categories"
            :key="cat"
            :value="cat"
          >
            {{ formatCategory(cat) }}
          </option>
        </select>
      </div>

      <div class="attribute">
        <select id="select-title" v-model="selectedArticleUrl" @change="handleArticleSelection">
          <option value="">--- Les gros titres ---</option>
          <option
            v-for="item in rssBigTitles"
            :key="item.link"
            :value="item.link"
          >
            {{ item.title }}
          </option>

          <option value="">--- La culture ---</option>
          <option
            v-for="item in rssCultureTitles"
            :key="item.link"
            :value="item.link"
          >
            {{ item.title }}
          </option>

          <option value="">--- Internet ---</option>
          <option
            v-for="item in rssInternetTitles"
            :key="item.link"
            :value="item.link"
          >
            {{ item.title }}
          </option>

          <option value="">--- Musique ---</option>
          <option
            v-for="item in rssMusiqueTitles"
            :key="item.link"
            :value="item.link"
          >
            {{ item.title }}
          </option>

          <option value="">--- Cinema ---</option>
          <option
            v-for="item in rssCinemaTitles"
            :key="item.link"
            :value="item.link"
          >
            {{ item.title }}
          </option>

          <option value="">--- Sport ---</option>
          <option
            v-for="item in rssSportTitles"
            :key="item.link"
            :value="item.link"
          >
            {{ item.title }}
          </option>
        </select>

        <p>
          article choisi :
          <span
            id="selected-article"
            ref="selectedArticle"
            @mousedown="handleMouseDown"
            @mouseup="handleMouseUp"
          >
            {{ formData.selected_article }}
          </span>
        </p>
        <p>mots choisis : <span id="selected-words">{{ formData.selected_words }}</span></p>
      </div>

      <div class="attribute">
        <label for="content">Contenu :</label><br>
        <textarea
          id="content"
          v-model="formData.content"
          rows="8"
          required
        ></textarea>
      </div>

      <button type="submit">Créer</button>
      <a href="/articles">Annuler</a>
    </form>
  </div>
</template>

<script lang="ts" setup>
import { ref, onMounted } from 'vue';

interface RssItem {
  title: string;
  link: string;
}

interface FormData {
  title: string;
  author: string;
  content: string;
  category: string[];
  image: File | null;
  selected_article: string;
  selected_article_url: string;
  selected_words: string;
}

const props = defineProps<{
  categories: string[];
  rssBigTitles: RssItem[];
  rssCultureTitles: RssItem[];
  rssInternetTitles: RssItem[];
  rssMusiqueTitles: RssItem[];
  rssCinemaTitles: RssItem[];
  rssSportTitles: RssItem[];
}>();

const csrfToken = ref('');
const selectedArticle = ref<HTMLElement | null>(null);
const selectedArticleUrl = ref('');
const formData = ref<FormData>({
  title: '',
  author: '',
  content: '',
  category: [],
  image: null,
  selected_article: '',
  selected_article_url: '',
  selected_words: ''
});

const formatCategory = (category: string): string => {
  return category.charAt(0).toUpperCase() + category.slice(1).replace('_', ' ');
};

const handleImageUpload = (event: Event) => {
  const target = event.target as HTMLInputElement;
  if (target.files && target.files[0]) {
    formData.value.image = target.files[0];
  }
};

const handleArticleSelection = (event: Event) => {
  const select = event.target as HTMLSelectElement;
  const selectedOption = select.options[select.selectedIndex];
  const selectedText = selectedOption.text;
  const selectedValue = select.value;

  formData.value.selected_article = selectedValue ? selectedText : '';
  formData.value.selected_article_url = selectedValue;
  formData.value.selected_words = '';
};

const getSelectionText = (): string => {
  let text = '';
  if (window.getSelection) {
    text = window.getSelection()?.toString() || '';
  }
  return text;
};

const handleMouseDown = () => {
  formData.value.selected_words = '';
};

const handleMouseUp = () => {
  const selectedText = getSelectionText();
  if (selectedText) {
    formData.value.selected_words = selectedText;
  }
};

const submitForm = async () => {
  const form = new FormData();

  form.append('_token', csrfToken.value);
  form.append('title', formData.value.title);
  form.append('author', formData.value.author);
  form.append('content', formData.value.content);

  formData.value.category.forEach((cat) => {
    form.append('category[]', cat);
  });

  if (formData.value.image) {
    form.append('image', formData.value.image);
  }

  form.append('selected_article', formData.value.selected_article);
  form.append('selected_article_url', formData.value.selected_article_url);
  form.append('selected_words', formData.value.selected_words);

  try {
    const response = await fetch('/article', {
      method: 'POST',
      body: form,
      headers: {
        'X-Requested-With': 'XMLHttpRequest'
      }
    });

    if (response.ok) {
      window.location.href = '/articles';
    } else {
      console.error('Erreur lors de la création de l\'article');
    }
  } catch (error) {
    console.error('Erreur:', error);
  }
};

onMounted(() => {
  const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
  if (token) {
    csrfToken.value = token;
  }
});
</script>

<style lang="scss" scoped>
.create-article {
  max-width: 800px;
  margin: 0 auto;
  padding: 2rem;

  h1 {
    margin-bottom: 2rem;
  }

  form {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;

    .attribute {
      display: flex;
      flex-direction: column;

      label {
        font-weight: bold;
        margin-bottom: 0.5rem;
      }

      input[type="text"],
      textarea,
      select {
        padding: 0.5rem;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 1rem;
        font-family: inherit;
      }

      select[multiple] {
        min-height: 100px;
      }

      #selected-article {
        cursor: text;
        user-select: text;
        padding: 0.25rem;
        background: #f5f5f5;
        border-radius: 4px;
        display: inline-block;
        min-height: 1.5rem;
      }

      #selected-words {
        font-weight: bold;
        color: #0066cc;
      }
    }

    button[type="submit"] {
      padding: 0.75rem 1.5rem;
      background-color: #0066cc;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 1rem;
      transition: background-color 0.2s;

      &:hover {
        background-color: #0052a3;
      }
    }

    a {
      text-align: center;
      padding: 0.75rem 1.5rem;
      color: #666;
      text-decoration: none;

      &:hover {
        text-decoration: underline;
      }
    }
  }
}
</style>
