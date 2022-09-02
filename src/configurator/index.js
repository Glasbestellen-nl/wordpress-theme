const { render } = wp.element;
import { ConfiguratorProvider } from "./context/ConfiguratorContext";
import Configurator from "./components/Configurator";
if (document.getElementById("react_configurator")) {
  render(
    <ConfiguratorProvider>
      <Configurator />
    </ConfiguratorProvider>,
    document.getElementById("react_configurator")
  );
}
