import { calculateValueByFormula } from "../utils/formulas";
import { getConfigurationFromSteps } from "../utils/configuration";

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
  return steps;
};

/**
 * Sets step values by formula based on other step values
 */
const updateStepsValueByFormula = (steps) => {
  const configuration = getConfigurationFromSteps(steps);
  return steps.map((step) => {
    if (step.formula) {
      const calculatedValue = calculateValueByFormula(
        step.formula,
        configuration
      );
      step.value = Math.round(calculatedValue);
    }
    return step;
  });
};

export const configuratorReducer = (state, action) => {
  const { type, payload } = action;
  switch (type) {
    case "init_steps":
      const configuration = payload.configuration;
      let steps = payload.steps.map((step) => {
        step.active = step.parent_step ? false : true;
        step.invalid = false;
        step.value = configuration[step.id] || null;
        return step;
      });
      steps = updateStepsValueByFormula(updateStepsActiveProperty(steps));
      return { ...state, steps };
    case "update_step":
      return {
        ...state,
        steps: state.steps.map((step) => {
          if (step.id === payload.id) step[payload.property] = payload.value;
          return step;
        }),
      };
    case "update_step_value":
      return {
        ...state,
        steps: updateStepsValueByFormula(
          updateStepsActiveProperty(
            state.steps.map((step) => {
              if (step.id === payload.id) step.value = payload.value;
              return step;
            })
          )
        ),
      };
    case "update_invalid_steps":
      return {
        ...state,
        steps: state.steps.map((step) => {
          step.invalid = false;
          if (payload) {
            payload.forEach((invalid) => {
              if (invalid.id === step.id) {
                step.invalid = invalid.message;
              }
            });
          }
          return step;
        }),
      };
    case "submitting":
      return { ...state, submitting: payload };
    default:
      return state;
  }
};
