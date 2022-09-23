import create from "zustand";

const useStore = create((set) => ({
  Rank: [],
  // addRank function will add selcted project topic and supervisor to Rank array
  addRank: (id, topic, supervisors) =>
    set((state) => ({
      Rank: [
        ...state.Rank,
        { id, topic, supervisors, rank: state.Rank.length + 1 },
      ],
    })),
  removeRank: (id) =>
    set((state) => ({ Rank: state.Rank.filter((i) => i.id !== id) })),
}));

export default useStore;
