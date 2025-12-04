
<script setup lang="ts">
import { ref, onMounted } from 'vue';
import LogoAnimated from '../icons/LogoAnimated.vue';

const white = '#fff';
const red = '#FD494A';

const logoRef = ref();

onMounted(() => {
    setTimeout(() => {
        logoRef.value?.animate();
    }, 700);
});
</script>

<template>
    <div class="slide-content first-slide-layout">
        <h2 class="title">Bienvenue sur</h2>
        <LogoAnimated ref="logoRef" class="logo" :color1="red" :color2="white" />
        <p class="text">Ou, l’appli qui décode les mots des actualités pop</p>
    </div>
</template>

<style scoped lang="scss">
.first-slide-layout {
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: toRem(48);

    .logo {
        width: toRem(180);
        height: toRem(180);
        margin: 0;
    }

    .title {
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 1rem;
    }

    .text {
        font-size: toRem(28);
        line-height: 95%;
        text-decoration: underline;
        text-decoration-thickness: toRem(1);
        text-underline-offset: 20%;
        font-style: italic;
        font-weight: 400;
    }
}
</style>
