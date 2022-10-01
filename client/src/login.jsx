import {useState} from "react";
import "./login.css";
import emailjs from '@emailjs/browser';
import Modal from "./popup";


const Login_page = () => {
    const [email,setEmail] = useState('');
    const [user_type,setType] = useState('student');
    const [password,setPassword] = useState('');
    console.log(password);
    
    const [popup,setPopup] = useState(false);

    const handellogin = (e) =>{
        e.preventDefault();
        setPassword(Math.floor(Math.random() * (9999 - 1111)) + 1111);
        console.log(password);

        emailjs.sendForm('service_2qo1eeb', 'template_hbtmtbs', e.target, 'WjagjhsUVM7RUWDft')
      .then((result) => {
          console.log(result.text);
      }, (error) => {
          console.log(error.text);
      });

      setPopup(true)
        
    }

        if (!popup) 
        {
            return(
            <form onSubmit={handellogin}>
            <label >Choose a login type:</label>
            <br></br>
            <select value={user_type} onChange={(e) => setType(e.target.value)} >
                <option value="admin">Admin</option>
                <option value="student">Student</option>
                <option value="lecturer">Lecturer</option>
            </select>
            <br></br>
            
            {user_type === "student" && <label  >Email address : </label>}
            <br></br>
            {user_type === "student" && <input 
            type="email"
            id="email"
            name="email"
            value={email}
            onChange={(e) => setEmail(e.target.value)}/>}
            
            <br></br>
            {user_type === "student" && <input 
            className="password"
            name="password"
            value={password}
            onChange={(e) => setPassword(e.target.value)}
            />}
            
            <br></br>
            {user_type === "student" && <button  type="submit">Send Password</button>}
            {user_type !== "student" && <a href="http://localhost/login.php"  >Login as {user_type}</a>}
        </form>
        )
        }

    return(
        
        <div >
        <Modal pin={password} email={email}/>
        </div>
        
    )

};
export default Login_page;
