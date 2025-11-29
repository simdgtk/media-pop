<template>
    <section class="categories">
        <h2>Catégories</h2>
        <div class="filters">
            
        </div>
        <Carousel />
    </section>
</template>

<script lang="ts" setup>
import Carousel from '../Carousel.vue';

</script>

<style lang="scss" scoped>
.categories {
    @extend %container;
    margin: 0 auto;
    padding: 0;
    padding-top: toRem(54);
    display: flex;
    flex-direction: column;
    gap: toRem(24);
    background-color: $blue;
    color: $white;

    h2 {
        color: $white;
        margin-left: toRem(20);
        padding-right: toRem(20);
    }
}
</style>
