import { useState } from 'react'
import reactLogo from './assets/react.svg'
import './App.css'
import create from 'zustand'

const useBearStore = create((set) => ({
  bears: 0,
  increasePopulation: () => set((state) => ({ bears: state.bears + 1 })),
  decreasePopulation: () => set((state) => ({ bears: state.bears - 1 })),
  removeAllBears: () => set({ bears: 0 }),
}))

function App() {

  const bears = useBearStore((state) => state.bears)
  const increasePopulation = useBearStore((state) => state.increasePopulation)
  const decreasePopulation = useBearStore((state) => state.decreasePopulation)
  const removeAllBears = useBearStore((state) => state.removeAllBears)


  return (
    <div className="App">
      <div>
        
      </div>
      <h1>🐻BEAR!</h1>
      <div className="card">
        <h1>{bears} around here ...</h1>
        <button onClick={increasePopulation}>
          Bear up
        </button>
        <button onClick={decreasePopulation}>
          Bear down
        </button>
        <button onClick={removeAllBears}>
          Bear gone
        </button>

        <p>
          Edit <code>src/App.jsx</code> and save to test HMR
        </p>
      </div>
      <p className="read-the-docs">
        Click on the Vite and React logos to learn more
      </p>
    </div>
  )
}

export default App
