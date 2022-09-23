/* eslint-disable quotes */
import React, { useState, useEffect } from "react";
import PropTypes from "prop-types";
import { Flex, Text, Checkbox, Button, Badge } from "@chakra-ui/react";

import useStore from "../../store";

const ProjectCard = ({ project }) => {
  const [checked, setChecked] = useState(false);
  const description =
    project.project_description &&
    project.project_description.toString().slice(0, 110) + "...";

  // useEffect(() => {
  //   if (!Rank.some((e) => e.id === project.project_id)) {
  //     setChecked(false);
  //   }
  // }, [Rank]);

  const addRank = useStore((state) => state.addRank);
  const removeRank = useStore((state) => state.removeRank);

  const handleCheck = (e) => {
    setChecked(e.target.checked);
    if (e.target.checked) {
      addRank(
        project.project_id,
        project.project_topic,
        project.project_supervisors
      );
    } else {
      removeRank(project.project_id);
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
      transition="all .3s ease"
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
              {project.project_topic}
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
          {project.project_discipline &&
            project.project_discipline.map((project_discipline) => (
              <Badge key={project_discipline} borderRadius="full" px="2">
                {project_discipline}
              </Badge>
            ))}
        </Flex>
        <Flex flexDir="column" flexWrap="wrap" gap={1}>
          {project.project_supervisors &&
            project.project_supervisors.map((project_supervisors) => (
              <Text key={project_supervisors} fontSize="sm">
                {project_supervisors}
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
