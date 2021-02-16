<template>
  <!-- Fullscreen overlay -->
  <div
    class="container fixed left-0 right-0 flex flex-col items-stretch justify-end px-constrained z-20 transition-all duration-200 md:static md:px-0 md:mb-10 md:z-auto"
    :class="isLayoutOpened ? 'top-0 left-0 right-0 bottom-sa-3 h-screen pt-16 pb-sa-3 bg-black bg-opacity-50' : ''"
  >
    <!-- Mobile over-tab-bar widget -->
    <div
      class="flex flex-nowrap items-center md:hidden"
      :class="isLayoutOpened ? 'justify-between mb-8' : 'justify-center'"
    >
      <button
        type="button"
        @click="openCart()"
        class="block w-full max-w-md text-center font-cartoon text-white uppercase px-7 pt-6 pb-3 bg-mc-red rounded-full shadow-sm border-b-4 border-mc-red-500"
      >
        Total {{ total }}
      </button>

      <button
        v-show="isLayoutOpened"
        @click="closeCart()"
        type="button"
        class="bg-white rounded-full shadow-sm p-6 ml-4"
      >
        <CloseIcon class="text-mc-blue" />
      </button>
    </div>

    <div
      class="flex flex-col items-center transition-all duration-200 h-0 overflow-hidden md:h-auto"
      :class="isLayoutOpened ? 'h-auto mb-10 md:mb-0' : ''"
    >
      <p
        class="hidden md:flex justify-center items-center w-60 h-60 rounded-full bg-mc-red text-white font-cartoon text-center border-b-10 border-mc-red-500 uppercase text-lg p-12 md:p-16"
      >
        Total <br />
        {{ total }}
      </p>

      <!-- Checkout form -->
      <form class="w-full px-8 pt-6 bg-white rounded-xl md:-mt-12 shadow-sm overflow-y-auto">
        <legend class="w-full font-display mb-8 text-center">Artículos en tu carrito</legend>

        <p v-show="items.length === 0" class="text-sm text-center mb-8">No hay artículos en tu carrito...</p>

        <div
          class="grid grid-cols-cart-item gap-4 items-center py-3 border-b-2 border-dotted"
          v-for="item in items"
          :key="item.id"
        >
          <p class="text-sm col-span-2">
            <span>{{ products[item.id].name }}</span>
            <span> — {{ formatMoney(products[item.id].price) }}</span>
          </p>

          <label
            class="relative font-display text-sm border-2 border-gray-200 rounded-lg hover:border-mc-yellow focus-within:border-mc-yellow transition-colors duration-200"
          >
            <span class="absolute bottom-2 left-2 text-grey-400 mr-2">x</span>

            <input
              v-model="item.quantity"
              type="number"
              min="1"
              max="10"
              name="quantity"
              class="w-full h-full pl-8 p-2 appearance-none"
            />
          </label>

          <button
            @click="removeFromCart(item.id)"
            type="button"
            class="justify-self-end hover:text-mc-red focus:text-mc-red transition-colors duration-200"
          >
            <TrashIcon class="w-8 h-8" />
          </button>
        </div>

        <label
          class="flex flex-nowrap justify-center items-center cursor-pointer border-2 border-transparent px-3 py-4 mt-2 mb-4 rounded-lg focus-within:border-mc-blue focus-within:border-dashed transition-all duration-200"
        >
          <input
            type="checkbox"
            name="international-shipping"
            v-model="isInternationalShipping"
            value="true"
            class="checkbox appearance-none w-8 h-8 rounded-lg mr-4 border-2 border-mc-grey-500 bg-white checked:bg-check-mark"
          />
          <span class="flex-1 font-display text-sm leading-none">Envío Internacional</span>
        </label>

        <p v-show="isInternationalShipping" class="text-sm pl-4 mb-8">
          Se incluirán $10USD de gastos de envío al momento del pago ¯\_(ツ)_/¯
        </p>

        <div v-show="!purchaseSuccess" :class="{ 'opacity-50': !items.length }" id="paypal-buttons" />
      </form>

      <!-- Success message -->
      <section
        v-show="purchaseSuccess"
        class="w-full px-8 py-6 mt-10 bg-mc-blue rounded-xl text-white shadow-sm border-b-6 border-black border-opacity-20"
      >
        <div class="flex flex-col flex-nowrap items-center mb-6">
          <g-image
            src="~/assets/images/juanele-cartoon.png"
            alt=""
            class="w-20 rounded-full bg-white mr-6 bg-mc-blue border-2 border-white mb-2"
          />

          <p class="font-display mb-2">¡Gracias por tu compra!</p>
          <p class="text-sm text-center">Recibirás un correo cuando tu pedido este en camino</p>
        </div>

        <p class="text-sm text-center">
          ¡No olvides darle like a mis redes para que más gente me dé dinero ah no... este shi!
        </p>
      </section>
    </div>
  </div>
