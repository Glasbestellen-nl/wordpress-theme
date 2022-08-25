const { msg } = window.gb;

export const validateBasic = (value) => {
  if (!value || value === "") {
    return { valid: false, message: msg.enterField };
  } else {
    return { valid: true, message: "" };
  }
};

export const validateByRules = (value, rules, configuration) => {
  let valid = true;
  let message = "";

  if (rules) {
    if (rules.min && value < parseInt(rules.min)) {
      valid = false;
      message = msg.dimensionValueTooSmall.replace("{0}", rules.min);
    } else if (rules.max) {
      let max;
      if (rules.max.dependence) {
        const maxDependence = rules.max.dependence;
        const dependentStepIds =
          (!Array.isArray(maxDependence) && [maxDependence]) || maxDependence;
        let previousMax = 0;
        dependentStepIds.forEach((dependentStepId) => {
          const dependentValue = configuration[dependentStepId];
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
        message = msg.dimensionValueTooLarge.replace("{0}", max);
      }
    }

    if (rules.less_than && rules.less_than.step) {
      let lessThan = rules.less_than;
      let dependentStepId = lessThan.step;
      let dependentValue = configuration[dependentStepId];

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

    if (rules.exclude) {
      let excludeRules = rules.exclude;
      console.log(excludeRules);
      if (Array.isArray(excludeRules)) {
        excludeRules.forEach((excludeRule) => {
          if (excludeRule.step && excludeRule.options) {
            // let step = $(`.js-step-input-${excludeRule.step}`);
            // excludeRule.options.forEach((optionId) => {
            //   let option = step.find(
            //     `option[data-option-id="${optionId}"]:selected`
            //   );
            //   if (option.length > 0) {
            //     valid = false;
            //     msg = excludeRule.message;
            //   }
            // });
          }
        });
      }
    }
  }
  return { valid, message };
};
