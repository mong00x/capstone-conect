import update from "immutability-helper";
import { memo, useCallback, useState } from "react";
import { useDrop } from "react-dnd";
import { Card } from "./Cards";
import { ItemTypes } from "./ItemTypes";
const style = {
  width: 400,
};
const ITEMS = [
  {
    id: 1,
    text: "Machine learning approaches for Cyber Security",
  },
  {
    id: 2,
    text: "Enhancing airport screening using a deep neural network algorithm",
  },
  {
    id: 3,
    text: "Augmented Reality System on Improving Safety of Young Drivers",
  },
];
export const Container = memo(function Container() {
  const [cards, setCards] = useState(ITEMS);
  const findCard = useCallback(
    (id) => {
      const card = cards.filter((c) => `${c.id}` === id)[0];
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
          id={`${card.id}`}
          text={card.text}
          moveCard={moveCard}
          findCard={findCard}
        />
      ))}
    </div>
  );
});
