import { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import apiUtils from "../utils/apiUtils"

const Login = ({ onLogin }) => {
    const [loginCredentials, setLoginCredentials] = useState({ username: "", password: "" });

    const navigate = useNavigate();

    const URL = apiUtils.getUrl()

    const login = async (evt) => {
        evt.preventDefault()
        try {
            const res = await apiUtils.getAxios().post(URL + '/login', {
                username: loginCredentials.username,
                password: loginCredentials.password
            })
            localStorage.setItem('jwtToken', res.data.access_token)
            localStorage.setItem('user', loginCredentials.username)
            localStorage.setItem('userId', res.data.user_id)
            localStorage.setItem('memberId', res.data.member_id)
            navigate('/landing-page')
            onLogin()
        } catch (error) {
        }
    }

    const toRegister = () => {
        navigate('/register')
    }

    const onChange = (evt) => {
        setLoginCredentials({ ...loginCredentials, [evt.target.id]: evt.target.value })
    }

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