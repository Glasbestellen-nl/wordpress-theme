const { useContext } = wp.element;
import { ConfiguratorContext } from "../context/ConfiguratorContext";
import Option from "./Option";

const FieldDropdown = ({ id, options, changeHandler }) => {
  const { configuration, invalidFields } = useContext(ConfiguratorContext);

  const getValue = () => {
    return configuration && configuration[id];
  };

  const getDefault = () => {
    if (!options || options.length == 0) return;
    return options.find((option) => option.default);
  };

  const handleChange = (e) => {
    const value = e.target.value;
    changeHandler(value);
  };

  const getClassNames = () => {
    const classNames = [
      "dropdown configurator__dropdown",
      "configurator__form-control",
    ];
    if (invalidFields[id]) classNames.push("invalid");
    else classNames.push("valid");
    return classNames.join(" ");
  };

  return (
    <select class={getClassNames()} onChange={handleChange} value={getValue()}>
      {!getDefault() && <option value="">Geen</option>}
      {options &&
        options.length > 0 &&
        options.map((option) => (
          <Option
            key={option.id}
            option={option}
            defaultOption={getDefault()}
          />
        ))}
    </select>
  );
};

export default FieldDropdown;
