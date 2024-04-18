import axios from "axios";

export default defineNuxtPlugin((nuxtApp) => {
    const defaultUrl = "https://fish-text.ru/get?format=json&number=3";

    let api = axios.create({
        baseURL: defaultUrl,
        headers: {
            common: {},
        },
    });
    return {
        provide: {
            api: api,
        },
    };
});