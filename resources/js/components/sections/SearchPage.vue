<template>
    <section class="search-page">
        <h2>recherche</h2>
        <div class="search-container">
            <input type="text" v-model="searchQuery" placeholder="Recherche" class="search-input" />
            <Search class="search-icon" />
        </div>
    </section>
</template>

<script lang="ts" setup>
import Search from '../icons/Search.vue';
</script>

<style lang="scss" scoped>
.search-page {
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

    .search-container {
        position: relative;
        display: flex;
        flex-direction: row-reverse;
        align-items: center;
        max-width: toRem(350);
        margin-left: toRem(20);
        margin-right: toRem(20);

        .search-icon {
            position: absolute;
            right: toRem(16);
            width: toRem(24);
            height: toRem(24);
            color: $light-blue;
            pointer-events: none;
            transition: color 0.15s ease;
        }

        .search-input {
            width: 100%;
            padding: toRem(12) toRem(52) toRem(12) toRem(16);
            font-size: toRem(16);
            border: toRem(1) solid $white;
            border-radius: 9999px;
            background-color: transparent;
            outline: none;
            transition: border-color 0.2s ease;
            background-color: $white;

            &::placeholder {
                color: $light-blue;
            }

            &:focus {
                border-color: $light-blue;

                &~.search-icon {
                    color: $blue;
                }
            }
        }

        &:focus-within {
            .search-icon {
                color: $black;
            }
        }
    }
}
</style>
