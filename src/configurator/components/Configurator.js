import { getStepsData } from "../services/data";
import Step from "./Step";

const Configurator = () => {
  const steps = getStepsData();

  return (
    <div>
      {steps.map((step) => {
        return <Step key={step.id} step={step} />;
      })}
    </div>
  );
};

export default Configurator;
