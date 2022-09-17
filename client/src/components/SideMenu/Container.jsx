import update from "immutability-helper";
import { memo, useCallback, useState } from "react";
import { useDrop } from "react-dnd";
import { Card } from "./Cards";
import { ItemTypes } from "./ItemTypes";

import useStore from "../../store";

const style = {
  width: "100%",
};

//  get item data from store

const Container = memo(function Container() {
  const Rank = useStore((state) => state.Rank);
  console.log("Rank", Rank);
  const [cards, setCards] = useState(Rank);
  useStore.subscribe(
    (state) => {
      setCards(state.Rank);
    },
    (state) => state.Rank
  );

  const findCard = useCallback(
    // useCallback is a hook that returns a memoized version of the callback that only changes if one of the dependencies has changed. the function will only be called if one of the dependencies has changed.
    (id) => {
      const card = cards.filter((c) => `${c.id}` === id)[0]; // filter returns an array of all elements that pass the test implemented by the provided function. [0] returns the first element of the array.
      return {
        card,
        index: cards.indexOf(card),
      };
    },
    [cards]
  );
  const moveCard = useCallback(
    (id, atIndex) => {
      const { card, index } = findCard(id);
      setCards(
        update(cards, {
          $splice: [
            [index, 1],
            [atIndex, 0, card],
          ],
        })
      );
    },
    [findCard, cards, setCards]
  );
  const [, drop] = useDrop(() => ({ accept: ItemTypes.CARD }));
  return (
    <div ref={drop} style={style}>
      {cards.map((card) => (
        <Card
          key={card.id}
          id={card.id}
          text={card.topic}
          supervisors={card.supervisors}
          moveCard={moveCard}
          findCard={findCard}
        />
      ))}
    </div>
  );
});

export default Container;
