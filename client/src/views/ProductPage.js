import { useParams } from 'react-router-dom';
import { useState, useEffect } from 'react';
import apiUtils from "../utils/apiUtils"
import shirt from '../img/shirt.jpg';


const ProductPage = () => {
    const [product, setProduct] = useState({});
    const [isLoading, setIsLoading] = useState(true);
    const { productId } = useParams();

    const URL = apiUtils.getUrl();

    useEffect(() => {
        const getProductById = async () => {
            try {
                const response = await apiUtils.getAxios().get(URL + '/product/' + productId)
                setProduct(response.data)
                setIsLoading(false)
            } catch (error) {
            }
        }
        getProductById()
    }, []);

    return (
        <div className="center">
            {isLoading ? (
                <div>
                    <h1>404</h1>
                    <h4>Product doesn't exist</h4>
                </div>
            ) : (
                <div className="product-container">
                    <div className="product-card">
                        <img src={shirt} alt={product.product_name} className="product-image" />
                        <h2 className="product-name">{product.product_name}</h2>
                        <p className="product-price">$ {product.product_price}</p>
                    </div>
                </div>
            )}
        </div>
    )
}

export default ProductPage