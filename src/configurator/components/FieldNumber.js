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
}) => {
  const [state, dispatch] = useContext(ConfiguratorContext);
  const [value, setValue] = useState(null);

  useEffect(() => {
    setValue(state.configuration[id]);
  }, [state.configuration[id]]);

  const handleChange = (e) => {
    let value = e.target.value;
    if (value && state.sizeUnit === "cm") value *= 10;
    const { valid, message } = validate(value, required, rules, state.sizeUnit);
    if (!valid) {
      dispatch({ type: "add_invalid_field", payload: { id, message } });
    } else {
      dispatch({ type: "remove_invalid_field", payload: { id } });
    }
    setValue(value);
  };

  const handleBlur = () => {
    changeHandler(value);
  };

  const getClassNames = () => {
    const classNames = ["form-control", "configurator__form-control"];
    if (state.invalidFields[id]) classNames.push("invalid");
    else if (value && !disabled) classNames.push("valid");
    return classNames.join(" ");
  };

  const getValue = () => {
    if (!value) return "";
    if (state.sizeUnit === "cm") {
      return value / 10;
    }
    return value;
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
