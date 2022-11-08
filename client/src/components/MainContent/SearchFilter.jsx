import React, { useState, useRef } from "react";
import {
  Flex,
  Input,
  Button,
  IconButton,
  InputGroup,
  InputRightElement,
} from "@chakra-ui/react";
import { CloseIcon } from "@chakra-ui/icons";
import { searchStore, filterStore } from "../../store";

import "./SearchFilter.css";

const SearchFilter = () => {
  const inputRef = useRef();
  const search = searchStore((state) => state.search);
  const setSearch = searchStore((state) => state.setSearch);
  const filter = filterStore((state) => state.filter);
  const setFilter = filterStore((state) => state.setFilter);

  console.log(search);

  // const searchItems = (searchValue) => {
  //   setSearchInput(searchValue); // is this line necessary?
  //   if (searchValue !== "") {
  //     const filteredData = APIData.filter((item) => {
  //       // what is item?
  //       return Object.values(item)
  //         .join("") // join all values into one string
  //         .toLowerCase() // convert to lowercase
  //         .includes(searchInput.toLowerCase()); // check if the search input is included in the string
  //     });
  //     setFilteredResults(filteredData);
  //     console.log(filteredResults);
  //   } else {
  //     setFilteredResults(APIData);
  //   }
  // };

  return (
    <Flex 
      flexDir="column"
      p="16px" 
      borderBottom="1px solid #E2E8F0" 
      className="container"
      alignItems="center"
          >
      <Flex
        flexDir="row"
        justifyContent="space-between"
        alignItems="center"
        flexWrap="wrap"
        value={search}
        onChange={(e) => setSearch(e.target.value)}
        marginRight="1%"
        w="60%"
      >
        <Flex flexDir="row" alignItems="center" gap={4} w="100%">
          <InputGroup>
            <Input
              ref={inputRef}
              className="search-input"
              placeholder="Search the projects"
              size="md"
              borderRadius="50px"
              w="100%"
              bg="BG"
              value={search}
              onChange={(e) => setSearch(e.target.value)}
              shadow="md"
              h="47px"

            />
            <InputRightElement width="4.5rem">
              <IconButton
                size="md"
                onClick={() => setSearch("")}
                aria-label="cleare search"
                icon={<CloseIcon />}
                bg="BG"
                borderRadius={50}
                mr="-26px"
                top="3.3px"
              />
            </InputRightElement>
          </InputGroup>

          {/* <Button className="search-btn" bg="DarkShades" color="LightShades">
            Search
          </Button> */}
        </Flex>
        
      </Flex>
      <Flex flexDir="row"> </Flex>
    </Flex>
  );
};

export default SearchFilter;
