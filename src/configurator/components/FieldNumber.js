const { useState, useEffect, useContext } = wp.element;
import { ConfiguratorContext } from "../context/ConfiguratorContext";

const FieldNumber = ({ id }) => {
  const { sizeUnit, configuration, setConfiguration } =
    useContext(ConfiguratorContext);
  const [value, setValue] = useState(null);

  useEffect(() => {
    if (configuration[id]) setValue(configuration[id]);
  }, [configuration]);

  const handleChange = (e) => {
    setValue(e.target.value);
  };

  const handleBlur = () => {
    setConfiguration((prevConfig) => ({ ...prevConfig, [id]: value }));
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

export default FieldNumber;
