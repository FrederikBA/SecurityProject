import { useNavigate } from "react-router-dom";

const Admin = ({ role }) => {
    const navigate = useNavigate()

    const navigateBack = () => {
        navigate("/")
    }

    return (
        <div className="center">
            {role === 'admin' ? (
                <div>
                    <h1>Hello Admin</h1>
                </div>
            ) : (
                <div>
                    <h1>Unauthorized </h1>
                    <button onClick={navigateBack} className="return-btn">Take me back</button>
                </div>
            )}
        </div>
    )
}

export default Admin