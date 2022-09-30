import React from "react";
import ProjectCard from "./ProjectCard";
import { Flex, Grid, Spinner, Text } from "@chakra-ui/react";
import SearchFilter from "./SearchFilter";
import { searchStore, filterStore } from "../../store";

import axios from "axios";
import { useQuery } from "@tanstack/react-query";

const MainContent = () => {
  const search = searchStore((state) => state.search);
  console.log(process.env.NODE_ENV);
  const url =
    process.env.NODE_ENV === "development"
      ? "http://localhost/all_projects.php"
      : "https://cduprojects.spinetail.cdu.edu.au/adminpage/all_projects.php";
  const fetchProjects = async () => {
    // if in development mode, api url is localhost, else it is the cpanel url

    const { data } = await axios.get(url);
    return data.projects;
    //error handling
  };

  const { isLoading, isError, isSuccess, data, error } = useQuery(
    ["projects"],
    fetchProjects
  );

  // register project to store

  isError && console.log("Error: ", error.message);

  return isLoading ? (
    <Flex
      justifyContent="center"
      alignItems="center"
      height="100vh"
      width="100vw"
    >
      <Spinner
        thickness="4px"
        speed="0.65s"
        emptyColor="gray.200"
        color="blue.500"
        size="xl"
      />
    </Flex>
  ) : isSuccess ? (
    <Flex flexDir="column" w="100%" h="100%" color="DarkShades" bg="ContentBG">
      <SearchFilter />
      <Grid
        templateColumns="repeat(auto-fill, minmax(360px, 1fr))"
        gap={8}
        p="32px 32px 120px 32px"
        justifyContent="space-between"
        overflow={"auto"}
      >
        {data &&
          data
            .filter((project) =>
              Object.values(project)
                .join("")
                .toLowerCase()
                .includes(search.toLowerCase())
            )
            .map((project) => (
              <ProjectCard key={project.project_id} project={project} />
            ))}
      </Grid>
    </Flex>
  ) : (
    isError && (
      <Flex
        justifyContent="center"
        alignItems="center"
        height="100vh"
        width="100vw"
      >
        <Text>Something went wrong</Text>
      </Flex>
    )
  );
};

export default MainContent;
