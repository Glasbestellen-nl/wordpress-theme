const { msg } = window.gb;
import { convertNumberBySizeUnit } from "./sizeUnit";
import { getOptionValue } from "./steps";

export const validateBasic = (value) => {
  if (value === "") {
    return { valid: false, message: msg.enterField };
  } else {
    return { valid: true, message: "" };
  }
};

export const validateByRules = (
  value,
  rules,
  configuration,
  sizeUnit = "mm"
) => {
  let valid = true;
  let message = "";

  if (rules) {
    // Minimum size
    if (rules.min && value < parseInt(rules.min)) {
      valid = false;
      message = msg.dimensionValueTooSmall.replace(
        "{0}",
        convertNumberBySizeUnit(rules.min, sizeUnit)
      );
    }
    // Maximum size
    else if (rules.max) {
      let max;
      if (rules.max.dependence) {
        const maxDependence = rules.max.dependence;
        const dependentStepIds =
          (!Array.isArray(maxDependence) && [maxDependence]) || maxDependence;
        let previousMax = 0;
        dependentStepIds.forEach((dependentStepId) => {
          const dependentValue =
            getOptionValue(dependentStepId, configuration[dependentStepId]) ||
            configuration[dependentStepId];
          if (dependentValue && dependentValue > previousMax) {
            if (rules.max.greater && rules.max.less) {
              max =
                value > parseInt(dependentValue)
                  ? parseInt(rules.max.greater)
                  : parseInt(rules.max.less);
            } else {
              max = parseInt(dependentValue);
            }
            previousMax = max;
          }
        });
      } else {
        max = parseInt(rules.max);
      }

      if (value > max) {
        valid = false;
        message = msg.dimensionValueTooLarge.replace(
          "{0}",
          convertNumberBySizeUnit(max, sizeUnit)
        );
      }
    }

    // Based on dependent value
    if (rules.less_than && rules.less_than.step) {
      let lessThan = rules.less_than;
      let dependentStepId = lessThan.step;
      let dependentValue = getOptionValue(
        dependentStepId,
        configuration[dependentStepId]
      );
      if (dependentValue) {
        if (lessThan.value) {
          dependentValue -= parseInt(lessThan.value);
        }
        if (dependentValue < value) {
          valid = false;
          if (rules.less_than.message) {
            message = rules.less_than.message;
          }
        }
      }
    }
  }
  return { valid, message };
};

export const validate = (value, required, rules, configuration, sizeUnit) => {
  let validationResult = required
    ? validateBasic(value)
    : { valid: true, message: "" };
  if (validationResult.valid) {
    if (rules)
      validationResult = validateByRules(value, rules, configuration, sizeUnit);
  }
  return validationResult;
};
