<script setup>
import FooterNav from '@/Components/FooterNav.vue';
import HeaderBar from '@/Components/HeaderBar.vue';
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Terms of Service" />
    <HeaderBar />
    <div v-if="!$page.props.auth.user" class="fixed top-[56px] left-1/2 -translate-x-1/2 w-full max-w-[600px] flex justify-center items-center bg-[#FFA000] border-b border-[#e0e0e0] z-[150] h-[56px] min-h-[56px]">
        <Link :href="route('login')" class="text-[#111] font-bold text-[18px] px-[18px] py-[12px] min-w-[44px] min-h-[44px] no-underline inline-flex items-center justify-center rounded-lg transition-colors duration-150 active:bg-[#f0f2f5]" :class="{ 'underline text-[#1877f2]': route().current('login') }">Login</Link>
        <span class="text-[#222] text-[20px] px-2 min-w-[24px] min-h-[44px] inline-flex items-center justify-center select-none">|</span>
        <Link :href="route('register')" class="text-[#111] font-bold text-[18px] px-[18px] py-[12px] min-w-[44px] min-h-[44px] no-underline inline-flex items-center justify-center rounded-lg transition-colors duration-150 active:bg-[#f0f2f5]" :class="{ 'underline text-[#1877f2]': route().current('register') }">Register</Link>
    </div>

    <div class="min-h-screen bg-gray-50 pt-28 pb-14 dark:bg-gray-900">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <h1
                class="mb-6 text-3xl font-bold tracking-tight text-gray-900 dark:text-gray-100"
            >
                Terms of Service
            </h1>

            <p class="mb-4 text-gray-700 dark:text-gray-200">
                Welcome to New Pinoypark. Please read these Terms of Service
                carefully before using our website or services. By accessing or
                using New Pinoypark, you agree to comply with and be bound by
                these terms.
            </p>

            <ol class="space-y-4 text-gray-700 list-decimal pl-5 dark:text-gray-200">
                <li>
                    <h2 class="font-semibold">Acceptance of Terms</h2>
                    <p class="mt-1">
                        By accessing, browsing, or using our website, you
                        acknowledge that you have read, understood, and agreed
                        to be bound by these Terms of Service, as well as any
                        applicable laws and regulations. If you do not agree
                        with these terms, please do not use our service.
                    </p>
                </li>

                <li>
                    <h2 class="font-semibold">Use of the Service</h2>
                    <p class="mt-1">
                        You agree to use New Pinoypark only for lawful purposes
                        and in a manner that does not violate any applicable
                        laws, regulations, or the rights of others. You are
                        responsible for any activity that occurs under your
                        account, if applicable.
                    </p>
                </li>

                <li>
                    <h2 class="font-semibold">User Responsibilities</h2>
                    <p class="mt-1">
                        You agree not to misuse the service, attempt to gain
                        unauthorized access to the system, or engage in any
                        activity that could harm, disrupt, or interfere with the
                        proper functioning of the website.
                    </p>
                </li>

                <li>
                    <h2 class="font-semibold">Changes to the Terms</h2>
                    <p class="mt-1">
                        We reserve the right to update, modify, or replace these
                        Terms of Service at any time without prior notice. Any
                        changes will be effective immediately upon posting. Your
                        continued use of the service after changes are made
                        constitutes acceptance of the revised terms.
                    </p>
                </li>

                <li>
                    <h2 class="font-semibold">Termination</h2>
                    <p class="mt-1">
                        We reserve the right to suspend or terminate access to
                        our service at our sole discretion, without notice, if
                        you violate these Terms of Service.
                    </p>
                </li>

                <li>
                    <h2 class="font-semibold">Disclaimer</h2>
                    <p class="mt-1">
                        The service is provided on an "as is" and "as available"
                        basis. We make no warranties, expressed or implied,
                        regarding the reliability, availability, or accuracy of
                        the service.
                    </p>
                </li>

                <li>
                    <h2 class="font-semibold">Contact Us</h2>
                    <p class="mt-1">
                        If you have any questions or concerns regarding these
                        Terms of Service, please contact us through our official
                        channels.
                    </p>
                </li>
            </ol>
        </div>
        <FooterNav />
    </div>
</template>
