<template>
    <div class="bottom-nav">
        <a href="/" class="icon-container" :class="{ fill: current === 'home' }" @click="choose('home')">
            <Home class="icon" :fill="current === 'home'" />
            <div class="icon-title">
                <span class="title-text">Accueil</span>
                <div role="presentation" aria-hidden="true" class="highlight"></div>
            </div>
        </a>
        <a href="/search" class="icon-container" :class="{ fill: current === 'search' }" @click="choose('search')">
            <Search class="icon" :fill="current === 'search'" />
            <div class="icon-title">
                <span class="title-text">recherche</span>
                <div role="presentation" aria-hidden="true" class="highlight"></div>
            </div>
        </a>
        <a href="/favorite" class="icon-container" :class="{ fill: current === 'favorite' }" @click="choose('favorite')">
            <Heart class="icon" :fill="current === 'favorite'" />
            <div class="icon-title">
                <span class="title-text">favoris</span>
                <div role="presentation" aria-hidden="true" class="highlight"></div>
            </div>
        </a>
        <a href="/profile" class="icon-container" :class="{ fill: current === 'account' }" @click="choose('account')">
            <User class="icon" :fill="current === 'account'" />
            <div class="icon-title">
                <span class="title-text">compte</span>
                <div role="presentation" aria-hidden="true" class="highlight"></div>
            </div>
        </a>
    </div>
</template>

<script lang="ts" setup>
import { ref, computed } from 'vue';
import Heart from '../icons/Heart.vue';
import Home from '../icons/Home.vue';
import User from '../icons/User.vue';
import Search from '../icons/Search.vue';

const localSelected = ref<string|null>(null);

const urlSelected = computed(() => {
    const path = window.location.pathname;
    if (path.startsWith('/search')) return 'search';
    if (path.startsWith('/account') || path.startsWith('/favorite')) return 'favorite';
    // if (path.startsWith('/favorite')) return 'favorite';
    if (path.startsWith('/account') || path.startsWith('/profile')) return 'account';
    return 'home';
});

const current = computed(() => localSelected.value ?? urlSelected.value);

function choose(tab: string) {
    localSelected.value = tab;
}
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
    z-index: 10;
    box-shadow: 0 toRem(-6) toRem(10) 0 rgba(44, 0, 166, 0.2);
    padding-bottom: toRem(24);

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
            :deep(.icon) {
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
