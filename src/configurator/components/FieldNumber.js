const { useState, useEffect, useContext } = wp.element;
import { ConfiguratorContext } from "../context/ConfiguratorContext";

const FieldNumber = ({ id, required, rules, changeHandler, validate }) => {
  const {
    sizeUnit,
    configuration,
    invalidFields,
    addInvalidField,
    removeInvalidField,
  } = useContext(ConfiguratorContext);
  const [value, setValue] = useState(null);

  useEffect(() => {
    if (configuration[id]) {
      const { valid, message } = validate(
        configuration[id],
        required,
        rules,
        sizeUnit
      );
      if (!valid) {
        addInvalidField(id, message);
      } else {
        removeInvalidField(id);
      }
      setValue(configuration[id]);
    }
  }, [configuration]);

  const handleChange = (e) => {
    let value = e.target.value;
    if (value && sizeUnit === "cm") value *= 10;
    const { valid, message } = validate(value, required, rules, sizeUnit);
    if (!valid) {
      addInvalidField(id, message);
    } else {
      removeInvalidField(id);
    }
    setValue(value);
  };

  const handleBlur = () => {
    changeHandler(value);
  };

  const getClassNames = () => {
    const classNames = ["form-control", "configurator__form-control"];
    if (invalidFields[id]) classNames.push("invalid");
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
