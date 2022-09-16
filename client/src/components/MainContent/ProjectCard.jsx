import React, { useState } from "react";
import {
  Flex,
  Box,
  Text,
  Checkbox,
  useCheckbox,
  Button,
  Badge,
} from "@chakra-ui/react";

const ProjectCard = ({ id }) => {
  const [checked, setChecked] = useState(false);
  const handleCheck = (e) => {
    setChecked(e.target.checked);
    // save checked card id to store
    if (e.target.checked) {
      // add to store
    } else {
      // remove from store
    }
    console.log(localStorage);
  };
  return (
    <Flex
      flexDir="column"
      p="16px"
      gap="20px"
      height="400px"
      w="100%"
      borderRadius={12}
      bg="BG"
      justifyContent="space-between"
      border="3px inset #E2E8F0"
      borderColor={checked ? "AccentMain.default" : "transparent"}
    >
      <Flex flexDir="column" gap={2}>
        <Flex flexDir="row" justifyContent="space-between" alignItems="center">
          <Checkbox size="lg" borderColor="#888" onChange={handleCheck} id={id}>
            <Text fontSize="1.2rem" fontWeight="bold" lineHeight={6}>
              Machine learning approaches for Cyber Security
            </Text>
          </Checkbox>
        </Flex>
        <Text>
          As we use internet more, the data produced by us is enormous. But are
          these data being secure? The goal of applying machine learning or
          intelligence is to better ...
        </Text>
        <Flex flexDir="row" justifyContent="flex-end" alignItems="center">
          <Button size="sm" bg="none">
            Read more
          </Button>
        </Flex>
      </Flex>

      <Flex flexDir="column" gap={4}>
        <Flex flexDir="row" gap={1} flexWrap="wrap">
          <Badge>CS</Badge>
          <Badge>IS&DS</Badge>
          <Badge>SE</Badge>
          <Badge>Internal</Badge>
          <Badge>External</Badge>
        </Flex>
        <Flex flexDir="column" flexWrap="wrap" gap={1}>
          <Text fontSize="sm">Dr. Bharanidharan Shanmugam</Text>
          <Text fontSize="sm">Dr. Sami Azam</Text>
        </Flex>
      </Flex>
    </Flex>
  );
};

export default ProjectCard;
