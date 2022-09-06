const { useContext, useEffect } = wp.element;
import { formatTextBySizeUnit } from "../services/sizeUnit";
import { ConfiguratorContext } from "../context/ConfiguratorContext";
import Option from "./Option";

const FieldDropdown = ({
  id,
  options,
  rules,
  changeHandler,
  validate,
  required,
}) => {
  const {
    configuration,
    sizeUnit,
    invalidFields,
    addInvalidField,
    removeInvalidField,
  } = useContext(ConfiguratorContext);

  useEffect(() => {
    const handleInvalidOptionCombinations = () => {
      if (configuration[id]) {
        const selectedOption = options.find(
          (option) => option.id === configuration[id]
        );
        if (
          selectedOption &&
          selectedOption.rules &&
          selectedOption.rules.exclude
        ) {
          const { exclude } = selectedOption.rules;
          removeInvalidField(id);
          exclude.forEach((rule) => {
            const { step, options, message } = rule;
            if (configuration[step]) {
              const compareConfig = configuration[step];
              if (options.includes(compareConfig)) {
                addInvalidField(id, formatTextBySizeUnit(message, sizeUnit));
              }
            }
          });
        }
      }
    };
    handleInvalidOptionCombinations();
  }, [configuration]);

  const getValue = () => {
    return configuration && configuration[id];
  };

  const getOptionValueById = (id) => {
    const option = options.find((option) => option.id === parseInt(id));
    return option && option.value ? option.value : id;
  };

  const getDefault = () => {
    if (!options || options.length == 0) return;
    return options.find((option) => option.default);
  };

  const handleChange = (e) => {
    const value = e.target.value;
    const { valid, message } = validate(
      getOptionValueById(value),
      required,
      rules,
      sizeUnit
    );
    if (!valid) {
      addInvalidField(id, formatTextBySizeUnit(message, sizeUnit));
    } else {
      removeInvalidField(id);
      changeHandler(value);
    }
  };

  const getClassNames = () => {
    const classNames = [
      "dropdown configurator__dropdown",
      "configurator__form-control",
    ];
    if (invalidFields[id]) classNames.push("invalid");
    else classNames.push("valid");
    return classNames.join(" ");
  };

  return (
    <select class={getClassNames()} onChange={handleChange} value={getValue()}>
      {!getDefault() && <option value="">Geen</option>}
      {options &&
        options.length > 0 &&
        options.map((option) => (
          <Option
            key={option.id}
            option={option}
            defaultOption={getDefault()}
          />
        ))}
    </select>
  );
};

export default FieldDropdown;
