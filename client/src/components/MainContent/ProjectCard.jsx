import React from "react";
import { Flex, Box, Text, Checkbox, Button, Badge } from "@chakra-ui/react";

const ProjectCard = () => {
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
    >
      <Flex flexDir="column" gap={2}>
        <Flex flexDir="row" justifyContent="space-between" alignItems="center">
          <Checkbox size="lg" borderColor="#888">
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
          <Button size="sm">Read more</Button>
        </Flex>
      </Flex>

      <Flex flexDir="column" gap={2}>
        <Flex flexDir="row" gap={2} flexWrap="wrap">
          <Badge>CS</Badge>
          <Badge>IS&DS</Badge>
          <Badge>SE</Badge>
          <Badge>Internal</Badge>
          <Badge>External</Badge>
        </Flex>
        <Flex flexDir="row" flexWrap="wrap">
          <Text>Dr. Bharanidharan Shanmugam</Text>
          <Text>Dr. Sami Azam</Text>
        </Flex>
      </Flex>
    </Flex>
  );
};

export default ProjectCard;
