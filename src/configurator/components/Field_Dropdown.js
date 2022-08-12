import Option from "./Option";

const Field_Dropdown = (props) => {
  const { options } = props;

  const getDefault = () => {
    if (!options || options.length == 0) return;
    return options.find((option) => option.default);
  };

  return (
    <select class="dropdown configurator__dropdown configurator__form-control">
      {!getDefault() && <option>Geen</option>}
      {options &&
        options.length > 0 &&
        options.map((option) => <Option key={option.id} option={option} />)}
    </select>
  );
};

export default Field_Dropdown;
