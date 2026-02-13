<script setup>
import FooterNav from '@/Components/FooterNav.vue';
import HeaderBar from '@/Components/HeaderBar.vue';
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Cookies Policy" />
    <HeaderBar />
    <div v-if="!$page.props.auth.user" class="fixed top-[56px] left-0 w-full flex justify-center items-center bg-[#FFA000] border-b border-[#e0e0e0] z-[150] h-[56px] min-h-[56px]">
        <Link :href="route('login')" class="text-[#111] font-bold text-[18px] px-[18px] py-[12px] min-w-[44px] min-h-[44px] no-underline inline-flex items-center justify-center rounded-lg transition-colors duration-150 active:bg-[#f0f2f5]" :class="{ 'underline text-[#1877f2]': route().current('login') }">Login</Link>
        <span class="text-[#222] text-[20px] px-2 min-w-[24px] min-h-[44px] inline-flex items-center justify-center select-none">|</span>
        <Link :href="route('register')" class="text-[#111] font-bold text-[18px] px-[18px] py-[12px] min-w-[44px] min-h-[44px] no-underline inline-flex items-center justify-center rounded-lg transition-colors duration-150 active:bg-[#f0f2f5]" :class="{ 'underline text-[#1877f2]': route().current('register') }">Register</Link>
    </div>

    <div class="min-h-screen bg-gray-50 pt-28 pb-14 dark:bg-gray-900">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <h1
                class="mb-6 text-3xl font-bold tracking-tight text-gray-900 dark:text-gray-100"
            >
                Cookies Policy
            </h1>

            <p class="mb-4 text-gray-700 dark:text-gray-200">
                This Cookies Policy explains how New Pinoypark uses cookies and
                similar technologies in compliance with the Philippine Data
                Privacy Act of 2012 (RA 10173).
            </p>

            <p class="mb-4 text-gray-700 dark:text-gray-200">
                By continuing to use our website, you consent to the use of
                cookies in accordance with this policy.
            </p>

            <ol class="space-y-4 text-gray-700 list-decimal pl-5 dark:text-gray-200">
                <li>
                    <h2 class="font-semibold">What Are Cookies?</h2>
                    <p class="mt-1">
                        Cookies are small text files that are stored on your
                        device (computer, tablet, or mobile phone) when you
                        visit a website. They help the website function
                        properly, improve user experience, and provide
                        information to the website owner.
                    </p>
                    <p class="mt-1">
                        Cookies may be classified as:
                    </p>
                    <ul class="mt-1 list-disc pl-5">
                        <li>
                            <strong>Essential cookies</strong> – necessary for
                            the website to function properly
                        </li>
                        <li>
                            <strong>Performance and analytics cookies</strong> –
                            help us understand how users interact with the site
                        </li>
                        <li>
                            <strong>Functionality cookies</strong> – remember
                            user preferences and settings
                        </li>
                    </ul>
                </li>

                <li>
                    <h2 class="font-semibold">How We Use Cookies</h2>
                    <p class="mt-1">
                        We use cookies to:
                    </p>
                    <ul class="mt-1 list-disc pl-5">
                        <li>Enable core website functionality</li>
                        <li>Analyze website traffic and usage patterns</li>
                        <li>Remember your preferences and settings</li>
                        <li>
                            Improve website performance and user experience
                        </li>
                    </ul>
                    <p class="mt-1">
                        Cookies do not give us access to your device or personal
                        files. Any personal data collected through cookies is
                        processed in accordance with our Privacy Policy and RA
                        10173.
                    </p>
                </li>

                <li>
                    <h2 class="font-semibold">Third-Party Cookies</h2>
                    <p class="mt-1">
                        In some cases, we may use third-party services (such as
                        analytics tools) that place cookies on your device to
                        help us analyze site usage and improve our services.
                        These third parties are required to comply with
                        applicable data protection laws.
                    </p>
                </li>

                <li>
                    <h2 class="font-semibold">Managing and Disabling Cookies</h2>
                    <p class="mt-1">
                        You can control, restrict, or delete cookies through
                        your browser settings at any time. Please note that
                        disabling cookies may affect the functionality and
                        performance of certain features on our website.
                    </p>
                </li>

                <li>
                    <h2 class="font-semibold">Updates to This Cookies Policy</h2>
                    <p class="mt-1">
                        We may update this Cookies Policy from time to time to
                        reflect changes in technology, legal requirements, or
                        business practices. Any updates will be posted on this
                        page and will take effect immediately.
                    </p>
                </li>

                <li>
                    <h2 class="font-semibold">Contact Us</h2>
                    <p class="mt-1">
                        If you have any questions about our use of cookies or
                        this Cookies Policy, you may contact us through our
                        official support channels.
                    </p>
                </li>
            </ol>
        </div>
        <FooterNav />
    </div>
</template>

