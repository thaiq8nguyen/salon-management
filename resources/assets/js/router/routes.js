import Login from "Pages/Login";
import Dashboard from "Pages/Dashboard";

import Store from "Store";

const routes = [
  { name: "Login", path: "/login", component: Login },
  {
    name: "Dashboard",
    path: "/dashboard",
    component: Dashboard,
    beforeEnter: requiresAuth
  }
];

async function requiresAuth(to, from, next) {
  await Store.getters["Authentications/isAuthenticated"];
  if (Store.getters["Authentications/isAuthenticated"]) {
    next();
  } else {
    next({ name: "Login" });
  }
}

export default routes;
