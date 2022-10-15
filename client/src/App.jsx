import "./App.css";
import { QueryClient, QueryClientProvider } from "@tanstack/react-query";
import { ReactQueryDevtools } from "@tanstack/react-query-devtools";
import {  Flex } from "@chakra-ui/react";
import NavBar from "./components/NavBar";
import SideMenu from "./components/SideMenu/SideMenu";
import MainContent from "./components/MainContent/MainContent";

const queryClient = new QueryClient();

function App() {
  const redirectUrl = process.env.NODE_ENV === "development" ? "http://localhost:5173" : "https://cduprojects.spinetail.cdu.edu.au";
  if(JSON.parse(sessionStorage.getItem('user')) == null || JSON.parse(sessionStorage.getItem('user')).auth == false)
  {
    location.replace(redirectUrl)
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
