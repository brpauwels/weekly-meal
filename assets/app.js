import 'bootstrap/dist/js/bootstrap.bundle';

import Vue from "vue";
import App from "./components/App";
import router from "./router";
import store from "./store";

import './styles/app.scss';

new Vue({
  components: {App},
  template: "<App/>",
  router,
  store
}).$mount("#app");
