<template>
    <section class="article">
        <div class="hero-article">
            <div class="title-container">
                <div class="image-container">
                    <img src="https://images.unsplash.com/photo-1761839258753-85d8eecbbc29?q=80&w=3270&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDF8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                        alt="Article Image" />
                </div>
                <h1 class="title">One piece</h1>
            </div>
            <p class="external-title">Sous-titre. de l’article.............Norem ipsum dolor sit amet, consectetur
                adipiscing elit.
                Etiam eu turpis
                molestie, dictum est a.</p>
            <p class="subtitle">Sous-titre. de l’article.............Norem ipsum dolor sit amet, consectetur
                adipiscing elit.
                Etiam eu turpis
                molestie, dictum est a.</p>
        </div>
        <div class="content-container-wrapper">
            <div class="content-container">
                <Content />
            </div>
            <MopopIcon class="bg-icon" />
        </div>
    </section>
</template>

<script lang="ts" setup>
import Content from '../Content.vue';
import Pop from '../icons/Pop.vue';
import MopopIcon from '../icons/MopopIcon.vue';


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
            background-color: $lime;
            font-family: 'Font1', sans-serif;
            font-weight: 900;
            text-transform: uppercase;
            width: fit-content;
            line-height: 1;
            padding: toRem(2) toRem(4);

            position: absolute;
            bottom: 0;
            left: toRem(8);
            transform: translateY(45%);
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
