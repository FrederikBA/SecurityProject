import { useEffect } from "react";
import { ToastContainer } from 'react-toastify';
import { useNavigate } from "react-router-dom";

const LandingPage = ({ isLoggedIn, checkLogin, getToken }) => {
    const navigate = useNavigate()

    useEffect(() => {
        const timer = setTimeout(() => {
            checkLogin();
            getToken();
        }, 100);
        return () => clearTimeout(timer);
    }, []);


    return (
        <div className="center">
            {isLoggedIn && <h3>Welcome</h3>}
            <button onClick={() => { navigate('/') }} className="return-btn">Back to shop</button>
            <ToastContainer />
        </div>
    )
}

export default LandingPage