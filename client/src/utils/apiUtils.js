import axios from "axios";

const URL = 'https://localhost/security';

const api = () => {

    const getUrl = () => {
        return URL;
    }

    const getAxios = () => {
        axios.defaults.withCredentials = true;
        return axios.create()
    }

    return {
        getUrl,
        getAxios,
    }
}

export default api();