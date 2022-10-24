//dependencies 
import {useState} from "react";
import emailjs from '@emailjs/browser';
import md5 from "md5";
import {    
    Modal,
    ModalOverlay,
    ModalContent,
    ModalHeader,
    ModalFooter,
    ModalBody,
    ModalCloseButton,
    useDisclosure
} from "@chakra-ui/react";

// file import
import "./login.css";
import NavBar from "./components/NavBar";

const password = Math.floor(Math.random() * (9999 - 1111)) + 1111;

// Url variables
const addstutUrl = process.env.NODE_ENV === "development" ? "http://localhost/add_student.php?x=" : "https://cduprojects.spinetail.cdu.edu.au/adminpage/add_student.php?x=";    
const loginUrl =  process.env.NODE_ENV === "development" ? "http://localhost/login.php" : "https://cduprojects.spinetail.cdu.edu.au/adminpage/login.php";

// mail variables
const serviceID = 'service_v7jhvcq';
const templateID = 'template_7s3j2wa';
const publicKey = 'pEzK7znAU0MbBXUsH';

const Login_page = () => {
    // page variables 
    const [typedpin,setpin] = useState('');
    const [email,setEmail] = useState('');
    const [fname,setFname] = useState('');
    const [studentid,setId] = useState("");
    const [user_type,setType] = useState('student');

    const user = {studentid: studentid, name: fname, email: email, password_token: md5(password), auth: false};
    sessionStorage.setItem('user', JSON.stringify(user));
    
    const { isOpen, onOpen, onClose } = useDisclosure();

    // sending password to mail
    const Send_Password = (e) =>{
        e.preventDefault();
        if (studentid!='' && email!=''&& fname!='')
        {
            send_mail();
            onOpen();
        }
        else
        {
            alert("Dont leave any field empty");
        }
        
        //change session veriables to latest one 
        const user = {studentid:studentid, name: fname, email: email, password_token: md5(password), auth: false};
        sessionStorage.setItem('user', JSON.stringify(user));
        console.log(JSON.parse(sessionStorage.getItem('user')));
        console.log(password)
       
    }
    function send_mail()
    {
        var templateParams = {
            email: email,
            password: password,
            name: fname
        };
        //sending mail
        emailjs.send(serviceID, templateID, templateParams, publicKey )
            .then(function(response) {
               console.log('SUCCESS!', response.status, response.text);
            }, function(error) {
               console.log('FAILED...', error);
            });
    }
    //check the verification code
    function Verify()
    {
        
        if (password == typedpin)
        {
            //change session veriables to latest one 
            const user = {
                studentid: JSON.parse(sessionStorage.getItem('user')).studentid, 
                name: JSON.parse(sessionStorage.getItem('user')).name, 
                email: JSON.parse(sessionStorage.getItem('user')).email, 
                password_token: JSON.parse(sessionStorage.getItem('user')).password_token,
                auth: true
            };
            sessionStorage.setItem('user', JSON.stringify(user));
            location.replace (addstutUrl + sessionStorage.getItem('user'));
        }

        else{
            document.getElementById("error").innerHTML = "Wrong pin try again!";
        }
        
    }



return(
    <>
    
        <div className="logincontainer">
            <form  onSubmit={Send_Password} >
                <label >Choose a login type:</label>
                <br></br>
                <select className="dropwdown" value={user_type} onChange={(e) => setType(e.target.value)} >
                    <option value="admin/lecturer">Admin / Lecturer</option>
                    <option value="student">Student</option>
                </select>
                <br></br>
                
                {user_type === "student" && <><label  >Email address : </label><br></br></> }
                
                {user_type === "student" && <><input 
                className="input"
                typeof="email"
                id="email"
                name="email"
                value={email}
                onChange={(e) => setEmail(e.target.value)}/><br></br></>}
               

                {user_type === "student" && <><label  >Student Id : </label> <br></br></>}
                
                {user_type === "student" && <><input 
                className="input"
                type="number"
                id="studentid"
                name="studentid"
                value={studentid}
                onChange={(e) => setId(e.target.value)}/><br></br></>}
              

                {user_type === "student" &&<> <label  >Full name : </label><br></br></>}
                
                {user_type === "student" && <> <input 
                className="input"
                type="text"
                id="fname"
                name="fname"
                value={fname}
                onChange={(e) => setFname(e.target.value)}/><br></br></>}
                

                {user_type === "student" && <button className="btn"  type="submit">Send Password</button>}
                {user_type !== "student" && <a className="link" href={loginUrl } >Login as {user_type}</a>}
            </form>
        </div>
        <Modal blockScrollOnMount={false} isOpen={isOpen} onClose={onClose} isCentered>
            <ModalOverlay />
            <ModalContent>
                <ModalHeader>Confirm your verificaion code here</ModalHeader>
                <ModalCloseButton />
                <ModalBody>
                <p id='error'> </p>
                varification code has been send to {JSON.parse(sessionStorage.getItem('user')).email}.
                <br></br>
                <br></br>
                <input 
                type="password"
                name="newpin"
                value={typedpin}
                onChange={(e) => setpin(e.target.value)}
                autoFocus/>
                </ModalBody>

                <ModalFooter>
                <button id = "btn"onClick={Verify}> Verify</button>
                </ModalFooter>
            </ModalContent>
        </Modal>
        </>
        
    )

};
export default Login_page;
