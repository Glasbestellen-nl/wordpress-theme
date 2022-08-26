export const getStepsData = () => {
  return (
    window.gb &&
    window.gb.configuratorSettings &&
    window.gb.configuratorSettings.steps
  );
};

/**
 * Convert steps array to object for easier use
 */
export const getStepsMap = () => {
  const stepsArray = getStepsData();
  if (!stepsArray) return;
  return stepsArray.reduce((acc, step) => ({ ...acc, [step.id]: step }), {});
};
