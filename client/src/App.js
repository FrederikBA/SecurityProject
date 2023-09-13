import { BrowserRouter, Routes, Route } from "react-router-dom";
import { useState, useEffect } from "react";
import apiUtils from "./utils/apiUtils";
import { toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';

//Views
import Header from './views/shared/Header';
import NoMatch from "./views/NoMatch";
import ShopPage from './views/ShopPage';
import ProductPage from './views/ProductPage';
import Login from './views/Login';
import Register from "./views/Register";
import LandingPage from "./views/LandingPage";
import Cart from "./views/Cart";
import OrderConfirmation from "./views/OrderConfirmation";
import Admin from "./views/Admin";
import Profile from "./views/Profile";


const App = () => {
  const [isLoggedIn, setIsLoggedIn] = useState(false);
  const [role, setRole] = useState("user");
  const [csrf, setCsrf] = useState("");
  const URL = apiUtils.getUrl()

  const getToken = async () => {
    try {
      const response = await apiUtils.getAxios().get(apiUtils.getUrl() + '/token', {
        withCredentials: true,
      });
      // If success, set token
      setCsrf(response.data.csrf_token)
    } catch (error) {
      //Handle error
    }
  }

  const checkLogin = async () => {
    try {
      const response = await apiUtils.getAxios().get(apiUtils.getUrl() + '/checklogin', {
        withCredentials: true,
      });
      // If success, do login
      setIsLoggedIn(true)
      setRole(response.data)

    } catch (error) {
      //Handle error
    }
  }

  const onLogout = async () => {
    try {
      await apiUtils.getAxios().post(URL + '/logout') //Do logout
      setIsLoggedIn(false)
      setRole("")
      notifyLogout()
    } catch (error) {
      //Handle error
    }
  }

  //Toast
  const notifyLogout = () => {
    toast.info('You are now logged out', { position: toast.POSITION.BOTTOM_RIGHT });
  };

  useEffect(() => {
    checkLogin();
    getToken();
  }, []);

  return (
    <BrowserRouter>
      <Header isLoggedIn={isLoggedIn} role={role} onLogout={() => { onLogout(); setIsLoggedIn(false) }} />
      <Routes>
        <Route path="/" element={<ShopPage isLoggedIn={isLoggedIn} />} />
        <Route path="/product/:productId" element={<ProductPage />} />
        <Route path="/login" element={<Login />} />
        <Route path="/register" element={<Register />} />
        <Route path="/cart" element={<Cart csrf={csrf} />} />
        <Route path="/receipt" element={<OrderConfirmation />} />
        <Route path="/landing" element={<LandingPage isLoggedIn={isLoggedIn} checkLogin={checkLogin} getToken={getToken} />} />
        <Route path="/admin" element={<Admin role={role} csrf={csrf} />} />
        <Route path="/profile" element={<Profile onLogout={() => { setIsLoggedIn(false) }} />} />
        <Route path='*' element={<NoMatch />} />
      </Routes>
    </BrowserRouter>
  );
}

export default App;