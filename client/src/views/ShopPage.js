import apiUtils from "../utils/apiUtils"
import { useState, useEffect } from 'react';
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';

import ProductCard from '../components/ProductCard';

const ShopPage = () => {
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
    const rentNotifySuccess = () => {
        toast.success('Din film er tilføjet til kurven', { position: toast.POSITION.BOTTOM_RIGHT });
    };

    const rentNotifyError = () => {
        toast.error('Der opstod en fejl, din film blev ikke tilføjet', { position: toast.POSITION.BOTTOM_RIGHT });
    };

    const rentNotifyLogin = () => {
        toast.error('Du skal logge ind for at leje en film', { position: toast.POSITION.BOTTOM_RIGHT });
    };


    return (
        <div className="center">
            <ProductCard products={products} isLoading={isLoading} rentNotifySuccess={rentNotifySuccess} rentNotifyError={rentNotifyError} rentNotifyLogin={rentNotifyLogin} />
        </div>
    )
}

export default ShopPage