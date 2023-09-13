import { useState } from 'react';
import apiUtils from "../utils/apiUtils"
import { useNavigate } from "react-router-dom";
import { toast, ToastContainer } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';

const Profile = ({ onLogout }) => {
  const URL = apiUtils.getUrl();
  const [confirmation, setConfirmation] = useState('');
  const navigate = useNavigate();


  const handleDelete = async () => {
    if (confirmation.trim() !== 'I Agree') {
      return;
    }

    try {
      await apiUtils.getAxios().post(URL + '/deletecurrentuser/', {
        confirmation: confirmation,
      });
      onLogout()
      navigate("/landing")
    } catch (error) {
      //Handle error
      confirmationError(error.response.data)
    }
  };

  // Toast

  const confirmationError = (msg) => {
    toast.error(msg, { position: toast.POSITION.BOTTOM_RIGHT });
  };

  return (
    <div className="center">
      <h1>User Profile</h1>
      <input
        type="text"
        placeholder="Type 'I Agree' to delete your account"
        value={confirmation}
        onChange={(e) => setConfirmation(e.target.value)}
        className="confirmation-input"
      />
      <br></br>
      <button
        onClick={handleDelete}
        className={`delete-button ${confirmation.trim() === 'I Agree' ? 'enabled' : ''} mt-3`}
        disabled={confirmation.trim() !== 'I Agree'}
      >
        Delete Account
      </button>
      <ToastContainer />
    </div >
  );
};

export default Profile;
