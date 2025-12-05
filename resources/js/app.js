import './bootstrap';
import { createApp } from 'vue';
import Navbar from './components/sections/Navbar.vue';
import News from './components/sections/News.vue';
import Categories from './components/sections/Categories.vue';
import Article from './components/sections/Article.vue';
import BottomNav from './components/sections/BottomNav.vue';
import SearchPage from './components/sections/SearchPage.vue';
import FavoritePage from './components/sections/FavoritePage.vue';
import CreateArticle from './components/CreateArticle.vue';
import UpdateProfileForm from './components/UpdateProfileForm.vue';
import OnboardingPopup from "./components/OnBoarding.vue";
import LoginForm from './components/LoginForm.vue';
import RegisterForm from './components/RegisterForm.vue';

const app = createApp({});

app.component("onboarding-popup", OnboardingPopup);
app.component('navbar', Navbar);
app.component('news', News);
app.component('categories', Categories);
app.component("article-component", Article);
app.component("navbar-bottom", BottomNav);
app.component("search-page", SearchPage);
app.component("favorite-page", FavoritePage);
app.component("create-article", CreateArticle);
app.component("update-profile-form", UpdateProfileForm);
app.component("login-form", LoginForm);
app.component("register-form", RegisterForm);
app.mount('#app');
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
