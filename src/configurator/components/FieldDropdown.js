const { useContext } = wp.element;
import { ConfiguratorContext } from "../context/ConfiguratorContext";
import Option from "./Option";

const FieldDropdown = (props) => {
  const { id, options } = props;
  const { configuration, setConfiguration, setCollapsedSteps } =
    useContext(ConfiguratorContext);

  const handleChange = (e) => {
    const value = e.target.value;
    setConfiguration((prevState) => ({ ...prevState, [id]: value }));
    if (options) {
      setCollapsedSteps((prevCollapsedSteps) => {
        let updatedCollapsedSteps = prevCollapsedSteps;
        options.forEach((option) => {
          const childSteps = option.child_steps;
          if (childSteps) {
            if (Array.isArray(childSteps)) {
              option.child_steps.forEach((stepId) => {
                if (option.id == value) {
                  updatedCollapsedSteps = updatedCollapsedSteps.filter(
                    (id) => id !== stepId
                  );
                } else {
                  updatedCollapsedSteps.push(stepId);
                }
              });
            } else {
              const stepId = childSteps;
              if (option.id == value) {
                updatedCollapsedSteps = updatedCollapsedSteps.filter(
                  (id) => id !== stepId
                );
              } else {
                updatedCollapsedSteps.push(stepId);
              }
            }
          }
        });
        return updatedCollapsedSteps;
      });
    }
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

export default FieldDropdown;
