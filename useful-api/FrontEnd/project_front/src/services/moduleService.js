import axios from 'axios';

const API_URL = `${process.env.VUE_APP_API_URL}/modules`;

const getToken = () => {
    return localStorage.getItem("token");
};

const axiosInstance = axios.create({
    baseURL: API_URL,
    headers: {
        Accept: 'application/json',
    },
});

axiosInstance.interceptors.request.use(
    (config) => {
        const token = getToken();
        if (token) {
            config.headers['Authorization'] = `Bearer ${token}`;
        return config;
    },
    (error) => {
        return Promise.reject(error);
    }
);


export const moduleService = {
    async getModules() {
        try {
            const response = await axiosInstance.get('');
            return response.data;
        } catch (error) {
            throw new Error('Error retrieving modules');
        }
    },

    // Activer un module
    async activateModule(moduleId) {
        try {
            const response = await axiosInstance.post(`/${moduleId}/activate`);
            return response.data;
        } catch (error) {
            throw new Error('Error activating the module');
        }
    },

    // Désactiver un module
    async deactivateModule(moduleId) {
        try {
            const response = await axiosInstance.post(`/${moduleId}/deactivate`);
            return response.data;
        } catch (error) {
            throw new Error('Error disabling module');
        }
    },
};
