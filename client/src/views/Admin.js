import React from 'react';
import { useState, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import apiUtils from '../utils/apiUtils';
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import { faRemove } from '@fortawesome/free-solid-svg-icons'

const Admin = ({ role }) => {
    const [products, setProducts] = useState([]);
    const [orders, setOrders] = useState([]);
    const [users, setUsers] = useState([]);
    const [selectedOrderId, setSelectedOrderId] = useState("");
    const [selectedUserId, setSelectedUserId] = useState("");
    const [product, setProduct] = useState({ name: "", price: 0 });
    const [editedUser, setEditedUser] = useState({ email: "", username: "" });
    const [editedProduct, setEditedProduct] = useState({ id: 0, price: "" });


    const URL = apiUtils.getUrl()
    const navigate = useNavigate();

    const deleteIcon = <FontAwesomeIcon icon={faRemove} />

    const getAllProducts = async () => {
        const response = await apiUtils.getAxios().get(URL + '/products')
        setProducts(response.data)
    }

    const getAllOrders = async () => {
        const response = await apiUtils.getAxios().get(URL + '/orders')
        setOrders(response.data)
    }

    const getAllUsers = async () => {
        const response = await apiUtils.getAxios().get(URL + '/users')
        setUsers(response.data)
    }

    useEffect(() => {
        getAllProducts()
        getAllOrders()
        getAllUsers()
    }, []);


    const onChangeProduct = (evt) => {
        setProduct({ ...product, [evt.target.id]: evt.target.value })
    }

    const onChangeUser = (evt) => {
        setEditedUser({ ...editedUser, [evt.target.id]: evt.target.value })
    }

    const createProduct = async () => {
        try {
            const formData = new FormData();
            formData.append('name', product.name);
            formData.append('price', product.price);

            const response = await apiUtils.getAxios().post(URL + '/createproduct', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                },
            });

            await getAllProducts()
            productCreatedSuccess(response)
        } catch (error) {
            productCreatedError(error.response.data)
        }
    }

    const editProduct = (productId) => {
        const productToEdit = products.find((product) => product.product_id === productId);
        if (productToEdit) {
            setEditedProduct({ id: productId, price: productToEdit.product_price });
        }
    };

    const handleSaveProduct = async (productId) => {
        try {
            const response = await apiUtils.getAxios().post(URL + '/updateproduct', {
                id: productId,
                price: Number(editedProduct.price),
            });
            await getAllProducts();
            productUpdatedSuccess(response);
            setEditedProduct({ id: null, price: "" });
        } catch (error) {
            productUpdatedError(error.response.data);
        }
    };

    const cancelEditProduct = () => {
        setEditedProduct({ id: null, price: "" });
    };


    const handleDeleteProduct = async (productId) => {
        try {
            await apiUtils.getAxios().post(URL + '/deleteproduct', {
                id: productId
            });
            await getAllProducts();
        } catch (error) {
            productDeletedError(error.response.data)
        }
    };

    const updateOrderStatus = async () => {
        try {
            const response = await apiUtils.getAxios().post(URL + '/updateorder', {
                id: selectedOrderId
            })
            orderUpdatedSuccess(response)
            await getAllOrders()
        } catch (error) {
            orderUpdatedError(error.response.data)
        }
    }

    const updateUser = async () => {
        try {
            const response = await apiUtils.getAxios().post(URL + '/updateuser', {
                id: selectedUserId,
                email: editedUser.email,
                username: editedUser.username
            })
            userUpdatedSuccess(response)
            await getAllUsers()
        } catch (error) {
            userUpdatedError(error.response.data)
        }
    }

    const handleDeleteUser = async (userId) => {
        try {
            await apiUtils.getAxios().post(URL + '/deleteuser', {
                id: userId
            });
            await getAllUsers();
        } catch (error) {
            userDeletedError(error.response.data)
        }
    };

    const handleDeleteOrder = async (orderId) => {
        try {
            await apiUtils.getAxios().post(URL + '/deleteorder', {
                id: orderId
            });
            await getAllOrders();
        } catch (error) {
            userDeletedError(error.response.data)
        }
    };

    // Toast
    const productCreatedSuccess = () => {
        toast.success('Product created successfully', { position: toast.POSITION.BOTTOM_RIGHT });
    };

    const productCreatedError = (msg) => {
        toast.error(msg, { position: toast.POSITION.BOTTOM_RIGHT });
    };

    const productUpdatedSuccess = () => {
        toast.success('Product updated successfully', { position: toast.POSITION.BOTTOM_RIGHT });
    };

    const productUpdatedError = (msg) => {
        toast.error(msg, { position: toast.POSITION.BOTTOM_RIGHT });
    };

    const productDeletedError = (msg) => {
        toast.error(msg, { position: toast.POSITION.BOTTOM_RIGHT });
    };

    const orderUpdatedSuccess = () => {
        toast.success('Order updated successfully', { position: toast.POSITION.BOTTOM_RIGHT });
    };

    const orderUpdatedError = (msg) => {
        toast.error(msg, { position: toast.POSITION.BOTTOM_RIGHT });
    };

    const userUpdatedSuccess = () => {
        toast.success('User updated successfully', { position: toast.POSITION.BOTTOM_RIGHT });
    };

    const userUpdatedError = (msg) => {
        toast.error(msg, { position: toast.POSITION.BOTTOM_RIGHT });
    };

    const userDeletedError = (msg) => {
        toast.error(msg, { position: toast.POSITION.BOTTOM_RIGHT });
    };

    return (
        <div className="container mt-4">
            {role === 'admin' ? (
                <div>
                    <div className="center">
                        <h1>Hello Admin</h1>
                    </div>

                    {/* Section 1: Admin Dashboard */}
                    <section className="mb-4 admin-section">
                        <div className="center">
                            <h2>Product Management</h2>
                        </div>
                        <form onChange={onChangeProduct} >
                            <div className="mb-3">
                                <label htmlFor="name">Product Name</label>
                                <input
                                    type="text"
                                    className="form-control"
                                    id="name"
                                    placeholder="Name"
                                />
                            </div>
                            <div className="mb-3">
                                <label htmlFor="price">Price</label>
                                <div className="input-group">
                                    <input
                                        type="number"
                                        className="form-control"
                                        id="price"
                                        placeholder="Price"
                                    />
                                </div>
                            </div>
                        </form>
                        <button className="admin-btn mb-4" onClick={createProduct}>Create Product</button>

                        <table className="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                {products &&
                                    products.map((product) => (
                                        <tr key={product.product_id}>
                                            <td>{product.product_id}</td>
                                            <td>{product.product_name}</td>
                                            <td>
                                                {product.product_id === editedProduct.id ? (
                                                    <input
                                                        type="number"
                                                        className="form-control"
                                                        value={editedProduct.price}
                                                        onChange={(e) =>
                                                            setEditedProduct({
                                                                ...editedProduct,
                                                                price: e.target.value,
                                                            })
                                                        }
                                                    />
                                                ) : (
                                                    `$${product.product_price}`
                                                )}
                                            </td>
                                            <td>
                                                {product.product_id === editedProduct.id ? (
                                                    <>
                                                        <button
                                                            className="btn btn-success"
                                                            onClick={() => handleSaveProduct(product.product_id)}
                                                        >
                                                            Save
                                                        </button>{" "}
                                                        <button
                                                            className="btn btn-danger"
                                                            onClick={() => cancelEditProduct()}
                                                        >
                                                            Cancel
                                                        </button>
                                                    </>
                                                ) : (
                                                    <>
                                                        <button
                                                            className="btn btn-primary"
                                                            onClick={() => editProduct(product.product_id)}
                                                        >
                                                            Edit
                                                        </button>{" "}
                                                    </>
                                                )}
                                            </td>
                                            <td>{<div onClick={() => handleDeleteProduct(product.product_id)} className="product-remove">{deleteIcon}</div>}</td>
                                        </tr>
                                    ))}
                            </tbody>
                        </table>

                    </section>

                    {/* Section 2: Order Management */}
                    <section className="mb-4 admin-section">
                        <div className="center">
                            <h2>Order Management</h2>
                        </div>
                        <div className="mb-3">
                            <label htmlFor="orderSelect">Update Order Status</label>
                            <select
                                className="form-select"
                                id="orderSelect"
                                value={selectedOrderId}
                                onChange={(e) => setSelectedOrderId(e.target.value)}
                            >
                                <option value="">Select an order ID</option>
                                {orders.map((order) => (
                                    <option key={order.order_id} value={order.order_id}>
                                        {order.order_id} ({order.order_status})
                                    </option>
                                ))}
                            </select>

                            <table className="table table-striped">
                                <thead className="mt-head">
                                    <tr>
                                        <th>ID</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {orders &&
                                        orders.map((order) => (
                                            <tr key={order.order_id}>
                                                <td>{order.order_id}</td>
                                                <td>{order.order_status}</td>
                                                <td>{order.created}</td>
                                                <td>{<div onClick={() => handleDeleteOrder(order.order_id)} className="product-remove">{deleteIcon}</div>}</td>
                                            </tr>
                                        ))}
                                </tbody>
                            </table>
                        </div>
                        <button className="admin-btn" onClick={updateOrderStatus}>Complete order</button>
                    </section>

                    {/* Section 3: User Management */}
                    <section className="mb-4 admin-section">
                        <div className="center">
                            <h2>User Management</h2>
                        </div>
                        <label htmlFor="userSelect">Select User</label>
                        <select
                            className="form-select mb-4"
                            id="userSelect"
                            value={selectedUserId}
                            onChange={(e) => setSelectedUserId(e.target.value)}
                        >
                            <option value="">Select a User</option>
                            {users.map((user) => (
                                <option key={user.user_id} value={user.user_id}>
                                    {user.username}
                                </option>
                            ))}
                        </select>
                        <form onChange={onChangeUser} >
                            <div className="mb-3">
                                <label htmlFor="email">Email</label>
                                <input
                                    type="text"
                                    className="form-control"
                                    id="email"
                                    placeholder="Email"
                                />
                            </div>
                            <div className="mb-3">
                                <label htmlFor="username">Username</label>
                                <input
                                    type="text"
                                    className="form-control"
                                    id="username"
                                    placeholder="Username"
                                />
                            </div>
                        </form>
                        <button className="admin-btn" onClick={updateUser}>Update user</button>

                        <table className="table table-striped">
                            <thead className="mt-head">
                                <tr>
                                    <th>ID</th>
                                    <th>Username</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                {users &&
                                    users.map((user) => (
                                        <tr key={user.user_id}>
                                            <td>{user.user_id}</td>
                                            <td>{user.username}</td>
                                            <td>{<div onClick={() => handleDeleteUser(user.user_id)} className="product-remove">{deleteIcon}</div>}</td>
                                        </tr>
                                    ))}
                            </tbody>
                        </table>
                    </section>
                </div>
            ) : (
                <div className="center">
                    <h1>Unauthorized</h1>
                    <button onClick={() => { navigate('/') }} className="return-btn">Back to shop</button>
                </div>
            )}
            <ToastContainer />
        </div>
    );
};

export default Admin;
