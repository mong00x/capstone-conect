import create from "zustand";

export const useStore = create((set) => ({
  Rank: [],
  // addRank function will add selcted project topic and supervisor to Rank array
  addRank: (id, topic, lecturer, lecturer2, rank) =>
    set((state) => ({
      Rank: [
        ...state.Rank,
        { id, topic, lecturer, lecturer2, rank },
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

export const cardStore = create((set) => ({
  card:[],
  setCard: (value) => set(() => ({ card: value })),
}));

