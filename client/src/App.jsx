import "./App.css";
import React from "react";
import { QueryClient, QueryClientProvider } from "@tanstack/react-query";
import { ReactQueryDevtools } from "@tanstack/react-query-devtools";
import {  
  Flex,   
  Modal,
  Button,
  ModalOverlay,
  ModalContent,
  ModalHeader,
  ModalFooter,
  ModalBody,
  ModalCloseButton,
  useDisclosure,
  Text
} from "@chakra-ui/react";
import NavBar from "./components/NavBar";
import SideMenu from "./components/SideMenu/SideMenu";
import MainContent from "./components/MainContent/MainContent";

const queryClient = new QueryClient();

function App() {
  const redirectUrl = process.env.NODE_ENV === "development" ? "http://localhost:5173" : "https://cduprojects.spinetail.cdu.edu.au";
  if(JSON.parse(sessionStorage.getItem('user')) == null || JSON.parse(sessionStorage.getItem('user')).auth == false)
  {
    location.replace(redirectUrl)
  }
  const { isOpen, onOpen, onClose } = useDisclosure()
  const [firstTime, setFirstTime] = React.useState(true)

  React.useEffect(() => {
    if(firstTime)
    {
      onOpen()
      setFirstTime(false)
    }
  }, [firstTime])


  
  return (
    <Flex
      className="App"
      display="flex"
      flexDir="column"
      height="100%"
      overflow="hidden"
    >
      <NavBar />
      <QueryClientProvider client={queryClient}>
        <Flex flexDir="row" wdith="100%" height="100%">
          <SideMenu />
          <MainContent />
        </Flex>
        <ReactQueryDevtools initialIsOpen={false} />
      </QueryClientProvider>
      <Modal blockScrollOnMount={false} isOpen={isOpen} onClose={onClose} isCentered>
        <ModalOverlay />
        <ModalContent>
          <ModalHeader>Welcome to HIT 401 Capstone Project</ModalHeader>
          <ModalCloseButton />
          <ModalBody>
            <Text fontWeight='bold' mb='1rem'>
              you can view and select your top 3 projects. Please select carefully as you will not be able to change your selection after. 
            </Text>
          </ModalBody>

          <ModalFooter>
            <Button colorScheme='blue' mr={3} onClick={onClose}>
              OK
            </Button>
          </ModalFooter>
        </ModalContent>
      </Modal>
    </Flex>
  );
}

export default App;
