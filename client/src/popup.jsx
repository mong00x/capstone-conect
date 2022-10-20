import react from 'react';
import {useState} from "react";
import md5 from "md5";

const Modal = ( {pin}) => 


{
    const [typedpin,setpin] = useState("");
    const redirectUrl = process.env.NODE_ENV === "development" ? "http://localhost/add_student.php?x=" : "https://cduprojects.spinetail.cdu.edu.au/adminpage/add_student.php?x=";    
    function Verify()
    {
        if (pin==typedpin)
        {
            const user = {
                studentid: JSON.parse(sessionStorage.getItem('user')).studentid, 
                name: JSON.parse(sessionStorage.getItem('user')).name, 
                email: JSON.parse(sessionStorage.getItem('user')).email, 
                password_token: JSON.parse(sessionStorage.getItem('user')).password_token,
                auth: true
            }
            sessionStorage.setItem('user', JSON.stringify(user))
            location.replace (redirectUrl + sessionStorage.getItem('user')) 
        }

        else{
            document.getElementById("error").innerHTML = "Wrong pin try again!";
        }
        
    }
    return(
        <div className='popup'>
            
            <div className='popinside'>
                <p id='error'> </p>
                varification code has been send to {JSON.parse(sessionStorage.getItem('user')).email}.
                <br></br>
                <br></br>
                
                
                <input 
                type="password"
                name="newpin"
                value={typedpin}
                onChange={(e) => setpin(e.target.value)}/>
                

                <button onClick={Verify}> Verify</button>
                
                

            </div>

        </div>
    )
}


export default Modal;
