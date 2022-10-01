import React from "react";
import ReactDOM from "react-dom/client";
import App from "./App";
import Login_page  from "./login";
import About from "./About";
import { ChakraProvider, extendTheme } from "@chakra-ui/react";

import { BrowserRouter, Routes, Route } from "react-router-dom";

const theme = extendTheme({
  colors: {
    BG: "#FEFEFE",
    ContentBG: "#F5F5F5",
    LightShades: "#F2F2F2",
    DarkShades: "#363A66",
    AccentLight: "#9BADCD",
    AccentMain: {
      light: "#E9D8FF",
      default: "#9747FF",
    },
  },
});

ReactDOM.createRoot(document.getElementById("root")).render(
  <React.StrictMode>
    <ChakraProvider theme={theme}>
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
