const { useState, useEffect, useContext } = wp.element;
import { ConfiguratorContext } from "../context/ConfiguratorContext";
import { validateBasic, validateByRules } from "../services/validation";

const FieldNumber = ({
  id,
  changeHandler,
  required,
  rules,
  invalid,
  setInvalid,
}) => {
  const { sizeUnit, configuration } = useContext(ConfiguratorContext);
  const [value, setValue] = useState(null);

  useEffect(() => {
    if (configuration[id]) setValue(configuration[id]);
  }, [configuration]);

  const handleChange = (e) => {
    const value = e.target.value;
    const { valid, message } = validate(value);
    if (!valid) {
      setInvalid(message);
    } else {
      setInvalid(false);
    }
    setValue(value);
  };

  const validate = (value) => {
    let validationResult = required
      ? validateBasic(value)
      : { valid: true, message: "" };
    if (validationResult.valid) {
      if (rules)
        validationResult = validateByRules(value, rules, configuration);
    }
    return validationResult;
  };

  const handleBlur = () => {
    const { valid, message } = validate(value);
    if (!valid) {
      setInvalid(message);
    } else {
      setInvalid(false);
      changeHandler(value);
    }
  };

  const getClassNames = () => {
    const classNames = ["form-control", "configurator__form-control"];
    if (invalid) classNames.push("invalid");
    else classNames.push("valid");
    return classNames.join(" ");
  };

  return (
    <input
      type="number"
      className={getClassNames()}
      placeholder={sizeUnit}
      onChange={handleChange}
      onBlur={handleBlur}
      value={value}
    />
  );
};

export default FieldNumber;
