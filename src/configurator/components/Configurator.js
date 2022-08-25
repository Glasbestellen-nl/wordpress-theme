import { getStepsData } from "../services/steps";
import Step from "./Step";

const Configurator = () => {
  const steps = getStepsData().filter((step) => !step.parent_step);

  return (
    <div>
      {steps.map((step) => {
        return <Step key={step.id} step={step} />;
      })}
    </div>
  );
};

export default Configurator;
