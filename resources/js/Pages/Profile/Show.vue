<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import axios from 'axios';
import { toast } from '@/Stores/toast';

const props = defineProps({
    user: {
        type: Object,
        required: true,
    },
});

const authUser = usePage().props.auth.user;
const isOwnProfile = authUser.id === props.user.id;

// Tabs Logic
const tabs = ['Timeline', 'About', 'Photo', 'Forum'];
const activeTab = ref('About');

// Image Upload Logic
const coverInput = ref(null);
const avatarInput = ref(null);
const uploading = ref(false);

const triggerFileInput = (type) => {
    if (type === 'cover') {
        coverInput.value.click();
    } else {
        avatarInput.value.click();
    }
};

const onImagePick = (event, type) => {
    const file = event.target.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = (e) => {
        uploadImage(e.target.result, type);
    };
    reader.readAsDataURL(file);
};

const uploadImage = (base64, type) => {
    uploading.value = true;
    axios.post(route('profile.image.store', { type: type }), {
        image: base64
    }).then(response => {
        window.location.reload();
    }).catch(error => {
        console.error(error);
        if (error.response && error.response.data && error.response.data.errors) {
            console.log('Validation errors:', error.response.data.errors);
            toast.show('Failed to upload ' + type + ': ' + JSON.stringify(error.response.data.errors), 'error');
        } else if (error.response && error.response.data && error.response.data.message) {
            toast.show('Failed to upload ' + type + ': ' + error.response.data.message, 'error');
        } else {
            toast.show('Failed to upload ' + type, 'error');
        }
    }).finally(() => {
        uploading.value = false;
    });
};

const getImageUrl = (type, userId) => {
    return route('profile.image.show', { type, userId }) + '?t=' + Date.now();
};
</script>

<template>
    <Head :title="`${user.username}'s Profile`" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ user.username }}'s Profile
                </h2>
                <Link
                    v-if="isOwnProfile"
                    :href="route('profile.edit', { user: user.username })"
                    class="bg-indigo-600 text-white px-4 py-2 rounded-md font-semibold hover:bg-indigo-700 transition"
                >
                    Edit Profile
                </Link>
            </div>
        </template>

        <div class="py-6">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <!-- Cover Photo Container -->
                <div class="relative bg-gray-200 dark:bg-gray-700 h-48 md:h-64 rounded-t-lg group">
                    <img
                        :src="getImageUrl('cover', user.id)"
                        class="w-full h-full object-cover rounded-t-lg"
                        alt="Cover Photo"
                    />

                    <!-- Cover Upload Button (Own Profile) -->
                    <div v-if="isOwnProfile"
                         @click="triggerFileInput('cover')"
                         class="absolute bottom-4 right-4 bg-black/50 hover:bg-black/70 text-white p-2 rounded-full cursor-pointer transition-colors z-10">
                        <i class="fas fa-camera"></i>
                        <input type="file" ref="coverInput" class="hidden" accept="image/*" @change="onImagePick($event, 'cover')" />
                    </div>

                    <div v-if="uploading" class="absolute inset-0 bg-black/30 flex items-center justify-center text-white font-bold z-20">
                        Uploading...
                    </div>
                </div>

                <!-- Profile Info Block -->
                <div class="bg-white dark:bg-gray-800 pt-24 md:pt-24 pb-6 px-8 md:px-12 rounded-b-lg shadow-sm relative">
                    <!-- Profile Picture (Positioned relative to Info Block) -->
                    <div class="absolute -top-16 md:-top-20 left-1/2 -translate-x-1/2 md:left-12 md:translate-x-0">
                        <div class="relative group">
                            <img
                                :src="getImageUrl('avatar', user.id)"
                                class="h-32 w-32 md:h-40 md:w-40 rounded-full border-4 border-white dark:border-gray-800 object-cover shadow-lg bg-white"
                                alt="Avatar"
                            />
                            <!-- Avatar Upload Button (Own Profile) -->
                            <div v-if="isOwnProfile"
                                 @click="triggerFileInput('avatar')"
                                 class="absolute bottom-2 right-2 bg-gray-100 dark:bg-gray-700 p-2 rounded-full cursor-pointer shadow-md hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                                <i class="fas fa-camera text-gray-700 dark:text-gray-200"></i>
                                <input type="file" ref="avatarInput" class="hidden" accept="image/*" @change="onImagePick($event, 'avatar')" />
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 text-center md:text-left">
                        <div>
                            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white">{{ user.username }}</h1>
                            <p class="text-gray-600 dark:text-gray-400">@{{ user.username }}</p>
                        </div>
                        <div class="flex justify-center md:justify-end gap-2">
                            <button v-if="!isOwnProfile" class="bg-indigo-600 text-white px-4 py-2 rounded-md font-semibold hover:bg-indigo-700 transition flex items-center gap-2">
                                <i class="fas fa-user-plus"></i> Add Friend
                            </button>
                            <button v-if="!isOwnProfile" class="bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-white px-4 py-2 rounded-md font-semibold hover:bg-gray-300 dark:hover:bg-gray-600 transition flex items-center gap-2">
                                <i class="fab fa-facebook-messenger"></i> Message
                            </button>
                            <button class="bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-white px-3 py-2 rounded-md font-semibold hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                                <i class="fas fa-ellipsis-h"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Tabs Row -->
                <div class="mt-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm flex overflow-x-auto no-scrollbar border-b dark:border-gray-700">
                    <button
                        v-for="tab in tabs"
                        :key="tab"
                        @click="activeTab = tab"
                        class="px-6 py-4 font-medium text-sm transition-colors whitespace-nowrap border-b-2"
                        :class="activeTab === tab
                            ? 'border-indigo-600 text-indigo-600'
                            : 'border-transparent text-gray-500 hover:text-gray-700 dark:hover:text-gray-300'"
                    >
                        {{ tab }}
                    </button>
                </div>

                <!-- Tab Content -->
                <div class="mt-4">
                    <!-- About Tab -->
                    <div v-if="activeTab === 'About'" class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                        <h3 class="text-lg font-bold mb-4 border-b pb-2 text-gray-900 dark:text-white">Personal Information</h3>
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Username</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ user.username }}</dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email address</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ user.email }}</dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Gender</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 capitalize">{{ user.gender }}</dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Member Since</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ new Date(user.created_at).toLocaleDateString() }}</dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">First Name</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ user.firstname || 'Not set' }}</dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Last Name</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ user.lastname || 'Not set' }}</dd>
                            </div>
                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Address</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ user.address || 'Not set' }}</dd>
                            </div>
                        </dl>

                        <h3 class="text-lg font-bold mt-8 mb-4 border-b pb-2 text-gray-900 dark:text-white">Account Details</h3>
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Credits</dt>
                                <dd class="mt-1 text-sm font-bold text-green-600">{{ user.credits }}</dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Timeline Tab (Placeholder) -->
                    <div v-else-if="activeTab === 'Timeline'" class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 text-center text-gray-500">
                        <i class="fas fa-stream text-4xl mb-2"></i>
                        <p>Timeline posts will appear here.</p>
                    </div>

                    <!-- Photo Tab (Placeholder) -->
                    <div v-else-if="activeTab === 'Photo'" class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 text-center text-gray-500">
                        <i class="far fa-images text-4xl mb-2"></i>
                        <p>User photos will appear here.</p>
                    </div>

                    <!-- Forum Tab (Placeholder) -->
                    <div v-else-if="activeTab === 'Forum'" class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 text-center text-gray-500">
                        <i class="fas fa-comments text-4xl mb-2"></i>
                        <p>Forum topics will appear here.</p>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
