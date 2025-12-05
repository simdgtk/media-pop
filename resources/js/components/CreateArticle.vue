<template>
    <Navbar color1="#fff" color2="#4400FF" />
    <div class="create-article">
        <h2>Article</h2>

        <form @submit.prevent="submitForm" enctype="multipart/form-data">
            <input type="hidden" name="_token" :value="csrfToken">

            <div class="attribute">
                <div class="title-container">
                    <label for="title" class="title">
                        titre de l’article mopop
                    </label>
                    <div role="presentation" aria-hidden="true" class="highlight"></div>
                </div>
                <input type="text" id="title" v-model="formData.title" placeholder="Comment le drapeau de One Piece...."
                    required>
            </div>

            <div class="author-select">
                <div class="title-container">
                    <label for="author" class="title">
                        author
                    </label>
                    <div role="presentation" aria-hidden="true" class="highlight"></div>
                </div>

                <div class="styled-select-container">
                    <select id="author" v-model="formData.author" required class="styled-select">
                        <option value="" disabled selected>select</option>
                        <option v-for="author in authors" :key="author.id" :value="author.id">
                            {{ author.nom }}
                        </option>
                    </select>
                    <span class="icon-chevron"><svg viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M11.2826 1.28318L6.28255 6.28318C6.21287 6.3531 6.13008 6.40857 6.03892 6.44643C5.94775 6.48428 5.85001 6.50377 5.7513 6.50377C5.65259 6.50377 5.55485 6.48428 5.46369 6.44643C5.37252 6.40857 5.28973 6.3531 5.22005 6.28318L0.220051 1.28318C0.0791548 1.14228 -2.09952e-09 0.951183 0 0.751926C2.09952e-09 0.552669 0.0791548 0.361572 0.220051 0.220676C0.360947 0.0797797 0.552044 0.000625136 0.751301 0.000625134C0.950558 0.000625131 1.14165 0.0797797 1.28255 0.220676L5.75193 4.69005L10.2213 0.220051C10.3622 0.079155 10.5533 0 10.7526 0C10.9518 0 11.1429 0.079155 11.2838 0.220051C11.4247 0.360948 11.5039 0.552044 11.5039 0.751301C11.5039 0.950559 11.4247 1.14165 11.2838 1.28255L11.2826 1.28318Z"
                                fill="currentColor" />
                        </svg>
                    </span>
                </div>

                <!-- <div class="styled-select-container">
                    <select id="author" v-model="formData.author" required class="styled-select">
                        <option value="" disabled selected>select</option>
                        <option value="Luffy">Luffy</option>
                        <option value="Nami">Nami</option>
                        <option value="Zoro">Zoro</option>
                        <option value="Sanji">Sanji</option>
                        <option value="Robin">Robin</option>
                    </select>
                    <span class="icon-chevron"><svg viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M11.2826 1.28318L6.28255 6.28318C6.21287 6.3531 6.13008 6.40857 6.03892 6.44643C5.94775 6.48428 5.85001 6.50377 5.7513 6.50377C5.65259 6.50377 5.55485 6.48428 5.46369 6.44643C5.37252 6.40857 5.28973 6.3531 5.22005 6.28318L0.220051 1.28318C0.0791548 1.14228 -2.09952e-09 0.951183 0 0.751926C2.09952e-09 0.552669 0.0791548 0.361572 0.220051 0.220676C0.360947 0.0797797 0.552044 0.000625136 0.751301 0.000625134C0.950558 0.000625131 1.14165 0.0797797 1.28255 0.220676L5.75193 4.69005L10.2213 0.220051C10.3622 0.079155 10.5533 0 10.7526 0C10.9518 0 11.1429 0.079155 11.2838 0.220051C11.4247 0.360948 11.5039 0.552044 11.5039 0.751301C11.5039 0.950559 11.4247 1.14165 11.2838 1.28255L11.2826 1.28318Z"
                                fill="currentColor" />
                        </svg>
                    </span>
                </div> -->
            </div>


            <div class="attribute image-upload">
                <div class="title-container">
                    <label for="image" class="title">
                        image
                    </label>
                    <div role="presentation" aria-hidden="true" class="highlight"></div>
                </div>
                <div class="file-upload-wrapper">
                    <input type="file" id="image" @change="handleImageUpload" accept="image/*"
                        class="file-upload-input">
                    <label for="image" class="file-upload-label">image</label>
                    <span class="file-upload-filename">{{ formData.image ? formData.image.name : 'Aucun fichier choisi'
                        }}</span>
                </div>
            </div>

            <div class="attribute category-select">
                <div class="title-container">
                    <label for="category" class="title">
                        catégories
                    </label>
                    <div role="presentation" aria-hidden="true" class="highlight"></div>
                </div>
                <div class="list-select">
                    <div class="select-item" v-for="cat in categories" :key="cat"
                        :class="{ selected: formData.category.includes(cat) }" @click="toggleCategory(cat)">
                        {{ formatCategory(cat) }}
                    </div>
                </div>
            </div>

            <div class="attribute article-select">
                <div class="title-container">
                    <label for="select-title" class="title">
                        article de référence
                    </label>
                    <div role="presentation" aria-hidden="true" class="highlight"></div>
                </div>
                <div class="styled-select-container">
                    <select id="select-title" v-model="selectedArticleUrl" @change="handleArticleSelection"
                        class="styled-select-article">
                        <option value="">Exemple de mon titre de l'article de...</option>
                        <option value="">--- Les gros titres ---</option>
                        <option v-for="item in rssBigTitles" :key="item.link" :value="item.link">
                            {{ item.title }}
                        </option>

                        <option value="">--- La culture ---</option>
                        <option v-for="item in rssCultureTitles" :key="item.link" :value="item.link">
                            {{ item.title }}
                        </option>

                        <option value="">--- Internet ---</option>
                        <option v-for="item in rssInternetTitles" :key="item.link" :value="item.link">
                            {{ item.title }}
                        </option>

                        <option value="">--- Musique ---</option>
                        <option v-for="item in rssMusiqueTitles" :key="item.link" :value="item.link">
                            {{ item.title }}
                        </option>

                        <option value="">--- Cinema ---</option>
                        <option v-for="item in rssCinemaTitles" :key="item.link" :value="item.link">
                            {{ item.title }}
                        </option>

                        <option value="">--- Sport ---</option>
                        <option v-for="item in rssSportTitles" :key="item.link" :value="item.link">
                            {{ item.title }}
                        </option>
                    </select>
                    <span class="icon-chevron blue"><svg viewBox="0 0 12 7" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M11.2826 1.28318L6.28255 6.28318C6.21287 6.3531 6.13008 6.40857 6.03892 6.44643C5.94775 6.48428 5.85001 6.50377 5.7513 6.50377C5.65259 6.50377 5.55485 6.48428 5.46369 6.44643C5.37252 6.40857 5.28973 6.3531 5.22005 6.28318L0.220051 1.28318C0.0791548 1.14228 -2.09952e-09 0.951183 0 0.751926C2.09952e-09 0.552669 0.0791548 0.361572 0.220051 0.220676C0.360947 0.0797797 0.552044 0.000625136 0.751301 0.000625134C0.950558 0.000625131 1.14165 0.0797797 1.28255 0.220676L5.75193 4.69005L10.2213 0.220051C10.3622 0.079155 10.5533 0 10.7526 0C10.9518 0 11.1429 0.079155 11.2838 0.220051C11.4247 0.360948 11.5039 0.552044 11.5039 0.751301C11.5039 0.950559 11.4247 1.14165 11.2838 1.28255L11.2826 1.28318Z"
                                fill="currentColor" />
                        </svg>
                    </span>
                </div>
            </div>

            <div class="attribute selected-words">
                <div class="title-container">
                    <label for="select-title" class="title">
                        sélection de surlignement
                    </label>
                    <div role="presentation" aria-hidden="true" class="highlight"></div>
                </div>
                <div class="selected-words-explained">
                    Sélectionne la portion du titre à surligner en cliquant d'abord sur le mot où la sélection commence,
                    puis sur le mot où elle se termine.
                </div>
                <div class="words-container" v-if="formData.selected_article">
                    <span v-for="(word, index) in articleWords" :key="index" class="word-item"
                        :class="{ 'selected': isWordSelected(index) }" @click="toggleWordSelection(index)">
                        {{ word }}
                    </span>
                </div>
            </div>

            <div class="attribute">
                <div class="title-container">
                    <label for="content" class="title">
                        contenu de l'article
                    </label>
                    <div role="presentation" aria-hidden="true" class="highlight"></div>
                </div>
                <div ref="quillEditor" id="content" class="quill-editor" style="height: 250px;"></div>
            </div>
            <button type="submit">Ajouter mon article</button>
        </form>
    </div>
    <BottomNav />
