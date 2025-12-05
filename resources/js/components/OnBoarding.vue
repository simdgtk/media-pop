<template>
    <Transition name="fade">
        <div v-if="isOpen" class="onboarding-popup">
            <div class="content-wrapper">
                <div class="slides-container">
                    <Transition name="slide-fade" mode="out-in">
                        <div :key="currentSlide" class="slide">
                            <template v-if="currentSlide < slides.length">
                                <component :is="slides[currentSlide]" />
                            </template>
                            <template v-else>
                                <div class="logo-slide">
                                    <component :is="LogoAnimated" class="logo-anim" v-if="LogoAnimated" />
                                    <div v-else>Loading...</div>
                                </div>
                            </template>
                        </div>

                    </Transition>
                </div>

                <div class="controls-container" v-if="currentSlide < slides.length">
                    <button class="action-button" @click="nextSlide">
                        <span class="button-text">{{ currentSlide === slides.length - 1 ? 'Commencer' : 'Continuer'
                        }}</span>
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M12 5L19 12L12 19" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </Transition>
</template>

<script lang="ts" setup>
import { ref, onMounted, onUnmounted, defineAsyncComponent, shallowRef } from 'vue';

import SlideFirst from './onboarding/SlideFirst.vue';
import SlideSecond from './onboarding/SlideSecond.vue';

const LogoAnimated = defineAsyncComponent(() => import('./icons/LogoAnimated.vue'));

const isOpen = ref(false);
const currentSlide = ref(0);

const slides = shallowRef([
    SlideFirst,
    SlideSecond]);

const nextSlide = () => {
    if (currentSlide.value < slides.value.length) {
        currentSlide.value++;

        if (currentSlide.value === slides.value.length) {
            setTimeout(() => {
                closePopup();
            }, 2000);
        }
    }
};

const closePopup = () => {
    isOpen.value = false;
    localStorage.setItem('mopop_onboarding_completed', 'true');
};

const handleOpenEvent = () => {
    currentSlide.value = 0;
    isOpen.value = true;
};

onMounted(() => {
    const hasSeenOnboarding = localStorage.getItem('mopop_onboarding_completed');
    if (!hasSeenOnboarding) {
        isOpen.value = true;
    }
    window.addEventListener('open-onboarding', handleOpenEvent);
});

onUnmounted(() => {
    window.removeEventListener('open-onboarding', handleOpenEvent);
});
</script>

<style scoped lang="scss">
@use 'sass:color';

.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.5s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}

.slide-fade-enter-active,
.slide-fade-leave-active {
    transition: opacity 0.3s ease, transform 0.3s ease;
}

.slide-fade-enter-from {
    opacity: 0;
    transform: translateX(20px);
}

.slide-fade-leave-to {
    opacity: 0;
    transform: translateX(-20px);
}

.onboarding-popup {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background-color: #FD494A;
    z-index: 9999;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    color: $white;
    overflow: hidden;
}

.content-wrapper {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: toRem(40) toRem(20);
    max-width: toRem(500);
    margin: 0 auto;
}

.slides-container {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
    position: relative;
}

.slide {
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100%;
}


.logo-slide {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
    width: 100%;

    .logo-anim {
        width: toRem(150);
        height: auto;
        color: $white;
    }
}

.controls-container {
    width: 100%;
    display: flex;
    justify-content: center;
    padding-bottom: toRem(40);
}

.action-button {
    display: flex;
    align-items: center;
    gap: toRem(8);
    background-color: $blue;
    color: $white;
    padding: toRem(12) toRem(24);
    border-radius: toRem(999);
    font-size: toRem(16);
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
    border: none;
    font-family: 'Instrument Sans', sans-serif;

    &:hover {
        background-color: color.adjust($blue, $lightness: -5%);
        transform: scale(1.02);
    }

    &:active {
        transform: scale(0.98);
    }

    svg {
        width: toRem(20);
        height: toRem(20);
    }
}
</style>
