<script setup>
import FooterNav from '@/Components/FooterNav.vue';
import HeaderBar from '@/Components/HeaderBar.vue';
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Privacy Policy" />
    <HeaderBar />
    <div v-if="!$page.props.auth.user" class="fixed top-[56px] left-1/2 -translate-x-1/2 w-full max-w-[600px] flex justify-center items-center bg-[#FFA000] border-b border-[#e0e0e0] z-[150] h-[56px] min-h-[56px]">
        <Link :href="route('login')" class="text-[#111] font-bold text-[18px] px-[18px] py-[12px] min-w-[44px] min-h-[44px] no-underline inline-flex items-center justify-center rounded-lg transition-colors duration-150 active:bg-[#f0f2f5]" :class="{ 'underline text-[#1877f2]': route().current('login') }">Login</Link>
        <span class="text-[#222] text-[20px] px-2 min-w-[24px] min-h-[44px] inline-flex items-center justify-center select-none">|</span>
        <Link :href="route('register')" class="text-[#111] font-bold text-[18px] px-[18px] py-[12px] min-w-[44px] min-h-[44px] no-underline inline-flex items-center justify-center rounded-lg transition-colors duration-150 active:bg-[#f0f2f5]" :class="{ 'underline text-[#1877f2]': route().current('register') }">Register</Link>
    </div>

    <div class="min-h-screen bg-gray-50 pt-28 pb-14 dark:bg-gray-900">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8 space-y-10">
            <section>
                <h1
                    class="mb-6 text-3xl font-bold tracking-tight text-gray-900 dark:text-gray-100"
                >
                    Privacy Policy
                </h1>

                <p class="mb-4 text-gray-700 dark:text-gray-200">
                    At New Pinoypark, your privacy is important to us. This
                    Privacy Policy explains how we collect, use, protect, and
                    handle your personal information when you use our website
                    and services.
                </p>

                <ol class="space-y-4 text-gray-700 list-decimal pl-5 dark:text-gray-200">
                    <li>
                        <h2 class="font-semibold">Information We Collect</h2>
                        <p class="mt-1">
                            We collect personal information that you voluntarily
                            provide to us, such as when you create an account,
                            contact us, or use certain features of our service.
                            This may include, but is not limited to, your name,
                            email address, and other relevant details.
                        </p>
                    </li>

                    <li>
                        <h2 class="font-semibold">How We Use Your Information</h2>
                        <p class="mt-1">
                            We use the information we collect to:
                        </p>
                        <ul class="mt-1 list-disc pl-5">
                            <li>Provide, operate, and maintain our services</li>
                            <li>Improve and personalize user experience</li>
                            <li>
                                Communicate with you regarding updates, support,
                                or important notices
                            </li>
                            <li>
                                Ensure the security and integrity of our
                                platform
                            </li>
                        </ul>
                    </li>

                    <li>
                        <h2 class="font-semibold">Data Protection and Security</h2>
                        <p class="mt-1">
                            We implement reasonable administrative, technical,
                            and organizational measures to protect your personal
                            information from unauthorized access, disclosure,
                            alteration, or destruction. However, no method of
                            transmission over the internet is completely secure.
                        </p>
                    </li>

                    <li>
                        <h2 class="font-semibold">Data Sharing</h2>
                        <p class="mt-1">
                            We do not sell, trade, or rent your personal
                            information to third parties, except when required
                            by law or necessary to provide our services.
                        </p>
                    </li>

                    <li>
                        <h2 class="font-semibold">Your Rights</h2>
                        <p class="mt-1">
                            You may have the right to access, update, or request
                            deletion of your personal information, subject to
                            applicable laws and regulations.
                        </p>
                    </li>

                    <li>
                        <h2 class="font-semibold">Changes to This Policy</h2>
                        <p class="mt-1">
                            We reserve the right to update or modify this
                            Privacy Policy at any time. Any changes will be
                            effective immediately upon posting. Continued use of
                            our service constitutes acceptance of the updated
                            policy.
                        </p>
                    </li>

                    <li>
                        <h2 class="font-semibold">Contact Us</h2>
                        <p class="mt-1">
                            If you have any questions or concerns about this
                            Privacy Policy or how your data is handled, please
                            contact us through our official channels.
                        </p>
                    </li>
                </ol>
            </section>

            <section>
                <h1
                    class="mb-4 text-2xl font-bold tracking-tight text-gray-900 dark:text-gray-100"
                >
                    Privacy Policy
                    <span class="block text-base font-normal text-gray-600 dark:text-gray-300">
                        (Philippine Data Privacy Act of 2012 – RA 10173
                        Compliant)
                    </span>
                </h1>

                <p class="mb-4 text-gray-700 dark:text-gray-200">
                    At New Pinoypark, we value your privacy and are committed to
                    protecting your personal data in accordance with the Data
                    Privacy Act of 2012 (Republic Act No. 10173), its
                    Implementing Rules and Regulations, and relevant issuances
                    of the National Privacy Commission (NPC).
                </p>

                <p class="mb-4 text-gray-700 dark:text-gray-200">
                    This Privacy Policy explains how we collect, use, store, and
                    protect your personal information.
                </p>

                <ol class="space-y-4 text-gray-700 list-decimal pl-5 dark:text-gray-200">
                    <li>
                        <h2 class="font-semibold">Information We Collect</h2>
                        <p class="mt-1">
                            We may collect personal information that you
                            voluntarily provide, including but not limited to:
                        </p>
                        <ul class="mt-1 list-disc pl-5">
                            <li>Full name</li>
                            <li>Email address</li>
                            <li>Account credentials</li>
                            <li>
                                Other information necessary to provide our
                                services
                            </li>
                        </ul>
                        <p class="mt-1">
                            We may also collect non-personal data such as usage
                            data, browser type, and system information for
                            system improvement and security purposes.
                        </p>
                    </li>

                    <li>
                        <h2 class="font-semibold">Purpose of Data Collection</h2>
                        <p class="mt-1">
                            Your personal data is collected and processed for
                            legitimate purposes, including:
                        </p>
                        <ul class="mt-1 list-disc pl-5">
                            <li>Account creation and user identification</li>
                            <li>
                                Providing, maintaining, and improving our
                                services
                            </li>
                            <li>
                                Communicating updates, notifications, and
                                support
                            </li>
                            <li>
                                Ensuring system security and preventing fraud
                            </li>
                            <li>
                                Complying with legal and regulatory requirements
                            </li>
                        </ul>
                        <p class="mt-1">
                            Personal data shall be processed only for purposes
                            stated at the time of collection.
                        </p>
                    </li>

                    <li>
                        <h2 class="font-semibold">Legal Basis for Processing</h2>
                        <p class="mt-1">
                            We process personal data based on any of the
                            following lawful criteria:
                        </p>
                        <ul class="mt-1 list-disc pl-5">
                            <li>Your consent</li>
                            <li>
                                The necessity of data processing for the
                                performance of a contract
                            </li>
                            <li>Compliance with legal obligations</li>
                            <li>
                                Legitimate interests of the platform, provided
                                such interests do not override your fundamental
                                rights
                            </li>
                        </ul>
                    </li>

                    <li>
                        <h2 class="font-semibold">Data Sharing and Disclosure</h2>
                        <p class="mt-1">
                            We do not sell or trade your personal data. Personal
                            information may be shared only:
                        </p>
                        <ul class="mt-1 list-disc pl-5">
                            <li>When required by law or lawful order</li>
                            <li>
                                With authorized service providers who assist in
                                platform operations, subject to strict
                                confidentiality and data protection agreements
                            </li>
                        </ul>
                    </li>

                    <li>
                        <h2 class="font-semibold">Data Retention</h2>
                        <p class="mt-1">
                            We retain personal data only for as long as
                            necessary to fulfill the purposes for which it was
                            collected or as required by applicable laws and
                            regulations. After this period, data will be
                            securely deleted or anonymized.
                        </p>
                    </li>

                    <li>
                        <h2 class="font-semibold">
                            Data Protection and Security Measures
                        </h2>
                        <p class="mt-1">
                            We implement reasonable and appropriate
                            organizational, physical, and technical security
                            measures to protect personal data against loss,
                            misuse, unauthorized access, disclosure, alteration,
                            or destruction.
                        </p>
                        <p class="mt-1">
                            While we strive to protect your information, no
                            method of electronic transmission or storage is 100%
                            secure.
                        </p>
                    </li>

                    <li>
                        <h2 class="font-semibold">Data Subject Rights</h2>
                        <p class="mt-1">
                            In accordance with RA 10173, you have the right to:
                        </p>
                        <ul class="mt-1 list-disc pl-5">
                            <li>Be informed</li>
                            <li>Access your personal data</li>
                            <li>Object to data processing</li>
                            <li>Request correction or rectification</li>
                            <li>Request erasure or blocking</li>
                            <li>Data portability</li>
                            <li>
                                File a complaint with the National Privacy
                                Commission
                            </li>
                        </ul>
                        <p class="mt-1">
                            You may exercise these rights by contacting us
                            through our official channels.
                        </p>
                    </li>

                    <li>
                        <h2 class="font-semibold">
                            Changes to This Privacy Policy
                        </h2>
                        <p class="mt-1">
                            We reserve the right to update this Privacy Policy
                            at any time to reflect changes in law, regulation,
                            or business practices. Any changes will be posted on
                            this page and shall take effect immediately.
                        </p>
                    </li>

                    <li>
                        <h2 class="font-semibold">Contact Information</h2>
                        <p class="mt-1">
                            For questions, concerns, or requests related to your
                            personal data or this Privacy Policy, you may
                            contact us through our official support channels.
                        </p>
                    </li>
                </ol>
            </section>
        </div>
        <FooterNav />
    </div>
</template>

