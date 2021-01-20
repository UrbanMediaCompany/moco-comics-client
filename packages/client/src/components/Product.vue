<template>
  <article class="flex flex-col flex-nowrap items-center md:justify-evenly">
    <div class="relative px-6 mb-8">
      <g-image :src="media.url" class="w-full max-w-5xl border-4 border-black" />

      <p
        class="absolute -bottom-6 right-0 w-32 h-32 bg-mc-yellow text-white font-display flex justify-center items-center border-b-8 border-mc-yellow-500 rounded-full"
      >
        <span class="">{{ formattedPrice }}</span>
      </p>
    </div>

    <div class="w-full bg-white border-t-10 border-grey-300 rounded-lg shadow-sm overflow-hidden px-8 pb-8">
      <header class="pt-8 mb-8">
        <h2 class="font-display text-md">{{ name }}</h2>
        <time :datetime="publishedDate" class="font-display text-grey-400">{{
          capitalize(formattedPublishedDate)
        }}</time>
      </header>

      <button
        @click="addToCart()"
        type="button"
        class="group w-full max-w-xl mx-auto flex justify-center items-center bg-mc-blue text-center text-sm text-white py-2 px-4 rounded-lg font-display disabled:opacity-70 disabled:cursor-not-allowed"
        :disabled="showConfirmation"
      >
        <ShopIcon class="mr-4 transform origin-top group-hover:rotate-12 transition-transform duration-200" />
        {{ showConfirmation ? '¡Agregado al carrito!' : '¡Lo quiero!' }}
      </button>
    </div>
  </article>
</template>

<script>
import ShopIcon from '~/assets/icons/shopping-bag.svg';
import capitalize from '~/utils/capitalize';
import formatMoney from '~/utils/format-money';

export default {
  name: 'Product',
  components: {
    ShopIcon,
  },
  props: {
    id: String,
    name: String,
    price: Number,
    media: Object,
    publishedDate: String,
    formattedPublishedDate: String,
  },
  data() {
    return {
      showConfirmation: false,
    };
  },
  computed: {
    formattedPrice() {
      return formatMoney(this.price);
    },
  },
  methods: {
    capitalize,
    addToCart() {
      this.$emit('add-to-cart', this.id);
      this.showConfirmation = true;

      setTimeout(() => {
        this.showConfirmation = false;
      }, 2000);
    },
  },
};
</script>
