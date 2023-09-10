import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import apiUtils from '../utils/apiUtils';
import shirt from '../img/shirt.jpg';

const ProductCard = ({ products, isLoggedIn, isLoading, buyNotifySuccess, buyNotifyError, buyNotifyLogin }) => {
    const navigate = useNavigate();
    const [hoveredProductId, setHoveredProductId] = useState(null);

    const addToCart = async (productId, productName, quantity, productPrice) => {
        try {
            if (isLoggedIn) {
                const formData = new FormData();
                formData.append('productId', productId);
                formData.append('productName', productName);
                formData.append('quantity', quantity);
                formData.append('productPrice', productPrice);

                await apiUtils.getAxios().post(apiUtils.getUrl() + '/addtocart', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });
                buyNotifySuccess()
            } else {
                buyNotifyLogin()
            }

        } catch (error) {
            buyNotifyError()
        }
    };

    const handleProductClick = (productId) => {
        navigate(`/product/${productId}`);
    };

    const handleMouseEnter = (productId) => {
        setHoveredProductId(productId);
    };

    const handleMouseLeave = () => {
        setHoveredProductId(null);
    };

    if (isLoading) {
        return <br></br>;
    }

    return (
        <div className="container" >
            <div className="row row-cols-5">
                {products.map((product) => (
                    <div key={product.product_id} className="col mb-4 poster" onMouseEnter={() => handleMouseEnter(product.product_id)}
                        onMouseLeave={handleMouseLeave}>
                        <img src={shirt} className="card-img-top" alt={product.product_name} />
                        {hoveredProductId === product.product_id ? (
                            <>
                                <button onClick={() => handleProductClick(product.product_id)} className="btn show-more">More info</button>
                                <button onClick={(e) => { e.stopPropagation(); addToCart(product.product_id, product.product_name, 1, product.product_price); }} id="rent-button" className="btn rent">Add to cart</button>
                            </>
                        ) : null}

                        <div className="card-body center">
                            <p className="card-title">{product.product_name}</p>
                            <span className="poster-text">${product.product_price}</span>
                        </div>
                    </div>
                ))
                }
            </div>
        </div >
    );




};

export default ProductCard;