export const convertNumberBySizeUnit = (number, sizeUnit = "mm") => {
  if ("cm" == sizeUnit) number = number / 10;
  return number;
};

export const formatTextBySizeUnit = (text, sizeUnit = "mm") => {
  if ("cm" == sizeUnit) {
    text = text.replace("/d+(?:[,.]d+)?(?=s*(?:mm))/", (value) => value / 10);
    text = text.replace("mm", "cm");
  }
  return text;
};
