export const getStepsData = () => {
  return window?.configurator?.settings?.steps;
};

export const getStepsMap = () => {
  const stepsArray = getStepsData();
  if (!stepsArray) return;
  return stepsArray.reduce((acc, step) => ({ ...acc, [step.id]: step }), {});
};

export const getOptionValue = (stepId, optionId) => {
  if (!stepId || !optionId) return;
  const steps = getStepsData();
  const step = steps.find((step) => step.id === stepId);
  if (!step || !step.options) return;
  const option = step.options.find(
    (option) => parseInt(option.id) === parseInt(optionId)
  );
  return (option && option.value) || null;
};
