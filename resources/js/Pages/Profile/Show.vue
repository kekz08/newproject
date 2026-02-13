<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';

const props = defineProps({
    user: {
        type: Object,
        required: true,
    },
});

const authUser = usePage().props.auth.user;
const isOwnProfile = authUser.id === props.user.id;
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

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Personal Info -->
                            <div>
                                <h3 class="text-lg font-bold mb-4 border-b pb-2">Personal Information</h3>
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
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">First Name</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ user.firstname }}</dd>
                                    </div>
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Middle Name</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ user.middlename || 'N/A' }}</dd>
                                    </div>
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Last Name</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ user.lastname }}</dd>
                                    </div>
                                    <div class="sm:col-span-2">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Address</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ user.address || 'Not provided' }}</dd>
                                    </div>
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Contact Number</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ user.contact_number || 'Not provided' }}</dd>
                                    </div>
                                </dl>
                            </div>

                            <!-- Account Details -->
                            <div>
                                <h3 class="text-lg font-bold mb-4 border-b pb-2">Account Details</h3>
                                <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Credits</dt>
                                        <dd class="mt-1 text-sm font-bold text-green-600">{{ user.credits }}</dd>
                                    </div>
                                    <div class="sm:col-span-1" v-if="isOwnProfile">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Last IP Address</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ user.ip || 'N/A' }}</dd>
                                    </div>
                                    <div class="sm:col-span-2" v-if="isOwnProfile">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Browser</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 break-all">{{ user.browser || 'N/A' }}</dd>
                                    </div>
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Member Since</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ new Date(user.created_at).toLocaleDateString() }}</dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
