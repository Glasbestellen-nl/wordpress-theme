const Option = ({ option }) => {
  const { id, title, value } = option;

  const getId = () => {
    return id;
  };

  const getTitle = () => {
    return title;
  };

  return <option value={getId()}>{getTitle()}</option>;
};

export default Option;
