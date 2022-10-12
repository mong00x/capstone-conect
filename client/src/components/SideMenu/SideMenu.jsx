import React, {useState} from "react";
import { Box, Flex, Text, Button,
  Modal,
  ModalOverlay,
  ModalContent,
  ModalHeader,
  ModalFooter,
  ModalBody,
  ModalCloseButton,
  useDisclosure,
  Checkbox
} from '@chakra-ui/react' 

// drag and drop stuff
import Container from "./Container";
import { DndProvider } from "react-dnd";
import { HTML5Backend } from "react-dnd-html5-backend";
import { useStore,cardStore } from "../../store";

const SideMenu = () => {
  const { isOpen, onOpen, onClose } = useDisclosure()
  const [checked, setChecked] = useState(false)
  

  const Rank = useStore((state) => state.Rank);
  const gloCard = cardStore((state) => state.card);
  return (
    <Flex
      w="380px"
      bg="BG"
      color="DarkShades"
      flexDirection="column"
      borderRight="1px solid #E2E8F0"
      justifyContent="space-between"
      height="90%"
    >
      <Flex flexDir="column">
        <Box p="1rem" bg="DarkShades" textAlign="center" width="100%">
          <Text fontSize="1rem" fontWeight="bold" color="LightShades">
            My selections {Rank.length}/3
          </Text>
        </Box>
        <Box p="1rem">
          <Text>Please select up to 3 projects</Text>
          <Text>Drag to rank</Text>

          <DndProvider backend={HTML5Backend}>
            <Container />
          </DndProvider>
        </Box>
      </Flex>

        <Button 
          className="submit-btn"
          mx="1rem"
          bg="AccentMain.default"
          colorScheme="purple"
          onClick={onOpen}
          disabled={Rank.length < 3}
        >
          Submit
        </Button>

        <Modal isOpen={isOpen} onClose={onClose}>
        <ModalOverlay />
        <ModalContent>
          <ModalHeader fontSize={24}>Submit your project selection</ModalHeader>
          <ModalCloseButton />
          <ModalBody>
            <Flex flexDir="column" gap={5} mt={6}>
            { gloCard.map((item) => (

              <Box key={item.id}>
                <Flex flexDir="row" alignItems="center" gap={3}>
                  <Flex bg="DarkShades" minW="27px" minH="27px" borderRadius="100" justifyContent="center" alignItems="center" textAlign="center">
                  <Text color="LightShades" fontWeight="bold" mb="3px" ml="1px">{gloCard.indexOf(item) + 1}</Text>

                  </Flex>
                  <Text fontWeight="bold" lineHeight="20px">{item.topic}</Text>

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
            

          </ModalBody>

          <ModalFooter mt={8}>
            <Button mr={3} onClick={null} colorScheme="purple">
              Confirm and Submit
            </Button>
            <Button variant='ghost' onClick={onClose} >Cancel</Button>
          </ModalFooter>
        </ModalContent>
      </Modal>

    </Flex>
  );
};

export default SideMenu;
