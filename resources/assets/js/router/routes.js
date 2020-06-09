import Login from "Pages/Login";
import Dashboard from "Pages/Dashboard";
import Technicians from "Pages/Technicians";
import Sales from "Pages/Sales";
import Payday from "Pages/Payday";

import Store from "Store";

const routes = [
  { name: "Login", path: "/login", component: Login },
  {
    name: "Dashboard",
    path: "/dashboard",
    component: Dashboard,
    beforeEnter: requiresAuth
  },
  {
    name: "Technicians",
    path: "/technicians",
    component: Technicians,
    beforeEnter: requiresAuth
  },
  {
    name: "Sales",
    path: "/sales",
    component: Sales,
    beforeEnter: requiresAuth
  },
  {
    name: "Payday",
    path: "/payday",
    component: Payday,
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
