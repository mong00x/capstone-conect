import react from 'react';
import {useState} from "react";
import axios from "axios";

const Modal = ( {pin,email,fname,studentid}) => 


{
    const [typedpin,setpin] = useState("");
    const redirectUrl = process.env.NODE_ENV === "development" ? "http://localhost/add_student.php?x=" : "https://cduprojects.spinetail.cdu.edu.au/adminpage/add_student.php?x=";    
    function Verify()
{
    if (pin==typedpin)
    {
        const user = {studentid: studentid, name: fname, email: email, password_token: pin, auth: true}
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
                varification code has been send to {email}.
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
