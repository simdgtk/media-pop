<template>
    <div class="categories-container">
        <section class="categories">
            <h2>Catégories</h2>
            <div class="filters">
                <Button class="button" text="filtres et tri" @click="isOpen = true">
                    <template #icon>
                        <Filter />
                    </template>
                </Button>
            </div>
            <Popup :isOpen="isOpen" @close="isOpen = false" />
            <div class="title-extended-container">
                <h3 class="title-extended">musique</h3>
                <div aria-hidden="true" role="presentation" class="border"></div>
            </div>
            <Carousel />
        </section>
    </div>
</template>

<script lang="ts" setup>
import { ref } from 'vue';
import Carousel from '../Carousel.vue';
import Button from '../../Button.vue';
import Filter from '../icons/Filter.vue';
import Popup from '../Popup.vue';

const isOpen = ref(false);

</script>

<style lang="scss" scoped>
.categories-container {
    width: 100%;
    background-color: $blue;
    overflow: hidden;
}
.categories {
    margin-inline: auto;
    padding-inline: toRem(20);
    max-width: 1440px;
    width: 100%;
    margin: 0 auto;
    padding: 0;
    padding-top: toRem(54);
    display: flex;
    flex-direction: column;
    gap: toRem(24);
    background-color: $blue;
    color: $white;

    h2 {
        color: $white;
        margin-left: toRem(20);
        padding-right: toRem(20);
    }

    .filters {
        margin-left: toRem(20);

        .button {
            color: $blue;
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
}
</style>
