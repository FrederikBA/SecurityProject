import { BrowserRouter, Routes, Route } from "react-router-dom";
import Header from './components/Header';
import ShopPage from './views/ShopPage';
import Two from './views/Two';


const App = () => {

  return (
    <BrowserRouter>
      <Header />
      <Routes>
        <Route path="/" element={<ShopPage />} />
        <Route path="/two" element={<Two />} />
      </Routes>
    </BrowserRouter>
  );
}

export default App;