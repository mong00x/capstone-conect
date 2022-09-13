import { useState } from "react";
import reactLogo from "./assets/react.svg";
import "./App.css";
import create from "zustand";

import { QueryClient, QueryClientProvider } from "@tanstack/react-query";
import { ReactQueryDevtools } from "@tanstack/react-query-devtools";

import { Box, Flex, Text } from "@chakra-ui/react";

import NavBar from "./components/NavBar";
import SideMenu from "./components/SideMenu/SideMenu";
import MainContent from "./components/MainContent/MainContent";

const useBearStore = create((set) => ({
  bears: 0,
  increasePopulation: () => set((state) => ({ bears: state.bears + 1 })),
  decreasePopulation: () => set((state) => ({ bears: state.bears - 1 })),
  removeAllBears: () => set({ bears: 0 }),
}));

const queryClient = new QueryClient();

function App() {
  const bears = useBearStore((state) => state.bears);
  const increasePopulation = useBearStore((state) => state.increasePopulation);
  const decreasePopulation = useBearStore((state) => state.decreasePopulation);
  const removeAllBears = useBearStore((state) => state.removeAllBears);

  return (
    <div className="App">
      <NavBar />
      <QueryClientProvider client={queryClient}>
        <Flex flexDir="row" wdith="100%">
          <SideMenu />
          <MainContent />
        </Flex>
        <ReactQueryDevtools initialIsOpen={false} />
      </QueryClientProvider>
    </div>
  );
}

export default App;