</template>

<script lang="ts" setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';
import Quill from 'quill';
import 'quill/dist/quill.snow.css';
import Navbar from './sections/Navbar.vue';
import BottomNav from './sections/BottomNav.vue';

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

const quillEditor = ref<HTMLDivElement | null>(null);
let quill: Quill | null = null;

const articleWords = ref<string[]>([]);
const selectedWordIndices = ref<number[]>([]);
const firstSelectedIndex = ref<number | null>(null);

const formatCategory = (category: string): string => {
    return category.charAt(0).toUpperCase() + category.slice(1).replace('_', ' ');
};

const toggleCategory = (cat: string) => {
    if (formData.value.category.includes(cat)) {
        formData.value.category = [];
    } else {
        formData.value.category = [cat];
    }
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

    if (selectedText && selectedValue) {
        articleWords.value = selectedText.split(/\s+/).filter(word => word.length > 0);
        selectedWordIndices.value = [];
        firstSelectedIndex.value = null;
    } else {
        articleWords.value = [];
        selectedWordIndices.value = [];
        firstSelectedIndex.value = null;
    }
};

const isWordSelected = (index: number): boolean => {
    return selectedWordIndices.value.includes(index);
};

const toggleWordSelection = (index: number) => {
    if (selectedWordIndices.value.length === 1 && selectedWordIndices.value[0] === index) {
        selectedWordIndices.value = [];
        firstSelectedIndex.value = null;
        updateSelectedWords();
        return;
    }

    if (firstSelectedIndex.value === null) {
        firstSelectedIndex.value = index;
        selectedWordIndices.value = [index];
        updateSelectedWords();
        return;
    }

    const start = Math.min(firstSelectedIndex.value, index);
    const end = Math.max(firstSelectedIndex.value, index);
    selectedWordIndices.value = [];
    for (let i = start; i <= end; i++) {
        selectedWordIndices.value.push(i);
    }
    updateSelectedWords();
};

