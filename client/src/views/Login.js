import { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import apiUtils from "../utils/apiUtils";
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';
import ReCAPTCHA from "react-google-recaptcha";
/* global grecaptcha */


const Login = () => {
    const [loginCredentials, setLoginCredentials] = useState({ username: "", password: "" });

    const navigate = useNavigate();

    const URL = apiUtils.getUrl();

    const login = async (evt) => {
        evt.preventDefault();
        try {   
                const formData = new FormData();
                formData.append('username', loginCredentials.username);
                formData.append('password', loginCredentials.password);
    
                console.log("FormData prepared, sending login request"); 
                 const response = await apiUtils.getAxios().post(URL + '/login', formData, {
                     headers: {
                         'Content-Type': 'multipart/form-data'
                     },
                 });
                navigate('/landing');
        } catch (error) {
            loginNotifyError("Login failed");
        }
    };


    const toRegister = () => {
        navigate('/register');
    };

    const onChange = (evt) => {
        setLoginCredentials({ ...loginCredentials, [evt.target.id]: evt.target.value });
    };

    // Toast
    const loginNotifyError = (msg) => {
        toast.error(msg, { position: toast.POSITION.BOTTOM_RIGHT });
    };

    return (
        <div className="center">
            <form onChange={onChange} >
                <input className="loginInput" placeholder="Username" id="username" />
                <br></br>
                <input className="loginInput" type="password" placeholder="Password" id="password" />
                <br></br>
                {/* <div className="g-recaptcha" data-sitekey="6LcQ8gIoAAAAAOJYd_oMXu7wPSnte3q66mPRF2Bl" data-action="LOGIN"></div> */}
                <button className="loginButton" onClick={login}>Log in</button>
                <br></br>
            </form>
            <button className="loginButton" onClick={toRegister}>Sign up</button>

            <ReCAPTCHA
    sitekey="6LeHfgMoAAAAAK-xEgrArjssBOgl7a5OuInbVloQ"
    onChange={onChange}
  />
            <ToastContainer />
        </div>
    );
}

export default Login;