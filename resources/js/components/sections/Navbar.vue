<template>
    <nav class="navbar">
        <a href="/" class="logo-container" @click.prevent="triggerAnimation">
            <LogoAnimated ref="logoRef" class="logo" :color1="color1" :color2="color2" />
        </a>
        <a href="/" class="onboarding-link">
            <Question />
        </a>
    </nav>
</template>

<script lang="ts" setup>
import { ref } from 'vue';
import Question from '../icons/Question.vue';
import LogoAnimated from '../icons/LogoAnimated.vue';

const props = defineProps({
    color1: { type: String, default: '#FD494A' },
    color2: { type: String, default: '#B8FF93' }
});

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

    .onboarding-link {
        svg {
            width: toRem(24);
            margin: toRem(8);
        }
    }
}
</style>
