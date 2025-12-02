<template>
  <span v-html="svgContent" aria-hidden="true" />
</template>

<script lang="ts" setup>
import { computed, defineProps } from 'vue'

const houseSimple = `<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 256 256"><path d="M219.31,108.68l-80-80a16,16,0,0,0-22.62,0l-80,80A15.87,15.87,0,0,0,32,120v96a8,8,0,0,0,8,8H216a8,8,0,0,0,8-8V120A15.87,15.87,0,0,0,219.31,108.68ZM208,208H48V120l80-80,80,80Z"></path></svg>`
const houseSimpleFill = `<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 256 256"><path d="M224,120v96a8,8,0,0,1-8,8H40a8,8,0,0,1-8-8V120a15.87,15.87,0,0,1,4.69-11.32l80-80a16,16,0,0,1,22.62,0l80,80A15.87,15.87,0,0,1,224,120Z"></path></svg>`

const props = defineProps<{ fill?: boolean }>()
const svgContent = computed(() => props.fill ? houseSimpleFill : houseSimple)
</script>

<style>
</style>
