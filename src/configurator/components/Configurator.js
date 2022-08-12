const { useContext } = wp.element;
import { SettingsContext } from "../context/SettingsContext";
import Step from "./Step";

const Configurator = () => {
  const { steps } = useContext(SettingsContext);
  return (
    <div>
      {steps.map((step) => (
        <Step key={step.id} step={step} />
      ))}
    </div>
  );
};

export default Configurator;
