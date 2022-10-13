import { getOptionValue } from "../utils/steps";

export const calculateCircleCutSideLeftOver = (diameter, cutSideLength) => {
  const radius = diameter / 2;
  return (
    (radius -
      Math.sqrt(Math.pow(radius, 2) - Math.pow(cutSideLength, 2) / 4) -
      diameter) *
    -1
  );
};

export const calculateValueByFormula = (formula, configuration) => {
  let value = 0;
  const { type, params } = formula;
  if (type && params) {
    switch (type) {
      case "leftover_height_cut_side_circle": {
        const { d, c } = params;
        const diameter = getOptionValue(d, configuration[d]);
        const cutSideLength = configuration[c];
        value = calculateCircleCutSideLeftOver(diameter, cutSideLength);
      }
    }
  }
  return value;
};
