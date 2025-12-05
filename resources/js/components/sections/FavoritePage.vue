<template>
    <section class="search-page">
        <h2>Mes favoris</h2>

        <template v-for="category in categories" :key="category">
            <template v-if="shouldShowCategory(category)">
                <div class="title-extended-container">
                    <h3 class="title-extended">{{ categoryNames[category] }}</h3>
                    <div class="border" aria-hidden="true" role="presentation"></div>
                </div>
                <Carousel
                    :category="category"
                    :bgIcon="false"
                    :articles="articlesByCategory[category]"
                    :favoriteIds="favorites"
                    :onlyFavorites="true"
                />
            </template>
        </template>

        <MopopIcon class="bg-icon" />
        <MopopIcon class="bg-icon second" />
    </section>
</template>

<script lang="ts" setup>
import { ref, onMounted } from 'vue';
import Carousel from '../Carousel.vue';
import MopopIcon from '../icons/MopopIcon.vue';

const categories = ['actualite', 'cinema', 'culture', 'internet', 'musique', 'sport'];
const categoryNames: Record<string, string> = {
    actualite: 'Actualités',
    cinema: 'Cinéma',
    culture: 'Culture',
    internet: 'Internet',
    musique: 'Musique',
    sport: 'Sport'
};

const favorites = ref<number[]>([]);
const articlesByCategory = ref<Record<string, any[]>>({});
const loading = ref(true);

const fetchFavorites = async () => {
    try {
        const res = await fetch('/profile/favorites', { credentials: 'same-origin' });
        if (res.ok) {
            const data = await res.json();
            favorites.value = data.favorites || [];
        } else {
            favorites.value = [];
        }
    } catch {
        favorites.value = [];
    }
};

const fetchArticles = async () => {
    for (const category of categories) {
        try {
            const res = await fetch(`/articles/latest?category=${category}`, { credentials: 'same-origin' });
            if (res.ok) {
                const data = await res.json();
                // Filtrer uniquement les articles favoris
                articlesByCategory.value[category] = data.filter((a: any) => favorites.value.includes(a.id));
            } else {
                articlesByCategory.value[category] = [];
            }
        } catch {
            articlesByCategory.value[category] = [];
        }
    }
    loading.value = false;
};

onMounted(async () => {
    await fetchFavorites();
    await fetchArticles();
});

const shouldShowCategory = (category: string) => {
    return articlesByCategory.value[category] && articlesByCategory.value[category].length > 0;
};
</script>

<style lang="scss" scoped>
.search-page {
    @extend %container;
    margin: 0 auto;
    padding: 0;
    margin-top: toRem(36);
    display: flex;
    flex-direction: column;
    gap: toRem(24);
    position: relative;
    overflow: hidden;

    h2 {
        color: $white;
        margin-left: toRem(20);
        padding-right: toRem(20);
    }

    .search-and-filters {
        display: flex;
        flex-direction: column;
        gap: toRem(16);

        .filters {
            margin-left: toRem(20);

            .button {
                color: $blue;
            }
        }
    }


    .search-container {
        position: relative;
        display: flex;
        flex-direction: row-reverse;
        align-items: center;
        max-width: toRem(500);
        margin-left: toRem(20);
        margin-right: toRem(20);

        .search-icon {
            position: absolute;
            right: toRem(16);
            width: toRem(24);
            height: toRem(24);
            color: $light-blue;
            pointer-events: none;
            transition: color 0.15s ease;
        }

        .search-input {
            width: 100%;
            padding: toRem(12) toRem(52) toRem(12) toRem(16);
            font-size: toRem(16);
            border: toRem(1) solid $white;
            border-radius: 9999px;
            background-color: transparent;
            color: $blue;
            outline: none;
            transition: border-color 0.2s ease;
            background-color: $white;

            &::placeholder {
                color: $light-blue;
            }

            &:focus {
                border-color: $light-blue;

                &~.search-icon {
                    color: $blue;
                }
            }
        }

        &:focus-within {
            .search-icon {
                color: $black;
            }
        }
    }

    .title-extended-container {
        width: fit-content;
        position: relative;

        .title-extended {
            font-size: toRem(16);
            font-weight: 900;
            font-family: 'Font1', sans-serif;
            text-transform: uppercase;
            margin-left: toRem(20);
            color: $white;
        }

        .border {
            position: absolute;
            transform-origin: right;
            transform: scale(-1);
            bottom: toRem(6);
            right: toRem(4);
            width: 100vw;
            height: toRem(1);
            background-color: $white;
        }
    }

    .bg-icon {
        position: absolute;
        top: toRem(60);
        right: toRem(-50);
        width: toRem(230);
        color: $dark-blue;
        pointer-events: none;
        user-select: none;
        z-index: -1;
        display: block;

        &.second {
            top: toRem(262);
            left: toRem(-80);
        }
    }
}
</style>
