<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed, onMounted, onUnmounted } from 'vue';

const props = defineProps({
    visible: {
        type: Boolean,
        default: false
    },
    unreadCount: {
        type: Number,
        default: 0
    },
    activeEventsCount: {
        type: Number,
        default: 0
    }
});

const emit = defineEmits(['close', 'menu-select']);

const page = usePage();
const user = computed(() => page.props.auth.user);

// Placeholder logic for roles
const isAdminOrOwner = computed(() => user.value?.role === 'admin' || user.value?.role === 'owner');
const isVip = computed(() => user.value?.is_vip);

const close = () => {
    emit('close');
};

const handleLogout = () => {
    emit('menu-select', 'Logout');
};

// Handle escape key to close
const handleKeydown = (e) => {
    if (e.key === 'Escape' && props.visible) {
        close();
    }
};

onMounted(() => window.addEventListener('keydown', handleKeydown));
onUnmounted(() => window.removeEventListener('keydown', handleKeydown));

</script>

<template>
    <Transition
        enter-active-class="transition ease-out duration-250"
        enter-from-class="opacity-0"
        enter-to-class="opacity-100"
        leave-active-class="transition ease-in duration-200"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
    >
        <div v-if="visible" class="fixed inset-y-0 left-1/2 -translate-x-1/2 w-full max-w-[600px] bg-black/55 backdrop-blur-sm z-[1000] flex justify-start items-start" @click="close">
            <Transition
                enter-active-class="transition ease-out duration-250 transform"
                enter-from-class="-translate-x-full"
                enter-to-class="translate-x-0"
                leave-active-class="transition ease-in duration-200 transform"
                leave-from-class="translate-x-0"
                leave-to-class="-translate-x-full"
            >
                <div
                    v-if="visible"
                    class="drawer-menu w-full max-w-[360px] h-[calc(100vh-112px)] bg-white shadow-2xl flex flex-col relative top-[112px] overflow-y-auto rounded-r-2xl max-sm:max-w-full max-sm:rounded-none"
                    @click.stop
                >
                    <nav class="flex-1 p-0 flex flex-col items-center">
                        <Link :href="route('shop')" class="flex items-center w-full px-6 max-[480px]:px-4 bg-transparent border-none cursor-pointer transition-colors duration-150 text-left min-h-[56px] border-b border-[#f2f2f2] active:bg-[#f3f4f6] tap-highlight-transparent" @click="close">
                            <i class="fas fa-store w-8 text-center mr-4 text-2xl text-[#4caf50]"></i>
                            <span class="text-lg font-bold text-gray-900">Shop</span>
                        </Link>

                        <Link :href="route('chatrooms')" class="flex items-center w-full px-6 max-[480px]:px-4 bg-transparent border-none cursor-pointer transition-colors duration-150 text-left min-h-[56px] border-b border-[#f2f2f2] active:bg-[#f3f4f6] tap-highlight-transparent" @click="close">
                            <i class="fas fa-comments w-8 text-center mr-4 text-2xl text-[#2196f3]"></i>
                            <span class="text-lg font-bold text-gray-900">Chatrooms</span>
                        </Link>

                        <Link :href="route('forum')" class="flex items-center w-full px-6 max-[480px]:px-4 bg-transparent border-none cursor-pointer transition-colors duration-150 text-left min-h-[56px] border-b border-[#f2f2f2] active:bg-[#f3f4f6] tap-highlight-transparent" @click="close">
                            <i class="fas fa-comments-dollar w-8 text-center mr-4 text-2xl text-[#ff9800]"></i>
                            <span class="text-lg font-bold text-gray-900">Forum</span>
                        </Link>

                        <Link :href="route('friends')" class="flex items-center w-full px-6 max-[480px]:px-4 bg-transparent border-none cursor-pointer transition-colors duration-150 text-left min-h-[56px] border-b border-[#f2f2f2] active:bg-[#f3f4f6] tap-highlight-transparent" @click="close">
                            <i class="fas fa-users w-8 text-center mr-4 text-2xl text-[#673ab7]"></i>
                            <span class="text-lg font-bold text-gray-900">Friends</span>
                        </Link>

                        <Link :href="route('statistics')" class="flex items-center w-full px-6 max-[480px]:px-4 bg-transparent border-none cursor-pointer transition-colors duration-150 text-left min-h-[56px] border-b border-[#f2f2f2] active:bg-[#f3f4f6] tap-highlight-transparent" @click="close">
                            <i class="fas fa-chart-bar w-8 text-center mr-4 text-2xl text-[#009688]"></i>
                            <span class="text-lg font-bold text-gray-900">Statistics</span>
                        </Link>

                        <Link :href="route('petwars')" class="flex items-center w-full px-6 max-[480px]:px-4 bg-transparent border-none cursor-pointer transition-colors duration-150 text-left min-h-[56px] border-b border-[#f2f2f2] active:bg-[#f3f4f6] tap-highlight-transparent" @click="close">
                            <i class="fas fa-dragon w-8 text-center mr-4 text-2xl text-[#8B4513]"></i>
                            <span class="text-lg font-bold text-gray-900">Pet Wars</span>
                        </Link>

                        <Link :href="route('settings')" class="flex items-center w-full px-6 max-[480px]:px-4 bg-transparent border-none cursor-pointer transition-colors duration-150 text-left min-h-[56px] border-b border-[#f2f2f2] active:bg-[#f3f4f6] tap-highlight-transparent" @click="close">
                            <i class="fas fa-cog w-8 text-center mr-4 text-2xl text-[#607d8b]"></i>
                            <span class="text-lg font-bold text-gray-900">Settings</span>
                        </Link>

                        <Link v-if="isAdminOrOwner" :href="route('staff.panel')" class="flex items-center w-full px-6 max-[480px]:px-4 bg-transparent border-none cursor-pointer transition-colors duration-150 text-left min-h-[56px] border-b border-[#f2f2f2] active:bg-[#f3f4f6] tap-highlight-transparent" @click="close">
                            <i class="fas fa-tools w-8 text-center mr-4 text-2xl text-gray-700"></i>
                            <span class="text-lg font-bold text-gray-900">Staff Panel</span>
                        </Link>

                        <Link :href="route('online.users')" class="flex items-center w-full px-6 max-[480px]:px-4 bg-transparent border-none cursor-pointer transition-colors duration-150 text-left min-h-[56px] border-b border-[#f2f2f2] active:bg-[#f3f4f6] tap-highlight-transparent" @click="close">
                            <i class="fas fa-user-friends w-8 text-center mr-4 text-2xl text-[#e91e63]"></i>
                            <span class="text-lg font-bold text-gray-900">Online Users</span>
                        </Link>

                        <Link v-if="isVip" :href="route('vip.panel')" class="flex items-center w-full px-6 max-[480px]:px-4 bg-transparent border-none cursor-pointer transition-colors duration-150 text-left min-h-[56px] border-b border-[#f2f2f2] active:bg-[#f3f4f6] tap-highlight-transparent" @click="close">
                            <i class="fas fa-crown w-8 text-center mr-4 text-2xl text-[#FFD700]"></i>
                            <span class="text-lg font-bold text-gray-900">VIP Panel</span>
                        </Link>

                        <button class="flex items-center w-full px-6 max-[480px]:px-4 bg-transparent border-none cursor-pointer transition-colors duration-150 text-left min-h-[56px] active:bg-[#f3f4f6] tap-highlight-transparent border-t-2 border-gray-100 mt-auto bg-gray-50/50" @click="handleLogout">
                            <i class="fas fa-sign-out-alt w-8 text-center mr-4 text-2xl text-gray-900"></i>
                            <span class="text-xl font-black text-gray-900">Logout</span>
                        </button>
                    </nav>
                </div>
            </Transition>
        </div>
    </Transition>
</template>

