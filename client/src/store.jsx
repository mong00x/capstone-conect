import create from "zustand";

export const useStore = create((set) => ({
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

export const searchStore = create((set) => ({
  search: "",
  setSearch: (value) => set(() => ({ search: value })),
}));

export const filterStore = create((set) => ({
  filter: "",
  setFilter: (value) => set(() => ({ filter: value })),
}));
