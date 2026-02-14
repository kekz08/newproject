<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, usePage, router } from '@inertiajs/vue3';
import { ref, computed, onMounted } from 'vue';
import { toast } from '@/Stores/toast';
import axios from 'axios';
import PostCard from '@/Components/PostCard.vue';
import CreatePostModal from '@/Components/CreatePostModal.vue';

const { auth } = usePage().props;
const user = auth.user;

const posts = ref([]);
const stories = ref([]);
const loading = ref(true);
const showCreateModal = ref(false);

const goToMyProfile = () => {
    if (user && user.username) {
        router.get(route('profile.show', { user: user.username }));
    }
};

const triggerCreatePost = () => {
    showCreateModal.value = true;
};

const fetchPosts = async () => {
    loading.value = true;
    try {
        const response = await axios.get(route('posts.index'));
        posts.value = response.data.data;
    } catch (error) {
        console.error('Error fetching posts:', error);
        toast.show('Failed to load posts.', 'error');
    } finally {
        loading.value = false;
    }
};

const handlePostCreated = (newPost) => {
    posts.value.unshift(newPost);
};

onMounted(() => {
    fetchPosts();
});
</script>

<template>
    <Head title="Home" />

    <AuthenticatedLayout>
        <div class="max-w-[600px] mx-auto px-2">
            <!-- Status Input -->
            <div class="flex items-center bg-white dark:bg-gray-800 p-3 rounded-2xl shadow-sm mb-3 w-full box-border">
                <div class="w-11 h-11 rounded-full mr-3 cursor-pointer flex items-center justify-center shrink-0 overflow-hidden border border-gray-200 dark:border-gray-700" @click="goToMyProfile">
                    <img
                        v-if="user && user.id"
                        :src="route('profile.image.show', { type: 'avatar', userId: user.id }) + '?t=' + Date.now()"
                        class="w-full h-full object-cover"
                        alt="User Avatar"
                    />
                    <i v-else class="fas fa-user text-gray-500 text-xl"></i>
                </div>
                <div class="flex-grow" @click="triggerCreatePost">
                    <input
                        class="w-full h-11 rounded-full border-none px-4 bg-gray-100 dark:bg-gray-700 cursor-pointer text-base text-gray-900 dark:text-gray-100 outline-none hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors"
                        :placeholder="user && user.username ? `What's on your mind, ${user.username}?` : 'What\'s on your mind?'"
                        readonly
                    />
                </div>
                <button class="bg-none border-none text-2xl text-gray-500 dark:text-gray-400 cursor-pointer ml-3 min-w-[44px] min-h-[44px] flex items-center justify-center hover:text-indigo-600 transition-colors" @click="triggerCreatePost">
                    <i class="fas fa-camera"></i>
                </button>
            </div>

            <!-- Stories Placeholder -->
            <div class="bg-white dark:bg-gray-800 rounded-xl p-4 mb-3 shadow-sm text-center">
                <p class="text-gray-500 dark:text-gray-400 italic">Stories Feed coming soon...</p>
            </div>

            <!-- Divider -->
            <div class="h-[10px] bg-gray-200 dark:bg-gray-700 -mx-2 mb-3 w-[calc(100%+16px)]"></div>

            <!-- Posts Section -->
            <div v-if="loading && posts.length === 0" class="space-y-4">
                <div v-for="i in 3" :key="i" class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-sm animate-pulse">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-gray-200 dark:bg-gray-700 rounded-full mr-3"></div>
                        <div class="space-y-2">
                            <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded w-32"></div>
                            <div class="h-3 bg-gray-200 dark:bg-gray-700 rounded w-20"></div>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded w-full"></div>
                        <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded w-5/6"></div>
                    </div>
                </div>
            </div>

            <div v-else-if="posts.length > 0" class="space-y-4">
                <PostCard v-for="post in posts" :key="post.id" :post="post" />
            </div>

            <div v-else class="text-center py-8 text-gray-500 dark:text-gray-400">
                <i class="fas fa-newspaper text-4xl mb-2"></i>
                <p>No posts to show right now.</p>
            </div>
        </div>

        <CreatePostModal
            :show="showCreateModal"
            @close="showCreateModal = false"
            @post-created="handlePostCreated"
        />
    </AuthenticatedLayout>
</template>
