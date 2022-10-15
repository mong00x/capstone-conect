/* eslint-disable quotes */
import React, { useState, useRef } from "react";
import PropTypes from "prop-types";
import {
  Flex,
  Text,
  Box,
  Checkbox,
  Button,
  Badge,
  Modal,
  ModalOverlay,
  ModalContent,
  ModalHeader,
  ModalFooter,
  ModalBody,
  ModalCloseButton,
  useDisclosure,
} from "@chakra-ui/react";

import { useStore } from "../../store";

const ProjectCard = React.memo(({ project, discplines }) => {
  const Rank = useStore((state) => state.Rank);
  // console.log(Object.values(discplines))


  const [checked, setChecked] = useState(
    Rank.some((i) => i.id === project.project_id)
  );
  const { isOpen, onOpen, onClose } = useDisclosure();

  const checkRef = useRef(null);

  const description =
    project.project_description &&
    project.project_description.toString().slice(0, 200) + "...";

  const addRank = useStore((state) => state.addRank);
  const removeRank = useStore((state) => state.removeRank);

  const handleCheck = (e) => {
    //if function is writen as normal function, it needs to be called with arrow function
    // otherwise it will be called when the page is loaded, not when the checkbox is clicked
    setChecked(e.target.checked);
    if (e.target.checked) {
      addRank(
        project.project_id,
        project.project_topic,
        {"id":project.lecturer_id ,"name": project.lecturer_name},
        {"id":project.lecturer2_id ,"name": project.lecturer2_name},

      );
    } else {
      removeRank(project.project_id);
    }
  };
  return (
    <Flex p="16px"
    w="100%"
    borderRadius={12}
    bg="BG"
   
    border="3px inset #E2E8F0"
    borderColor={checked ? "AccentMain.default" : "transparent"}
    transition="all .3s ease">
      <Flex
        flexDir="column"
        gap="20px"
        justifyContent="space-between"
      >
        <Flex flexDir="column" gap={2}>
          <Flex
            flexDir="row"
            justifyContent="space-between"
            alignItems="flex-start"
            minH="50px"
          >
            <Checkbox
              ref={checkRef}
              size="lg"
              borderColor="#888"
              alignItems="flex-start"
              checked={checked}
              defaultChecked={checked}
              disabled={Rank.length >= 3 && !checked}
              onChange={handleCheck}
            >
              <Text fontSize="1rem" fontWeight="bold" lineHeight={6}>
                {project.project_topic}
              </Text>
            </Checkbox>
          </Flex>
          <Text>{description}</Text>
          <Flex flexDir="row" justifyContent="flex-end" alignItems="center">
            <Button size="sm" bg="none" onClick={onOpen}>
              Read more
            </Button>
          </Flex>
        </Flex>

        <Flex flexDir="column" gap={4}>
          <Flex flexDir="row" gap={2} flexWrap="wrap">
            {discplines &&
              discplines.map((discpline) => (
                <Badge key={discpline} borderRadius="full" px="2">
                  {discpline}
                </Badge>
              ))}
          </Flex>
            {project.lecturer_name && project.lecturer2_name &&
            (
              <Flex flexDir="row" gap={2} flexWrap="wrap">
                <Text fontWeight="bold">{project.lecturer_name}</Text>
                <Text>{project.lecturer2_name}</Text>
              </Flex>
            )}
        </Flex>
      </Flex>

      <Modal isOpen={isOpen} onClose={onClose} scrollBehavior="inside">
        <ModalOverlay />
        <ModalContent minW="40%" minH="50%">
          <ModalHeader maxW="95%">{project.project_topic}</ModalHeader>
          <ModalCloseButton />
          <ModalBody>
            <Text>{project.project_description}</Text>
            <Flex flexDir="row" gap={2} flexWrap="wrap" mt={5}>
            {discplines &&
              discplines.map((discpline) => (
                <Badge key={discpline} borderRadius="full" px="3">
                  {discpline}
                </Badge>
              ))}
          </Flex>
          {project.lecturer_name && project.lecturer2_name &&
            (
              <Flex gap={4} mt={8}>
                <Text fontWeight="bold">{project.lecturer_name}</Text>
                <Text>{project.lecturer2_name}</Text>
              </Flex>
            )}
          </ModalBody>

          <ModalFooter>
            <Button
              colorScheme={checked ? "gray" : "purple"}
              disabled={Rank.length >= 3 && !checked}
              onClick={() => {
                checkRef.current.click();
                onClose();
              }}
            >
              {checked ? "Unselect this topic" : "Select this topic"}
            </Button>
          </ModalFooter>
        </ModalContent>
      </Modal>
    </Flex>
  );
});

ProjectCard.propTypes = {
  project: PropTypes.object.isRequired,
};

export default ProjectCard;
