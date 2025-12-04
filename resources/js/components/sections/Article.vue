<template>
<section class="article">
    <div class="hero-article">
        <div class="title-container">
            <div class="image-container">
                <img :src="article.image_url ?? 'https://via.placeholder.com/310x169'" 
                     :alt="article.title" />
            </div>
            <h1 ref="titleRef" class="title">{{ article.title }}</h1>
        </div>
        <p class="external-title" v-if="article.subtitle">{{ article.subtitle }}</p>
    </div>

    <div class="content-container-wrapper">
        <div class="content-container">
            <Content :article="article" />
        </div>
        <MopopIcon class="bg-icon" />
    </div>
</section>
</template>

<script lang="ts" setup>
import { ref, onMounted, onUnmounted } from 'vue';
import Content from '../Content.vue';
import MopopIcon from '../icons/MopopIcon.vue';
import SplitType from 'split-type';

interface Auteur {
    nom: string;
    description: string;
    image_url: string;
}

interface Article {
    id: number;
    title: string;
    subtitle?: string;
    content?: string;
    image_url?: string;
    auteur?: string;
    source_title?: string;
    source_url?: string;
    category?: string[];
    published_at?: string;
}

const props = defineProps<{ article: Article }>();
const article = props.article;

const titleRef = ref<HTMLElement | null>(null);
let splitInstance: SplitType | null = null;

const handleResize = () => splitInstance?.split();

onMounted(() => {
    if (titleRef.value) {
        splitInstance = new SplitType(titleRef.value, {
            types: 'lines',
            tagName: 'span',
        });
        window.addEventListener('resize', handleResize);
    }
});

onUnmounted(() => {
    window.removeEventListener('resize', handleResize);
    splitInstance?.revert();
});

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
            font-size: toRem(28);
            font-family: 'Font1', sans-serif;
            font-weight: 900;
            text-transform: uppercase;
            width: fit-content;
            line-height: 1.15;

            position: absolute;
            bottom: 0;
            left: toRem(8);
            transform: translateY(45%);

            :deep(.line) {
                background-color: $lime;
                padding: toRem(2) toRem(4);
                display: inline-block;
                width: fit-content;
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
