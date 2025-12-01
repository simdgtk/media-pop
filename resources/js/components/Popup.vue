<template>
    <Transition name="fade">
        <div v-if="isOpen" class="popup" @click="handleBackdropClick">
            <div class="filters-container" @click.stop>
                <span class="title">filtrer et trier</span>
                <div class="filters">
                    <div class="filter filter-date-range">
                        <div class="filter-title-container">
                            <span class="filter-title">
                                période
                            </span>
                            <div role="presentation" aria-hidden="true" class="highlight"></div>
                        </div>
                        <div class="date">
                            <input type="date" ref="dateInputRef" v-model="selectedDate" class="hidden-input" />
                            <div class="date-input" @click="openDatePicker">
                                <span class="date-display">{{ formattedDate }}</span>
                                <Calendar />
                            </div>
                        </div>
                    </div>
                    <div class="filter filter-category"></div>
                </div>
                <button class="save-button">filtrer les 78 articles</button>
            </div>
        </div>
    </Transition>
</template>

<script lang="ts" setup>
import { ref, computed } from 'vue';
import Calendar from './icons/Calendar.vue';

defineProps<{
    isOpen: boolean;
}>();

const emit = defineEmits<{
    close: [];
}>();

const dateInputRef = ref<HTMLInputElement | null>(null);
const selectedDate = ref('2025-04-12');

const formattedDate = computed(() => {
    if (!selectedDate.value) return '12 avril 2025';

    const date = new Date(selectedDate.value);
    const options: Intl.DateTimeFormatOptions = { day: 'numeric', month: 'long', year: 'numeric' };
    return date.toLocaleDateString('fr-FR', options);
});

const handleBackdropClick = () => {
    emit('close');
};

const openDatePicker = () => {
    dateInputRef.value?.showPicker();
};
</script>

<style scoped lang="scss">
@use 'sass:color';

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
        display: flex;
        flex-direction: column;
        gap: toRem(48);

        .title {
            text-transform: lowercase;
            font-weight: 700;
            font-family: 'Instrument Sans', sans-serif;
            font-size: toRem(32);
            text-align: center;
            display: inline-block;
            width: 100%;
        }

        .save-button {
            padding: toRem(16) toRem(20);
            background-color: $blue;
            color: $white;
            border-radius: toRem(32);
            font-size: toRem(16);
            font-weight: 500;
            font-family: 'Instrument Sans', sans-serif;
            line-height: 100%;
            width: 100%;
            text-align: center;
            will-change: transform;
            transition: transform 0.1s ease-in-out, background-color 0.1s ease-in-out;

            &:hover {
                background-color: color.adjust($blue, $lightness: -5%);
                transform: scale(0.99);

            }

            &:active {
                background-color: color.adjust($blue, $lightness: -10%);
                transform: scale(0.96);
            }
        }

        .filters {
            .filter {
                .filter-title-container {
                    position: relative;
                    width: fit-content;
                    display: flex;
                    margin-bottom: toRem(16);

                    .filter-title {
                        font-size: toRem(20);
                        font-weight: 600;
                        text-transform: lowercase;
                        display: inline-block;
                        position: relative;
                        z-index: 1;
                        line-height: 95%;
                    }

                    .highlight {
                        content: '';
                        position: absolute;
                        bottom: 0;
                        left: 0;
                        width:  calc(100% + toRem(4));
                        height: 100%;
                        background-color: $lime;
                        border-radius: toRem(2);
                        z-index: 0;

                        transform: translate(toRem(-2), 0);
                    }
                }

                .date {
                    position: relative;

                    .hidden-input {
                        position: absolute;
                        opacity: 0;
                        pointer-events: none;
                        width: 0;
                        height: 0;
                    }

                    .date-input {
                        display: flex;
                        align-items: center;
                        justify-content: space-between;
                        background-color: $blue;
                        color: $white;
                        padding: toRem(16) toRem(20);
                        border-radius: toRem(999);
                        font-size: toRem(16);
                        font-weight: 500;
                        cursor: pointer;
                        transition: background-color 0.2s ease-in-out;

                        &:hover {
                            background-color: color.adjust($blue, $lightness: -5%);
                        }

                        .date-display {
                            font-family: 'Instrument Sans', sans-serif;
                        }

                        svg {
                            width: toRem(24);
                            height: toRem(24);
                            flex-shrink: 0;
                        }
                    }
                }
            }
        }
    }

}
</style>
