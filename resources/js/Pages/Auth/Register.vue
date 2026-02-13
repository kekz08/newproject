<script setup>
import { ref, computed } from 'vue';
import HeaderBar from '@/Components/HeaderBar.vue';
import FooterNav from '@/Components/FooterNav.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import '@/../css/top-nav-bar.css';

const form = useForm({
    username: '',
    firstname: '',
    middlename: '',
    lastname: '',
    address: '',
    contact_number: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const showPassword = ref(false);
const showConfirmPassword = ref(false);
const loading = computed(() => form.processing);
const error = computed(() => Object.values(form.errors)[0] || null);
const recaptchaToken = ref('placeholder-token'); // Placeholder as requested in template

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};

const handleGoogleLogin = () => {
    alert('Google Sign-up is currently disabled.');
};

const goLogin = () => {
    form.get(route('login'));
};

const handleRegister = () => {
    submit();
};
</script>

<template>
  <div class="register-root">
    <Head title="Register" />
    <!-- Viewport meta for mobile scaling -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />

    <HeaderBar />

    <div class="top-nav-bar">
      <Link :href="route('login')" class="top-nav-link" :class="{ 'top-nav-link-exact-active': route().current('login') }">Login</Link>
      <span class="top-nav-divider">|</span>
      <Link :href="route('register')" class="top-nav-link" :class="{ 'top-nav-link-exact-active': route().current('register') }">Register</Link>
    </div>

    <div class="main-content flex flex-col items-center justify-center min-h-screen pt-28 pb-14">
      <h2 class="title text-3xl font-bold text-gray-800 mb-6">Create an Account</h2>

      <div v-if="loading && !error" class="register-loading-spinner mb-4 text-indigo-600">
        <i class="fas fa-spinner fa-spin"></i> Redirecting to home...
      </div>

      <div v-if="error" class="error bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 w-full max-w-md">
        {{ error }}
      </div>

      <div class="w-full max-w-md space-y-4">
        <!-- Username -->
        <div class="input-group relative">
          <i class="fas fa-user-tag input-icon absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
          <input
            v-model="form.username"
            class="form-input w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
            type="text"
            placeholder="Username"
            autocomplete="username"
            :disabled="loading"
            required
            autofocus
          />
        </div>

        <!-- Full Name Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div class="input-group relative">
            <i class="fas fa-user input-icon absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
            <input
              v-model="form.firstname"
              class="form-input w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
              type="text"
              placeholder="First Name"
              autocomplete="given-name"
              :disabled="loading"
              required
            />
          </div>
          <div class="input-group relative">
            <i class="fas fa-user input-icon absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
            <input
              v-model="form.lastname"
              class="form-input w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
              type="text"
              placeholder="Last Name"
              autocomplete="family-name"
              :disabled="loading"
              required
            />
          </div>
        </div>

        <!-- Middle Name -->
        <div class="input-group relative">
          <i class="fas fa-user input-icon absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
          <input
            v-model="form.middlename"
            class="form-input w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
            type="text"
            placeholder="Middle Name (Optional)"
            autocomplete="additional-name"
            :disabled="loading"
          />
        </div>

        <!-- Email -->
        <div class="input-group relative">
          <i class="fas fa-envelope input-icon absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
          <input
            v-model="form.email"
            class="form-input w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
            type="email"
            placeholder="Email"
            autocomplete="username"
            :disabled="loading"
            required
          />
        </div>

        <!-- Password -->
        <div class="input-group relative">
          <i class="fas fa-lock input-icon absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
          <input
            v-model="form.password"
            class="form-input w-full pl-10 pr-12 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
            :type="showPassword ? 'text' : 'password'"
            placeholder="Password"
            autocomplete="new-password"
            :disabled="loading"
            required
          />
          <i
            :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"
            class="password-toggle-icon absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 cursor-pointer hover:text-gray-600 transition"
            @click="showPassword = !showPassword"
          ></i>
        </div>

        <!-- Confirm Password -->
        <div class="input-group relative">
          <i class="fas fa-lock input-icon absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
          <input
            v-model="form.password_confirmation"
            class="form-input w-full pl-10 pr-12 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
            :type="showConfirmPassword ? 'text' : 'password'"
            placeholder="Confirm Password"
            autocomplete="new-password"
            :disabled="loading"
            required
          />
          <i
            :class="showConfirmPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"
            class="password-toggle-icon absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 cursor-pointer hover:text-gray-600 transition"
            @click="showConfirmPassword = !showConfirmPassword"
          ></i>
        </div>

        <!-- Address -->
        <div class="input-group relative">
          <i class="fas fa-map-marker-alt input-icon absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
          <input
            v-model="form.address"
            class="form-input w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
            type="text"
            placeholder="Address (Optional)"
            autocomplete="street-address"
            :disabled="loading"
          />
        </div>

        <!-- Contact Number -->
        <div class="input-group relative">
          <i class="fas fa-phone input-icon absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
          <input
            v-model="form.contact_number"
            class="form-input w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
            type="text"
            placeholder="Contact Number (Optional)"
            autocomplete="tel"
            :disabled="loading"
          />
        </div>

        <!-- reCAPTCHA widget placeholder -->
        <div class="recaptcha-container flex justify-center py-2">
          <div id="register-recaptcha" class="bg-gray-100 p-4 rounded border border-gray-200 text-sm text-gray-500">
            reCAPTCHA Placeholder
          </div>
        </div>

        <button
          class="btn btn-primary btn-lg register-btn w-full bg-indigo-600 text-white py-3 rounded-lg font-bold hover:bg-indigo-700 transition disabled:opacity-50 disabled:cursor-not-allowed"
          :disabled="loading || !recaptchaToken"
          @click="handleRegister"
        >
          <i v-if="loading" class="fas fa-spinner fa-spin mr-2"></i>
          {{ loading ? 'Registering...' : 'Register' }}
        </button>

        <button
          class="btn btn-outline btn-lg google-btn w-full border-2 border-gray-300 text-gray-700 py-3 rounded-lg font-bold hover:bg-gray-50 transition flex items-center justify-center space-x-2 disabled:opacity-50 disabled:cursor-not-allowed"
          :disabled="loading"
          @click="handleGoogleLogin"
        >
          <i class="fab fa-google"></i>
          <span>Sign up with Google</span>
        </button>

        <div class="signup-row text-center text-gray-600 mt-6">
          Already have an account?
          <a @click.prevent="goLogin" href="#" class="signup-link text-indigo-600 hover:text-indigo-800 font-bold ml-1">Login</a>
        </div>
      </div>
    </div>
    <FooterNav />
  </div>
</template>
