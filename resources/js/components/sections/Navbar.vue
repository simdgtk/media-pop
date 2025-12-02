<template>
    <nav class="navbar">
        <a href="/" class="logo-container" @click.prevent="triggerAnimation">
             <LogoAnimated ref="logoRef" class="logo" />
        </a>
    </nav>
</template>

<script lang="ts" setup>
import { ref } from 'vue';
import Burger from '../icons/Burger.vue';
import Logo from '../icons/Logo.vue';
import LogoAnimated from '../icons/LogoAnimated.vue';

const logoRef = ref<InstanceType<typeof LogoAnimated> | null>(null);

const triggerAnimation = () => {
    if (logoRef.value) {
        logoRef.value.animate();
    }
};
</script>

<style lang="scss" scoped>
.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    @extend %container;

    margin-top: toRem(20);
    padding-right: toRem(20);

    .logo-container {
        width: toRem(68);
        .logo {
            color: $lime;
        }
    }

    .burger-menu {
        svg {
            width: toRem(24);
            color: $white;
            margin: toRem(8);
        }
    }
}
</style>
