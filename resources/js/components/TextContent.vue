<template>
    <div class="text-content" v-html="props.content"></div>
</template>

<script lang="ts" setup>

const props = defineProps<{
    content?: string
}>();
</script>

<style lang="scss" scoped>
.text-content {
    font-size: toRem(16);
    line-height: 106%;
    font-weight: 400;
    
    p {
        margin-bottom: toRem(24);
    }
    
    :deep(h2), :deep(h3) {
        font-size: toRem(28);
        color: $red;
        margin-bottom: toRem(16);
        font-weight: 700;
        line-height: 100%;
        text-transform: none;
        font-family: 'Instrument Sans', sans-serif;
    }

    :deep(a) {
        text-decoration: underline;
        text-decoration-thickness: toRem(1);
        text-underline-offset: toRem(2);
    }

    :deep(u) {
        font-style: italic;
    }
    :deep(b), :deep(strong), :deep(em) {
        font-weight: 700;
    }
}
</style>
