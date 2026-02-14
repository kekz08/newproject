<script setup>
import { ref } from 'vue';
import { usePage } from '@inertiajs/vue3';
import axios from 'axios';
import { toast } from '@/Stores/toast';

const props = defineProps({
    show: Boolean,
});

const emit = defineEmits(['close', 'post-created']);

const { auth } = usePage().props;
const user = auth.user;

const postText = ref('');
const imagePreview = ref(null);
const fileInput = ref(null);
const audience = ref('public');
const uploading = ref(false);

const close = () => {
    postText.value = '';
    imagePreview.value = null;
    emit('close');
};

const triggerFileInput = () => {
    fileInput.value.click();
};

const onFileChange = (e) => {
    const file = e.target.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = (event) => {
        imagePreview.value = event.target.result;
    };
    reader.readAsDataURL(file);
};

const submitPost = async () => {
    if (!postText.value && !imagePreview.value) {
        toast.show('Please enter some text or select an image.', 'warning');
        return;
    }

    uploading.value = true;
    try {
        const response = await axios.post(route('posts.store'), {
            text: postText.value,
            image: imagePreview.value,
            audience: audience.value,
        });

        toast.show(response.data.message, 'success');
        emit('post-created', response.data.post);
        close();
    } catch (error) {
        console.error(error);
        toast.show('Failed to create post.', 'error');
    } finally {
        uploading.value = false;
    }
};
</script>

<template>
    <div v-if="show" class="fixed inset-0 z-[1000] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" @click.self="close">
        <div class="bg-white dark:bg-gray-800 w-full max-w-[500px] rounded-2xl shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-200">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-4 border-b dark:border-gray-700">
                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mx-auto">Create Post</h3>
                <button @click="close" class="absolute right-4 w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 dark:bg-gray-700 text-gray-500 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-4">
                <!-- User Info -->
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 rounded-full overflow-hidden border border-gray-200 dark:border-gray-700 mr-3">
                        <img
                            :src="route('profile.image.show', { type: 'avatar', userId: user.id })"
                            class="w-full h-full object-cover"
                            alt="User Avatar"
                        />
                    </div>
                    <div>
                        <div class="font-bold text-gray-900 dark:text-gray-100">{{ user.username }}</div>
                        <select v-model="audience" class="mt-1 bg-gray-100 dark:bg-gray-700 border-none rounded-md py-0.5 pl-2 pr-8 text-xs font-semibold text-gray-600 dark:text-gray-300 focus:ring-0 cursor-pointer">
                            <option value="public">🌎 Public</option>
                            <option value="friends">👥 Friends</option>
                            <option value="private">🔒 Private</option>
                        </select>
                    </div>
                </div>

                <!-- Text Input -->
                <textarea
                    v-model="postText"
                    class="w-full min-h-[120px] text-lg text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 border-none focus:ring-0 bg-transparent resize-none p-0"
                    :placeholder="`What's on your mind, ${user.username}?`"
                ></textarea>

                <!-- Image Preview -->
                <div v-if="imagePreview" class="relative mt-4 rounded-xl overflow-hidden border dark:border-gray-700 max-h-[300px]">
                    <img :src="imagePreview" class="w-full h-full object-cover" />
                    <button @click="imagePreview = null" class="absolute top-2 right-2 w-8 h-8 flex items-center justify-center rounded-full bg-black/50 text-white hover:bg-black/70 transition-colors">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <!-- Add to Post -->
                <div class="mt-4 flex items-center justify-between p-2 border dark:border-gray-700 rounded-xl">
                    <span class="font-semibold text-gray-600 dark:text-gray-300 ml-2">Add to your post</span>
                    <div class="flex space-x-1">
                        <button @click="triggerFileInput" class="w-9 h-9 flex items-center justify-center rounded-full text-green-500 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors" title="Photo/Video">
                            <i class="fas fa-images text-xl"></i>
                        </button>
                        <input type="file" ref="fileInput" class="hidden" accept="image/*" @change="onFileChange" />
                        <button class="w-9 h-9 flex items-center justify-center rounded-full text-blue-500 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors" title="Tag Friends">
                            <i class="fas fa-user-tag text-xl"></i>
                        </button>
                        <button class="w-9 h-9 flex items-center justify-center rounded-full text-yellow-500 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors" title="Feeling/Activity">
                            <i class="fas fa-smile text-xl"></i>
                        </button>
                        <button class="w-9 h-9 flex items-center justify-center rounded-full text-red-500 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors" title="Location">
                            <i class="fas fa-map-marker-alt text-xl"></i>
                        </button>
                    </div>
                </div>

                <!-- Submit Button -->
                <button
                    @click="submitPost"
                    :disabled="uploading || (!postText && !imagePreview)"
                    class="w-full mt-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    <i v-if="uploading" class="fas fa-spinner fa-spin mr-2"></i>
                    {{ uploading ? 'Posting...' : 'Post' }}
                </button>
            </div>
        </div>
    </div>
</template>
