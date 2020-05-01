export default {
  SET_TECHNICIANS(state, technicians) {
    state.technicians = technicians;
  },
  ADD_TECHNICIAN(state, technician) {
    state.technicians.push(technician);
  }
};
