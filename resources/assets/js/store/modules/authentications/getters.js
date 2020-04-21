export default {
  isAuthenticated(state) {
    return !!state.authentication.accessToken;
  }
};
