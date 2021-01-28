import SecurityAPI from "../api/security";

const AUTHENTICATING = "AUTHENTICATING",
  AUTHENTICATING_SUCCESS = "AUTHENTICATING_SUCCESS",
  AUTHENTICATING_ERROR = "AUTHENTICATING_ERROR",
  PROVIDING_DATA_ON_REFRESH_SUCCESS = "PROVIDING_DATA_ON_REFRESH_SUCCESS";

export default {
  namespaced: true,
  state: {
    isLoading: false,
    error: null,
    isAuthenticated: false,
    user: null
  },
  getters: {
    isLoading(state) {
      return state.isLoading;
    },
    hasError(state) {
      return state.error !== null;
    },
    error(state) {
      return state.error;
    },
    isAuthenticated(state) {
      return state.isAuthenticated;
    },
    user(state) {
      return state.user;
    },
  },
  mutations: {
    [AUTHENTICATING](state) {
      state.isLoading = true;
      state.error = null;
      state.isAuthenticated = false;
      state.user = null;
    },
    [AUTHENTICATING_SUCCESS](state, user) {
      state.isLoading = false;
      state.error = null;
      state.isAuthenticated = true;
      state.user = user;
    },
    [AUTHENTICATING_ERROR](state, error) {
      state.isLoading = false;
      state.error = error;
      state.isAuthenticated = false;
      state.user = null;
    },
    [PROVIDING_DATA_ON_REFRESH_SUCCESS](state, payload) {
      state.isLoading = false;
      state.error = null;
      state.isAuthenticated = payload.isAuthenticated;
      state.user = payload.user;
    }
  },
  actions: {
    async login({commit}) {
      commit(AUTHENTICATING);
      try {
        await SecurityAPI.login().then((response) => {
          commit(AUTHENTICATING_SUCCESS, response.data);
        });
      } catch (error) {
        commit(AUTHENTICATING_ERROR, error);
      }
    },
    onRefresh({commit}, payload) {
      commit(PROVIDING_DATA_ON_REFRESH_SUCCESS, payload);
    }
  }
}
