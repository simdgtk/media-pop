<template>
    <section class="article">
        <div class="hero-article">
            <div class="title-container">
                <div class="image-container">
                    <img :src="props.article.image ? `/storage/${props.article.image}` : 'https://via.placeholder.com/310x169'"
                        :alt="props.article.title" />
                </div>
                <h1 ref="titleRef" class="title"><span class="highlight">{{ props.article.selected_words }}</span></h1>
            </div>
            <p class="external-title">{{ props.article.title }}</p>
            <p>{{ props.article.source_title }}</p>
        </div>

        <div class="content-container-wrapper">
            <div class="content-container">
                <Content :article="props.article" />
            </div>
            <MopopIcon class="bg-icon" />
        </div>
    </section>
</template>

<script lang="ts" setup>
import { ref } from 'vue';
import Content from '../Content.vue';
import MopopIcon from '../icons/MopopIcon.vue';

interface Article {
    id: number;
    title: string;
    subtitle?: string;
    content?: string;
    image?: string;
    author?: string;
    source_title?: string;
    source_url?: string;
    category?: string[];
    published_at?: string;
    selected_words?: string;
}

const props = defineProps<{
    article: Article
}>();

const titleRef = ref<HTMLElement | null>(null);
</script>

<style lang="scss" scoped>
.hero-article {
    @extend %container;
}

.article {
    padding-top: toRem(42);
    color: $white;

    .title-container {
        position: relative;

        .image-container {
            border-radius: toRem(8);
            overflow: hidden;
            aspect-ratio: 310 / 169;
            background-color: $white;

            img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                user-select: none;
            }
        }

        .title {
            color: $red;
            position: absolute;
            bottom: 0;
            left: toRem(8);
            width: calc(100% - #{toRem(16)});
            transform: translateY(45%);
            word-wrap: break-word;
            pointer-events: none;

            .highlight {
                background-color: $lime;
                line-height: 1.15;
                font-size: toRem(28);
                font-family: 'Font1', sans-serif;
                font-weight: 900;
                text-transform: uppercase;
                padding: toRem(2) toRem(4);
                display: inline;
                box-decoration-break: clone;
                -webkit-box-decoration-break: clone;
            }
        }
    }

    .external-title {
        margin-top: toRem(42);
        font-size: toRem(28);
        font-weight: 700;
        line-height: 100%;
    }

    .subtitle {
        margin-top: toRem(16);
        font-weight: 700;
        font-size: toRem(16);
    }

    .content-container-wrapper {
        position: relative;
        overflow: hidden;
        z-index: 2;
        background-color: $white;
        padding: toRem(24) 0;
        margin-top: toRem(24);

        .content-container {
            @extend %container;
            color: $black;
        }

        .bg-icon {
            position: absolute;
            bottom: toRem(20);
            right: toRem(-50);
            width: toRem(300);
            height: toRem(400);
            color: rgba($blue, 0.06);
            pointer-events: none;
            user-select: none;
            z-index: -1;
        }
    }
}
</style>
