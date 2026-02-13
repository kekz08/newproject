<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Home" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Home
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-2xl font-bold mb-4">Welcome back,
                            <Link :href="route('profile.show', { user: $page.props.auth.user.username })" class="text-indigo-600 hover:text-indigo-800 underline">
                                {{ $page.props.auth.user.username }}
                            </Link>!
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            This is your personalized home page. You can manage your profile, view your statistics, and more from here.
                        </p>

                        <!-- User Info Grid -->
                        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="p-4 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg shadow-sm">
                                <h4 class="font-bold text-gray-700 dark:text-gray-300 border-b pb-2 mb-3">Profile Information</h4>
                                <div class="space-y-2 text-sm">
                                    <p><span class="font-semibold">Username:</span>
                                        <Link :href="route('profile.show', { user: $page.props.auth.user.username })" class="text-indigo-600 hover:text-indigo-800 underline">
                                            {{ $page.props.auth.user.username }}
                                        </Link>
                                    </p>
                                    <p><span class="font-semibold">Full Name:</span> {{ $page.props.auth.user.firstname }} {{ $page.props.auth.user.middlename }} {{ $page.props.auth.user.lastname }}</p>
                                    <p><span class="font-semibold">Email:</span> {{ $page.props.auth.user.email }}</p>
                                    <p><span class="font-semibold">Address:</span> {{ $page.props.auth.user.address || 'Not provided' }}</p>
                                    <p><span class="font-semibold">Contact:</span> {{ $page.props.auth.user.contact_number || 'Not provided' }}</p>
                                </div>
                            </div>

                            <div class="p-4 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg shadow-sm">
                                <h4 class="font-bold text-gray-700 dark:text-gray-300 border-b pb-2 mb-3">Session & Account</h4>
                                <div class="space-y-2 text-sm">
                                    <p><span class="font-semibold text-green-600">Credits:</span> {{ $page.props.auth.user.credits }}</p>
                                    <p><span class="font-semibold">Last IP Address:</span> {{ $page.props.auth.user.ip || 'N/A' }}</p>
                                    <div class="flex items-start">
                                        <span class="font-semibold mr-1">Browser:</span>
                                        <span class="truncate" :title="$page.props.auth.user.browser">{{ $page.props.auth.user.browser || 'N/A' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div class="p-4 bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-100 dark:border-indigo-800 rounded-lg">
                                <h4 class="font-bold text-indigo-600 dark:text-indigo-400">Recent Activity</h4>
                                <p class="text-sm mt-1">No recent activity to show.</p>
                            </div>
                            <div class="p-4 bg-green-50 dark:bg-green-900/20 border border-green-100 dark:border-green-800 rounded-lg">
                                <h4 class="font-bold text-green-600 dark:text-green-400">Statistics</h4>
                                <p class="text-sm mt-1">Everything is looking good!</p>
                            </div>
                            <div class="p-4 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-100 dark:border-yellow-800 rounded-lg">
                                <h4 class="font-bold text-yellow-600 dark:text-yellow-400">Notifications</h4>
                                <p class="text-sm mt-1">You have 0 new notifications.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
