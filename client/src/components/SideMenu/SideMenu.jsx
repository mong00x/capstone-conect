import React, { useState } from "react";
import { Box, Flex, Text, Button } from "@chakra-ui/react";

// drag and drop stuff
import Example from "./Example";
import { DndProvider } from "react-dnd";
import { HTML5Backend } from "react-dnd-html5-backend";

const SideMenu = () => {
  // get state student name from store
  const [studentName, setStudentName] = useState("John Doe");

  return (
    <Flex
      minW="240px"
      height="100%"
      bg="BG"
      color="DarsShades"
      flexDirection="column"
    >
      <Box py="2rem" bg="DarkShades" textAlign="center">
        {/* avatar */}
        <Text fontSize="1rem" fontWeight="bold" color="LightShades">
          Hi, {studentName}
        </Text>
      </Box>
      <Box mt="2rem" p="1rem">
        <DndProvider backend={HTML5Backend}>
          <Example />
        </DndProvider>
      </Box>

      <Button m="1rem">Submit</Button>
    </Flex>
  );
};

export default SideMenu;
