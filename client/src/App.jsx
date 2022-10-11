import "./App.css";
import create from "zustand";
import { QueryClient, QueryClientProvider } from "@tanstack/react-query";
import { ReactQueryDevtools } from "@tanstack/react-query-devtools";
import { Box, Flex, Text } from "@chakra-ui/react";
import NavBar from "./components/NavBar";
import SideMenu from "./components/SideMenu/SideMenu";
import MainContent from "./components/MainContent/MainContent";

const queryClient = new QueryClient();

function App() {
   if(JSON.parse(sessionStorage.getItem('user')).auth == null)
  {
    const user = {auth: false}
    sessionStorage.setItem('user', JSON.stringify(user))
  }
  if((!JSON.parse(sessionStorage.getItem('user')).auth))
  {
    
    location.replace("http://127.0.0.1:5173/")
  }
  return (
    <Flex
      className="App"
      display="flex"
      flexDir="column"
      height="100%"
      overflow="hidden"
    >
      <NavBar />
      <QueryClientProvider client={queryClient}>
        <Flex flexDir="row" wdith="100%" height="100%">
          <SideMenu />
          <MainContent />
        </Flex>
        <ReactQueryDevtools initialIsOpen={false} />
      </QueryClientProvider>
    </Flex>
  );
}

export default App;
