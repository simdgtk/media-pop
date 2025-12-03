<template>
    <section class="news">
        <h2>Actualités</h2>
        <Carousel :bgIcon="true" />
        <Carousel :bgIcon="true" :date="new Date().toISOString().split('T')[0]" />
    </section>
</template>

<script lang="ts" setup>
import Carousel from '../Carousel.vue';

</script>

<style lang="scss" scoped>
.news {
    @extend %container;
    margin: 0 auto;
    padding: 0;
    margin-top: toRem(36);
    display: flex;
    flex-direction: column;
    gap: toRem(24);

    h2 {
        color: $white;
        margin-left: toRem(20);
        padding-right: toRem(20);
    }
}
</style>
