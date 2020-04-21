const loadState = () => {
  try {
    const serializedState = localStorage.getItem("appState");
    if (serializedState === null) {
      return undefined;
    }

    const state = JSON.parse(serializedState);

    return state;
  } catch (errors) {
    return undefined;
  }
};

const saveState = (state) => {
  try {
    const serializedState = JSON.stringify(state);

    localStorage.setItem("appState", serializedState);
  } catch (errors) {
    return undefined;
  }
};

const removeState = () => {
  try {
    localStorage.removeItem("appState");
  } catch (errors) {
    return undefined;
  }
};

export { loadState, saveState, removeState };
