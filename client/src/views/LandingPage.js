import { useState, useEffect } from "react";
import apiUtils from "../utils/apiUtils";

const LandingPage = ({ isLoggedIn, onLogin, onLogout }) => {
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
            <div className="center">
                {isLoggedIn ? <h3>Welcome</h3>
                    : <h3>You have been logged out</h3>}
            </div >
        </div>)
}

export default LandingPage