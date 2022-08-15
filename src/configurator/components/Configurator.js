const { useContext } = wp.element;
import { SettingsContext } from "../context/SettingsContext";
import { ConfigurationContext } from "../context/ConfigurationContext";
import Step from "./Step";

const Configurator = () => {
  const { steps } = useContext(SettingsContext);
  const { configuration, setConfiguration } = useContext(ConfigurationContext);

  return (
    <div>
      {steps.map((step) => {
        return <Step key={step.id} step={step} />;
      })}
    </div>
  );
};

export default Configurator;
