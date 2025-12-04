<template>
    <div class="text-content" ref="contentRef" v-html="props.content"></div>
</template>

<script lang="ts" setup>
import { ref, onMounted, onUnmounted } from 'vue';
import SplitType from 'split-type';

const props = defineProps<{
    content?: string
}>();

const contentRef = ref<HTMLElement | null>(null);
let splitInstances: SplitType[] = [];

const handleResize = () => {
    splitInstances.forEach(instance => instance.split());
};

onMounted(() => {
    if (contentRef.value) {
        const headers = contentRef.value.querySelectorAll('h3');
        headers.forEach(header => {
            const split = new SplitType(header as HTMLElement, {
                types: 'lines',
                tagName: 'span'
            });
            splitInstances.push(split);
        });
        
        if (splitInstances.length > 0) {
            window.addEventListener('resize', handleResize);
        }
    }
});

onUnmounted(() => {
    window.removeEventListener('resize', handleResize);
    splitInstances.forEach(instance => instance.revert());
});
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

        :deep(.line) {
            background-color: $lime;
            padding: toRem(2) toRem(4);
            display: inline-block;
            width: fit-content;
        }
    }
}
</style>