</template>

<script>
import formatMoney from '~/utils/format-money';
import loadPaypalSKD from '~/utils/load-paypal-sdk';

import TrashIcon from '~/assets/icons/trash.svg';
import CloseIcon from '~/assets/icons/x.svg';

export default {
  name: 'ShoppingCart',
  components: {
    CloseIcon,
    TrashIcon,
  },
  props: {
    items: {
      type: Array,
      required: true,
    },
    products: {
      type: Object,
      required: true,
    },
    removeFromCart: {
      type: Function,
      required: true,
    },
  },
  async mounted() {
    const mq = window.matchMedia('(min-width: 768px)');
    mq.addEventListener('change', this.handleMediaChange);
    this.handleMediaChange(mq);

    await loadPaypalSKD();

    window.paypal
      .Buttons({
        style: { label: 'pay' },
        onInit: this.initPaypalButtons,
        onClick: this.onPaypalButtonClick,
        createOrder: this.createPaypalOrder,
        onApprove: this.onPaypalOrderApproved,
        onCancel: this.onPaypalOrderCancelled,
        onError: this.onPaypalOrderError,
      })
      .render('#paypal-buttons');
  },
  data() {
    return {
      isMobileViewport: false,
      isCartOpen: false,
      isInternationalShipping: false,
      disablePaypalButtons: () => {},
      enablePaypalButtons: () => {},
      purchaseSuccess: false,
      purchaseError: false,
      payer: '',
    };
  },
  watch: {
    items(items) {
      if (items.length > 0) this.enablePaypalButtons();
      if (items.length === 0) this.disablePaypalButtons();
    },
  },
  computed: {
    total() {
      const total = this.items.reduce((acc, item) => {
        return acc + this.products[item.id].price * item.quantity;
      }, 0);

      return formatMoney(total);
    },
    // Cart is only either 'collapsed' or 'open' when on mobile viewports,
    isLayoutOpened() {
      return this.isMobileViewport && this.isCartOpen;
    },
  },
  methods: {
    formatMoney,
    handleMediaChange({ matches }) {
      this.isMobileViewport = !matches;
    },
    openCart() {
      this.isCartOpen = true;
    },
    closeCart() {
      this.isCartOpen = false;
    },
    initPaypalButtons(_, actions) {
      // Disable buttons on load
      actions.disable();

      // We'll need these in the future so keep a reference
      this.disablePaypalButtons = actions.disable;
      this.enablePaypalButtons = actions.enable;
    },
    onPaypalButtonClick({ fundingSource }) {
      this.purchaseSuccess = false;
      this.purchaseError = false;

      this.$emit('purchase-method-intent', fundingSource);
    },
    createPaypalOrder() {
      return fetch('/.netlify/functions/checkout', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ cart: this.items, isInternationalShipping: this.isInternationalShipping }),
      })
        .then((res) => res.json())
        .then(({ order }) => order)
        .catch((err) => [err]);
    },
    onPaypalOrderApproved(data, actions) {
      this.purchaseSuccess = true;

      this.$emit('purchase-method-intent', null);

      return actions.order.capture().then(({ payer: { name } }) => {
        this.payer = `${name.given_name} ${name.surname}`;
      });
    },
    onPaypalOrderCancelled() {
      this.$emit('purchase-method-intent', null);
    },
    onPaypalOrderError() {
      this.purchaseError = true;

      this.$emit('purchase-method-intent', null);
    },
  },
};
</script>

<style>
.container {
  bottom: calc(9rem + env(safe-area-inset-bottom));
}
</style>
