import Vue from "vue";
import VueRouter from "vue-router";
Vue.use(VueRouter);

const routes = [
  {
    path: "/",
    redirect: {
      name: "login",
    },
  },
  {
    path: "/login",
    name: "login",
    component: () => import("@/pages/Auth/loginPage.vue"),
    meta: {
      menu: "User",
    },
  },
  {
    path: "/dashboard",
    name: "dashboard",
    component: () => import("@/pages/Dashboard/dashboardPage.vue"),
    meta: {
      menu: "Dashboard",
      requiresAuth: true,
    },
  },
  {
    path: "/user",
    name: "User List",
    component: () => import("@/pages/Auth/user-listPage.vue"),
    meta: {
      menu: "User",
      requiresAuth: true,
    },
  },
  {
    path: "/user/register",
    name: "register",
    component: () => import("@/pages/Auth/registerPage.vue"),
    meta: {
      menu: "Education",
      requiresAuth: true,
    },
  },
];

const router = new VueRouter({
  routes,
});

router.beforeEach((to, from, next) => {
  // instead of having to check every route record with
  // to.matched.some(record => record.meta.requiresAuth)
  if (to.matched.some((record) => record.meta.requiresAuth)) {
    const token = localStorage.getItem("token");
    if (!token) {
      next({
        name: "login",
      });
    } else {
      next();
    }
  } else {
    //if route no auth
    next();
  }
});

export default router;
