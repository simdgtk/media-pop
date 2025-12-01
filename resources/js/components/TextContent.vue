<template>
    <div class="text-content">
        <p>
            Norem ipsum dolor sit amet, consectetur adipiscing elit. Etiam eu turpis molestie, dictum est a, mattis
            tellus. Sed dignissim, metus nec fringilla accumsan, risus sem sollicitudin lacus, ut interdum tellus elit
            sed risus. Maecenas eget condimentum velit, sit amet feugiat lectus. Class aptent taciti sociosqu ad litora
            torquent per conubia nostra, per inceptos himenaeos. Praesent auctor purus luctus enim egestas, ac
            scelerisque ante pulvinar. Donec ut rhoncus ex. Suspendisse ac rhoncus nisl, eu tempor urna. Curabitur vel
            bibendum lorem. Morbi convallis convallis diam sit amet lacinia. Aliquam in elementum tellus.
        </p>
        <h3>Le titre de la seconde partie.......................</h3>
    </div>
</template>

<script lang="ts" setup>

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
