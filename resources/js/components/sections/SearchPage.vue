<template>
    <section class="search-page">
        <h2>recherche</h2>
        <div class="search-and-filters">
            <div class="search-container">
                <input type="text" v-model="searchQuery" placeholder="Recherche" class="search-input" />
                <Search class="search-icon" />
            </div>
            <div class="filters">
                <Button class="button" text="filtres" @click="isOpen = true">
                    <template #icon>
                        <Filter />
                    </template>
                </Button>
            </div>
        </div>
        <Popup :isOpen="isOpen" :preselected="activeCategories" @close="isOpen = false" @applyFilters="updateFilters"/>
        <template v-if="!activeCategories || activeCategories.includes('actualite') || activeCategories.includes('all')">
            <div class="title-extended-container">
                <h3 class="title-extended">actualités</h3>
                <div class="border"></div>
            </div>
            <Carousel category="actualite" :bgIcon="false" />
        </template>
        <template v-if="!activeCategories || activeCategories.includes('cinema') || activeCategories.includes('all')">
            <div class="title-extended-container">
                <h3 class="title-extended">cinéma</h3>
                <div aria-hidden="true" role="presentation" class="border"></div>
            </div>
            <Carousel category="cinema" :bgIcon="false" />
        </template>
        <template v-if="!activeCategories || activeCategories.includes('culture') || activeCategories.includes('all')">
            <div class="title-extended-container">
                <h3 class="title-extended">culture</h3>
                <div aria-hidden="true" role="presentation" class="border"></div>
            </div>
            <Carousel category="culture" :bgIcon="false" />
        </template>
        <template v-if="!activeCategories || activeCategories.includes('internet') || activeCategories.includes('all')">
            <div class="title-extended-container">
                <h3 class="title-extended">internet</h3>
                <div aria-hidden="true" role="presentation" class="border"></div>
            </div>
            <Carousel category="internet" :bgIcon="false" />
        </template>
        <template v-if="!activeCategories || activeCategories.includes('musique') || activeCategories.includes('all')">
            <div class="title-extended-container">
                <h3 class="title-extended">musique</h3>
                <div aria-hidden="true" role="presentation" class="border"></div>
            </div>
            <Carousel category="musique" :bgIcon="false" />
        </template>
        <template v-if="!activeCategories || activeCategories.includes('sport') || activeCategories.includes('all')">
            <div class="title-extended-container">
                <h3 class="title-extended">sport</h3>
                <div aria-hidden="true" role="presentation" class="border"></div>
            </div>
            <Carousel category="sport" :bgIcon="false" />
        </template>
        <MopopIcon class="bg-icon" />
        <MopopIcon class="bg-icon second" />
    </section>
</template>

<script lang="ts" setup>
import { ref, watch } from 'vue';

const activeCategories = ref<string[] | null>(null);

const readUrlFilters = () => {
    const params = new URLSearchParams(window.location.search);
    const catQuery = params.getAll('cat'); 

    activeCategories.value = catQuery.length ? catQuery : null;
};

readUrlFilters();


import Search from '../icons/Search.vue';
import Button from '../../Button.vue';
import Filter from '../icons/Filter.vue';
import Popup from '../Popup.vue';
import Carousel from '../Carousel.vue';
import MopopIcon from '../icons/MopopIcon.vue';

const isOpen = ref(false);

const updateFilters = (cats: string[]) => {
    activeCategories.value = cats;
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
