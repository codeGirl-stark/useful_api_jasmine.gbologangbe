import axios from "axios";

const API_URL = `${process.env.VUE_APP_API_URL}`;

export const authService = {
    async register(formData) {
        return axios.post(`${API_URL}/register`, formData);
    },

    async login(credentials) {
        return axios.post(`${API_URL}/login`, credentials);
    },

    async logout(token) {
        return axios.post(
            `${API_URL}/logout`,
            {},
            {
                headers: {
                    Authorization: `Bearer ${token}`,
                },
            }
        );
    },
};
