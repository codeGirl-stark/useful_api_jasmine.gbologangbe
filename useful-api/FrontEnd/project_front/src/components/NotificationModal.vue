<template>
    <div class="fixed top-5 right-5 space-y-2 z-50">
        <div
            v-for="toast in store.toasts"
            :key="toast.id"
            :class="[
                'px-4 py-2 rounded shadow-lg text-white min-w-[200px] flex justify-between items-center',
                toast.type === 'success'
                    ? 'bg-green-500'
                    : toast.type === 'error'
                    ? 'bg-red-500'
                    : 'bg-blue-500',
            ]"
        >
            <span>{{ toast.msg }}</span>
            <button class="ml-2 font-bold" @click="store.remove(toast.id)">
                ✕
            </button>
        </div>
    </div>
</template>

<script setup>
import { useNotificationStore } from "@/stores/notifications";
const store = useNotificationStore();
</script>

<style scoped>
/* Optionnel: animation entrée/sortie */
</style>
