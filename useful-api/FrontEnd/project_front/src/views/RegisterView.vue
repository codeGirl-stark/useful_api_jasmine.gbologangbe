<template>
    <div class="hero min-h-full" style="background-image: url(register.jpg)">
        <div class="hero-overlay bg-black bg-opacity-60"></div>
        <div class="hero-content text-center py-20">
            <div class="hero min-h-screen">
                <div class="hero-content flex-col lg:flex-row-reverse">
                    <div class="text-center lg:text-left text-white p-6">
                        <h1 class="text-5xl font-bold">Register now !</h1>
                        <p class="py-6 max-w-lg">
                            Create your account to manage your modules and
                            create custom short links. Join us quickly and
                            easily.
                        </p>
                    </div>

                    <div
                        class="card w-full bg-white text-black max-w-xl shrink-0 shadow-2xl transition-shadow duration-300 hover:shadow-xl p-4 rounded-lg"
                    >
                        <form
                            @submit.prevent="handleRegister"
                            class="card-body"
                        >
                            <div class="space-y-4">
                                <div>
                                    <label class="label">
                                        <span class="label-text">Name</span>
                                    </label>
                                    <input
                                        v-model="formData.name"
                                        type="text"
                                        class="input w-full p-3 bg-gray-100 border-2 border-blue-500 rounded-lg focus:outline-none focus:border-blue-700 transition"
                                        placeholder="Your Name"
                                        required
                                    />
                                </div>

                                <!-- Email -->
                                <div>
                                    <label class="label">
                                        <span class="label-text">Email</span>
                                    </label>
                                    <input
                                        v-model="formData.email"
                                        type="email"
                                        class="input w-full p-3 bg-gray-100 border-2 border-blue-500 rounded-lg focus:outline-none focus:border-blue-700 transition"
                                        placeholder="Email"
                                        required
                                    />
                                </div>

                                <div>
                                    <label class="label">
                                        <span class="label-text">Password</span>
                                    </label>
                                    <input
                                        v-model="formData.password"
                                        type="password"
                                        class="input w-full p-3 bg-gray-100 border-2 border-blue-500 rounded-lg focus:outline-none focus:border-blue-700 transition"
                                        placeholder="Your password (min 8 characters)"
                                        required
                                    />
                                </div>

                                <div>
                                    <label class="label">
                                        <span class="label-text"
                                            >Confirm password</span
                                        >
                                    </label>
                                    <input
                                        v-model="formData.password_confirmation"
                                        type="password"
                                        class="input w-full p-3 bg-gray-100 border-2 border-blue-500 rounded-lg focus:outline-none focus:border-blue-700 transition"
                                        placeholder="Confirm password"
                                        required
                                    />
                                </div>
                            </div>

                            <div class="mt-6">
                                <button
                                    type="submit"
                                    class="btn w-full text-white bg-blue-600 hover:bg-blue-700 border-none transition duration-150 py-3 rounded-lg"
                                    :disabled="authStore.loading"
                                >
                                    {{
                                        authStore.loading
                                            ? "Registration..."
                                            : "Register"
                                    }}
                                </button>
                            </div>

                            <div class="text-center mt-4 text-sm">
                                <router-link
                                    to="/login"
                                    class="link link-hover text-blue-600 hover:text-blue-800"
                                >
                                    Already have an account? Log in
                                </router-link>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";

import { useAuthStore } from "@/stores/auth";

const authStore = useAuthStore();
const router = useRouter();

// Données du formulaire
const formData = ref({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
});

const handleRegister = async () => {
    const result = await authStore.register(formData.value);

    if (result.success === true) {
        router.push("/login");
    }
};
</script>

<style scoped>
.hero-overlay {
    background-color: rgba(0, 0, 0, 0.6);
}
</style>
