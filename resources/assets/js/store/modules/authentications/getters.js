export default {
  isAuthenticated(state) {
    return !!state.authentication.accessTolken;
  }
};
