import { useState, useEffect } from "react";
import apiUtils from "../utils/apiUtils";
import shirt from '../img/shirt.jpg';

const Cart = () => {
    const [cart, setCart] = useState({ "cartLines": [] });

    const URL = apiUtils.getUrl()

    useEffect(() => {
        const getCart = async () => {
            const response = await apiUtils.getAxios().get(URL + '/cart')
            setCart(response.data)
            console.log(cart);
        }
        getCart()
    }, []);

    const totalQuantity = cart.cartLines.reduce((total, cartLine) => total + cartLine.quantity, 0);

    return (
        <div className="container">
            <h3 className="center my-4">Your shopping cart ({totalQuantity} items) </h3>
            {totalQuantity === 0 ? (
                <br></br>
            ) : (
                <>
                    <table className="table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            {cart.cartLines && cart.cartLines.map((item, index) => (
                                <tr key={index}>
                                    <td><img src={shirt} alt={item.productName} width="150" height="100" /></td>
                                    <td>{item.productName}</td>
                                    <td>{item.quantity}</td>
                                    <td>${item.price}</td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                    <div className="text-end">
                        <h4>Total Price: $100</h4>
                    </div>
                </>
            )}
        </div>
    )
}

export default Cart;