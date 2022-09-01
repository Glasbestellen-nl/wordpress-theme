const { useContext } = wp.element;
import { priceIncludingVat, formatPrice } from "../services/price";
import { formatTextBySizeUnit } from "../services/sizeUnit";
import { ConfiguratorContext } from "../context/ConfiguratorContext";

const Option = ({ option, defaultOption }) => {
  const { id, title, price } = option;
  const { sizeUnit } = useContext(ConfiguratorContext);

  const getId = () => {
    return id;
  };

  const isDefaultOption = () => {
    return defaultOption && defaultOption.id == id;
  };

  const getDefaultPrice = () => {
    return (defaultOption && defaultOption.price) || 0;
  };

  const getTitle = () => {
    const finalTitle = [];
    const isDefault = isDefaultOption();
    finalTitle.push(title);
    if (parseInt(price) !== 0 && !isDefault) {
      const defaultPrice = getDefaultPrice();
      const plusPrice = price - defaultPrice;
      if (parseInt(plusPrice) !== 0) {
        const plusFormattedPrice = formatPrice(priceIncludingVat(plusPrice));
        finalTitle.push("+ " + plusFormattedPrice);
      }
    }
    return formatTextBySizeUnit(finalTitle.join(" "), sizeUnit);
  };

  return <option value={getId()}>{getTitle()}</option>;
};

export default Option;
