<template>
    <Transition name="fade">
        <div v-if="isOpen" class="popup" @click="handleBackdropClick">
            <div class="image-container">
                <div class="filters-container" @click.stop @touchstart="handleTouchStart" @touchmove="handleTouchMove"
                    @touchend="handleTouchEnd" :style="containerStyle">
                    <Pop class="pop-bg" />
                    <div class="drag-handle"></div>
                    <span class="title">filtrer</span>
                    <div class="filters">
                        <div class="filter filter-date-range">
                            <div class="filter-title-container">
                                <span class="filter-title">
                                    période
                                </span>
                                <div role="presentation" aria-hidden="true" class="highlight"></div>
                            </div>
                            <div class="date-flex">
                                <span>du</span>
                                <div class="date">
                                    <input type="date" ref="dateInputRefFrom" v-model="selectedDateFrom"
                                        class="hidden-input" />
                                    <div class="date-input" @click="openDatePickerFrom">
                                        <span class="date-display">{{ formattedDateFrom }}</span>
                                        <Calendar />
                                    </div>
                                </div>
                                <span>au</span>
                                <div class="date">
                                    <input type="date" ref="dateInputRefTo" v-model="selectedDateTo"
                                        class="hidden-input" />
                                    <div class="date-input" @click="openDatePickerTo">
                                        <span class="date-display">{{ formattedDateTo }}</span>
                                        <Calendar />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="filter filter-category">
                            <div class="filter-title-container">
                                <span class="filter-title">
                                    catégories
                                </span>
                                <div role="presentation" aria-hidden="true" class="highlight"></div>
                            </div>
                            <div class="list-select">
                                <div class="select-item selected">cinéma</div>
                                <div class="select-item">culture</div>
                                <div class="select-item">musique</div>
                                <div class="select-item selected">sport</div>
                                <div class="select-item">jeux vidéo</div>
                                <div class="select-item">livres</div>
                                <div class="select-item selected">festival</div>
                            </div>
                        </div>
                    </div>
                    <button class="save-button">filtrer les 78 articles</button>
                </div>
                <!-- <Pop class="pop" /> -->
            </div>

        </div>
    </Transition>
</template>

<script lang="ts" setup>
import { ref, computed, watch, type CSSProperties } from 'vue';
import Calendar from './icons/Calendar.vue';
import Pop from './icons/Pop.vue';

const props = defineProps<{
    isOpen: boolean;
}>();

const emit = defineEmits<{
    close: [];
}>();

const startY = ref(0);
const currentY = ref(0);
const isDragging = ref(false);
const translateY = ref(0);

const handleTouchStart = (e: TouchEvent) => {
    startY.value = e.touches[0].clientY;
    isDragging.value = true;
};

const handleTouchMove = (e: TouchEvent) => {
    if (!isDragging.value) return;

    currentY.value = e.touches[0].clientY;
    const delta = currentY.value - startY.value;

    if (delta > 0) {
        translateY.value = delta;
    }
};

const handleTouchEnd = () => {
    isDragging.value = false;

    if (translateY.value > 100) {
        emit('close');
    }
    translateY.value = 0;
};

const containerStyle = computed<CSSProperties>(() => {
    if (isDragging.value && translateY.value > 0) {
        return {
            transform: `translateY(${translateY.value}px)`,
            transition: 'none'
        };
    }

    return {
        transform: undefined,
        transition: 'transform 0.3s ease'
    };
});

watch(() => props.isOpen, (isOpen) => {
    if (isOpen) {
        document.body.style.overflow = 'hidden';
    } else {
        document.body.style.overflow = '';
    }
});

const dateInputRefFrom = ref<HTMLInputElement | null>(null);
const dateInputRefTo = ref<HTMLInputElement | null>(null);
const selectedDateFrom = ref(new Date().toISOString().split('T')[0]);
const selectedDateTo = ref(new Date().toISOString().split('T')[0]);

const formattedDateFrom = computed(() => {
    if (!selectedDateFrom.value) return '1 déc. 2025';

    const date = new Date(selectedDateFrom.value);
    const options: Intl.DateTimeFormatOptions = { day: 'numeric', month: 'short', year: 'numeric' };
    return date.toLocaleDateString('fr-FR', options);
});

const formattedDateTo = computed(() => {
    if (!selectedDateTo.value) return '1 déc. 2025';

    const date = new Date(selectedDateTo.value);
    const options: Intl.DateTimeFormatOptions = { day: 'numeric', month: 'short', year: 'numeric' };
    return date.toLocaleDateString('fr-FR', options);
});

const handleBackdropClick = () => {
    emit('close');
};

const openDatePickerFrom = () => {
    dateInputRefFrom.value?.showPicker();
};

const openDatePickerTo = () => {
    dateInputRefTo.value?.showPicker();
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
    overflow: hidden;

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
        touch-action: none;
        overflow: hidden;

        .pop-bg {
            position: absolute;
            width: 100%;
            z-index: 0;
            bottom: 0;
            right: 0;
            pointer-events: none;
            transform: translateX(5%);
            color: rgba($blue, 0.05);
        }

        > :not(.pop-bg) {
            position: relative;
            z-index: 1;
        }

        .drag-handle {
            width: toRem(48);
            height: toRem(4);
            background-color: rgba($blue, 0.2);
            border-radius: toRem(2);
            position: absolute;
            top: toRem(12);
            left: 50%;
            transform: translateX(-50%);
        }

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
            display: flex;
            flex-direction: column;
            gap: toRem(28);

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
                        display: block;
                        content: '';
                        position: absolute;
                        bottom: 0;
                        left: 0;
                        width: calc(100% + toRem(4));
                        height: 100%;
                        background-color: $lime;
                        z-index: -1;
                        transform: translate(toRem(-2), 0);
                    }
                }

                .date-flex {
                    display: flex;
                    align-items: center;
                    gap: toRem(8);
                    flex-wrap: wrap;
                    font-size: toRem(14);

                    .date {
                        position: relative;
                        width: fit-content;

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
                            gap: toRem(8);
                            flex-wrap: wrap;
                            background-color: $blue;
                            color: $white;
                            padding: toRem(10) toRem(12);
                            line-height: 100%;
                            border-radius: toRem(999);
                            font-size: toRem(14);
                            font-weight: 500;
                            cursor: pointer;
                            transition: background-color 0.2s ease-in-out;
                            width: fit-content;

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

                .list-select {
                    display: flex;
                    gap: toRem(8);
                    flex-wrap: wrap;

                    .select-item {
                        line-height: 100%;
                        padding: toRem(8) toRem(12);
                        border-radius: toRem(999);
                        background-color: $white;
                        color: $blue;
                        border: toRem(1) solid $blue;
                        font-size: toRem(14);
                        transition: background-color 0.1s ease-in-out, color 0.1s ease-in-out, transform 0.1s ease-in-out;

                        &.selected {
                            background-color: $blue;
                            color: $white;
                            border: toRem(1) solid $blue;
                        }

                        &:hover {
                            transform: scale(0.99);
                        }

                        &:active {
                            transform: scale(0.96);
                        }
                    }
                }
            }
        }
    }

}
</style>
