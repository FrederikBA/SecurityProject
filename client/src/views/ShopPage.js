import apiUtils from "../utils/apiUtils"
import { useState, useEffect } from 'react';
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';

import ProductCard from '../components/ProductCard';

const ShopPage = ({ isLoggedIn }) => {
    const [products, setProducts] = useState([{}]);
    const [isLoading, setIsLoading] = useState(true);

    const URL = apiUtils.getUrl()

    useEffect(() => {
        const getProducts = async () => {
            const response = await apiUtils.getAxios().get(URL + '/products')
            setProducts(response.data)
            setIsLoading(false)
        }
        getProducts();
    }, []);

    //Toast
    const buyNotifySuccess = () => {
        toast.success('Product added to the cart', { position: toast.POSITION.BOTTOM_RIGHT });
    };

    const buyNotifyError = () => {
        toast.error('An unexpected error occured, the product was not added to the cart', { position: toast.POSITION.BOTTOM_RIGHT });
    };

    const buyNotifyLogin = () => {
        toast.error('You have to be logged in to add to cart', { position: toast.POSITION.BOTTOM_RIGHT });
    };


    return (
        <div className="center">
            <ProductCard products={products} isLoggedIn={isLoggedIn} isLoading={isLoading} buyNotifySuccess={buyNotifySuccess} buyNotifyError={buyNotifyError} buyNotifyLogin={buyNotifyLogin} />
            <ToastContainer />
        </div>
    )
}

export default ShopPage