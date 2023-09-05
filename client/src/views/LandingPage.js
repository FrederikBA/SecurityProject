import { useState, useEffect } from "react";
import apiUtils from "../utils/apiUtils";

const LandingPage = ({ onLogin, onLogout }) => {
    const URL = apiUtils.getUrl();

    useEffect(() => {
        const checkLogin = async () => {
            try {
                const response = await apiUtils.getAxios().get(URL + '/checklogin', {
                    withCredentials: true,
                });
                //If success, do login
                onLogin()

            } catch (error) {
                //If error, do logout
                onLogout()
            }
        }
        checkLogin();
    }, []);

    return (
        <div className="center">
            <h1>Welcome</h1>

        </div>)
}

export default LandingPage