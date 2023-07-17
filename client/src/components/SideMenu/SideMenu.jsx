import React, {useState, useEffect, useRef} from "react";
import { 
  Box, 
  Flex, 
  Text, 
  Button,
  CloseButton,
  Alert,
  AlertTitle,
  AlertDescription,
  ScaleFade,
  Modal,
  ModalOverlay,
  ModalContent,
  ModalHeader,
  ModalFooter,
  ModalBody,
  useDisclosure,
  Stack,
  CircularProgress,
  CircularProgressLabel,

} from '@chakra-ui/react' 
import { CheckCircleIcon, WarningIcon  } from "@chakra-ui/icons";
import axios from "axios";

// drag and drop stuff
import Container from "./Container";
import { DndProvider } from "react-dnd";
import { HTML5Backend } from "react-dnd-html5-backend";
import { useStore,cardStore } from "../../store";

const SideMenu = () => {
  const submitModal = useDisclosure()
  const initialRef = useRef(null)
  const {
    isOpen: isVisible,
    onClose,
    onOpen,
  } = useDisclosure({ defaultIsOpen: false })
  const {
    isOpen: isAlertOpen,
    onClose: onAlertClose,
    onOpen: onAlertOpen,
  } = useDisclosure({ defaultIsOpen: false })
  const [isSubmitted, setIsSubmitted] = useState(false);

  const postUrl = process.env.NODE_ENV === "development" ? "http://localhost/add_project_register.php" : "https://cduprojects.spinetail.cdu.edu.au/adminpage/add_project_register.php";

  const Rank = useStore((state) => state.Rank);
  const gloCard = cardStore((state) => state.card);

  useEffect(() => {
    Rank.length === 3 ?  onAlertOpen() : onAlertClose();
  }, [Rank]);
  const handleSubmit = () => {
    // post the data to the database
    console.log("submit");

    gloCard.map(
      (card) => {
        axios.post(postUrl, JSON.stringify({
          student_id: JSON.parse(sessionStorage.getItem("user")).studentid,
          project_id: card.id,
          project_ranking: gloCard.indexOf(card) + 1,
          approve: gloCard.indexOf(card) === 0 ? 0 : null,
        }))
        .then((res) => {
          console.log("res", res.data);
        })
        .catch((err) => {
          console.log("err", err);
        });
      }
    )
      onOpen()
      setIsSubmitted(true);
      
  };

  // useEffect(() => {
  //   if (Rank.length === 3) {
  //     toast({
  //       title: 'You have selected your 3 projects.',
  //       description: 'You can now drag to rank them before submision. Project that is ranked higher will be prioritised.',
  //       status: 'success',
  //       duration: 9000,
  //       isClosable: true,
  //       position:"bottom",
  //       containerStyle: {
  //         mb:"28px",
  //         maxWidth: '30%',
  //       }
  //     })
  //   }

  // }, [Rank]);

useEffect(()=>{
  if(isSubmitted){
    setTimeout(()=>{
      window.location.href="https://sage-tapioca-de39e4.netlify.app/"
    }, 20000)
  }
})

 

  return (
    <Flex
      w="400px"
      height="95vh"
      pb={7}
      bg="BG"
      color="DarkShades"
      flexDirection="column"
      borderRight="1px solid #E2E8F0"
      justifyContent="space-between"
    >
      <Flex flexDir="column">
        <Box p="1rem" bg="DarkShades" textAlign="center" width="100%">
          <Text fontSize="1rem" fontWeight="bold" color="LightShades">
            <Stack direction="row" spacing={2} align="center">
              <Text>Please select up to 3 projects</Text>

              <CircularProgress value={Rank.length*33.333} color="#9747FF">
                <CircularProgressLabel>{Rank.length}/3</CircularProgressLabel>
              </CircularProgress>
            </Stack>
          
          </Text>
        </Box>
        {isAlertOpen && 
          <Alert status='info' colorScheme="purple">
            You can now drag to rank your projects before submision. Project that is ranked higher will be prioritised.
            <CloseButton
              alignSelf='flex-start'
              position='relative'
              right={-1}
              top={-1}
              onClick={onAlertClose}
            />
        </Alert>
          }
        <Box p="1rem">
          

          <DndProvider backend={HTML5Backend}>
            <Container />
          </DndProvider>
        </Box>
      </Flex>

        <Button 
          className="submit-btn"
          mx="1rem"
          colorScheme="purple"
          onClick={submitModal.onOpen}
          disabled={Rank.length < 3 || isSubmitted === true }
          
        >
          Submit
        </Button>

        <Modal 
          initialFocusRef={initialRef}
          isOpen={submitModal.isOpen} 
          onClose={submitModal.onClose} 
          closeOnOverlayClick={false} 
          size="xl">
        <ModalOverlay
      bg={isSubmitted ? 'blackAlpha.400' : 'blackAlpha.300'}
      backdropFilter={isSubmitted && 'blur(8px)'}
    />
        <ModalContent>
          <ModalHeader fontSize={24} >Submit your Aplication</ModalHeader>
          {/* <ModalCloseButton ref={initialRef}/> */}
          <ModalBody>
            {isVisible ? 
            (
              <ScaleFade initialScale={0.9} in={isVisible}> 
                <Alert
                  status='success'
                  variant='subtle'
                  flexDirection='column'
                  alignItems='center'
                  justifyContent='center'
                  textAlign='center'
                  height='280px'
                >
                <CheckCircleIcon boxSize='40px' mr={0} color="green.500"/>
                <AlertTitle mt={4} mb={1} fontSize='lg'>
                  Application submitted!
                </AlertTitle>
                <AlertDescription maxWidth='md' whiteSpace="normal">
                  Thanks for submitting your application. Your application will be responded within a few days. 
                  Please check your email for further information.
                </AlertDescription>
              </Alert>
              <br/>
              <Text fontSize="xl" fontWeight="bold">You can close the window now, or you will be redirected to the home page in 20 seconds
              </Text>

            </ScaleFade>
          ):
          (
            <>
            <Flex flexDir="column" gap={2} mt={6}>
            { gloCard.map((item) => (

              <Box key={item.id}  borderRadius={5} py={4} px={2} bg="gray.100" color="DarkShades">
                <Flex flexDir="row" alignItems="flex-start" gap={3}>
                  <Flex bg="DarkShades" minW="2rem"minH="2rem" borderRadius="100" justifyContent="center" alignItems="center" textAlign="center">
                    <Text color="LightShades" fontWeight="bold">
                      {gloCard.indexOf(item) + 1}
                    </Text>
                  </Flex>
                  <Flex flexDir="column" gap={4}>

                    <Text fontWeight="bold" lineHeight="20px">{item.topic}</Text>

                    <Flex flexDir="row" gap={1} flexWrap="wrap" alignItems="center" >
                      <Stack direction="row" alignItems="center" mr={4}>
                        <Text fontWeight="bold"  lineHeight="20px" >{item.lecturer.name}</Text>

                      </Stack>
                      <Stack direction="row" alignItems="center">
                        <Text lineHeight="20px">{item.lecturer2.name}</Text>
                      </Stack>
                    </Flex>
                  </Flex>
                
                </Flex>
              </Box>
              )
            )}
            </Flex>
            <Flex gap={1} flexDir="column" mt={10}>
              {window &&  <Text>Submit as: <b >{JSON.parse(sessionStorage.getItem("user")).name}</b></Text>}
              {window &&  <Text>Email: <b>{JSON.parse(sessionStorage.getItem("user")).email}</b></Text>}
            </Flex>

            <Flex flexDir="column" gap={2} mt={8}>
              <Text>
              Your supervisor will be informed of your application. 
              </Text>
              <Text>
              Once your application is approved, you will receive an email notification. Please pay attemtion to your mailbox. 

              </Text>
              
            </Flex>
            </>
          )}
            

          </ModalBody>

          <ModalFooter mt={8}>
            {
              !isSubmitted&&
              <>
                <Button mr={3} onClick={handleSubmit} colorScheme="purple">
                  Confirm and Submit
                </Button>
                <Button variant='ghost' onClick={submitModal.onClose} >
                  Cancel
                </Button>
              </>
             }
          </ModalFooter>
        </ModalContent>
      </Modal>

    </Flex>
  );
};

export default SideMenu;
