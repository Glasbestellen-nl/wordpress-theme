const { useContext } = wp.element;
import Option from "./Option";
import { ConfigurationContext } from "../context/ConfigurationContext";

const Field_Dropdown = (props) => {
  const { id, options } = props;
  const { configuration, updateConfiguration } =
    useContext(ConfigurationContext);

  const handleChange = (e) => {
    updateConfiguration({
      [id]: e.target.value,
    });
  };

  const getValue = () => {
    return configuration && configuration[id];
  };

  const getDefault = () => {
    if (!options || options.length == 0) return;
    return options.find((option) => option.default);
  };

  return (
    <select
      class="dropdown configurator__dropdown configurator__form-control"
      onChange={handleChange}
      value={getValue()}
    >
      {!getDefault() && <option value="">Geen</option>}
      {options &&
        options.length > 0 &&
        options.map((option) => <Option key={option.id} option={option} />)}
    </select>
  );
};

export default Field_Dropdown;
