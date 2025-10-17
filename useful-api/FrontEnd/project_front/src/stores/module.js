import { defineStore } from 'pinia';
import { moduleService } from '@/services/moduleService';

export const useModuleStore = defineStore('modules', {
    state: () => ({
        modules: [],
        activeModules: [],
        loading: false,
        error: null,
    }),

    actions: {
        async fetchModules() {
            this.loading = true;
            this.error = null;
            try {
                const modules = await moduleService.getModules();
                this.modules = modules;
                this.activeModules = modules.filter(module => module.active);
            } catch (error) {
                this.error = error.message;
            } finally {
                this.loading = false;
            }
        },

        // Activer un module
        async activateModule(moduleId) {
            this.loading = true;
            this.error = null;
            try {
                await moduleService.activateModule(moduleId);
                this.activeModules.push(moduleId);
            } catch (error) {
                this.error = error.message;
            } finally {
                this.loading = false;
            }
        },

        // Désactiver un module
        async deactivateModule(moduleId) {
            this.loading = true;
            this.error = null;
            try {
                await moduleService.deactivateModule(moduleId);
                this.activeModules = this.activeModules.filter(id => id !== moduleId);
            } catch (error) {
                this.error = error.message;
            } finally {
                this.loading = false;
            }
        },
    },
});
