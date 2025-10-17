import { defineStore } from "pinia";
import { authService } from "@/services/authService";
import { useNotificationStore } from "./notifications";

export const useAuthStore = defineStore("auth", {
    state: () => ({
        user: null,
        token: null,
        tokenExpiry: null,
        loading: false,
        error: null,
    }),

    actions: {
        async register(formData) {
            const notif = useNotificationStore();
            this.loading = true;
            this.error = null;
            try {
                const { data } = await authService.register(formData);
                this.user = data.user;
                this.token = data.token;
                localStorage.setItem("token", data.token);
                localStorage.setItem("user", JSON.stringify(data.user));
                notif.show("registration successful", "success");
                return true;
            } catch (error) {
                this.error =
                    error.response?.data?.message || "Registration failure";
                if (
                    error.response?.status === 422 &&
                    error.response.data.errors
                ) {
                    notif.show(
                        "Please correct the errors in the form.",
                        "error"
                    );
                    return {
                        success: false,
                        errors: error.response.data.errors,
                    };
                }
                notif.show(this.error, "error");
                return false;
            } finally {
                this.loading = false;
            }
        },

        async login(credentials) {
            const notif = useNotificationStore();
            this.loading = true;
            this.error = null;

            try {
                const { data } = await authService.login(credentials);
                if (data.token && data.user_id) {
                    this.token = data.token;
                    localStorage.setItem("token", data.token);
                    localStorage.setItem("user_id", data.user_id);

                    // Set expiration time for the token
                    const EXPIRATION_DELAY = 24 * 60 * 60 * 1000;
                    const expiry = Date.now() + EXPIRATION_DELAY;
                    this.tokenExpiry = expiry;

                    localStorage.setItem("tokenExpiry", expiry);

                    notif.show("Connected", "success");

                    return { authenticate: true };
                } else {
                    throw new Error("Invalid login response");
                }
            } catch (error) {
                const errorMessage =
                    error.response?.data?.message || "Connection failure";
                this.error = errorMessage;
                notif.show(this.error, "error");

                return { authenticate: false };
            } finally {
                this.loading = false;
            }
        },

        async logout(router) {
            const notif = useNotificationStore();
            if (!this.token) return;
            try {
                await authService.logout(this.token);
            } catch (error) {
                console.warn("Disconnection error:", error);
            } finally {
                this.user = null;
                this.token = null;
                this.tokenExpiry = null;
                localStorage.removeItem("token");
                localStorage.removeItem("user");
                localStorage.removeItem("tokenExpiry");

                notif.show("Successfully logged out", "success");
                if (router) router.push("/login");
            }
        },
    },

    persist: {
        paths: ["user", "token", "tokenExpiry"],
        storage: localStorage,
    },
});
