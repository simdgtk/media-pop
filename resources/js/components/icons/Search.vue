<template>
  <span v-html="svgContent" aria-hidden="true" />
</template>

<script lang="ts" setup>
import { computed, defineProps } from 'vue'

const search = `<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 256 256"><path d="M229.66,218.34l-50.07-50.06a88.11,88.11,0,1,0-11.31,11.31l50.06,50.07a8,8,0,0,0,11.32-11.32ZM40,112a72,72,0,1,1,72,72A72.08,72.08,0,0,1,40,112Z"></path></svg>`
const searchFill = `<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 256 256"><path d="M168,112a56,56,0,1,1-56-56A56,56,0,0,1,168,112Zm61.66,117.66a8,8,0,0,1-11.32,0l-50.06-50.07a88,88,0,1,1,11.32-11.31l50.06,50.06A8,8,0,0,1,229.66,229.66ZM112,184a72,72,0,1,0-72-72A72.08,72.08,0,0,0,112,184Z"></path></svg>`

const props = defineProps<{ fill?: boolean }>()
const svgContent = computed(() => props.fill ? searchFill : search)
</script>

<style>
</style>
