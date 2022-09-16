import React from "react";
import ProjectCard from "./ProjectCard";
import { Box, Flex, Grid } from "@chakra-ui/react";
import SearchFilter from "./SearchFilter";

const MainContent = () => {
  // register project to store
  return (
    <Flex flexDir="column" w="100%" h="100%" color="DarkShades" bg="ContentBG">
      <SearchFilter />
      <Grid
        templateColumns="repeat(auto-fill, minmax(300px, 1fr))"
        gap={8}
        p="32px 32px 120px 32px"
        justifyContent="space-between"
        overflow={"auto"}
      >
        <ProjectCard id={1} />
        <ProjectCard id={2} />
        <ProjectCard id={3} />
        <ProjectCard id={4} />
        <ProjectCard id={5} />
        <ProjectCard id={6} />
      </Grid>
    </Flex>
  );
};

export default MainContent;
