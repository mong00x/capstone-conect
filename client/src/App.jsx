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
      // settimeout is used to prevent the modal from opening on page load
      setTimeout(() => {
        onOpen()
        setFirstTime(false)
      }, 1000);
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
      
      <QueryClientProvider client={queryClient}>
        <Flex flexDir="row" wdith="100%" height="100%">
          <SideMenu />
          <MainContent />
        </Flex>
        <ReactQueryDevtools initialIsOpen={false} />
      </QueryClientProvider>
      <Modal blockScrollOnMount={false} isOpen={isOpen} onClose={onClose} isCentered size="xl">
        <ModalOverlay />
        <ModalContent>
          <ModalHeader>👋Welcome to Capstone Connect!</ModalHeader>
          <ModalCloseButton />
          <ModalBody>
            <Text mb='1rem'>
            You can view and select the 3 projects you most want to apply for.
            </Text>
            <Text mb='1rem'>
            Please choose carefully, once the application is submitted it cannot be changed.
            </Text>
          </ModalBody>

          <ModalFooter>
            <Button colorScheme='purple' mr={3} onClick={onClose} width="auto">
              OK
            </Button>
          </ModalFooter>
        </ModalContent>
      </Modal>
    </Flex>
  );
}

export default App;
