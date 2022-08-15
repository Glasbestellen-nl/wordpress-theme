const { useContext } = wp.element;
import { ConfiguratorContext } from "../context/ConfiguratorContext";
import Step from "./Step";

const Configurator = () => {
  const { steps } = useContext(ConfiguratorContext);

  return (
    <div>
      {steps.map((step) => {
        return <Step key={step.id} step={step} />;
      })}
    </div>
  );
};

export default Configurator;
