import Field_Number from "./Field_Number";
import Field_Dropdown from "./Field_Dropdown";

const Step = ({ step }) => {
  const { id, title, required, options, description } = step;

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
        return <Field_Dropdown id={id} options={options} />;
      }
    } else {
      return <Field_Number id={id} />;
    }
  };

  const getInputRowClasses = () => {
    const classes = ["configurator__form-col", "configurator__form-input"];
    if (hasOptions() && options.length == 1 && required) {
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
