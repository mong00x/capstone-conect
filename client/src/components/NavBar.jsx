import React from "react";
import { Box, Flex, Text } from "@chakra-ui/react";

const NavBar = () => {
  return (
    <Box
      m="auto"
      w="100%"
      diplay="flex"
      justifyContent="space-between"
      px="1rem"
      py="0.5rem"
      border="1px"
      borderColor="#ddd"
      bg="BG"
    >
      <Text fontSize="2xl" fontWeight="bold" width="auto">
        Capstone project
      </Text>
    </Box>
  );
};

export default NavBar;