const updateSelectedWords = () => {
    if (selectedWordIndices.value.length === 0) {
        formData.value.selected_words = '';
        return;
    }

    const selectedWords = selectedWordIndices.value.map(i => articleWords.value[i]);
    formData.value.selected_words = selectedWords.join(' ');
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
            window.location.href = '/';
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
    if (quillEditor.value && quillEditor.value instanceof HTMLElement) {
        quill = new Quill(quillEditor.value, {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ 'header': [2, false] }],
                    ['italic', 'underline', 'link']
                ]
            },
            formats: ['header', 'italic', 'underline', 'link']
        });
        quill.on('text-change', () => {
            formData.value.content = quill!.root.innerHTML;
        });
    }
});

onBeforeUnmount(() => {
    quill = null;
});

const authors = ref<{ id: number; nom: string }[]>([]);

onMounted(async () => {
    try {
        const res = await fetch('/auteurs');
        if (res.ok) {
            authors.value = await res.json();
        } else {
            console.error('Erreur lors de la récupération des auteurs');
        }
    } catch (err) {
        console.error('Erreur fetch auteurs:', err);
    }
});
</script>

<style lang="scss">
@use 'sass:color';

.quill-editor h2 {
    font-size: 2rem !important;
    margin: 1.2em 0 0.7em 0 !important;
    color: #4400FF !important;
}
.quill-editor i, .quill-editor em {
    font-style: italic !important;
    color: #4400FF !important;
}
.quill-editor u {
    text-decoration: underline !important;
    text-decoration-thickness: 2px !important;
    text-underline-offset: 2px !important;
    color: #4400FF !important;
}
.quill-editor a {
    color: #C6FF00 !important;
    text-decoration: underline !important;
    transition: color 0.2s;
}
.quill-editor a:hover {
    color: #A0CC00 !important;
}
.quill-editor p {
    margin: 0.5em 0 !important;
}

