const { useState, useEffect, useContext } = wp.element;
import { ConfiguratorContext } from "../context/ConfiguratorContext";

const Field_Number = ({ id }) => {
  const [value, setValue] = useState(null);
  const { steps, setSteps, sizeUnit } = useContext(ConfiguratorContext);

  useEffect(() => {
    if (steps) {
      const step = steps.find((step) => step.id == id);
      if (step && step.value) setValue(step.value);
    }
  }, [steps]);

  const handleChange = (e) => {
    setValue(e.target.value);
  };

  const handleBlur = () => {
    if (value) {
      setSteps((prevSteps) => {
        return prevSteps.map((step) => {
          if (step.id == id) step.value = value;
          return step;
        });
      });
    }
  };

  return (
    <input
      type="number"
      className="form-control configurator__form-control"
      placeholder={sizeUnit}
      onChange={handleChange}
      onBlur={handleBlur}
      value={value}
    />
  );
};

export default Field_Number;
