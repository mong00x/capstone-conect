import {useState} from "react";
import "./login.css";
import emailjs from '@emailjs/browser';
import Modal from "./popup";

const Login_page = () => {
    const [email,setEmail] = useState('');
    const [fname,setFname] = useState('');
    const [studentid,setId] = useState('');
    const [user_type,setType] = useState('student');
    const [password,setPassword] = useState(Math.floor(Math.random() * (9999 - 1111)) + 1111);
    const [popup,setPopup] = useState(false);

    const loginUrl =  process.env.NODE_ENV === "development" ? "http://localhost/login.php" : "https://cduprojects.spinetail.cdu.edu.au/adminpage/login.php";
    
    const user = {name: fname, email: email, password_token: password, auth: false}
    sessionStorage.setItem('user', JSON.stringify(user))
    
    
    const handellogin = (e) =>{
        e.preventDefault();
        var templateParams = {
            email: email,
            password: password
        };
         
        emailjs.send('service_2qo1eeb', 'template_hbtmtbs', templateParams, 'WjagjhsUVM7RUWDft')
            .then(function(response) {
               console.log('SUCCESS!', response.status, response.text);
            }, function(error) {
               console.log('FAILED...', error);
            });
        
        const user = {studentid:studentid, name: fname, email: email, password_token: password, auth: false}
        sessionStorage.setItem('user', JSON.stringify(user))
        console.log(JSON.parse(sessionStorage.getItem('user')))
        
      setPopup(true)

        
    }

        if (!popup) 
        {
            return(
            <div className="logincontainer">
            <form  onSubmit={handellogin} >
            <label >Choose a login type:</label>
            <br></br>
            <select className="dropwdown" value={user_type} onChange={(e) => setType(e.target.value)} >
                <option value="admin">Admin</option>
                <option value="student">Student</option>
                <option value="lecturer">Lecturer</option>
            </select>
            <br></br>
            
            {user_type === "student" && <label  >Email address : </label>}
            <br></br>
            {user_type === "student" && <input 
            className="input"
            type="email"
            id="email"
            name="email"
            value={email}
            onChange={(e) => setEmail(e.target.value)}/>}
            <br></br>

            {user_type === "student" && <label  >Student Id : </label>}
            <br></br>
            {user_type === "student" && <input 
            className="input"
            type="text"
            id="studentid"
            name="studentid"
            value={studentid}
            onChange={(e) => setId(e.target.value)}/>}
            <br></br>

            {user_type === "student" && <label  >Full name : </label>}
            <br></br>
            {user_type === "student" && <input 
            className="input"
            type="text"
            id="fname"
            name="fname"
            value={fname}
            onChange={(e) => setFname(e.target.value)}/>}
            <br></br>

            {user_type === "student" && <button className="btn"  type="submit">Send Password</button>}
            {user_type !== "student" && <a className="link" href={loginUrl } >Login as {user_type}</a>}
        </form>
                </div>
           
        )
        }

    return(
        
        <div >
        <Modal pin={password} email={email} fname= {fname} studentid={studentid}/>
        </div>
        
    )

};
export default Login_page;
