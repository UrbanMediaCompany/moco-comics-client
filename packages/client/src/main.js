import SiteLayout from '~/layouts/Site.vue';
import MainLayout from '~/layouts/Main.vue';

import 'fontsource-assistant';
import 'fontsource-paytone-one/400-normal.css';
import 'fontsource-luckiest-guy/400-normal.css';

export default function (Vue) {
  // Set default layout as a global component
  Vue.component('SiteLayout', SiteLayout);
  Vue.component('MainLayout', MainLayout);
}
