import { useState, useEffect } from "react";
import { useNavigate } from "react-router-dom";
import apiUtils from "../utils/apiUtils"

const OrderConfirmation = () => {
    const [order, setOrder] = useState({});
    const navigate = useNavigate()
    const URL = apiUtils.getUrl()

    useEffect(() => {
        const getLatestOrder = async () => {
            const response = await apiUtils.getAxios().get(URL + '/latestorder')
            setOrder(response.data)
        }
        getLatestOrder()
    }, []);

    const navigateShop = () => {
        navigate("/")
    }

    return (
        <div className="container">
            <div className="center">
                <h1 className="mt-5">Thank you for ordering</h1>
            </div>

            {/* Order Details Table */}
            <div className="mt-5">
                <h2>Order Details</h2>
                <table className="table table-bordered">
                    <tbody>
                        <tr>
                            <th>Order ID</th>
                            <td>{order.order_id}</td>
                        </tr>
                        <tr>
                            <th>Order Date</th>
                            <td>{order.created}</td>
                        </tr>
                        {/* Add more order-related information as needed */}
                    </tbody>
                </table>
            </div>

            {/* Order Lines Table */}
            <div className="mt-5">
                <h2>Lines</h2>
                <table className="table table-bordered">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        {order.lines &&
                            order.lines.map((line) => (
                                <tr key={line.product_id}>
                                    <td>{line.product_name}</td>
                                    <td>{line.quantity}</td>
                                    <td>${line.price}</td>
                                    {/* Add more line-related information as needed */}
                                </tr>
                            ))}
                    </tbody>
                </table>
            </div>
            <div className="center">
                <button onClick={navigateShop} className="orderConfirmationButton">Back to shop</button>
            </div>
        </div>
    )
}

export default OrderConfirmation