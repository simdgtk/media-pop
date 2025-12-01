<template>
  <button class="button" @click="isOpen = true">
    <Filter />
    filtres et tri
  </button>
  <Popoup :isOpen="isOpen" @close="isOpen = false" />
</template>

<script lang="ts" setup>
import { ref } from 'vue';
import Filter from './components/icons/Filter.vue';
import Popoup from './components/Popup.vue';

const isOpen = ref(false);


</script>

<style scoped lang="scss">
@use 'sass:color';

.button {
    padding: toRem(10) toRem(12);
    background-color: $lime;
    width: fit-content;
    border-radius: 999px;
    color: $blue;
    pointer-events: all;
    cursor: pointer;
    transition: background-color 0.2s ease-in-out, color 0.2s ease-in-out, transform 0.1s ease-in-out;
    font-size: toRem(16);
    display: flex;
    align-items: center;
    gap: toRem(8);
    will-change: transform;
    backface-visibility: hidden;
    transform: translateZ(0);

    svg {
        width: toRem(16);
        height: toRem(16);
    }

    &:hover {
        background-color: color.adjust($lime, $lightness: -5%);
        transform: scale(0.99);
    }
    &:active {
        background-color: color.adjust($lime, $lightness: -10%);
        transform: scale(0.96);
    }
}
</style>
