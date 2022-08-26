const { useContext, useEffect } = wp.element;
import { validateBasic, validateByRules } from "../services/validation";
import { formatTextBySizeUnit } from "../services/sizeUnit";
import { ConfiguratorContext } from "../context/ConfiguratorContext";
import Option from "./Option";

const FieldDropdown = ({
  id,
  options,
  changeHandler,
  required,
  rules,
  invalid,
  setInvalid,
}) => {
  const { configuration, sizeUnit } = useContext(ConfiguratorContext);

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
          setInvalid(false);
          exclude.forEach((rule) => {
            const { step, options, message } = rule;
            if (configuration[step]) {
              const compareConfig = configuration[step];
              if (options.includes(compareConfig)) {
                setInvalid(formatTextBySizeUnit(message, sizeUnit));
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

  const getDefault = () => {
    if (!options || options.length == 0) return;
    return options.find((option) => option.default);
  };

  const validate = (value) => {
    let validationResult = required
      ? validateBasic(value)
      : { valid: true, message: "" };
    if (validationResult.valid) {
      if (rules) {
        validationResult = validateByRules(value, rules, configuration);
      }
    }
    return validationResult;
  };

  const handleChange = (e) => {
    const value = e.target.value;
    const { valid, message } = validate(value);
    if (!valid) {
      setInvalid(formatTextBySizeUnit(message, sizeUnit));
    } else {
      setInvalid(false);
      changeHandler(value);
    }
  };

  const getClassNames = () => {
    const classNames = [
      "dropdown configurator__dropdown",
      "configurator__form-control",
    ];
    if (invalid) classNames.push("invalid");
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
