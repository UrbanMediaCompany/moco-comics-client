import Vuex, { Store } from 'vuex';
import SiteLayout from '~/layouts/Site.vue';
import MainLayout from '~/layouts/Main.vue';

import 'fontsource-assistant';
import 'fontsource-paytone-one/400-normal.css';
import 'fontsource-luckiest-guy/400-normal.css';

export default function (Vue, { appOptions }) {
  // Set default layout as a global component
  Vue.component('SiteLayout', SiteLayout);
  Vue.component('MainLayout', MainLayout);

  Vue.use(Vuex);

  const persistedVisitor = localStorage.getItem('PERSISTED_VISITOR');

  appOptions.store = new Store({
    state: {
      persistedVisitor: persistedVisitor !== 'undefined' ? JSON.parse(persistedVisitor) : null,
      commentModal: {
        isOpen: false,
        post: null,
        repliesTo: null,
      },
    },
    mutations: {
      persistVisitor(state, payload) {
        state.persistVisitor = payload.visitor;
      },
      forgetVisitor(state) {
        state.persistedVisitor = null;
      },
      openCommentModal(state, payload) {
        state.commentModal = { isOpen: true, post: payload.post, repliesTo: payload.comment || null };
      },
      closeCommentModal(state) {
        state.commentModal = {
          isOpen: false,
          post: null,
          repliesTo: null,
        };
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
      openCommentModal({ commit }, { payload }) {
        commit('openCommentModal', payload);
      },
      closeCommentModal({ commit }) {
        commit('closeCommentModal');
      },
    },
  });
}
