<template>
    <nav class="navbar">
                     <a href="/" class="logo-container" @click.prevent="triggerAnimation">
                             <LogoAnimated
                                 ref="logoRef"
                                 class="logo"
                                 :color1="logoColor1"
                                 :color2="logoColor2"
                             />
                     </a>
    </nav>
</template>

<script lang="ts" setup>
import { computed, ref } from 'vue';
import LogoAnimated from '../icons/LogoAnimated.vue';
const logoRef = ref<InstanceType<typeof LogoAnimated> | null>(null);

const currentPath = typeof window !== 'undefined' ? window.location.pathname : '/';
const logoColor1 = computed(() => currentPath === '/search' ? '#4F49FD' : '#FD494A');
const logoColor2 = computed(() => '#B8FF93');

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
