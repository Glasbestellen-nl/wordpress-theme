const { useState, useEffect, useContext } = wp.element;
import { SettingsContext } from "../context/SettingsContext";
import { ConfigurationContext } from "../context/ConfigurationContext";

const Field_Number = ({ id }) => {
  const { sizeUnit } = useContext(SettingsContext);
  const [value, setValue] = useState(null);
  const { configuration, setConfiguration } = useContext(ConfigurationContext);

  useEffect(() => {
    if (configuration && configuration[id]) setValue(configuration[id]);
  }, [configuration]);

  const handleChange = (e) => {
    setValue(e.target.value);
  };

  const handleBlur = () => {
    if (value) {
      setConfiguration((prevConfiguration) => ({
        ...prevConfiguration,
        [id]: value,
      }));
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
