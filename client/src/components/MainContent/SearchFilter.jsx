import React from "react";
import { Flex, Input, Button } from "@chakra-ui/react";

const SearchFilter = () => {
  return (
    <Flex flexDir="column" p="32px" borderBottom="1px solid #E2E8F0" gap="12px">
      <Flex
        flexDir="row"
        justifyContent="space-between"
        alignItems="center"
        flexWrap="wrap"
        gap="12px"
      >
        <Flex flexDir="row" alignItems="center" gap={4} minWidth="40%">
          <Input
            className="search-input"
            placeholder="Search the projects"
            size="md"
            borderRadius={50}
            minW="300px"
            bg="BG"
          />
          <Button className="search-btn" bg="DarkShades" color="LightShades">
            Search
          </Button>
        </Flex>
        <Button>Filter</Button>
      </Flex>
      <Flex flexDir="row"> </Flex>
    </Flex>
  );
};

export default SearchFilter;
