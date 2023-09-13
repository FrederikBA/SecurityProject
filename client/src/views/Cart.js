import { useState, useEffect } from "react";
import { useNavigate } from "react-router-dom";
import apiUtils from "../utils/apiUtils";
import shirt from '../img/shirt.jpg';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import { faRemove } from '@fortawesome/free-solid-svg-icons'

const Cart = ({ csrf }) => {
    const [cart, setCart] = useState({ "cartLines": [] });
    const deleteIcon = <FontAwesomeIcon icon={faRemove} size="2x" />
    const navigate = useNavigate();
    const URL = apiUtils.getUrl()

    const getCart = async () => {
        const response = await apiUtils.getAxios().get(URL + '/cart')
        setCart(response.data)
    }

    useEffect(() => {
        getCart()
    }, []);

    const totalQuantity = cart.cartLines.reduce((total, cartLine) => total + cartLine.quantity, 0);

    const handleRemove = async (itemId) => {
        try {
            await apiUtils.getAxios().post(URL + '/removecartline', {
                id: itemId
            });
            await getCart();
        } catch (error) {
            console.error("Error removing cart line:", error);
        }
    };

    const purchase = async () => {
        try {
            const formData = new FormData();
            formData.append('lines', cart.cartLines);
            await apiUtils.getAxios().post(URL + '/createorder', {
                csrf: csrf,
                lines: cart.cartLines
            });
            navigate('/receipt')
        } catch (error) {
            console.log(error);
        }
    }


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
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            {cart.cartLines && cart.cartLines.map((item, index) => (
                                <tr key={index}>
                                    <td><img src={shirt} alt={item.productName} width="150" height="100" /></td>
                                    <td>{item.productName}</td>
                                    <td>{item.quantity}</td>
                                    <td>${item.price}</td>
                                    <td>{<div onClick={() => handleRemove(item.productId)} className="cart-remove cart-item-details">{deleteIcon}</div>}</td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                    <div className="text-end">
                        <h4>Total Price: ${cart.totalPrice}</h4>
                        <button className="btn btn-primary" onClick={purchase}>
                            Purchase
                        </button>
                    </div>
                </>
            )}
        </div>
    )
}

export default Cart;