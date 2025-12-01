import './bootstrap';
import { createApp } from 'vue';
import Navbar from './components/sections/Navbar.vue';
import News from './components/sections/News.vue';
import Categories from './components/sections/Categories.vue';
import Article from './components/sections/Article.vue';

const app = createApp({});

app.component('navbar', Navbar);
app.component('news', News);
app.component('categories', Categories);
app.component("article-component", Article);
app.mount('#app');
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
