import { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import apiUtils from "../utils/apiUtils"
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';

const Login = () => {
    const [loginCredentials, setLoginCredentials] = useState({ username: "", password: "" });

    const navigate = useNavigate();

    const URL = apiUtils.getUrl()

    const login = async (evt) => {
        evt.preventDefault()

        const formData = new FormData();
        formData.append('username', loginCredentials.username);
        formData.append('password', loginCredentials.password);


        try {
            const response = await apiUtils.getAxios().post(URL + '/login', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                },
            });
            //TODO Landing page
            navigate('/')
        } catch (error) {
            registerNotifyError(error.response.data)
        }
    }

    const toRegister = () => {
        navigate('/register')
    }

    const onChange = (evt) => {
        setLoginCredentials({ ...loginCredentials, [evt.target.id]: evt.target.value })
    }

    // Toast
    const registerNotifyError = (msg) => {
        toast.error(msg, { position: toast.POSITION.BOTTOM_RIGHT });
    };

    return (
        <div className="center">
            <form onChange={onChange} >
                <input className="loginInput" placeholder="Username" id="username" />
                <br></br>
                <input className="loginInput" type="password" placeholder="Password" id="password" />
                <br></br>
                <br></br>
                <button className="loginButton" onClick={login}>Log in</button>
                <br></br>
            </form>
            <button className="loginButton" onClick={toRegister}>Sign up</button>
        </div >
    )
}


export default Login