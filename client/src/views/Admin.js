import React from 'react';
import { useState, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import apiUtils from '../utils/apiUtils';
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';

const Admin = ({ role }) => {
    const [price, setPrice] = useState(10); //Default price to 10 dollars
    const [selectedOrderId, setSelectedOrderId] = useState("");
    const [product, setProduct] = useState({ product: "name", price: 0 });
    const [orders, setOrders] = useState([]);

    const URL = apiUtils.getUrl()
    const navigate = useNavigate();

    const getAllOrders = async () => {
        const response = await apiUtils.getAxios().get(URL + '/orders')
        setOrders(response.data)
    }

    useEffect(() => {
        getAllOrders()
    }, []);


    const onChangeProduct = (evt) => {
        setProduct({ ...product, [evt.target.id]: evt.target.value })
        console.log(product);
    }

    const createProduct = async () => {
        try {
            const formData = new FormData();
            formData.append('name', product.name);
            formData.append('price', Number(product.price));

            const response = await apiUtils.getAxios().post(URL + '/createproduct', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                },
            });

            productCreatedSuccess(response)
        } catch (error) {
            productCreatedError(error.response.data)
        }
    }

    const updateOrderStatus = async () => {
        try {
            const response = await apiUtils.getAxios().post(URL + '/updateorder', {
                id: selectedOrderId
            })
            orderUpdatedSuccess(response)
            getAllOrders()
        } catch (error) {
            orderUpdatedError(error.response.data)
        }
    }

    // Toast
    const productCreatedSuccess = () => {
        toast.success('Product created successfully', { position: toast.POSITION.BOTTOM_RIGHT });
    };

    const productCreatedError = (msg) => {
        toast.error(msg, { position: toast.POSITION.BOTTOM_RIGHT });
    };

    const orderUpdatedSuccess = () => {
        toast.success('Order updated successfully', { position: toast.POSITION.BOTTOM_RIGHT });
    };

    const orderUpdatedError = (msg) => {
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
                                <label htmlFor="task1Input">Product Name</label>
                                <input
                                    type="text"
                                    className="form-control"
                                    id="name"
                                    placeholder="Name"
                                />
                            </div>
                            <div className="mb-3">
                                <label htmlFor="task2Input">Price</label>
                                <div className="input-group">
                                    <input
                                        type="number"
                                        className="form-control"
                                        id="price"
                                        placeholder="Price"
                                        value={price}
                                        onChange={(e) => setPrice(parseInt(e.target.value, 10))}
                                    />
                                </div>
                            </div>
                        </form>
                        <button className="admin-btn" onClick={createProduct}>Create Product</button>
                    </section>

                    {/* Section 3: Content Management */}
                    <section className="mb-4 admin-section">
                        <div className="center">
                            <h2>Order Management</h2>
                        </div>
                        <div className="mb-3">
                            <label htmlFor="orderSelect">Select Order ID</label>
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
                        </div>
                        <button className="admin-btn" onClick={updateOrderStatus}>Complete order</button>
                    </section>

                    {/* Section 2: User Management */}
                    <section className="mb-4 admin-section">
                        <div className="center">
                            <h2>User Management</h2>
                        </div>
                        <div className="mb-3">
                            <label htmlFor="userName">User's Name</label>
                            <input
                                type="text"
                                className="form-control"
                                id="userName"
                                placeholder="User's name"
                            />
                        </div>
                        <div className="mb-3">
                            <label htmlFor="userEmail">User's Email</label>
                            <input
                                type="email"
                                className="form-control"
                                id="userEmail"
                                placeholder="User's email"
                            />
                        </div>
                        <div className="mb-3">
                            <label htmlFor="userRole">User Role</label>
                            <select className="form-select" id="userRole">
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                            </select>
                        </div>
                        <button className="admin-btn">Add User</button>
                    </section>
                </div>
            ) : (
                <div>
                    <h1>Unauthorized</h1>
                    <button onClick={() => { navigate('/') }} className="return-btn">Back to shop</button>
                </div>
            )}
            <ToastContainer />
        </div>
    );
};

export default Admin;
