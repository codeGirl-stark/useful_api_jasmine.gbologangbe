// src/stores/notifications.js
import { defineStore } from "pinia";

export const useNotificationStore = defineStore("notification", {
    state: () => ({
        toasts: [], // tableau de notifications
    }),

    actions: {
        /**
         * Affiche une notification toast
         * @param {string} msg - message
         * @param {"success"|"error"|"info"} type - type
         * @param {number} duration - durée en ms
         */
        show(msg, type = "success", duration = 3000) {
            const id = Date.now();
            this.toasts.push({ id, msg, type });

            setTimeout(() => {
                this.remove(id);
            }, duration);
        },

        remove(id) {
            this.toasts = this.toasts.filter((t) => t.id !== id);
        },

        clear() {
            this.toasts = [];
        },
    },
});
