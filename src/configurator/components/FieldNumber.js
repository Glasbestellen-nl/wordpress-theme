const { useState, useContext, useEffect, useRef } = wp.element;
import { ConfiguratorContext } from "../context/ConfiguratorContext";
import { calculateValueByFormula } from "../utils/formulas";
import { validate } from "../utils/validation";
import { getConfigurationFromSteps } from "../utils/configuration";

const FieldNumber = ({
  id,
  required,
  rules,
  disabled,
  changeHandler,
  invalid,
  value,
}) => {
  const [state, dispatch] = useContext(ConfiguratorContext);
  const [fieldValue, setFieldValue] = useState(null);
  const [touched, setTouched] = useState(false);

  useEffect(() => {
    setFieldValue(value);
  }, [value]);

  const handleChange = (e) => {
    if (!touched) setTouched(true);
    let value = e.target.value;
    if (value && state.sizeUnit === "cm") value *= 10;
    const { valid, message } = validate(
      value,
      required,
      rules,
      getConfigurationFromSteps(state.steps),
      state.sizeUnit
    );
    if (!valid) {
      dispatch({
        type: "update_step",
        payload: { id, property: "invalid", value: message },
      });
    } else {
      dispatch({
        type: "update_step",
        payload: { id, property: "invalid", value: false },
      });
    }
    if (valid && value === 0) value = value.toString(); // to allow number 0
    setFieldValue(value);
  };

  const handleBlur = () => {
    if (!touched) setTouched(true);
    changeHandler(fieldValue);
  };

  const getClassNames = () => {
    const classNames = ["form-control", "configurator__form-control"];
    if (invalid) classNames.push("invalid");
    else if (touched && fieldValue && !disabled) classNames.push("valid");
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
