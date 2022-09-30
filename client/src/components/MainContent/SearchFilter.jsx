import React, { useState } from "react";
import { Flex, Input, Button } from "@chakra-ui/react";
import { searchStore, filterStore } from "../../store";

const SearchFilter = () => {
  const search = searchStore((state) => state.search);
  const setSearch = searchStore((state) => state.setSearch);
  const filter = filterStore((state) => state.filter);
  const setFilter = filterStore((state) => state.setFilter);

  console.log(search);

  const searchItems = (searchValue) => {
    setSearchInput(searchValue); // is this line necessary?
    if (searchValue !== "") {
      const filteredData = APIData.filter((item) => {
        // what is item?
        return Object.values(item)
          .join("") // join all values into one string
          .toLowerCase() // convert to lowercase
          .includes(searchInput.toLowerCase()); // check if the search input is included in the string
      });
      setFilteredResults(filteredData);
      console.log(filteredResults);
    } else {
      setFilteredResults(APIData);
    }
  };

  return (
    <Flex flexDir="column" p="32px" borderBottom="1px solid #E2E8F0" gap="12px">
      <Flex
        flexDir="row"
        justifyContent="space-between"
        alignItems="center"
        flexWrap="wrap"
        gap="12px"
        value={search}
        onChange={(e) => setSearch(e.target.value)}
      >
        <Flex flexDir="row" alignItems="center" gap={4} minWidth="40%">
          <Input
            className="search-input"
            placeholder="Search the projects"
            size="md"
            borderRadius={50}
            minW="300px"
            bg="BG"
            value={search}
            onChange={(e) => setSearch(e.target.value)}
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
