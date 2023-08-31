import { BrowserRouter, Routes, Route } from "react-router-dom";
import Header from './components/Header';
import ShopPage from './views/ShopPage';
import ProductPage from './views/ProductPage';


const App = () => {

  return (
    <BrowserRouter>
      <Header />
      <Routes>
        <Route path="/" element={<ShopPage />} />
        <Route path="/product/:productId" element={<ProductPage />} />
      </Routes>
    </BrowserRouter>
  );
}

export default App;