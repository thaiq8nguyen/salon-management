import { client, authClient } from "./apiClient";

const login = (credential) => {
  return client.post("/login", credential);
};

const register = (user) => {
  return client.post("/register", user);
};
const logout = () => {
  return authClient.post("/logout");
};

export default {
  login,
  register,
  logout
};
