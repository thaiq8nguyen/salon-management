export default {
  isAuthenticated(state) {
    return !!state.user.accessToken;
  },
  user(state) {
    return state.user;
  },
  accessToken(state) {
    return state.user.accessToken;
  }
};
