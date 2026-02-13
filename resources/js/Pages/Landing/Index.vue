<script setup>
import FooterNav from '@/Components/FooterNav.vue';
import HeaderBar from '@/Components/HeaderBar.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed, ref, onMounted } from 'vue';
import { quotes } from '@/quotes';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
});

const page = usePage();
const appName = computed(() => page.props.appName || 'Pinoypark');
const currentYear = new Date().getFullYear();

const randomOnlineUsers = ref([]);
const allOnlineUsers = ref([]);
const currentQuote = ref(quotes[Math.floor(Math.random() * quotes.length)]);

const fetchOnlineUsers = async () => {
    try {
        const response = await fetch(route('online.users'), {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            }
        });
        if (response.ok) {
            const data = await response.json();
            allOnlineUsers.value = data.online_users;
            // Shuffling or limiting for the "bubble" display
            randomOnlineUsers.value = [...data.online_users].sort(() => 0.5 - Math.random()).slice(0, 10);
        }
    } catch (error) {
        console.error('Error fetching online users:', error);
    }
};

onMounted(() => {
    fetchOnlineUsers();
    // Update quote every 10 seconds
    setInterval(() => {
        currentQuote.value = quotes[Math.floor(Math.random() * quotes.length)];
    }, 10000);

    // Refresh real online users every 30 seconds
    setInterval(fetchOnlineUsers, 30000);
});

</script>

<template>
    <div class="min-h-screen w-full flex flex-col bg-white dark:bg-gray-900 p-0 m-0">
        <Head title="Welcome" />
        <HeaderBar />

        <div v-if="!$page.props.auth.user" class="fixed top-[56px] left-1/2 -translate-x-1/2 w-full max-w-[600px] flex justify-center items-center bg-[#FFA000] border-b border-[#e0e0e0] z-[150] h-[56px] min-h-[56px]">
            <Link :href="route('login')" class="text-[#111] font-bold text-[18px] px-[18px] py-[12px] min-w-[44px] min-h-[44px] no-underline inline-flex items-center justify-center rounded-lg transition-colors duration-150 active:bg-[#f0f2f5]" :class="{ 'underline text-[#1877f2]': route().current('login') }">Login</Link>
            <span class="text-[#222] text-[20px] px-2 min-w-[24px] min-h-[44px] inline-flex items-center justify-center select-none">|</span>
            <Link :href="route('register')" class="text-[#111] font-bold text-[18px] px-[18px] py-[12px] min-w-[44px] min-h-[44px] no-underline inline-flex items-center justify-center rounded-lg transition-colors duration-150 active:bg-[#f0f2f5]" :class="{ 'underline text-[#1877f2]': route().current('register') }">Register</Link>
        </div>

        <div class="border-b border-gray-400 mb-0"></div>

        <div class="relative min-h-[400px] flex-1 flex flex-col items-center pt-[128px] pb-14 w-full box-border">
            <div class="text-lg font-bold text-gray-900 dark:text-gray-100 mt-2 mb-1 self-start ml-2">Online Now:</div>

            <div class="flex flex-row items-center mb-1 w-full pl-2 overflow-x-auto">
                <div v-for="user in randomOnlineUsers" :key="user.id" class="flex flex-col items-center mr-2 mb-1 shrink-0">
                    <img
                        :src="user.avatar ? (user.avatar.startsWith('http') ? user.avatar : user.avatar) : '/images/default-avatar.png'"
                        class="w-12 h-12 rounded-full border border-gray-400 bg-gray-100 object-cover"
                        alt="User Avatar"
                    />
                    <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ user && user.username ? user.username : 'Unknown User' }}</div>
                </div>
            </div>

            <div class="text-base text-gray-500 dark:text-gray-400 mb-2 self-start ml-2">
                All Members Online ({{ allOnlineUsers.length }})
            </div>

            <div class="bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-md p-4 mt-4 mb-8 w-[96%] self-center text-base text-gray-900 dark:text-gray-100 text-left shadow-sm italic">
                "{{ currentQuote }}"
            </div>
        </div>

        <footer class="py-10 text-center text-gray-500 border-t border-gray-200 dark:border-gray-700 mb-14 bg-gray-50 dark:bg-gray-900">
            &copy; {{ currentYear }} {{ appName }}. All rights reserved.
        </footer>
        <FooterNav />
    </div>
</template>
