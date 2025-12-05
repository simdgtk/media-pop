<template>
    <div class="slide-content concept-layout" :class="{ 'animate': isAnimated }">
        <div class="base-content">
            <p class="text-intro">
                MoPop est une application d’actualité qui <span class="underline">surligne</span> les mots de la pop
                culture
            </p>

            <div class="mots">
                <span>one piece</span>
                <span>Fashion week</span>
                <span>live</span>
                <span>Showcase</span>
            </div>

            <p class="text-explain">Pour t’en expliquer leurs origines</p>
        </div>

        <div class="popup">
            <div class="popup-wrapper">
                <p class="popup-text">Filtre les différentes actualités par leur catégorie</p>
                <div class="categories-demo">
                    <div class="drag-handle"></div>
                    <span class="categories-title"><span class="highlight">catégories</span></span>
                    <div class="categories-list">
                        <button class="cat-btn selected">cinéma</button>
                        <button class="cat-btn">culture</button>
                        <button class="cat-btn">musique</button>
                        <button class="cat-btn selected">sport</button>
                        <button class="cat-btn">jeux vidéo</button>
                        <button class="cat-btn">livres</button>
                        <button class="cat-btn selected">festival</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { ref, onMounted } from 'vue';

const isAnimated = ref(false);

onMounted(() => {
    setTimeout(() => {
        isAnimated.value = true;
    }, 200);
});
</script>

<style scoped lang="scss">
$ease-out: cubic-bezier(0.215, 0.61, 0.355, 1);

.concept-layout {
    display: flex;
    flex-direction: column;
    justify-content: center;
    height: 100%;
    overflow: hidden;

    .base-content {
        display: flex;
        flex-direction: column;
        gap: toRem(32);

        transform: translateY(22vh);
        transition: transform 1s $ease-out;
        transition-delay: 1.8s;
        will-change: transform;
    }

    p {
        font-size: toRem(20);
    }

    .base-content p,
    .mots span {
        opacity: 0;
        transform: translateY(toRem(15));
        transition: opacity 0.6s $ease-out, transform 0.6s $ease-out;
        will-change: transform, opacity;
    }

    &.animate {
        .base-content {
            transform: translateY(0);
        }

        .base-content p,
        .mots span {
            opacity: 1;
            transform: translateY(0);
        }

        .popup {
            transform: translateY(0);
            opacity: 1;

            .popup-wrapper {
                margin-top: toRem(42);
            }
        }

        .popup .popup-text {
            opacity: 1;
            transform: translateY(0);
        }

        .popup .categories-demo {
            transform: translateY(0);
        }

        .categories-list .cat-btn {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .underline {
        background-color: $lime;
        color: $red;
        line-height: 100%;
        clip-path: polygon(0 10%, 100% 10%, 100% 100%, 0% 100%);
        display: inline-block;
    }

    .text-intro {
        transition-delay: 0.1s;
    }

    .mots {
        display: flex;
        flex-wrap: wrap;
        gap: toRem(8);

        span {
            font-size: toRem(24);
            font-weight: 700;
            background-color: $lime;
            text-transform: uppercase;
            color: $red;

            @for $i from 1 through 4 {
                &:nth-child(#{$i}) {
                    transition-delay: #{0.3s + ($i * 0.1s)};
                }
            }
        }
    }

    .text-explain {
        font-size: toRem(20);
        font-weight: 400;
        transition-delay: 0.8s;
    }

    .popup {
        margin-top: toRem(32);
        text-align: center;
        width: 100%;

        transform: translateY(100%);
        opacity: 0;
        transition: transform 1s $ease-out, opacity 0.8s $ease-out;
        transition-delay: 1.8s;
        will-change: transform, opacity;

        clip-path: polygon(0 -50%, 100% -50%, 100% 100%, 0% 100%);

        .popup-text {
            margin-bottom: toRem(16);
            opacity: 0;
            transform: translateY(toRem(10));
            transition: opacity 0.6s $ease-out, transform 0.6s $ease-out;
            transition-delay: 2.4s;
        }

        .categories-demo {
            background: $white;
            border-radius: toRem(32) toRem(32) 0 0;
            padding: toRem(24) toRem(20) toRem(20) toRem(20);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            position: relative;

            transform: translateY(100%);
            will-change: transform;

            transition: transform 1.2s $ease-out;
            transition-delay: 2.5s;

            .drag-handle {
                width: 20%;
                height: toRem(4);
                background-color: rgba($blue, 0.2);
                border-radius: toRem(2);
                position: absolute;
                top: toRem(12);
                left: 50%;
                transform: translateX(-50%);
            }

            .categories-title {
                font-size: toRem(24);
                font-weight: 700;
                margin-bottom: toRem(16);
                margin-top: toRem(16);

                .highlight {
                    background: $lime;
                    color: $blue;
                    padding: 0 toRem(4);
                }
            }

            .categories-list {
                display: flex;
                flex-wrap: wrap;
                gap: toRem(8);

                .cat-btn {
                    border-radius: toRem(999);
                    border: toRem(1) solid $blue;
                    background: #fff;
                    color: $blue;
                    font-size: toRem(18);
                    font-family: 'Instrument Sans', sans-serif;
                    font-weight: 500;
                    padding: toRem(4) toRem(10);
                    cursor: pointer;

                    transition: background 0.1s, color 0.1s, transform 0.1s;

                    opacity: 0;
                    transform: translateY(toRem(10));

                    &.selected {
                        background: $blue;
                        color: #fff;
                        border-color: $blue;
                    }

                    &:hover {
                        transform: scale(0.98);
                    }
                }
            }
        }
    }
}



.concept-layout.animate {
    .popup {
        .categories-demo {
            .categories-list {
                .cat-btn {
                    transition: opacity 0.5s $ease-out, transform 0.5s $ease-out, background 0.1s, color 0.1s;
                    opacity: 1;
                    transform: translateY(0) scale(1);

                    @for $i from 1 through 10 {
                        &:nth-child(#{$i}) {
                            transition-delay: #{3.7s + ($i * 0.05s)};
                        }
                    }
                }
            }
        }
    }
}
</style>
