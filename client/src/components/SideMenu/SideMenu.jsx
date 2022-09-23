import React from "react";
import { Box, Flex, Text, Button } from "@chakra-ui/react";

// drag and drop stuff
import Container from "./Container";
import { DndProvider } from "react-dnd";
import { HTML5Backend } from "react-dnd-html5-backend";

const SideMenu = () => {
  return (
    <Flex
      w="380px"
      maxH="90%"
      overflow="hidden"
      bg="BG"
      color="DarsShades"
      flexDirection="column"
      borderRight="1px solid #E2E8F0"
      justifyContent="space-between"
    >
      <Flex flexDir="column">
        <Box p="1rem" bg="DarkShades" textAlign="center" width="100%">
          <Text fontSize="1rem" fontWeight="bold" color="LightShades">
            My selections
          </Text>
        </Box>
        <Box p="1rem">
          <DndProvider backend={HTML5Backend}>
            <Container />
          </DndProvider>
        </Box>
      </Flex>

      <Button
        className="submit-btn"
        mx="1rem"
        bg="AccentMain.default"
        color="LightShades"
        borderRadius={50}
      >
        Submit
      </Button>
    </Flex>
  );
};

export default SideMenu;
