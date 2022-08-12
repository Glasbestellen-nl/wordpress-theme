import Field_Number from "./Field_Number";
import Field_Dropdown from "./Field_Dropdown";

const Step = ({ step }) => {
  const { title, required, options, description } = step;

  const isRequired = () => {
    return (
      (required && options && options.length == 0) ||
      (required && options && options.length > 0 && options.length > 1)
    );
  };

  const getDescriptionId = () => {
    return description && description.id;
  };

  const hasOptions = () => {
    return options && options.length > 0;
  };

  const renderInputField = () => {
    if (hasOptions()) {
      if (options.length == 1 && isRequired()) {
        return (
          <>
            <span>{options[0].title}</span>
            <input type="hidden" value="" class="js-input-hidden"></input>
          </>
        );
      } else {
        return <Field_Dropdown options={options} />;
      }
    } else {
      return <Field_Number />;
    }
  };

  const getInputRowClasses = () => {
    const classes = ["configurator__form-col", "configurator__form-input"];
    if (hasOptions() && options.length == 1 && isRequired()) {
      classes.push("configurator__form-input--default");
    }
    return classes.join(" ");
  };

  return (
    <div className="configurator__form-row">
      <div className="configurator__form-col">
        <label
          className="configurator__form-label"
          data-explanation-id={getDescriptionId()}
        >
          {title}
        </label>{" "}
        {isRequired() && <span>*</span>}
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
