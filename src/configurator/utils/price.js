const { tax, currency } = window.configurator;

export const priceIncludingVat = (price) => {
  const { rate } = tax;
  return price + price * (rate / 100);
};

export const formatPrice = (price) => {
  return new Intl.NumberFormat("nl-NL", { style: "currency", currency }).format(
    price
  );
};
