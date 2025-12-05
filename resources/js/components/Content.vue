<template>
    <section class="content">
        <TextContent :content="props.articleContent" />
        <footer class="content-footer">
            <div class="footer-container">
                <div class="author-infos">
                    <figure class="image-container">
                        <img :src="article.auteur?.image_url ?? '/images/default-author.jpg'"
                            :alt="article.auteur?.nom ?? 'Auteur inconnu'" />
                    </figure>
                    <address class="author">
                        <strong>{{ article.auteur?.nom ?? 'Auteur inconnu' }}</strong>
                        <i>{{ article.auteur?.description ?? 'Pas de description' }}</i>
                    </address>
                </div>
                <div class="buttons">
                    <Button class="share-button" text="like" reverse @click="toggleFavorite">
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
import { ref, onMounted } from 'vue';
import TextContent from './TextContent.vue';
import Button from '../Button.vue';
import Share from './icons/Share.vue';
import HeartBold from './icons/HeartBold.vue';

const isFilled = ref(false);


const props = defineProps<{
    article?: {
        id: number,
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

async function toggleFavorite() {
    if (!article?.id) return;

    try {
        const response = await fetch('/profile/favorites/toggle', { 
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                // Utiliser le jeton CSRF pour les requêtes web/POST
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            },
            body: JSON.stringify({ article_id: article.id })
        });

        const data = await response.json();

        if (response.ok) {
            isFilled.value = data.is_favorited; 
            
            console.log('Favoris mis à jour. État actuel:', data.is_favorited ? 'Favori' : 'Non favori');
        } else {
            console.error('Erreur lors de la mise à jour des favoris:', data.error);
        }
    } catch (err) {
        console.error("Erreur de connexion:", err);
    }
}


onMounted(() => {
    if (article && article.id) {
        fetch('/profile/favorites', { headers: { 'Accept': 'application/json' } })
            .then(res => res.json())
            .then(data => {
                isFilled.value = data.favorites?.includes(article.id) || false;
            })
            .catch(err => console.error("Erreur de récupération des favoris initiaux:", err));
    }
});

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
