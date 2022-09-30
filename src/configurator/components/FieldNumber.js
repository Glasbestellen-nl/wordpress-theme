const { useState, useContext, useEffect } = wp.element;
import { ConfiguratorContext } from "../context/ConfiguratorContext";
import { calculateValueByFormula } from "../utils/formulas";

const FieldNumber = ({
  id,
  required,
  rules,
  disabled,
  changeHandler,
  validate,
  invalid,
  value,
}) => {
  const [state, dispatch] = useContext(ConfiguratorContext);
  const [fieldValue, setFieldValue] = useState(null);

  useEffect(() => {
    setFieldValue(value);
  }, [value]);

  const handleChange = (e) => {
    let value = e.target.value;
    if (value && state.sizeUnit === "cm") value *= 10;
    //const { valid, message } = validate(value, required, rules, state.sizeUnit);
    // if (!valid) {
    //   dispatch({ type: "add_invalid_field", payload: { id, message } });
    // } else {
    //   dispatch({ type: "remove_invalid_field", payload: { id } });
    // }
    setFieldValue(value);
  };

  const handleBlur = () => {
    changeHandler(fieldValue);
  };

  const getClassNames = () => {
    const classNames = ["form-control", "configurator__form-control"];
    if (invalid) classNames.push("invalid");
    else if (fieldValue && !disabled) classNames.push("valid");
    return classNames.join(" ");
  };

  const getValue = () => {
    if (!fieldValue) return "";
    if (state.sizeUnit === "cm") {
      return fieldValue / 10;
    }
    return fieldValue;
  };

  return (
    <input
      type="number"
      className={getClassNames()}
      placeholder={state.sizeUnit}
      onChange={handleChange}
      onBlur={handleBlur}
      value={getValue()}
      disabled={disabled}
    />
  );
};

export default FieldNumber;
