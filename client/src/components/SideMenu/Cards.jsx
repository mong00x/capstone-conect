import { memo, useEffect, useRef } from "react";
import { useDrag, useDrop } from "react-dnd";
import { ItemTypes } from "./ItemTypes";
import PropTypes from "prop-types";

import { Flex, Text, Box, Fade } from "@chakra-ui/react";
import { DragHandleIcon } from "@chakra-ui/icons";

export const Card = memo(function Card({
  id,
  text,
  lecturer1,
  lecturer2,
  rank,
  moveCard,
  findCard,
}) {
  const existRef = useRef(true);
  useEffect(() => {
    existRef.current = true;
    return () => {
      existRef.current = false;
    };
  }, []);

  const originalIndex = findCard(id).index; // find the index of the card
  const [{ isDragging }, drag] = useDrag( // useDrag is a hook that returns a tuple containing the drag source connector and the monitor
    () => ({
      type: ItemTypes.CARD, 
      item: { id, originalIndex }, // item is the data that will be available to the drop target
      collect: (monitor) => ({ // collect is a function that returns a plain object of props to inject into your component
        isDragging: monitor.isDragging(), // isDragging returns true if the current drag operation is a drag source
      }),
      end: (item, monitor) => { // end is a function that is called when the drag operation ends
        const { id: droppedId, originalIndex } = item; // id of the dropped card, original index of the dropped card
        const didDrop = monitor.didDrop(); // didDrop returns true if the drop target handled the drop
        if (!didDrop) { // if the drop target did not handle the drop
          moveCard(droppedId, originalIndex); // move the card back to its original index
          console.log("drop failed") // log to console
        }
      },
    }),
    [id, originalIndex, moveCard]
  );



  const [, drop] = useDrop(// useDrop is a hook that returns a tuple containing the drop target connector and the monitor
    () => ({
      accept: ItemTypes.CARD,// accept only cards
      hover({ id: draggedId }) {// when a card is dragged over another card
        if (draggedId !== id) {// if the dragged card is not the same as the card being hovered over
          const { index: overIndex } = findCard(id); // find the index of the card being hovered over
          moveCard(draggedId, overIndex);  // move the dragged card to the index of the card being hovered over
          // update card rank to its current index
          rank = overIndex;
        }
      },
    }
    ),

    [findCard, moveCard] 
  );
  const opacity = isDragging ? 0.5 : 1;
  const background = isDragging ? "gray.100" : "gray.200"
  return (
    <Fade in={existRef.current} >
      <Flex
        className="RankCard"
        flexDir="row"
        ref={(node) => drag(drop(node))}
        alignItems="center"
        borderRadius="md"
        opacity={opacity}
        background={background}
        my={2}
        py={2}
        px={1}
        cursor="move"
        h="110px"
        transition="all 0.2s"
        overflow="hidde"
      >
        <Box>
          <DragHandleIcon />
          {/* {<Text>{rank}</Text>} */}
        </Box>
        <Flex flexDir="column" justifyContent="space-between" h="100%">
          <Text>
            {text && text.toString().slice(0,36) + "..."}
          </Text>
          {lecturer1 && lecturer2 &&
            (
              <Flex gap={4} flexWrap="wrap">
                <Text fontWeight="bold">{lecturer1.name}</Text>
                <Text>{lecturer2.name}</Text>
              </Flex>
            )}
        </Flex>
      </Flex>
    </Fade>
  );
});

Card.propTypes = {
  id: PropTypes.number.isRequired,
  text: PropTypes.string.isRequired,
  moveCard: PropTypes.func.isRequired,
  findCard: PropTypes.func.isRequired,
};
