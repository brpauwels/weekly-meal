import Vue from "vue";
import VueRouter from "vue-router";
import store from "../store";
import Home from "../components/Home";
import SignIn from "../components/SignIn";

Vue.use(VueRouter);

let router = new VueRouter({
  mode: "history",
  routes: [
    {
      path: "/",
      component: Home,
      meta: {requiresAuth: true}
    },
    {
      path: "/sign-in",
      component: SignIn
    },
    {
      path: "*",
      redirect: "/"
    }
  ],
});

router.beforeEach(async (to, from, next) => {
  if (store.getters["security/isAuthenticated"]) {
    next();
  }

  await store.dispatch("security/login");

  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (store.getters["security/isAuthenticated"]) {
      next();
    } else {
      next({path: "/sign-in"});
    }
  } else {
    next();
  }
});

export default router;
