<script setup>
import { toast } from '@/Stores/toast';
import { computed } from 'vue';

const typeClass = computed(() => {
    switch (toast.type) {
        case 'error':
            return 'bg-red-500 text-white';
        case 'warning':
            return 'bg-yellow-500 text-white';
        case 'info':
            return 'bg-blue-500 text-white';
        case 'success':
        default:
            return 'bg-green-500 text-white';
    }
});

const iconClass = computed(() => {
    switch (toast.type) {
        case 'error':
            return 'fas fa-exclamation-circle';
        case 'warning':
            return 'fas fa-exclamation-triangle';
        case 'info':
            return 'fas fa-info-circle';
        case 'success':
        default:
            return 'fas fa-check-circle';
    }
});
</script>

<template>
    <Transition
        enter-active-class="transform ease-out duration-300 transition"
        enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
        enter-to-class="translate-y-0 opacity-100 sm:translate-x-0"
        leave-active-class="transition ease-in duration-100"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
    >
        <div v-if="toast.visible" class="fixed bottom-5 right-5 z-[1000] max-w-sm w-full">
            <div :class="['rounded-lg shadow-lg p-4 flex items-center gap-3', typeClass]">
                <i :class="[iconClass, 'text-xl']"></i>
                <div class="flex-1 font-medium">
                    {{ toast.message }}
                </div>
                <button @click="toast.hide()" class="hover:bg-black/10 rounded-full p-1 transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </Transition>
</template>
