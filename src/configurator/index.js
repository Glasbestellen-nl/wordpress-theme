const { render } = wp.element;
import { SettingsProvider } from "./context/SettingsContext";
import Configurator from "./components/Configurator";
if (document.getElementById("react_configurator")) {
  render(
    <SettingsProvider>
      <Configurator />
    </SettingsProvider>,
    document.getElementById("react_configurator")
  );
}