.create-article {
        max-width: 800px;
        background-color: $white;
        @extend %container;

    h2 {
        margin: toRem(24) 0;
        color: $blue;
    }

    form {
        display: flex;
        flex-direction: column;
        gap: toRem(32);

        .author-select {
            display: flex;
            align-items: center;
            gap: toRem(8);
            flex-wrap: wrap;

            .title-container {
                margin-bottom: 0;
            }
        }

        .attribute {
            display: flex;
            flex-direction: column;
        }

        .image-upload {
            .file-upload-wrapper {
                display: flex;
                align-items: center;
                gap: toRem(12);
            }

            .file-upload-input {
                opacity: 0;
                position: absolute;
                width: 1px;
                height: 1px;
                overflow: hidden;
                z-index: -1;
            }

            .file-upload-label {
                background-color: $blue;
                color: $white;
                border-radius: 999px;
                padding: toRem(8) toRem(14);
                font-size: toRem(16);
                cursor: pointer;
                transition: background 0.2s;
                border: none;
                display: inline-block;
                font-weight: 600;
                text-transform: lowercase;
            }

            .file-upload-label:hover {
                background-color: color.scale($blue, $lightness: -20%);
            }

            .file-upload-filename {
                font-size: toRem(14);
                color: $blue;
            }
        }

        label {
            width: fit-content;
        }

        .title-container {
            position: relative;
            width: fit-content;
            display: flex;
            margin-bottom: toRem(16);
            position: relative;

            .title {
                font-size: toRem(20);
                font-weight: 600;
                text-transform: lowercase;
                display: inline-block;
                position: relative;
                z-index: 2;
                line-height: 95%;
                color: $blue;
            }

        }

        .selected-words-explained {
            color: $blue;
            font-size: toRem(18);
            line-height: 100%;
        }

        .words-container {
            display: flex;
            flex-wrap: wrap;
            margin-top: toRem(16);
            padding: toRem(16);
            border: toRem(1) solid $blue;
            border-radius: toRem(12);

            .word-item {
                padding: 0 toRem(2);
                cursor: pointer;
                font-size: toRem(16);
                color: $blue;
                transition: background-color 0.2s, transform 0.1s;
                user-select: none;

                &.selected {
                    background-color: $lime;
                    color: $blue;
                }
            }
        }

        .highlight {
            display: block;
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: calc(100% + toRem(4));
            height: 100%;
            background-color: $lime;
            transform: translate(toRem(-2), 0);
            transform-origin: left;
            transition: none;
        }



        input[type="text"] {
            border: toRem(1) solid #ccc;
            border-radius: 999px;
            font-size: toRem(16);
            padding: toRem(12) toRem(16);
            transition: border-color 0.2s;

            &::placeholder {
                color: $light-blue;
            }

            &:focus {
                border-color: $blue;
                outline: none;
            }
        }

        .styled-select-container {
            position: relative;
            width: fit-content;

            .styled-select {
                border: toRem(1) solid $blue;
                border-radius: 999px;
                font-size: toRem(16);
                padding: toRem(8);
                transition: border-color 0.2s;
                background: $blue;
                color: $white;
                width: fit-content;
                line-height: 100%;
                padding-right: toRem(32);
                position: relative;
                appearance: none;

                &:focus {
                    border-color: $blue;
                    outline: none;
                }
            }

            .styled-select-article {
                border: toRem(1) solid $blue;
                border-radius: toRem(24);
                font-size: toRem(16);
                padding: toRem(16) toRem(48) toRem(16) toRem(20);
                transition: border-color 0.2s;
                background: $white;
                color: $blue;
                width: 100%;
                line-height: 100%;
                position: relative;
                appearance: none;
                font-weight: 500;

                &:focus {
                    border-color: $blue;
                    outline: none;
                }
            }

            .icon-chevron {
                position: absolute;
                right: toRem(10);
                top: 50%;
                width: toRem(16);
                transform: translateY(-50%);
                user-select: none;
                pointer-events: none;
                z-index: 2;
                color: $white;

                &.blue {
                    color: $blue;
                }
            }
        }

        .article-select {
            .styled-select-container {
                width: 100%;
            }
        }

        textarea {
            border: toRem(1) solid #ccc;
        }

        .category-select {
            .list-select {
                display: flex;
                gap: toRem(8);
                flex-wrap: wrap;

                .select-item {
                    line-height: 100%;
                    padding: toRem(8) toRem(12);
                    border-radius: toRem(999);
                    background-color: $white;
                    color: $blue;
                    border: toRem(1) solid $blue;
                    font-size: toRem(14);
                    cursor: pointer;
                    transition: background-color 0.1s ease-in-out, color 0.1s ease-in-out, transform 0.1s ease-in-out;

                    &.selected {
                        background-color: $blue;
                        color: $white;
                        border: toRem(1) solid $blue;
                    }

                    &:hover {
                        transform: scale(0.99);
                    }

                    &:active {
                        transform: scale(0.96);
                    }
                }
            }
        }

        button[type="submit"] {
            background-color: $blue;
            padding: toRem(16);
            border-radius: toRem(12);
            color: $white;
            text-align: center;
            text-transform: lowercase;
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
