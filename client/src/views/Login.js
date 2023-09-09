import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import apiUtils from '../utils/apiUtils';
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';
import ReCAPTCHA from 'react-google-recaptcha';

const Login = () => {
    const [loginCredentials, setLoginCredentials] = useState({ username: '', password: '' });
    const [captchaKey, setCaptchaKey] = useState(1);

    const navigate = useNavigate();
    const URL = apiUtils.getUrl();

    const login = async (evt) => {
        evt.preventDefault();
        try {
            const formData = new FormData();
            formData.append('username', loginCredentials.username);
            formData.append('password', loginCredentials.password);
            formData.append('g-recaptcha-response', captchaValue);
            const response = await apiUtils.getAxios().post(URL + '/login', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
            });
            navigate('/landing');
        } catch (error) {
            loginNotifyError('Login failed');
            // Reset the reCAPTCHA on login failure
            setCaptchaKey((prevKey) => prevKey + 1);
        }
    };

    const [captchaValue, setCaptchaValue] = useState();

    const onCaptcha = (value) => {
        setCaptchaValue(value);
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
            <form onChange={onChange}>
                <input className="loginInput" placeholder="Username" id="username" />
                <br></br>
                <input className="loginInput" type="password" placeholder="Password" id="password" />
                <br></br>
                <br></br>
                <ReCAPTCHA
                    className="g-captcha"
                    sitekey="6LcPegcoAAAAALq6qy7sXoyh0LQJ-aL7xahbnSEK"
                    onChange={onCaptcha}
                    key={captchaKey}
                />
                <br></br>
                <button className="loginButton" onClick={login}>
                    Log in
                </button>
                <br></br>
            </form>
            <button className="loginButton" onClick={toRegister}>
                Sign up
            </button>
            <ToastContainer />
        </div>
    );
};

export default Login;
