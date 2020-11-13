// This is the main.js file. Import global CSS and scripts here.
// The Client API can be used here. Learn more: gridsome.org/docs/client-api
import DefaultLayout from '~/layouts/Default.vue';
import 'typeface-assistant';
import 'typeface-paytone-one';
import 'typeface-luckiest-guy';
import '~/styles/global.css';

export default function (Vue) {
  // Set default layout as a global component
  Vue.component('Layout', DefaultLayout);
}
