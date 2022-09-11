import { useState } from "react";
import reactLogo from "./assets/react.svg";
import "./App.css";
import create from "zustand";

import NavBar from "./components/NavBar";
import SideMenu from "./components/SideMenu";
import Content from "./components/Content";

const useBearStore = create((set) => ({
  bears: 0,
  increasePopulation: () => set((state) => ({ bears: state.bears + 1 })),
  decreasePopulation: () => set((state) => ({ bears: state.bears - 1 })),
  removeAllBears: () => set({ bears: 0 }),
}));

function App() {
  const bears = useBearStore((state) => state.bears);
  const increasePopulation = useBearStore((state) => state.increasePopulation);
  const decreasePopulation = useBearStore((state) => state.decreasePopulation);
  const removeAllBears = useBearStore((state) => state.removeAllBears);

  return (
    <div className="App">
      <NavBar />
      <SideMenu />
      <Content />
    </div>
  );
}

export default App;
