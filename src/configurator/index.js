const { render } = wp.element;
import { SettingsProvider } from "./context/SettingsContext";
import { ConfigurationProvider } from "./context/ConfigurationContext";
import Configurator from "./components/Configurator";
if (document.getElementById("react_configurator")) {
  render(
    <SettingsProvider>
      <ConfigurationProvider>
        <Configurator />
      </ConfigurationProvider>
    </SettingsProvider>,
    document.getElementById("react_configurator")
  );
}
