import Vue from "vue";
import VueRouter from "vue-router";
import store from "../store";
import Home from "../components/Home";
import SignIn from "../components/SignIn";

Vue.use(VueRouter);

let router = new VueRouter({
  mode: "history",
  routes: [
    {path: "/", component: Home, meta: { requiresAuth: true }},
    {path: "/sign-in", component: SignIn},
    {path: "*", redirect: "/"}
  ],
});

export default router;
