import react from 'react';
import {useState} from "react";

const Modal = ( {pin,email,fname}) => 
{
    const [typedpin,setpin] = useState("");
    
    function Verify()
{
    if (pin==typedpin)
    {
        const user = {name: fname, email: email, password_token: pin, auth: true}
        sessionStorage.setItem('user', JSON.stringify(user))
        
        console.log(JSON.parse(sessionStorage.getItem('user')))
        location.replace("http://127.0.0.1:5173/app")

    }
    else{
        console.log("wrong pin")
    }
    
}
    return(
        <div className='popup'>
            <div className='popinside'>
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
