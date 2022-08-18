export const getStepsData = () => {
  // return (
  //   window.gb &&
  //   window.gb.configuratorSettings &&
  //   window.gb.configuratorSettings.steps
  // );
  return [
    {
      id: "step_a",
      title: "Step A",
      options: [
        {
          id: "1",
          title: "Option 1",
          child_steps: ["step_b"],
        },
        {
          id: "2",
          title: "Option 2",
          child_steps: ["step_c"],
        },
      ],
    },
    {
      id: "step_b",
      title: "Step B",
      parent_step: "step_a",
      options: [
        {
          id: "1",
          title: "Option 1",
        },
        {
          id: "2",
          title: "Option 2",
        },
      ],
    },
    {
      id: "step_c",
      title: "Step C",
      parent_step: "step_a",
      options: [
        {
          id: "1",
          title: "Option 1",
          child_steps: ["step_d"],
        },
        {
          id: "2",
          title: "Option 2",
        },
      ],
    },
    {
      id: "step_d",
      title: "Step D",
      parent_step: "step_c",
      options: [
        {
          id: "1",
          title: "Option 1",
        },
        {
          id: "2",
          title: "Option 2",
        },
      ],
    },
  ];
};
