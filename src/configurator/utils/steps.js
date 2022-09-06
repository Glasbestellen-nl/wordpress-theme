export const getStepsData = () => {
  return window?.configurator?.settings?.steps;
};

/**
 * Convert steps array to object for easier use
 */
export const getStepsMap = () => {
  const stepsArray = getStepsData();
  if (!stepsArray) return;
  return stepsArray.reduce((acc, step) => ({ ...acc, [step.id]: step }), {});
};

export const getOptionValue = (stepId, optionId) => {
  const steps = getStepsData();
  const step = steps.find((step) => step.id === stepId);
  if (!step || !step.options) return;
  const option = step.options.find(
    (option) => option.id === parseInt(optionId)
  );
  if (option && option.value) return option.value;
  return;
};