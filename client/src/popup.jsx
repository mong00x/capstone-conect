import react from 'react';
import {useState} from "react";

const Modal = () => 
{
    const [typedpin,setpin] = useState("");
    
    function Verify()
    {
        if (JSON.parse(sessionStorage.getItem('user')).pin==typedpin)
        {
            location.replace ("http://localhost/add_student.php?x=" + sessionStorage.getItem('user')) 
        }

        else{
            document.getElementById("error").innerHTML = "Wrong pin try again!";
        }
    
    }
    return(
        <div className='popup'>
            
            <div className='popinside'>
                <p id='error'> </p>
                varification code has been send to { JSON.parse(sessionStorage.getItem('user')).email }.
                <br></br>
                <br></br>
                
                
                <input 
                type="password"
                name="newpin"
                value={typedpin}
                onChange={(e) => setpin(e.target.value)}/>
                

                <button onClick={Verify}> Verify</button>
                
                

            </div>

        </div>)
}


export default Modal;
