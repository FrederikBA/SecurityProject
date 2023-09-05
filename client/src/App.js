import { BrowserRouter, Routes, Route } from "react-router-dom";

//Views
import Header from './components/Header';
import ShopPage from './views/ShopPage';
import ProductPage from './views/ProductPage';
import Login from './views/Login';
import Register from "./views/Register";
import Profile from "./views/Profile";


const App = () => {

  return (
    <BrowserRouter>
      <Header />
      <Routes>
        <Route path="/" element={<ShopPage />} />
        <Route path="/product/:productId" element={<ProductPage />} />
        <Route path="/login" element={<Login />} />
        <Route path="/register" element={<Register />} />
        <Route path="/profile" element={<Profile />} />
      </Routes>
    </BrowserRouter>
  );
}

export default App;