<script setup>
import { Link } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import axios from 'axios';
import { toast } from '@/Stores/toast';

const props = defineProps({
    post: {
        type: Object,
        required: true,
    },
});

const localLikesCount = ref(props.post.likes_count || 0);
const isLiked = ref(props.post.liked_by_user || false);
const showComments = ref(false);
const comments = ref([]);
const newComment = ref('');
const loadingComments = ref(false);

const formattedDate = computed(() => {
    return new Date(props.post.created_at).toLocaleString();
});

const toggleLike = async () => {
    try {
        const response = await axios.post(route('posts.like', { post: props.post.id }));
        isLiked.value = response.data.liked;
        localLikesCount.value = response.data.likes_count;
    } catch (error) {
        console.error('Error toggling like:', error);
        toast.show('Failed to update like.', 'error');
    }
};

const fetchComments = async () => {
    if (comments.value.length > 0) return;
    loadingComments.value = true;
    try {
        const response = await axios.get(route('comments.index', { post: props.post.id }));
        comments.value = response.data;
    } catch (error) {
        console.error('Error fetching comments:', error);
        toast.show('Failed to load comments.', 'error');
    } finally {
        loadingComments.value = false;
    }
};

const toggleComments = () => {
    showComments.value = !showComments.value;
    if (showComments.value) {
        fetchComments();
    }
};

const submitComment = async () => {
    if (!newComment.value.trim()) return;
    try {
        const response = await axios.post(route('comments.store', { post: props.post.id }), {
            comment: newComment.value
        });
        comments.value.unshift(response.data);
        newComment.value = '';
        // In a real app we'd also increment a local comment count if we had one
    } catch (error) {
        console.error('Error submitting comment:', error);
        toast.show('Failed to post comment.', 'error');
    }
};

const handleShare = () => {
    const url = route('profile.show', { user: props.post.user.username }) + '#post-' + props.post.id;
    navigator.clipboard.writeText(url).then(() => {
        toast.show('Post link copied to clipboard!', 'success');
    }).catch(() => {
        toast.show('Failed to copy link.', 'error');
    });
};

</script>

<template>
    <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-sm mb-4" :id="'post-' + post.id">
        <!-- Post Header -->
        <div class="flex items-center mb-4">
            <Link :href="route('profile.show', { user: post.user.username })" class="shrink-0">
                <div class="w-10 h-10 rounded-full overflow-hidden border border-gray-200 dark:border-gray-700">
                    <img
                        :src="route('profile.image.show', { type: 'avatar', userId: post.user.id })"
                        class="w-full h-full object-cover"
                        alt="User Avatar"
                    />
                </div>
            </Link>
            <div class="ml-3">
                <Link :href="route('profile.show', { user: post.user.username })" class="font-bold text-gray-900 dark:text-gray-100 hover:underline">
                    {{ post.user.username }}
                </Link>
                <div class="text-xs text-gray-500 dark:text-gray-400">
                    {{ formattedDate }} • <i class="fas fa-globe"></i>
                </div>
            </div>
            <button class="ml-auto text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 p-2">
                <i class="fas fa-ellipsis-h"></i>
            </button>
        </div>

        <!-- Post Content -->
        <div class="text-gray-800 dark:text-gray-200 mb-4 whitespace-pre-wrap">
            {{ post.text }}
        </div>

        <!-- Post Image -->
        <div v-if="post.image" class="rounded-xl overflow-hidden mb-4 border border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900">
            <img
                :src="route('profile.image.show', { type: 'post', userId: post.user_id, fileName: post.image })"
                class="w-full h-auto max-h-[500px] object-contain mx-auto"
                alt="Post content"
            />
        </div>

        <!-- Post Stats -->
        <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400 border-b dark:border-gray-700 pb-3 mb-3">
            <div class="flex items-center">
                <span v-if="localLikesCount > 0" class="flex -space-x-1 mr-2">
                    <span class="w-5 h-5 bg-blue-500 rounded-full flex items-center justify-center text-[10px] text-white border border-white dark:border-gray-800">
                        <i class="fas fa-thumbs-up"></i>
                    </span>
                </span>
                <span>{{ localLikesCount }} {{ localLikesCount === 1 ? 'Like' : 'Likes' }}</span>
            </div>
            <div>{{ post.comments_count || 0 }} Comments • 0 Shares</div>
        </div>

        <!-- Post Actions -->
        <div class="flex items-center justify-around border-b dark:border-gray-700 pb-1 mb-1">
            <button
                @click="toggleLike"
                class="flex items-center justify-center flex-1 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors font-semibold"
                :class="isLiked ? 'text-blue-600' : 'text-gray-600 dark:text-gray-400'"
            >
                <i :class="isLiked ? 'fas fa-thumbs-up' : 'far fa-thumbs-up'" class="mr-2"></i> Like
            </button>
            <button
                @click="toggleComments"
                class="flex items-center justify-center flex-1 py-2 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors font-semibold"
            >
                <i class="far fa-comment mr-2"></i> Comment
            </button>
            <button
                @click="handleShare"
                class="flex items-center justify-center flex-1 py-2 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors font-semibold"
            >
                <i class="fas fa-share mr-2"></i> Share
            </button>
        </div>

        <!-- Comments Section -->
        <div v-if="showComments" class="mt-4 space-y-4">
            <!-- Comment Input -->
            <div class="flex items-start space-x-2">
                <div class="w-8 h-8 rounded-full overflow-hidden shrink-0">
                    <img :src="route('profile.image.show', { type: 'avatar', userId: $page.props.auth.user.id })" class="w-full h-full object-cover" />
                </div>
                <div class="flex-grow">
                    <textarea
                        v-model="newComment"
                        @keydown.enter.prevent="submitComment"
                        placeholder="Write a comment..."
                        class="w-full bg-gray-100 dark:bg-gray-700 border-none rounded-2xl px-4 py-2 text-sm focus:ring-1 focus:ring-blue-500 resize-none dark:text-gray-100"
                        rows="1"
                    ></textarea>
                </div>
            </div>

            <!-- Comments List -->
            <div v-if="loadingComments" class="text-center py-2">
                <i class="fas fa-spinner fa-spin text-gray-400"></i>
            </div>
            <div v-else class="space-y-3">
                <div v-for="comment in comments" :key="comment.id" class="flex items-start space-x-2">
                    <Link :href="route('profile.show', { user: comment.user.username })" class="shrink-0">
                        <div class="w-8 h-8 rounded-full overflow-hidden">
                            <img :src="route('profile.image.show', { type: 'avatar', userId: comment.user.id })" class="w-full h-full object-cover" />
                        </div>
                    </Link>
                    <div class="flex flex-col">
                        <div class="bg-gray-100 dark:bg-gray-700 rounded-2xl px-3 py-2">
                            <Link :href="route('profile.show', { user: comment.user.username })" class="font-bold text-xs hover:underline dark:text-gray-100">
                                {{ comment.user.username }}
                            </Link>
                            <p class="text-sm dark:text-gray-200">{{ comment.comment }}</p>
                        </div>
                        <div class="flex space-x-3 mt-1 ml-2 text-[10px] text-gray-500 font-bold">
                            <button class="hover:underline">Like</button>
                            <button class="hover:underline">Reply</button>
                            <span>{{ new Date(comment.created_at).toLocaleDateString() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
