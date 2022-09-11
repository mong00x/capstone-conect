import React from "react";
import { Box, Flex, Text } from "@chakra-ui/react";

const NavBar = () => {
  return (
    <Box bg="BG" shadow="md">
      <Box
        m="auto"
        w="100%"
        maxW={1440}
        diplay="flex"
        justifyContent="space-between"
        px="1rem"
        py="0.5rem"
      >
        <Text fontSize="2xl" fontWeight="bold" width="auto">
          Capstone project
        </Text>
      </Box>
    </Box>
  );
};

export default NavBar;
