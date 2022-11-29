import React from "react";
import ReactDOM from "react-dom/client";
import { ChakraProvider, extendTheme } from "@chakra-ui/react";
import { BrowserRouter, Routes, Route } from "react-router-dom";

import App from "./App";
import Login_page  from "./login";
import About from "./About";
import NavBar from "./components/NavBar";


const theme = extendTheme({
  colors: {
    BG: "#FEFEFE",
    ContentBG: "#F5F5F5",
    LightShades: "#F2F2F2",
    DarkShades: "#363A66",
    AccentLight: "#9BADCD",
    AccentMain: {
      light: "#E9D8FF",
      default: "#805AD5",
    },
  },
});

ReactDOM.createRoot(document.getElementById("root")).render(
  <React.StrictMode>
    <ChakraProvider theme={theme}>
    <NavBar />
      <BrowserRouter>
        <Routes>
          <Route path="/app" element={<App />} />
          <Route path="/" element={<Login_page />} />
          <Route path="about" element={<About />} />
        </Routes>
      </BrowserRouter>
    </ChakraProvider>
  </React.StrictMode>
);
