// This is the main.js file. Import global CSS and scripts here.
// The Client API can be used here. Learn more: gridsome.org/docs/client-api
import DefaultLayout from '~/layouts/Default.vue';

import 'fontsource-assistant';
import 'fontsource-paytone-one/400-normal.css';
import 'fontsource-luckiest-guy/400-normal.css';

export default function (Vue) {
  // Set default layout as a global component
  Vue.component('Layout', DefaultLayout);
}
