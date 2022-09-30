import update from "immutability-helper";
import { memo, useCallback, useState } from "react";
import { useDrop } from "react-dnd";
import { Card } from "./Cards";
import { ItemTypes } from "./ItemTypes";

import { useStore } from "../../store";

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
      console.log(cards);
    },
    (state) => state.Rank
  );

  const findCard = useCallback(
    // useCallback is a hook that returns a memoized version of the callback that only changes if one of the dependencies has changed
    // the function will only be called if one of the dependencies has changed.
    (id) => {
      const card = cards.filter((c) => c.id === id)[0];
      // filter returns an array of all elements that pass the test implemented by the provided function.
      // [0] returns the first element of the array.
      return {
        card,
        index: cards.indexOf(card),
      };
    },
    [cards]
  );
  const moveCard = useCallback(
    (id, atIndex) => {
      // id is the id of the card, atIndex is the drop index of the card
      const { card, index } = findCard(id); // find current card and card index
      console.log("finding card", card, index);
      setCards(
        // update the cards array
        update(cards, {
          // update is a function that returns a new cards Object based on the original object passed as the first argument,
          // the path to the value to be changed as the second argument,
          // and an object describing how to update the value as the third argument.
          $splice: [
            [index, 1], // remove the card from the array
            [atIndex, 0, card], // insert the card at the new index
          ],
        })
      );
    },
    [findCard, cards, setCards] // dependencies
  );
  const [, drop] = useDrop(() => ({ accept: ItemTypes.CARD }));
  return (
    <div ref={drop} style={style}>
      {cards.map((card) => (
        <Card
          key={card.rank}
          id={card.id && card.id}
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
