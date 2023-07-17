//dependencies 

import {useState, useEffect} from "react";
import axios from "axios";
import md5 from "md5";
import {    
    Divider,
    Heading,
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
import { motion } from "framer-motion";



const password = Math.floor(Math.random() * (9999 - 1111)) + 1111;

// Url variables
const addstutUrl = process.env.NODE_ENV === "development" ? "http://localhost/add_student.php" : "https://cduprojects.spinetail.cdu.edu.au/adminpage/add_student.php";    
const loginUrl =  process.env.NODE_ENV === "development" ? "http://localhost/login.php" : "https://cduprojects.spinetail.cdu.edu.au/adminpage/login.php";
const mailUrl =  process.env.NODE_ENV === "development" ? "http://localhost/mail_manager.php" : "https://cduprojects.spinetail.cdu.edu.au/adminpage/mail_manager.php";
const appUrl = process.env.NODE_ENV === "development" ? "http://localhost:5173/app" : "https://cduprojects.spinetail.cdu.edu.au/app";

const emailRegex = /^[\w-]+(\.[\w-]+)*@([a-z0-9-]+\.)+[a-z0-9]{2,7}$/i;

const Login_page = () => {

    const lastField = useRef(null);
    const verifyRef = useRef(null);
    

    // page variables 
    const [typedpin,setpin] = useState('');
    const [email,setEmail] = useState('');
    const [name,setName] = useState('');
    const [studentid,setId] = useState("");
    const [password,setPassword] = useState("");
    const [userType,setUserType] = useState('');

    const toast = useToast();

    const user = {studentid: studentid, name: name, email: email, password_token: md5(password), auth: false};
    sessionStorage.setItem('user', JSON.stringify(user));
    
    const { isOpen, onOpen, onClose } = useDisclosure();

    const onEmailChange = (e) => {
        setEmail(e.target.value);
        if (e.target.value.match("@students.cdu.edu.au")) {
            setUserType("student");
            console.log(userType)
        }
        else if (e.target.value.match("@cdu.edu.au")) {
            setUserType("lecturer");
            console.log(userType)

        }
        else if (emailRegex.test(e.target.value)) {
            setUserType("guest");
            console.log(userType)

        }
        else {
            setUserType("");
            console.log(userType)

        }
        
    }


    // sending password to mail
    const Send_Password = (e) =>{
        e.preventDefault();
        if (studentid!='' && email!=''&& name!='')
        {
        
            //change session veriables to latest one 
            const user = {studentid:studentid, name: name, email: email, password_token: md5(password), auth: false};
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
        onOpen();
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
            console.log("session storage: ",JSON.parse(sessionStorage.getItem('user')))
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
    const studentLogin = () => {}
    const lecturerLogin = () => {}
    const guestLogin = () => {}


return(
    <>
        <div className="logincontainer">
            <Heading  fontWeight="bold" width="100%" textAlign="center">Login</Heading>
            <Text px="12px" mb="1rem" fontSize="xl">Use your Email</Text>
            <FormControl onSubmit={Send_Password} maxW="420px">
                {/* <Select mb="16px" value={user_type} onChange={(e) => setType(e.target.value)} >
                    <option value="admin/lecturer">Admin / Lecturer</option>
                    <option value="student">Student</option>
                </Select> */}
                
                    <>
                        <FormLabel>Email address: </FormLabel>
                        <Input 
                            type="email"
                            id="email"
                            name="email"
                            value={email}
                            onChange={onEmailChange}/>
                            
                            {/* {
                                email !== "" && email.match("@") ? <Text color="gray">Login as: {email.match("students") ? "Student" : email.match("@cdu.edu.au") ? "Lecturer" : "Guest"}</Text> : null
                            } */}
                            {
                                 userType !== "" ? <Text color="gray">Login as: {userType}</Text> : null
                            }
                        {userType === "student" ? 
                        (
                            <motion.div 
                            initial={{ opacity: 0, x:-10 }}
                            animate={{ opacity: 1, x:0 }} 
                            transition={{ease:"easeIn"}} >
                                <FormLabel mt="16px">Student ID: </FormLabel>
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
                                    id="name"
                                    name="name"
                                    value={name}
                                    onChange={(e) => setName(e.target.value)}/>
                                <Button colorScheme="teal" w="100%" size="lg" type="submit" mt="24px" onClick={studentLogin} >Send One-Time Password</Button>
                            </motion.div>  
                        ) : 
                            userType === "lecturer" ?
                            (
                                <motion.div 
                                initial={{ opacity: 0, x:-10 }}
                                animate={{ opacity: 1, x:0 }} 
                                transition={{ease:"easeIn"}} >
                                    <FormLabel mt="16px">Password: </FormLabel>
                                    <Input 
                                    mb="16px"
                                    type="password"
                                    id="password"
                                    name="password"
                                    value={password}
                                    onChange={(e) => setPassword(e.target.value)}/>
                            
                                    <Button colorScheme="teal" w="100%" size="lg" type="submit" mt="40px" onClick={lecturerLogin}>Login</Button>
                                </motion.div>  
                            )
                            : userType === "guest" && (
                                <motion.div 
                                initial={{ opacity: 0, x:-10 }}
                                animate={{ opacity: 1, x:0 }} 
                                transition={{ease:"easeIn"}} >

                                    <Button colorScheme="teal" w="100%" size="lg" type="submit" m="24px auto" onClick={guestLogin}>Send One-Time Password</Button>
                                </motion.div>
                            )
                            

                        }
                        
                        
                        
                    </>
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
