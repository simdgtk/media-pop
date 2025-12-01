<template>
    <Transition name="fade">
        <div v-if="isOpen" class="popup" @click="handleBackdropClick">
            <div class="filters-container" @click.stop>
                <span>filtrer et trier</span>
            </div>
        </div>
    </Transition>
</template>

<script lang="ts" setup>
defineProps<{
    isOpen: boolean;
}>();

const emit = defineEmits<{
    close: [];
}>();

const handleBackdropClick = () => {
    emit('close');
};
</script>

<style scoped lang="scss">
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease;
}

.fade-enter-active .filters-container,
.fade-leave-active .filters-container {
    transition: transform 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}

.fade-enter-from .filters-container,
.fade-leave-to .filters-container {
    transform: translateY(100%);
}

.fade-enter-to,
.fade-leave-from {
    opacity: 1;
}

.fade-enter-to .filters-container,
.fade-leave-from .filters-container {
    transform: translateY(0);
}

.popup {
    width: 100vw;
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    background-color: #0004207d;
    z-index: 10;

    .filters-container {
        background-color: $white;
        border-radius: toRem(32) toRem(32) 0 0;
        color: $blue;
        padding: toRem(32) toRem(20);
        font-size: toRem(32);
        position: absolute;
        bottom: 0;
        width: 100%;
    }
}
</style>
