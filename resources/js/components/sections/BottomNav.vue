<template>
    <div class="bottom-nav">
        <div class="icon-container" :class="{ fill: selected === 'home' }" @click="selected = 'home'">
            <Home class="icon" :fill="selected === 'home'" />
            <div class="icon-title">
                <span class="title-text">Accueil</span>
                <div role="presentation" aria-hidden="true" class="highlight"></div>
            </div>
        </div>
        <div class="icon-container" :class="{ fill: selected === 'search' }" @click="selected = 'search'">
            <Search class="icon" :fill="selected === 'search'" />
            <div class="icon-title">
                <span class="title-text">recherche</span>
                <div role="presentation" aria-hidden="true" class="highlight"></div>
            </div>
        </div>
        <div class="icon-container" :class="{ fill: selected === 'favorites' }" @click="selected = 'favorites'">
            <Heart class="icon" :fill="selected === 'favorites'" />
            <div class="icon-title">
                <span class="title-text">favoris</span>
                <div role="presentation" aria-hidden="true" class="highlight"></div>
            </div>
        </div>
        <div class="icon-container" :class="{ fill: selected === 'account' }" @click="selected = 'account'">
            <User class="icon" :fill="selected === 'account'" />
            <div class="icon-title">
                <span class="title-text">compte</span>
                <div role="presentation" aria-hidden="true" class="highlight"></div>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { ref } from 'vue';
import Heart from '../icons/Heart.vue';
import Home from '../icons/Home.vue';
import User from '../icons/User.vue';
import Search from '../icons/Search.vue';

const selected = ref<'home' | 'search' | 'favorites' | 'account'>('home');

</script>

<style lang="scss" scoped>
@use 'sass:color';
@use "../../../css/easings" as *;

.bottom-nav {
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    max-width: 1440px;
    background-color: $white;
    border-radius: toRem(20) toRem(20) 0 0;
    display: flex;
    justify-content: space-between;
    gap: toRem(8);
    flex-wrap: wrap;
    padding: toRem(12) toRem(28);

    .icon {
        display: flex;
        align-items: flex-end;
        width: toRem(30);
        color: $light-blue;
    }

    .icon-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: toRem(2);

        .icon-title {
            position: relative;
            display: flex;

            .title-text {
                font-size: toRem(12);
                font-weight: 700;
                color: $light-blue;
                text-transform: lowercase;
                line-height: 100%;
            }

            .highlight {
                display: block;
                content: '';
                position: absolute;
                bottom: 0;
                left: 0;
                width: calc(100% + toRem(4));
                height: 100%;
                background-color: $lime;
                z-index: -1;
                transform: translate(toRem(-2), 0) scaleX(0);
                transform-origin: left;
                transition: none;
            }
        }

        &.fill {
            ::v-deep .icon {
                color: $blue;
            }

            .icon-title {
                .title-text {
                    color: $blue;
                }

                .highlight {
                    transform: translate(toRem(-2), 0) scaleX(1);
                    transition: transform 0.5s $ease-out-quart;
                }
            }
        }
    }

}
</style>
