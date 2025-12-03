<template>
    <div class="text-content" v-html="props.content"></div>
</template>

<script lang="ts" setup>
import { defineProps } from 'vue';

const props = defineProps<{
    content?: string
}>();
</script>

<style lang="scss" scoped>
.text-content {
    font-size: toRem(16);
    line-height: 106%;
    font-weight: 400;
    color: $black;

    p {
        margin-bottom: toRem(24);
    }

    h3 {
        font-size: toRem(28);
        color: $red;
        margin-bottom: toRem(16);
        font-weight: 700;
        line-height: 100%;
    }
}
</style>
