import axios from "axios";
import Store from "Store";

axios.defaults.baseURL = "/api/";

const headers = {
  accept: "application/json",
  "Content-Type": "application/json"
};

const client = axios.create({
  headers
});

const authClient = axios.create({
  headers
});

authClient.interceptors.request.use(
  function (config) {
    const token = Store.getters["Authentications/accessToken"];
    config.headers["Authorization"] = `Bearer ${token}`;

    return config;
  },
  function (error) {
    return Promise.reject(error);
  }
);

export { client, authClient };
