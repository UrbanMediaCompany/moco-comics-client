import Vuex, { Store } from 'vuex';
import PortalVue from 'portal-vue';
import SiteLayout from '~/layouts/Site.vue';

import 'fontsource-assistant';
import 'fontsource-paytone-one/400-normal.css';
import 'fontsource-luckiest-guy/400-normal.css';

export default function (Vue, { head, appOptions }) {
  // Set default layout as a global component
  Vue.component('SiteLayout', SiteLayout);

  head.htmlAttrs = { lang: 'es', dir: 'ltr' };

  Vue.use(Vuex);
  Vue.use(PortalVue);

  const persistedVisitor = localStorage.getItem('PERSISTED_VISITOR');

  appOptions.store = new Store({
    state: {
      persistedVisitor: persistedVisitor !== 'undefined' ? JSON.parse(persistedVisitor) : null,
    },
    mutations: {
      persistVisitor(state, payload) {
        state.persistVisitor = payload.visitor;
      },
      forgetVisitor(state) {
        state.persistedVisitor = null;
      },
    },
    actions: {
      persistVisitor({ commit }, { payload }) {
        localStorage.setItem('PERSISTED_VISITOR', JSON.stringify(payload.visitor));
        commit('persistVisitor', payload);
      },
      forgetVisitor({ commit }) {
        localStorage.removeItem('PERSISTED_VISITOR');
        commit('forgetVisitor');
      },
    },
  });
}
