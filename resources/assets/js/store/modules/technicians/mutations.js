export default {
  SET_TECHNICIANS(state, technicians) {
    state.technicians = technicians;
  },
  ADD_TECHNICIAN(state, technician) {
    state.technicians.push(technician);
  },
  UPDATE_TECHNICIAN(state, update) {
    state.technicians = state.technicians.map((technician) =>
      technician.id === update.id ? update : technician
    );
  },
  DELETE_TECHNICIAN(state, id) {
    state.technicians = state.technicians.filter(
      (technician) => technician.id !== id
    );
  }
};
