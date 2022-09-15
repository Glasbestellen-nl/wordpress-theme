const { render } = wp.element;
import Configurator from "./components/Configurator";
if (document.getElementById("react_configurator")) {
  render(<Configurator />, document.getElementById("react_configurator"));
}
