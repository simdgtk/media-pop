<template>
<section class="content">
    <TextContent :content="props.articleContent" />
    <footer class="content-footer">
        <div class="footer-container">
            <div class="author-infos">
                <figure class="image-container">
                    <img :src="article.auteur?.image ? `/storage/${article.auteur.image}` : 'default-author.jpg'" :alt="article.auteur?.nom ?? 'Auteur inconnu'" />
                </figure>
                <address class="author">
                    <strong>{{ article.auteur?.nom ?? 'Auteur inconnu' }}</strong>
                    <i>{{ article.auteur?.description ?? 'Pas de description' }}</i>
                </address>
            </div>
            <Button class="share-button" text="partager" reverse>
                <template #icon>
                    <Share />
                </template>
            </Button>
        </div>
    </footer>
</section>
</template>

<script lang="ts" setup>
import TextContent from './TextContent.vue';
import Button from '../Button.vue';
import Share from './icons/Share.vue';

const props = defineProps<{
    article?: {
        title: string,
        content: string,
        auteur?: {
            nom: string,
            description: string;
            image_url: string;
        }
    }
}>();

const article = props.article;

</script>

<style lang="scss" scoped>
.content {

    .content-footer {
        .footer-container {
            margin-top: toRem(42);
            display: flex;
            flex-direction: column;
            gap: toRem(20);

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
