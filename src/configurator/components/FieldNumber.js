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
    const { valid, message } = validate(configuration[id]);
    if (!valid) {
      setInvalid(message);
    } else {
      setInvalid(false);
    }
    setValue(configuration[id]);
  }, [configuration]);

  const handleChange = (e) => {
    let value = e.target.value;
    if (value && sizeUnit === "cm") value *= 10;
    const { valid, message } = validate(value);
    if (!valid) {
      setInvalid(message, sizeUnit);
    } else {
      setInvalid(false);
    }
    setValue(value);
  };

  const handleBlur = () => {
    changeHandler(value);
  };

  const validate = (value) => {
    let validationResult = required
      ? validateBasic(value)
      : { valid: true, message: "" };
    if (validationResult.valid) {
      if (rules)
        validationResult = validateByRules(
          value,
          rules,
          configuration,
          sizeUnit
        );
    }
    return validationResult;
  };

  const getClassNames = () => {
    const classNames = ["form-control", "configurator__form-control"];
    if (invalid) classNames.push("invalid");
    else if (value) classNames.push("valid");
    return classNames.join(" ");
  };

  const getValue = () => {
    if (!value) return "";
    if (sizeUnit === "cm") {
      return value / 10;
    }
    return value;
  };

  return (
    <input
      type="number"
      className={getClassNames()}
      placeholder={sizeUnit}
      onChange={handleChange}
      onBlur={handleBlur}
      value={getValue()}
    />
  );
};

export default FieldNumber;
