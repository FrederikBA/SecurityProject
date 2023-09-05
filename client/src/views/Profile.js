import { useState, useEffect } from "react";
import apiUtils from "../utils/apiUtils";

const Profile = () => {
    const [isLoggedIn, setIsLoggedIn] = useState(false);
    const URL = apiUtils.getUrl();

    useEffect(() => {
        const checkLogin = async () => {
            try {
                const response = await apiUtils.getAxios().get(URL + '/checklogin', {
                    withCredentials: true,
                });
                setIsLoggedIn(true);

            } catch (error) {
                setIsLoggedIn(false);
            }
        }
        checkLogin();
    }, []);


    return (
        <div>

        </div>)
}

export default Profile