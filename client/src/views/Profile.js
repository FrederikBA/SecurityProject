import { useState} from 'react';
import apiUtils from "../utils/apiUtils"
import { useNavigate } from "react-router-dom";


const Profile = () => {
    const URL = apiUtils.getUrl();
    const [confirmation, setConfirmation] = useState('');
    const [deleteStatus, setDeleteStatus] = useState('');
    const navigate = useNavigate();

  
    const handleDelete = async () => {
        if (confirmation.trim() !== 'I Agree') {
          setDeleteStatus("Please type exactly 'I Agree' to delete your account.");
          return;
        }
      
        try {
            const response = await apiUtils.getAxios().post(URL + '/deletecurrentuser/',{
                confirmation: confirmation,

            });
        
      
          if (response.status === 200) {
            setDeleteStatus('User deleted successfully');
          navigate("/landing")
            
          }
        } catch (error) {
          if (error.response && error.response.status === 400) {
            setDeleteStatus('Invalid body');
          } else {
            setDeleteStatus('Error deleting user');
          }
        }
      };
  
    return (
      <div className="center">
        <h1>User Profile</h1>
        <p>{deleteStatus}</p>
        <input
          type="text"
          placeholder="Type 'I Agree' to delete your account"
          value={confirmation}
          onChange={(e) => setConfirmation(e.target.value)}
        />
        <button onClick={handleDelete}>Delete Account</button>
      </div>
    );
  };
  
  export default Profile;
  