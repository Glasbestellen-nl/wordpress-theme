const { useContext, useState, useEffect } = wp.element;
import { ConfiguratorContext } from "../context/ConfiguratorContext";
import FieldNumber from "./FieldNumber";
import FieldDropdown from "./FieldDropdown";
import { getStepsData } from "../services/steps";
const stepsMap = getStepsData().reduce(
  (acc, step) => ({ ...acc, [step.id]: step }),
  {}
);
const Step = ({ step }) => {
  const { id, title, required, options, description } = step;
  const { setConfiguration, configuration } = useContext(ConfiguratorContext);
  const [selectedOption, setSelectedOption] = useState(null);

  useEffect(() => {
    if (options && configuration[id]) {
      const option = options.find((option) => option.id === configuration[id]);
      if (option) setSelectedOption(option);
    }
  }, [configuration]);

  // Remove element from configuration when unmounting
  useEffect(
    () => () => {
      setConfiguration((prevConfig) => {
        const { [id]: removedItem, ...rest } = prevConfig;
        return rest;
      });
    },
    []
  );

  const getDescriptionId = () => {
    return description && description.id;
  };

  const hasOptions = () => {
    return options && options.length > 0;
  };

  const changeHandler = (value) => {
    if (options) {
      setSelectedOption(options.find((option) => option.id === value));
    }
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
          />
        );
      }
    } else {
      return <FieldNumber id={id} changeHandler={changeHandler} />;
    }
  };

  const getClasses = () => {
    const classes = ["configurator__form-row"];
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
    <>
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
      {selectedOption?.child_steps?.map((stepId) => {
        const childStep = stepsMap[stepId];
        return <Step key={childStep.id} step={childStep} />;
      })}
    </>
  );
};

export default Step;
