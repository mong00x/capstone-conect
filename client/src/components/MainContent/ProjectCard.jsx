/* eslint-disable quotes */
import React, { useState, useEffect } from "react";
import PropTypes from "prop-types";
import { Flex, Text, Checkbox, Button, Badge } from "@chakra-ui/react";

import useStore from "../../store";

const ProjectCard = ({ project }) => {
  // useeffect to store listen if checked, create a new Rank once checked and remove a rank if unchecked

  const [checked, setChecked] = useState(false);
  const description =
    project.description && project.description.toString().slice(0, 110) + "...";
  const Rank = useStore((state) => state.Rank);

  useEffect(() => {
    //useEffect that listens to the ranks array in the store and if the project is not in the ranks array, then setChecked to false
    if (!Rank.some((e) => e.id === project.id)) {
      setChecked(false);
    }
  }, [Rank]);

  const addRank = useStore((state) => state.addRank); // addRank is a function that takes in a project and adds it to the ranks array in the store (global state)
  const removeRank = useStore((state) => state.removeRank);
  //when rank is removed, the check also needs to be removed, how to do this? maybe a

  const handleCheck = (e) => {
    setChecked(e.target.checked);
    if (e.target.checked) {
      addRank(project.id, project.topic, project.supervisors);
    } else {
      removeRank(project.id);
    }
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
          <Checkbox
            size="lg"
            borderColor="#888"
            checked={checked}
            onChange={handleCheck}
          >
            <Text fontSize="1rem" fontWeight="bold" lineHeight={6}>
              {project.topic}
            </Text>
          </Checkbox>
        </Flex>
        {/* regex to lookup first 2 sentence in description  */}
        <Text>{description}</Text>
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

ProjectCard.propTypes = {
  project: PropTypes.object.isRequired,
};

export default ProjectCard;
