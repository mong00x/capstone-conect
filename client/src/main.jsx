import React from "react";
import ReactDOM from "react-dom/client";
import App from "./App";
import { ChakraProvider, extendTheme } from "@chakra-ui/react";

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
      <App />
    </ChakraProvider>
  </React.StrictMode>
);
