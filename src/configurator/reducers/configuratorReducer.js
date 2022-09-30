export const initialState = {
  steps: [],
  sizeUnit: window?.configurator?.settings?.size_unit || "mm",
  loading: false,
  submitting: false,
  quantity: 1,
  message: "",
};

/**
 * Updates active property based on parent value
 */
const updateStepsActiveProperty = (steps) => {
  let updatedSteps = steps;
  let activatedChildSteps = [];
  steps.forEach((step, index) => {
    updatedSteps[index].active =
      step.parent_step && !activatedChildSteps.includes(step.id) ? false : true;
    if (step.active && step.options) {
      const stepValue = step.value;
      const selectedOption = step.options.find(
        (option) => option.id === stepValue
      );
      if (selectedOption && selectedOption.child_steps) {
        const { child_steps } = selectedOption;
        const childStepIds = Array.isArray(child_steps)
          ? child_steps
          : [child_steps];
        childStepIds.forEach(
          (childStepId) =>
            (updatedSteps = updatedSteps.map((step) => {
              if (step.id === childStepId) {
                step.active = true;
                activatedChildSteps.push(step.id);
              }
              return step;
            }))
        );
      }
    }
  });
  console.log(updatedSteps);
  return steps;
};

export const configuratorReducer = (state, action) => {
  const { type, payload } = action;
  switch (type) {
    case "init_steps":
      const configuration = payload.configuration;
      // Create initial step objects
      let steps = payload.steps.map((step) => {
        step.active = step.parent_step ? false : true;
        step.invalid = false;
        step.value = configuration[step.id] || null;
        return step;
      });
      steps = updateStepsActiveProperty(steps);
      return { ...state, steps };

    case "update_step_value":
      return {
        ...state,
        steps: updateStepsActiveProperty(
          state.steps.map((step) => {
            if (step.id === payload.id) step.value = payload.value;
            return step;
          })
        ),
      };
  }
};
