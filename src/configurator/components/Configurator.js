const { useContext, useEffect } = wp.element;
import { getStepsData } from "../services/steps";
import { ConfiguratorContext } from "../context/ConfiguratorContext";
import Step from "./Step";

const Configurator = () => {
  const steps = getStepsData().filter((step) => !step.parent_step);
  const { totalPriceHtml } = useContext(ConfiguratorContext);

  useEffect(() => {
    // Temporary setting price with jQuery
    if (totalPriceHtml !== "")
      jQuery(".js-config-total-price").html(totalPriceHtml);
  }, [totalPriceHtml]);

  return (
    <div>
      {steps.map((step) => {
        return <Step key={step.id} step={step} />;
      })}
    </div>
  );
};

export default Configurator;
