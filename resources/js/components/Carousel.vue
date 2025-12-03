<template>
    <div class="embla carousel" ref="emblaRef">
        <div class="embla__container">
            <a :href="`/article-test/${article.id}`" v-for="article in filteredArticles" :key="article.id" class="embla__slide article">
                <div class="image-container">
                    <img v-if="article.image_url" :src="article.image_url" :alt="article.title" />
                    <div v-else class="placeholder-box">Pas d'image</div>
                </div>
                <div class="article-names">
                    <p class="external-article-name" v-html="article.source_title ? article.source_title : 'Source'">
                    </p>
                    <h3 class="article-name">{{ article.title }}</h3>
                </div>
            </a>
            <div class="embla__slide article">
                <div class="image-container">
                    <img src="https://images.unsplash.com/photo-1761839258753-85d8eecbbc29?q=80&w=3270&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDF8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                        alt="Article Image" />
                </div>
                <div class="article-names">
                    <p class="external-article-name">Comment le drapeau de <span class="highlight">One Piece</span> est
                        devenu un symbole de révolte
                        chez la Gen Z ?</p>
                    <h3 class="article-name">Ou quels sont les messages cachés derrière cette oeuvre ? </h3>
                </div>
            </div>
        </div>

        <Mo v-if="bgIcon" class="icon-background" />
    </div>
</template>

<script lang="ts" setup>
import emblaCarouselVue from 'embla-carousel-vue'
import { ref, onMounted, computed, defineProps } from 'vue'
import Mo from './icons/Mo.vue'

interface ArticleData {
    id: number
    title: string
    source_title?: string | null
    excerpt?: string
    image_url?: string | null
    source_url?: string | null
    category?: string[] | null
    created_at?: string | null
}

const props = defineProps<{
    category?: string | null
    bgIcon?: boolean
}>()

const bgIcon = props.bgIcon ?? false;

const [emblaRef] = emblaCarouselVue()
const articles = ref<ArticleData[]>([])

const fetchLatest = async () => {
    try {
        let url = '/articles/latest';
        if (props.category) {
            url += `?category=${encodeURIComponent(props.category)}`;
        }

        const res = await fetch(url);
        if (!res.ok) {
            console.error('articles latest returned', res.status);
            return;
        }

        const data = await res.json();
        articles.value = data;
    } catch (err) {
        console.error('Failed to fetch latest articles', err);
    }
}


onMounted(fetchLatest)

const filteredArticles = computed(() => articles.value);

</script>



<style lang="scss" scoped>
.embla {
    overflow: hidden;
}

.embla__container {
    display: flex;
}

.embla__slide {
    flex: 0 0 100%;
    min-width: 0;
}

.carousel {
    position: relative;
    padding-bottom: toRem(24);
}

.icon-background {
    position: absolute;
    bottom: -1%;
    left: toRem(20);
    width: calc(100vw - 20px);
    height: auto;
    max-width: toRem(500);
    color: #F34243;
    z-index: -1;
}


.article {
    display: flex;
    flex-direction: column;
    gap: toRem(12);
    color: $white;
    max-width: 90vw;

    @media screen and (min-width: 768px) {
        max-width: toRem(310);
    }

    padding-left: toRem(20);

    &:last-of-type {
        margin-right: toRem(20);
    }

    .image-container {
        border-radius: toRem(8);
        overflow: hidden;
        aspect-ratio: 310 / 169;
        background-color: $white;

        img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .placeholder-box {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f1f1f1;
            color: #333;
            font-weight: 600;
            padding: toRem(12);
            text-align: center;
        }
    }

    .article-names {
        display: flex;
        flex-direction: column;
        gap: toRem(4);
        font-family: 'Instrument Sans', sans-serif;

        .external-article-name {
            font-weight: 700;
            font-size: toRem(14);
            line-height: 110%;
            margin-bottom: toRem(4);

            :deep(.highlight) {
                background-color: $lime;
                color: $red;
                padding: 0 toRem(2);
            }
        }

        .article-name {
            font-weight: 700;
            font-size: toRem(14);
            font-style: italic;
            text-decoration: underline;
            text-decoration-thickness: toRem(1);
            text-underline-offset: toRem(2);
            line-height: 95%;
        }
    }
}
</style>
