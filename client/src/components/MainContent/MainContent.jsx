import React from "react";
import ProjectCard from "./ProjectCard";
import { Box, Flex, Grid } from "@chakra-ui/react";
import SearchFilter from "./SearchFilter";

import useStore from "../../store";

const MainContent = () => {
  // register project to store
  const projects = useStore((state) => state.projects);
  console.log(projects);
  return (
    <Flex flexDir="column" w="100%" h="100%" color="DarkShades" bg="ContentBG">
      <SearchFilter />
      <Grid
        templateColumns="repeat(auto-fill, minmax(360px, 1fr))"
        gap={8}
        p="32px 32px 120px 32px"
        justifyContent="space-between"
        overflow={"auto"}
      >
        {projects.map((project) => (
          <ProjectCard key={project.id} project={project} />
        ))}
      </Grid>
    </Flex>
  );
};

export default MainContent;
