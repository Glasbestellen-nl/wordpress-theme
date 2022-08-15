const { useContext } = wp.element;
import Option from "./Option";
import { ConfiguratorContext } from "../context/ConfiguratorContext";

const Field_Dropdown = (props) => {
  const { id, options } = props;
  const { steps, setSteps } = useContext(ConfiguratorContext);

  const handleChange = (e) => {
    if (e.target.value)
      setSteps((prevSteps) => {
        return prevSteps.map((step) => {
          if (step.id == id) step.value = e.target.value;
          return step;
        });
      });
  };

  const getValue = () => {
    if (steps) {
      const step = steps.find((step) => step.id == id);
      return step && step.value;
    }
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
