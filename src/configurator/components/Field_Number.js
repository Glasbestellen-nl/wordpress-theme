const { useContext } = wp.element;
import { SettingsContext } from "../context/SettingsContext";

const Field_Number = () => {
  const { sizeUnit } = useContext(SettingsContext);

  return (
    <input
      type="number"
      className="form-control configurator__form-control"
      placeholder={sizeUnit}
    />
  );
};

export default Field_Number;
