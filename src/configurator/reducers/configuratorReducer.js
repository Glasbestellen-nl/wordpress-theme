import { getStepsData } from "../utils/steps";
import { calculateValueByFormula } from "../utils/formulas";

const steps = getStepsData().filter((step) => !step.parent_step);

export const initialState = {
  configuration: {},
  invalidFields: {},
  sizeUnit: window?.configurator?.settings?.size_unit || "mm",
  loading: false,
  submitting: false,
  quantity: 1,
  message: "",
};

export const configuratorReducer = (state, action) => {
  const { type, payload } = action;
  switch (type) {
    case "set_configuration":
      return { ...state, configuration: payload, loading: false };
    case "update_configuration":
      const configuration = state.configuration
        ? { ...state.configuration }
        : {};
      configuration[payload.id] = payload.value;

      // Set configuration values by formula based on other values in configuration
      steps.forEach((step) => {
        if (step.formula) {
          const calculatedValue = calculateValueByFormula(
            step.formula,
            configuration
          );
          configuration[step.id] = Math.round(calculatedValue);
        }
      });
      return { ...state, configuration };
    case "remove_configuration_item":
      const { [payload.id]: removedItem, ...restConfig } = state.configuration;
      return { ...state, configuration: restConfig };
    case "set_invalid_fields":
      return { ...state, invalidFields: payload };
    case "add_invalid_field":
      return {
        ...state,
        invalidFields: {
          ...state.invalidFields,
          [payload.id]: payload.message,
        },
      };
    case "remove_invalid_field":
      const invalidFields = { ...state?.invalidFields };
      if (invalidFields[payload.id]) delete invalidFields[payload.id];
      return { ...state, invalidFields };
    case "loading":
      return { ...state, loading: payload };
    case "submitting":
      return { ...state, submitting: payload };
    case "update_quantity":
      return { ...state, quantity: payload };
    case "update_message":
      return { ...state, message: payload };
    default:
      return state;
  }
};
