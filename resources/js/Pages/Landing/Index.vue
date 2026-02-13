<script setup>
import FooterNav from '@/Components/FooterNav.vue';
import HeaderBar from '@/Components/HeaderBar.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed, ref, onMounted } from 'vue';
import { quotes } from '@/quotes';
import '@/../css/top-nav-bar.css';
import '@/../css/landing.css';

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
    <div class="landing-root">
        <Head title="Welcome" />
        <HeaderBar class="header-bar" />

        <div v-if="!$page.props.auth.user" class="top-nav-bar">
            <Link :href="route('login')" class="top-nav-link" :class="{ 'top-nav-link-active': route().current('login') }">Login</Link>
            <span class="top-nav-divider">|</span>
            <Link :href="route('register')" class="top-nav-link" :class="{ 'top-nav-link-active': route().current('register') }">Register</Link>
        </div>

        <div class="hr"></div>

        <div class="main-content">
            <div class="online-now">Online Now:</div>

            <div class="users-row">
                <div v-for="user in randomOnlineUsers" :key="user.id" class="user-bubble">
                    <img
                        :src="user.avatar ? (user.avatar.startsWith('http') ? user.avatar : user.avatar) : '/images/default-avatar.png'"
                        class="user-img"
                        alt="User Avatar"
                    />
                    <div class="user-name">{{ user && user.username ? user.username : 'Unknown User' }}</div>
                </div>
            </div>

            <div class="members-online">
                All Members Online ({{ allOnlineUsers.length }})
            </div>


            <div class="quote-box card">
                "{{ currentQuote }}"
            </div>
        </div>

        <footer class="py-10 text-center text-gray-500 border-t border-gray-200 dark:border-gray-700 mb-14 bg-gray-50 dark:bg-gray-900">
            &copy; {{ currentYear }} {{ appName }}. All rights reserved.
        </footer>
        <FooterNav />
    </div>
</template>
