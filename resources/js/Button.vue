<template>
  <button class="button" :class="{ 'reverse': reverse }">
    <slot name="icon"></slot>
    <slot>{{ text }}</slot>
  </button>
</template>

<script lang="ts" setup>
defineProps<{
  text?: string;
  reverse?: boolean;
}>();


</script>

<style scoped lang="scss">
@use 'sass:color';

.button {
    padding: toRem(10) toRem(12);
    background-color: $lime;
    width: fit-content;
    border-radius: 999px;
    color: currentColor;
    pointer-events: all;
    cursor: pointer;
    transition: background-color 0.1s ease-in-out, color 0.1s ease-in-out, transform 0.1s ease-in-out;
    font-size: toRem(16);
    display: flex;
    align-items: center;
    gap: toRem(8);
    will-change: transform;
    backface-visibility: hidden;
    transform: translateZ(0);

    :deep(svg) {
        width: toRem(16);
        height: toRem(16);
    }

    &.reverse {
        flex-direction: row-reverse;
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
