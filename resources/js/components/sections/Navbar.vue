<template>
    <nav class="navbar">
        <a href="/" class="logo-container">
            <Logo class="logo" />
        </a>
        <div class="burger-menu">
            <Burger />
        </div>
    </nav>
</template>

<script lang="ts" setup>
import Burger from '../icons/Burger.vue';
import Logo from '../icons/Logo.vue';


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
