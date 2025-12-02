<template>
    <svg viewBox="0 0 342 313" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M342 0H0V313H342V0Z" fill="#FD494A" class="fond" />
        <!-- <path d="M88.5446 225.009H54.6387V253.899H88.5446V225.009Z" fill="#829" /> -->
        <path d="M129.46 247.86H209.96V276.07H129.46V247.86Z" fill="#B8FF93" class="traverse" />
        <path d="M212 242H318.58V282.21H212V242Z" fill="#FD494A" class="cache-traverse"
            :class="{ 'animate': isAnimating }" />
        <path class="letter-M" :class="{ 'animate': isAnimating }"
            d="M0.429688 2.62012H60.6197L86.7697 75.4101L112.73 2.62012H172.92V149.33H124.02V78.7901L99.3797 149.33H74.3597L49.3397 78.6101V149.33H0.43969V2.62012H0.429688Z"
            fill="#B8FF93" />
        <path class="letter-O" :class="{ 'animate': isAnimating }"
            d="M182.88 75.7899C182.88 30.2699 217.68 0.359863 260.94 0.359863C304.2 0.359863 339.56 30.2699 339.56 75.7899C339.56 121.31 302.88 151.59 260.94 151.59C219 151.59 182.88 123.56 182.88 75.7899ZM288.58 75.7899C288.58 59.0499 275.98 47.9499 261.12 47.9499C246.26 47.9499 233.85 59.0499 233.85 75.7899C233.85 92.5299 246.26 104.19 261.12 104.19C275.98 104.19 288.58 93.0899 288.58 75.7899Z"
            fill="#B8FF93" />
        <path class="letter-small-O"
            d="M127.58 203.28C127.58 180.71 144.7 163.4 169.53 163.4C194.36 163.4 211.85 180.7 211.85 203.28C211.85 225.86 195.11 242.22 169.53 242.22C146.21 242.22 127.58 226.8 127.58 203.28ZM179.68 202.9C179.68 197.07 174.79 192.74 169.52 192.74C164.63 192.74 159.74 197.07 159.74 202.9C159.74 208.73 164.63 213.06 169.52 213.06C174.79 213.06 179.68 208.55 179.68 202.9Z"
            fill="#B8FF93" />
        <path class="letter-bas-P2" d="M267.91 312.72V231.02H219V312.72H267.91Z" fill="#B8FF93" />
        <path class="letter-haut-P2" :class="{ 'animate': isAnimating }"
            d="M219 166H273.74C309.48 166 341.45 178.41 341.45 218.48C341.45 258.55 307.97 271.15 273.74 271.15H267.91H219V166.01V166ZM277.31 229.02C285.02 229.02 290.29 225.45 290.29 218.49C290.29 211.53 284.84 208.14 277.31 208.14H267.91V229.02H277.31Z"
            fill="#B8FF93" />
        <path class="letter-haut-P1"
            d="M1 166H55.74C91.48 166 123.45 178.41 123.45 218.48C123.45 258.55 89.97 271.15 55.74 271.15H49.91H1.01V166.01L1 166ZM59.31 229.02C67.02 229.02 72.29 225.45 72.29 218.49C72.29 211.53 66.84 208.14 59.31 208.14H49.91V229.02H59.31Z"
            fill="#B8FF93" />
        <path class="letter-bas-P1" :class="{ 'animate': isAnimating }"
            d="M49.9098 312.72V247.72H1.00977V312.72H49.9098Z" fill="#B8FF93" />
    </svg>


</template>

<script lang="ts" setup>
import { ref } from 'vue';

const isAnimating = ref(false);

const animate = () => {
    if (isAnimating.value) return;
    isAnimating.value = true;
    setTimeout(() => {
        isAnimating.value = false;
    }, 2000);
};

defineExpose({
    animate
});
</script>

<style lang="scss" scoped>
@use "../../../css/easings" as *;
.cache-traverse.animate {
    animation: cacheTraverseAnim 4.2s $ease-in-out-quart forwards;
}

@keyframes cacheTraverseAnim {
    0% {
        transform: translateX(0);
        opacity: 1;
    }
    40% {
        transform: translateX(-70%);
        opacity: 1;
    }
    80% {
        transform: translateX(-120%);
        opacity: 0;
    }
    100% {
        transform: translateX(0);
        opacity: 1;
    }
}
.letter-haut-P2.animate {
    animation: slideHautP2 2s $ease-in-out-quart forwards;
}
@keyframes slideHautP2 {
    0% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(14%);
    }
    100% {
        transform: translateY(0);
    }
}

.letter-M.animate {
    animation: slideM 2s $ease-in-out-quart forwards;
}

.letter-O.animate {
    animation: slideO 2s $ease-in-out-quart forwards;
}

.letter-bas-P1.animate {
    animation: slideBasP 2s $ease-in-out-quart forwards;
}

@keyframes slideM {
    0% {
        transform: translateX(0);
    }
    50% {
        transform: translateX(50%);
    }
    100% {
        transform: translateX(0);
    }
}

@keyframes slideO {
    0% {
        transform: translateX(0);
    }
    50% {
        transform: translateX(-52%);
    }
    100% {
        transform: translateX(0);
    }
}

@keyframes slideBasP {
    0% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-20%);
    }
    100% {
        transform: translateY(0);
    }
}
</style>
