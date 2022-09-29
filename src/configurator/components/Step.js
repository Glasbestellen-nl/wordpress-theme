const { useContext, useEffect, useState } = wp.element;
import { formatTextBySizeUnit } from "../utils/sizeUnit";
import { ConfiguratorContext } from "../context/ConfiguratorContext";
import FieldNumber from "./FieldNumber";
import FieldDropdown from "./FieldDropdown";
import { getStepsMap } from "../utils/steps";

const stepsMap = getStepsMap();

const Step = ({ step, validate, getSelectedOption }) => {
  const {
    id,
    title,
    required,
    options,
    description,
    rules,
    disabled,
    formula,
  } = step;
  const [state, dispatch] = useContext(ConfiguratorContext);
  const selectedOption = getSelectedOption(id);

  useEffect(() => {
    // Set step default when is child step
    const parentStepId = step.parent_step;
    if (parentStepId) {
      dispatch({
        type: "update_configuration",
        payload: { id, value: getDefaultValue() },
      });
    }
    return () => {
      // Remove element from configuration when unmounting
      dispatch({ type: "remove_configuration_item", payload: { id } });
    };
  }, []);

  const getDefaultValue = () => {
    if (hasOptions()) {
      const defaultOption = options.find((option) => option.default);
      return defaultOption?.id || null;
    } else {
      return step.default;
    }
  };

  const getDescriptionId = () => {
    return description && description.id;
  };

  const hasOptions = () => {
    return options && options.length > 0;
  };

  const changeHandler = (value) => {
    dispatch({ type: "update_configuration", payload: { id, value } });
  };

  const renderInputField = () => {
    if (hasOptions()) {
      if (options.length == 1 && required) {
        return (
          <>
            <span>{options[0].title}</span>
            <input type="hidden" value="" class="js-input-hidden"></input>
          </>
        );
      } else {
        return (
          <FieldDropdown
            id={id}
            options={options}
            changeHandler={changeHandler}
            rules={rules}
            required={required}
          />
        );
      }
    } else {
      return (
        <FieldNumber
          id={id}
          changeHandler={changeHandler}
          rules={rules}
          required={required}
          validate={validate}
          disabled={disabled}
          formula={formula}
        />
      );
    }
  };

  const getClassNames = () => {
    const classNames = ["configurator__form-row"];
    return classNames.join(" ");
  };

  const getInputRowClassNames = () => {
    const classNames = ["configurator__form-col", "configurator__form-input"];
    if (hasOptions() && options.length == 1 && required) {
      classNames.push("configurator__form-input--default");
    }
    return classNames.join(" ");
  };

  return (
    <>
      <div className={getClassNames()}>
        <div className="configurator__form-col">
          <label
            className="configurator__form-label"
            data-explanation-id={getDescriptionId()}
          >
            {formatTextBySizeUnit(title, state.sizeUnit)}
          </label>{" "}
          {required && <span>*</span>}
        </div>
        {getDescriptionId() && (
          <div className="configurator__form-col configurator__form-info">
            <i
              className="fas fa-info-circle configurator__info-icon js-popup-explanation"
              data-explanation-id={getDescriptionId()}
            ></i>
          </div>
        )}
        <div class={getInputRowClassNames()}>
          {renderInputField()}
          {state.invalidFields[id] && (
            <div class="invalid-feedback js-invalid-feedback">
              {state.invalidFields[id]}
            </div>
          )}
        </div>
      </div>
      {selectedOption?.child_steps?.map((stepId) => {
        const childStep = stepsMap[stepId];
        return (
          <Step
            key={childStep.id}
            step={childStep}
            getSelectedOption={getSelectedOption}
            validate={validate}
          />
        );
      })}
    </>
  );
};

export default Step;
