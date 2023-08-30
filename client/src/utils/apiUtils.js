import axios from "axios";

const URL = 'https://localhost/security';

const api = () => {

    const getUrl = () => {
        return URL;
    }

    const getAxios = () => {
        return axios.create()
    }

    return {
        getUrl,
        getAxios,
    }
}

export default api();