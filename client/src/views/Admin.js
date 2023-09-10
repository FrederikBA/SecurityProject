const Admin = ({ role }) => {
    return (
        <div className="center">
            {role === 'admin' ? (
                <div>
                    <h1>Hello Admin</h1>
                </div>
            ) : (
                <div>
                    <h1>Unauthorized </h1>
                </div>
            )}
        </div>
    )
}

export default Admin