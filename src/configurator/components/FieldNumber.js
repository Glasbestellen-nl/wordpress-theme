const { useState, useContext, useEffect } = wp.element;
import { ConfiguratorContext } from "../context/ConfiguratorContext";
import { calculateValueByFormula } from "../utils/formulas";

const FieldNumber = ({
  id,
  required,
  rules,
  disabled,
  formula,
  changeHandler,
  validate,
}) => {
  const {
    configuration,
    setConfiguration,
    sizeUnit,
    invalidFields,
    addInvalidField,
    removeInvalidField,
  } = useContext(ConfiguratorContext);
  const [value, setValue] = useState(null);

  useEffect(() => {
    if (configuration[id]) {
      setValue(configuration[id]);
    } else if (configuration && formula) {
      let value = calculateValueByFormula(formula, configuration);
      if (value) setValue(Math.round(value));
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
    else if (value && !disabled) classNames.push("valid");
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
      disabled={disabled}
    />
  );
};

export default FieldNumber;
