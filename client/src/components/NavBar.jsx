import React from "react";
import { Box, Text, useMediaQuery } from "@chakra-ui/react";

const NavBar = () => {
  const [isLargerThan768] = useMediaQuery("(min-width: 768px)")
  return (
    <>
    {
      isLargerThan768 ? (
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
      </Box>) 
      : (<Box
      m="auto"
      w="100%"
      diplay="flex"
      justifyContent="center"
      textAlign="center"
      px="1rem"
      py="0.5rem"
      bg="BG"
    >
      <Text fontSize="xl" fontWeight="bold" width="auto" cursor="default" underline="solid">
        Capstone Connect
      </Text>
    </Box>)}
    </>
  );
    
};

export default NavBar;
