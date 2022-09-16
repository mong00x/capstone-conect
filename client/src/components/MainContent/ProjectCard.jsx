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

const ProjectCard = ({ project }) => {
  const [checked, setChecked] = useState(false);
  const abstraction =
    project.description && project.description.toString().slice(0, 110) + "...";
  console.log(project.keywords && project.keywords[0]);
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
      height="420px"
      w="100%"
      borderRadius={12}
      bg="BG"
      justifyContent="space-between"
      border="3px inset #E2E8F0"
      borderColor={checked ? "AccentMain.default" : "transparent"}
    >
      <Flex flexDir="column" gap={2}>
        <Flex
          flexDir="row"
          justifyContent="space-between"
          alignItems="flex-start"
          minH="50px"
        >
          <Checkbox size="lg" borderColor="#888" onChange={handleCheck}>
            <Text fontSize="1rem" fontWeight="bold" lineHeight={6}>
              {project.topic}
            </Text>
          </Checkbox>
        </Flex>
        {/* regex to lookup first 2 sentence in description  */}
        <Text>{abstraction}</Text>
        <Flex flexDir="row" justifyContent="flex-end" alignItems="center">
          <Button size="sm" bg="none">
            Read more
          </Button>
        </Flex>
      </Flex>

      <Flex flexDir="column" gap={4}>
        <Flex flexDir="row" gap={2} flexWrap="wrap">
          {project.keywords.map((keyword) => (
            <Badge key={keyword} borderRadius="full" px="2">
              {keyword}
            </Badge>
          ))}
        </Flex>
        <Flex flexDir="column" flexWrap="wrap" gap={1}>
          {project.supervisors.map((supervisor) => (
            <Text key={supervisor} fontSize="sm">
              {supervisor}
            </Text>
          ))}
        </Flex>
      </Flex>
    </Flex>
  );
};

export default ProjectCard;
