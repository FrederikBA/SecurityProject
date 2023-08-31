import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import apiUtils from '../utils/apiUtils';
import shirt from '../img/shirt.jpg';

const ProductCard = ({ products, isLoading, rentNotifySuccess, rentNotifyError, rentNotifyLogin }) => {
    const navigate = useNavigate();
    const [hoveredProductId, setHoveredProductId] = useState(null);


    // const addToCart = async (movieId, price) => {

    //     try {
    //         if (localStorage.getItem('jwtToken') !== null) {
    //             await apiUtils.getAxios().post(apiUtils.getUrl() + '/addtocart', {
    //                 user_id: localStorage.getItem('userId'),
    //                 movie_id: movieId,
    //                 price: price,
    //             });
    //             rentNotifySuccess()
    //         } else {
    //             rentNotifyLogin()
    //         }

    //     } catch (error) {
    //         rentNotifyError()
    //     }
    // };

    // const handleMovieClick = (movieId) => {
    //     navigate(`/movies/id/${movieId}`);
    // };

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
        <div className="row row-cols-5">
            {/* {products.map((product) => (
                <div key={product.movie_id} className="col mb-4 poster" onMouseEnter={() => handleMouseEnter(movie.movie_id)}
                    onMouseLeave={handleMouseLeave}>
                    <img src={movie.poster} className="card-img-top" alt={movie.title} />
                    {hoveredMovieId === movie.movie_id ? (
                        <>
                            <button onClick={() => handleMovieClick(movie.movie_id)} className="btn show-more">Vis mere</button>
                            <button onClick={(e) => { e.stopPropagation(); addToCart(movie.movie_id, movie.price); }} id="rent-button" className="btn rent">Læg i kurv</button>
                        </>
                    ) : null}

                    <div className="card-body center">
                        <p className="card-title">{movie.title} ({movie.release_year})</p>
                        <div className="poster-text"><img className="star" src={star} alt="Rating Star" />{movie.rating} / 10</div>
                        <span className="poster-text">Lej for: {movie.price} kr.</span>
                    </div>
                </div>
            ))} */
                products.map((product) => (
                    <div key={product.product_id} className="col mb-4 poster" onMouseEnter={() => handleMouseEnter(product.product_id)}
                        onMouseLeave={handleMouseLeave}>
                        <img src={shirt} className="card-img-top" alt={product.product_name} />
                        {/* {hoveredProductId === product.product_id ? (
                            <>
                                <button onClick={() => handleMovieClick(movie.movie_id)} className="btn show-more">Vis mere</button>
                                <button onClick={(e) => { e.stopPropagation(); addToCart(movie.movie_id, movie.price); }} id="rent-button" className="btn rent">Læg i kurv</button>
                            </>
                        ) : null} */}

                        <div className="card-body center">
                            <p className="card-title">{product.product_name}</p>
                            <span className="poster-text">{product.product_price} kr.</span>
                        </div>
                    </div>
                ))
            }
        </div>
    );




};

export default ProductCard;