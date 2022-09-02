const { useContext, useState, useEffect } = wp.element;
import { formatTextBySizeUnit } from "../services/sizeUnit";
import { ConfiguratorContext } from "../context/ConfiguratorContext";
import FieldNumber from "./FieldNumber";
import FieldDropdown from "./FieldDropdown";
import { getStepsMap } from "../services/steps";

const stepsMap = getStepsMap();

const Step = ({ step, validate }) => {
  const { id, title, required, options, description, rules } = step;
  const { setConfiguration, configuration, sizeUnit, invalidFields } =
    useContext(ConfiguratorContext);

  useEffect(
    // Remove element from configuration when unmounting
    () => () => {
      setConfiguration((prevConfig) => {
        const { [id]: removedItem, ...rest } = prevConfig;
        return rest;
      });
    },
    []
  );

  const getSelectedOption = () => {
    if (!hasOptions() || !configuration[id]) return;
    return options.find((option) => option.id === configuration[id]);
  };

  const getDescriptionId = () => {
    return description && description.id;
  };

  const hasOptions = () => {
    return options && options.length > 0;
  };

  const changeHandler = (value) => {
    setConfiguration((prevConfig) => ({
      ...prevConfig,
      [id]: value,
    }));
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
            validate={validate}
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
            {formatTextBySizeUnit(title, sizeUnit)}
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
          {invalidFields[id] && (
            <div class="invalid-feedback js-invalid-feedback">
              {invalidFields[id]}
            </div>
          )}
        </div>
      </div>
      {getSelectedOption()?.child_steps?.map((stepId) => {
        const childStep = stepsMap[stepId];
        return <Step key={childStep.id} step={childStep} />;
      })}
    </>
  );
};

export default Step;
