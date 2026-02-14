<script setup>
import FooterNav from '@/Components/FooterNav.vue';
import HeaderBar from '@/Components/HeaderBar.vue';
import NavBar from '@/Components/NavBar.vue';
import DrawerMenu from '@/Components/DrawerMenu.vue';
import Toast from '@/Components/Toast.vue';
import { toast } from '@/Stores/toast';
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link, useForm } from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);
const isDrawerOpen = ref(false);
const logoutForm = useForm({});

const handleMenuSelect = (item) => {
    if (item === 'Logout') {
        logoutForm.post(route('logout'));
    } else {
        toast.show(`Navigating to ${item} (Temporary Content)`, 'info');
    }
    isDrawerOpen.value = false;
};
</script>

<template>
    <div>
        <HeaderBar />
        <NavBar @menu-press="isDrawerOpen = true" />
        <DrawerMenu
            :visible="isDrawerOpen"
            @close="isDrawerOpen = false"
            @menu-select="handleMenuSelect"
        />
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900 pt-[112px]">
            <nav
                class="border-b border-gray-100 bg-white dark:border-gray-700 dark:bg-gray-800"
            >

                <!-- Responsive Navigation Menu -->
                <div
                    :class="{
                        block: showingNavigationDropdown,
                        hidden: !showingNavigationDropdown,
                    }"
                    class="sm:hidden"
                >
                    <div class="space-y-1 pb-3 pt-2">
                        <ResponsiveNavLink
                            :href="route('dashboard')"
                            :active="route().current('dashboard')"
                        >
                            Dashboard
                        </ResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div
                        class="border-t border-gray-200 pb-1 pt-4 dark:border-gray-600"
                    >
                        <div class="px-4">
                            <div
                                class="text-base font-medium text-gray-800 dark:text-gray-200"
                            >
                                {{ $page.props.auth.user.username }}
                            </div>
                            <div class="text-sm font-medium text-gray-500">
                                {{ $page.props.auth.user.email }}
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.show', { user: $page.props.auth.user.username })">
                                Profile
                            </ResponsiveNavLink>
                            <ResponsiveNavLink
                                :href="route('logout')"
                                method="post"
                                as="button"
                            >
                                Log Out
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header
                class="bg-white shadow dark:bg-gray-800"
                v-if="$slots.header"
            >
                <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main class="pb-14">
                <slot />
            </main>
        </div>
        <FooterNav />
        <Toast />
    </div>
</template>
