import { priceIncludingVat, formatPrice } from "../services/price";

const Option = ({ option, defaultOption }) => {
  const { id, title, price } = option;

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
      let plusPrice = formatPrice(priceIncludingVat(price - defaultPrice));
      finalTitle.push("+ " + plusPrice);
    }
    return finalTitle.join(" ");
  };

  return <option value={getId()}>{getTitle()}</option>;
};

export default Option;
