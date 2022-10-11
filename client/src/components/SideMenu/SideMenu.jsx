import React from "react";
import { Box, Flex, Text, Button } from "@chakra-ui/react";

// drag and drop stuff
import Container from "./Container";
import { DndProvider } from "react-dnd";
import { HTML5Backend } from "react-dnd-html5-backend";
import { useStore } from "../../store";

const SideMenu = () => {
  const Rank = useStore((state) => state.Rank);
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
          <Text>Your selections will appear here</Text>
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
        >
          Submit
        </Button>
      

    </Flex>
  );
};

export default SideMenu;
