<template>
<section class="content">
    <TextContent :content="props.article?.content" />
    <footer class="content-footer">
        <div class="footer-container">
            <div class="author-infos">
                <figure class="image-container">
                    <img src="https://images.unsplash.com/photo-1761839258753-85d8eecbbc29?q=80&w=3270&auto=format&fit=crop" alt="Auteur"/>
                </figure>
                <address class="author">
                    <strong>{{ props.article?.author ?? 'Auteur inconnu' }}</strong>
                    <i>"J'écris des articles cool"</i>
                </address>
            </div>
            <div class="buttons">
                <Button class="share-button" text="like" reverse @click="isFilled = !isFilled">
                    <template #icon>
                        <HeartBold :fill="isFilled" />
                    </template>
                </Button>
                <Button class="share-button" text="partager" reverse>
                    <template #icon>
                        <Share />
                    </template>
                </Button>
            </div>
        </div>
    </footer>
</section>
</template>

<script lang="ts" setup>
import { ref } from 'vue';
import TextContent from './TextContent.vue';
import Button from '../Button.vue';
import Share from './icons/Share.vue';
import HeartBold from './icons/HeartBold.vue';

const isFilled = ref(false);

interface Article {
    content?: string;
    author?: string;
}

const props = defineProps<{
    article?: Article
}>();
</script>

<style lang="scss" scoped>
.content {

    .content-footer {
        .footer-container {
            margin-top: toRem(42);
            display: flex;
            flex-direction: column;
            gap: toRem(20);

            .buttons {
                display: flex;
                flex-direction: row;
                gap: toRem(8);
            }

            .author-infos {
                display: flex;
                flex-direction: row;
                align-items: flex-end;
                gap: toRem(20);
            }

            .author {
                display: flex;
                flex-direction: column;
                justify-content: center;

                strong {
                    font-size: toRem(16);
                    font-weight: 700;
                    font-family: 'Font1', sans-serif;
                    color: $red;
                }

                i {
                    font-size: toRem(12);
                    font-weight: 400;
                    font-style: italic;
                    margin-top: toRem(4);
                    color: $black;
                    user-select: none;
                }
            }
        }

        .share-button {
            align-self: flex-start;

            span {
                display: flex;
            }
        }
    }
}

.image-container {
    max-width: toRem(500);
    width: 40%;
    border-radius: toRem(8);
    overflow: hidden;
    aspect-ratio: 1;
    background-color: $white;

    img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        user-select: none;
    }
}
</style>
