import { BrowserRouter, Routes, Route } from "react-router-dom";
import { useState, useEffect } from "react";
import apiUtils from "./utils/apiUtils";

//Views
import Header from './views/shared/Header';
import ShopPage from './views/ShopPage';
import ProductPage from './views/ProductPage';
import Login from './views/Login';
import Register from "./views/Register";
import LandingPage from "./views/LandingPage";
import Cart from "./views/Cart";


const App = () => {
  const [isLoggedIn, setIsLoggedIn] = useState(false);
  const URL = apiUtils.getUrl()

  const onLogout = async () => {
    try {
      const response = await apiUtils.getAxios().post(URL + '/logout')
    } catch (error) {
      //Handle error
    }
  }

  useEffect(() => {
    const checkLogin = async () => {
      try {
        const response = await apiUtils.getAxios().get(apiUtils.getUrl() + '/checklogin', {
          withCredentials: true,
        });
        //If success, do login
        setIsLoggedIn(true)

      } catch (error) {
        //If error, do logout
        setIsLoggedIn(false)
      }
    }
    checkLogin();
  }, []);

  return (
    <BrowserRouter>
      <Header isLoggedIn={isLoggedIn} onLogout={() => { onLogout(); setIsLoggedIn(false) }} />
      <Routes>
        <Route path="/" element={<ShopPage isLoggedIn={isLoggedIn} />} />
        <Route path="/product/:productId" element={<ProductPage />} />
        <Route path="/login" element={<Login />} />
        <Route path="/register" element={<Register />} />
        <Route path="/cart" element={<Cart />} />
        <Route path='/landing' element={<LandingPage isLoggedIn={isLoggedIn} onLogin={() => setIsLoggedIn(true)} onLogout={() => setIsLoggedIn(false)} />} />
      </Routes>
    </BrowserRouter>
  );
}

export default App;