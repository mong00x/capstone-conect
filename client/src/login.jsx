//dependencies 

import {useState, useEffect} from "react";
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
    useDisclosure,
    PinInput, 
    PinInputField,
    useToast, 
    HStack,
    Stack,
    Text,
    Button
} from "@chakra-ui/react";
import React, {useRef} from "react";

// file import
import "./login.css";



const password = Math.floor(Math.random() * (9999 - 1111)) + 1111;

// Url variables
const addstutUrl = process.env.NODE_ENV === "development" ? "http://localhost/add_student.php?x=" : "https://cduprojects.spinetail.cdu.edu.au/adminpage/add_student.php?x=";    
const loginUrl =  process.env.NODE_ENV === "development" ? "http://localhost/login.php" : "https://cduprojects.spinetail.cdu.edu.au/adminpage/login.php";
const mailUrl =  process.env.NODE_ENV === "development" ? "http://localhost/mail_manager.php" : "https://cduprojects.spinetail.cdu.edu.au/adminpage/mail_manager.php";
 



const Login_page = () => {
    // mail variables
    // useEffect(()=>{
    //     fetch(mailUrl)
    //     .then(response =>{
    //         if(response.ok)
    //         {
    //             return response.json()
    //         }
    //         throw response;
    //     })
    //     .then (res =>{
    //         sessionStorage.setItem('data', JSON.stringify(res));
    //         console.log(res)

    //     })
    //     .catch(error=>
    //         {
    //             console.error("error", error);

    //         })
    //     .finally(()=>{
    //         console.log("emailjs configure")
    //     })

    // },[]);

    const lastField = useRef(null);
    const verifyRef = useRef(null);
    const serviceID = "service_2qo1eeb"
    const templateID = "template_hbtmtbs"
    const publicKey = "WjagjhsUVM7RUWDft"
    

    // page variables 
    const [typedpin,setpin] = useState('');
    const [email,setEmail] = useState('');
    const [fname,setFname] = useState('');
    const [studentid,setId] = useState("");
    const [user_type,setType] = useState('student');

    const toast = useToast();

    const user = {studentid: studentid, name: fname, email: email, password_token: md5(password), auth: false};
    sessionStorage.setItem('user', JSON.stringify(user));
    
    const { isOpen, onOpen, onClose } = useDisclosure();

    // sending password to mail
    const Send_Password = (e) =>{
        e.preventDefault();
        if (studentid!='' && email!=''&& fname!='')
        {
        
            //change session veriables to latest one 
            const user = {studentid:studentid, name: fname, email: email, password_token: md5(password), auth: false};
            sessionStorage.setItem('user', JSON.stringify(user));
            console.log(JSON.parse(sessionStorage.getItem('user')));
            console.log(password)

            send_mail();
            onOpen();
        }
        else
        {
            toast({
                title: 'Empty field',
                description: "Do not leave any field empty",
                status: 'error',
                duration: 3000,
                isClosable: true,
                position: 'top-right'
              });
        }
        
        
       
    }
    function send_mail()
    {
        var templateParams = {
            email: email,
            password: password,
            name: fname
        };
        //sending mail
        //  emailjs.send(JSON.parse(sessionStorage.getItem('data')).serviceID, JSON.parse(sessionStorage.getItem('data')).templateID, templateParams, JSON.parse(sessionStorage.getItem('data')).publicKey )
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
        
        if (JSON.parse(sessionStorage.getItem('user')).password_token == md5(typedpin))
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
            toast({
                title: 'Wrong Code.',
                description: "Re-check the verification code.",
                status: 'error',
                duration: 3000,
                isClosable: true,
                position: 'top-right'
              })
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
        
        <Modal 
            closeOnOverlayClick={false} 
            blockScrollOnMount={false} 
            isOpen={isOpen} 
            onClose={onClose} 
            isCentered >
            <ModalOverlay />
            <ModalContent alignItems="center" >
                <ModalHeader>Confirm your verificaion code</ModalHeader>
                <ModalCloseButton />
                <ModalBody>
                    <Stack gap="24px">
                        <Stack>
                            <Text>A varification code has been send to: </Text>
                            <Text fontWeight="bold" >{email}</Text>
                        </Stack>
                        
                    
                        <HStack justifyContent="center">
                            <PinInput 
                                otp 
                                size="lg"
                                onChange={(e) => setpin(parseInt(e))}>
                                <PinInputField />
                                <PinInputField />
                                <PinInputField />
                                {/* when last field is entered, focus on the button */}
                                <PinInputField
                                    ref={lastField}
                                    onInput={() => {
                                        verifyRef.current.focus();}}

                                />

                            </PinInput>
                        </HStack>
                    </Stack>
                </ModalBody>

                <ModalFooter m="25px">
                <Button ref={verifyRef} id="varify" onClick={Verify} colorScheme="green" size="lg" w="256px"> Verify</Button>
                </ModalFooter>
            </ModalContent>
        </Modal>
        </>
        
    )

};
export default Login_page;
