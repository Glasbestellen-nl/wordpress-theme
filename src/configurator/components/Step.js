const { useState, useEffect, useContext } = wp.element;
import { ConfiguratorContext } from "../context/ConfiguratorContext";
import FieldNumber from "./FieldNumber";
import FieldDropdown from "./FieldDropdown";

const Step = ({ step }) => {
  const { id, title, required, options, description, parent_step } = step;
  const { configuration, collapsedSteps } = useContext(ConfiguratorContext);

  const getDescriptionId = () => {
    return description && description.id;
  };

  const hasOptions = () => {
    return options && options.length > 0;
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
        return <FieldDropdown id={id} options={options} />;
      }
    } else {
      return <FieldNumber id={id} />;
    }
  };

  const getClasses = () => {
    const classes = ["configurator__form-row"];
    if (collapsedSteps.includes(id)) classes.push("d-none");
    return classes.join(" ");
  };

  const getInputRowClasses = () => {
    const classes = ["configurator__form-col", "configurator__form-input"];
    if (hasOptions() && options.length == 1 && required) {
      classes.push("configurator__form-input--default");
    }
    return classes.join(" ");
  };

  return (
    <div className={getClasses()}>
      <div className="configurator__form-col">
        <label
          className="configurator__form-label"
          data-explanation-id={getDescriptionId()}
        >
          {title}
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
      <div class={getInputRowClasses()}>
        {renderInputField()}
        <div class="invalid-feedback js-invalid-feedback"></div>
      </div>
    </div>
  );
};

export default Step;
