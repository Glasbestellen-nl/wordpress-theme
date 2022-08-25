const { useContext } = wp.element;
import { ConfiguratorContext } from "../context/ConfiguratorContext";
import Option from "./Option";

const FieldDropdown = ({ id, options, changeHandler }) => {
  const { configuration } = useContext(ConfiguratorContext);

  const getValue = () => {
    return configuration && configuration[id];
  };

  const getDefault = () => {
    if (!options || options.length == 0) return;
    return options.find((option) => option.default);
  };

  const handleChange = (e) => {
    changeHandler(e.target.value);
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

export default FieldDropdown;
