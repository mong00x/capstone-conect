import React from "react";
import { Box, Text } from "@chakra-ui/react";

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
      <Text fontSize="xl" fontWeight="bold" width="auto" cursor="default" underline="solid">
        Capstone Connect
      </Text>
    </Box>
  );
};

export default NavBar;
