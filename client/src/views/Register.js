import { useState } from 'react';
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';
import apiUtils from '../utils/apiUtils';

const Register = () => {
    const [loginCredentials, setLoginCredentials] = useState({ email: "", username: "", password: "" });
    const [errorMsg, setErrorMsg] = useState("");

    const URL = apiUtils.getUrl()

    const register = async () => {
        try {
            const formData = new FormData();
            formData.append('email', loginCredentials.email);
            formData.append('username', loginCredentials.username);
            formData.append('password', loginCredentials.password);

            const response = await apiUtils.getAxios().post(URL + '/register', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data', // Set the content type to form data
                },
            });


            registerNotifySuccess(response)
        } catch (error) {
            registerNotifyError(error.response.data)
        }
    }


    // Toast
    const registerNotifySuccess = () => {
        toast.success('Din bruger er oprettet!', { position: toast.POSITION.BOTTOM_RIGHT });
    };

    const registerNotifyError = (msg) => {
        toast.error(msg, { position: toast.POSITION.BOTTOM_RIGHT });
    };

    const onChange = (evt) => {
        setLoginCredentials({ ...loginCredentials, [evt.target.id]: evt.target.value })
    }

    return (
        <div className="center">
            <form onChange={onChange} >
                <input className="registerInput" type="text" placeholder="Email" id="email" />
                <br></br>
                <input className="registerInput" type="text" placeholder="Brugernavn" id="username" />
                <br></br>
                <input className="registerInput" type="text" placeholder="Adgangskode" id="password" />
                <br></br>
                <br></br>
            </form>
            <button className="loginButton" onClick={register}>Opret bruger</button>
            <ToastContainer />
        </div >
    )
}

export default Register