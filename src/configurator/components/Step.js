const { useContext } = wp.element;
import { formatTextBySizeUnit } from "../utils/sizeUnit";
import { ConfiguratorContext } from "../context/ConfiguratorContext";
import FieldNumber from "./FieldNumber";
import FieldDropdown from "./FieldDropdown";

const Step = ({ step }) => {
  const {
    id,
    value,
    invalid,
    options,
    required,
    rules,
    disabled,
    description,
    title,
    formula,
  } = step;
  const [state, dispatch] = useContext(ConfiguratorContext);

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

  const getDescriptionId = () => {
    return description && description.id;
  };

  const hasOptions = () => {
    return options && options.length > 0;
  };

  const changeHandler = (value) => {
    dispatch({ type: "update_step_value", payload: { id, value } });
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
            value={value}
            invalid={invalid}
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
          disabled={disabled}
          formula={formula}
        />
      );
    }
  };

  return (
    <div>
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
            {invalid && (
              <div class="invalid-feedback js-invalid-feedback">{invalid}</div>
            )}
          </div>
        </div>
      </>
    </div>
  );
};

export default Step;
