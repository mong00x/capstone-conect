//dependencies 

import {useState, useEffect} from "react";
import axios from "axios";
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
    Button,
    FormControl,
    FormLabel,
    FormErrorMessage,
    FormHelperText,
    Select,
    Input
} from "@chakra-ui/react";
import React, {useRef} from "react";

// file import
import "./login.css";



const password = Math.floor(Math.random() * (9999 - 1111)) + 1111;

// Url variables
const addstutUrl = process.env.NODE_ENV === "development" ? "http://localhost/add_student.php?x=" : "https://cduprojects.spinetail.cdu.edu.au/adminpage/add_student.php?x=";    
const loginUrl =  process.env.NODE_ENV === "development" ? "http://localhost/login.php" : "https://cduprojects.spinetail.cdu.edu.au/adminpage/login.php";
const mailUrl =  process.env.NODE_ENV === "development" ? "http://localhost/mail_manager.php" : "https://cduprojects.spinetail.cdu.edu.au/adminpage/mail_manager.php";
const appUrl = process.env.NODE_ENV === "development" ? "http://localhost:5173/app" : "https://cduprojects.spinetail.cdu.edu.au/app";


const Login_page = () => {

    const lastField = useRef(null);
    const verifyRef = useRef(null);
    

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

    //send mail
    function send_mail()
    {
       
        axios.post(mailUrl, JSON.stringify({
            name: JSON.parse(sessionStorage.getItem("user")).name,
            student_email: JSON.parse(sessionStorage.getItem('user')).email,
            student_id: JSON.parse(sessionStorage.getItem('user')).studentid,
            password: password
          }))
          .then((res) => {
            if (res.data.success == 0)
            {  
                toast({
                    title: 'Error',
                    description: res.data.msg,
                    status: 'error',
                    duration: 2000,
                    isClosable: true,
                    position: 'top-right'
                  }) 
            }
            else
            {
                onOpen();

            }
          })
          .catch((err) => {
            console.log("err", err);
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
            axios.post(addstutUrl, JSON.stringify({
                name: JSON.parse(sessionStorage.getItem("user")).name,
                student_id: JSON.parse(sessionStorage.getItem('user')).studentid,
                student_email: JSON.parse(sessionStorage.getItem('user')).email,
                password: JSON.parse(sessionStorage.getItem('user')).password_token
              }))
              .then((res) => {
                console.log("res", res.data);
                
              })
              .catch((err) => {
                console.log("err", err);
              });
              location.replace(appUrl);
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
            <Text fontSize="3xl" fontWeight="bold" mb="32px" alignSelf="left">Login</Text>
            <FormControl  onSubmit={Send_Password} maxW="420px">
                <FormLabel >Choose a login type:</FormLabel>
                <Select mb="16px" value={user_type} onChange={(e) => setType(e.target.value)} >
                    <option value="admin/lecturer">Admin / Lecturer</option>
                    <option value="student">Student</option>
                </Select>
                {user_type === "student" ?
                    <>
                        <FormLabel>Email address: </FormLabel>
                        <Input 
                            mb="16px"
                            type="email"
                            id="email"
                            name="email"
                            value={email}
                            onChange={(e) => setEmail(e.target.value)}/>
                        <FormLabel>Student ID: </FormLabel>
                        <Input 
                            mb="16px"
                            type="number"
                            id="studentid"
                            name="studentid"
                            value={studentid}
                            onChange={(e) => setId(parseInt(e.target.value))}/>
                        <FormLabel>Full name: </FormLabel>
                        <Input 
                            mb="32px"
                            type="text"
                            id="fname"
                            name="fname"
                            value={fname}
                            onChange={(e) => setFname(e.target.value)}/>
                        <Button colorScheme="green" w="100%" size="lg" type="submit" m="auto" onClick={Send_Password} >Send One-Time Password</Button>

                    </>
                 :
                 <Button colorScheme="green" w="100%" size="lg" mt="32px">
                    <a  href={loginUrl } >Login as {user_type}</a>
                 </Button>
                 }
            </FormControl>
        </div>
        
        <Modal 
            closeOnOverlayClick={false} 
            blockScrollOnMount={false} 
            isOpen={isOpen} 
            onClose={onClose} 
            isCentered >
            <ModalOverlay />
            <ModalContent alignItems="center" >
                <ModalHeader>Confirm your One-Time Password</ModalHeader>
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
