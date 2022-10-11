import { memo, useEffect, useRef } from "react";
import { useDrag, useDrop } from "react-dnd";
import { ItemTypes } from "./ItemTypes";
import PropTypes from "prop-types";

import { Flex, Text, Box, Fade } from "@chakra-ui/react";
import { DragHandleIcon } from "@chakra-ui/icons";

export const Card = memo(function Card({
  id,
  text,
  supervisors,
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

  const originalIndex = findCard(id).index;
  const [{ isDragging }, drag] = useDrag(
    () => ({
      type: ItemTypes.CARD,
      item: { id, originalIndex },
      collect: (monitor) => ({
        isDragging: monitor.isDragging(),
      }),
      end: (item, monitor) => {
        const { id: droppedId, originalIndex } = item;
        const didDrop = monitor.didDrop();
        if (!didDrop) {
          moveCard(droppedId, originalIndex);
        }
      },
    }),
    [id, originalIndex, moveCard]
  );
  const [, drop] = useDrop(
    () => ({
      accept: ItemTypes.CARD,
      hover({ id: draggedId }) {
        if (draggedId !== id) {
          const { index: overIndex } = findCard(id);
          moveCard(draggedId, overIndex);
        }
      },
    }),
    [findCard, moveCard]
  );
  const opacity = isDragging ? 0.5 : 1;
  const background = isDragging ? "gray.100" : ""
  return (
    <Fade in={existRef.current}>
      <Flex
        className="RankCard"
        flexDir="row"
        ref={(node) => drag(drop(node))}
        alignItems="center"
        borderRadius="md"
        opacity={opacity}
        background={background}
        my={2}
        cursor="move"
        h="120px"
        transition="all 0.2s"
      >
        <Box>
          <DragHandleIcon />
        </Box>
        <Flex flexDir="column" gap={2}>
          <Text fontWeight="bold" lineHeight="20px">
            {text && text}
          </Text>
          <Box>
            {supervisors &&
              supervisors.map((supervisor) => (
                <Text fontSize="sm">{supervisor}</Text>
              ))}
          </Box>
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
