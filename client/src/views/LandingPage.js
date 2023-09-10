import { useEffect } from "react";

const LandingPage = ({ isLoggedIn, checkLogin }) => {

    useEffect(() => {
        const dologinCheck = async () => {
            await checkLogin()
        }
        dologinCheck()
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