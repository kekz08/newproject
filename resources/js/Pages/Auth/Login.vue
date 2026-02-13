<script setup>
import { ref, computed } from 'vue';
import HeaderBar from '@/Components/HeaderBar.vue';
import FooterNav from '@/Components/FooterNav.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const page = usePage();
const form = useForm({
    login: '',
    password: '',
    remember: false,
});

const showPassword = ref(false);
const loading = computed(() => form.processing);
const error = computed(() => Object.values(form.errors)[0] || null);

const handleLogin = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};

const handleGoogleLogin = () => {
    alert('Google Login is currently disabled.');
};

const goRegister = () => {
    form.get(route('register'));
};
</script>

<template>
  <div class="login-root">
    <Head title="Log in" />
    <!-- Viewport meta for mobile scaling -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />

    <HeaderBar />

    <div class="fixed top-[56px] left-0 w-full flex justify-center items-center bg-[#FFA000] border-b border-[#e0e0e0] z-[150] h-[56px] min-h-[56px]">
      <Link :href="route('login')" class="text-[#111] font-bold text-[18px] px-[18px] py-[12px] min-w-[44px] min-h-[44px] no-underline inline-flex items-center justify-center rounded-lg transition-colors duration-150 active:bg-[#f0f2f5]" :class="{ 'underline text-[#1877f2]': route().current('login') }">Login</Link>
      <span class="text-[#222] text-[20px] px-2 min-w-[24px] min-h-[44px] inline-flex items-center justify-center select-none">|</span>
      <Link :href="route('register')" class="text-[#111] font-bold text-[18px] px-[18px] py-[12px] min-w-[44px] min-h-[44px] no-underline inline-flex items-center justify-center rounded-lg transition-colors duration-150 active:bg-[#f0f2f5]" :class="{ 'underline text-[#1877f2]': route().current('register') }">Register</Link>
    </div>

    <div class="border-b border-gray-400 mb-0"></div>

    <div class="main-content flex flex-col items-center justify-center min-h-screen pt-28 pb-14">
      <h2 class="welcome-title text-3xl font-bold text-gray-800 mb-2">Welcome Back!</h2>

      <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
          {{ status }}
      </div>

      <div v-if="error" class="error bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 w-full max-w-md">
        {{ error }}
      </div>

      <div class="w-full max-w-md space-y-4">
          <div class="input-group relative">
            <i class="fas fa-user input-icon absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
            <input
              v-model="form.login"
              class="form-input w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
              type="text"
              placeholder="Email or Username"
              autocomplete="username"
              :disabled="loading"
              required
              autofocus
            />
          </div>

          <div class="input-group relative">
            <i class="fas fa-lock input-icon absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
            <input
              v-model="form.password"
              class="form-input w-full pl-10 pr-12 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
              :type="showPassword ? 'text' : 'password'"
              placeholder="Password"
              autocomplete="current-password"
              :disabled="loading"
              required
            />
            <i
              :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"
              class="password-toggle-icon absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 cursor-pointer hover:text-gray-600 transition"
              @click="showPassword = !showPassword"
            ></i>
          </div>

          <div class="flex items-center">
              <input type="checkbox" id="remember" v-model="form.remember" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
              <label for="remember" class="ml-2 block text-sm text-gray-600">Remember me</label>
          </div>

          <button
            class="btn btn-primary btn-lg sign-in-btn w-full bg-indigo-600 text-white py-3 rounded-lg font-bold hover:bg-indigo-700 transition disabled:opacity-50 disabled:cursor-not-allowed"
            :disabled="loading"
            @click="handleLogin"
          >
            <i v-if="loading" class="fas fa-spinner fa-spin mr-2"></i>
            {{ loading ? 'Signing in...' : 'Sign In' }}
          </button>

          <button
            class="btn btn-outline btn-lg google-btn w-full border-2 border-gray-300 text-gray-700 py-3 rounded-lg font-bold hover:bg-gray-50 transition flex items-center justify-center space-x-2 disabled:opacity-50 disabled:cursor-not-allowed"
            :disabled="loading"
            @click="handleGoogleLogin"
          >
            <i class="fab fa-google"></i>
            <span>Sign in with Google</span>
          </button>

          <div class="text-center pt-2">
              <Link v-if="canResetPassword" :href="route('password.request')" class="forgot-password-link text-indigo-600 hover:text-indigo-800 text-sm font-semibold">
                Forgot Password?
              </Link>
          </div>

          <div class="signup-row text-center text-gray-600 mt-6">
            Don't have an account?
            <a @click.prevent="goRegister" href="#" class="signup-link text-indigo-600 hover:text-indigo-800 font-bold ml-1">Sign Up</a>
          </div>
      </div>
    </div>

    <FooterNav />
  </div>
</template>
