<template>
  <SiteLayout>
    <header class="hero relative w-full bg-mc-yellow pt-28 pb-32 px-constrained text-left overflow-hidden md:pt-44">
      <div class="flex flex-col flex-nowrap relative mb-12 max-w-7xl mx-auto">
        <h1 class="title font-display opacity-95 text-white text-3xl leading-none mb-12">
          ¡Hartos cómics para llevar!
        </h1>
        <p class="font-cartoon opacity-90 text-white text-lg">¡Llévele, llévele!</p>
      </div>
    </header>

    <main class="px-constrained -mt-20 md:pb-64">
      <section class="shelf w-full grid grid-cols-1 gap-16 pb-20 relative">
        <Product v-bind="product" @add-to-cart="addToCart($event)" v-for="product in products" :key="product.id" />
      </section>

      <aside class="pb-48 md:sticky md:-top-4 md:h-min">
        <div class="flex flex-col items-center mb-10">
          <p
            class="flex justify-center items-center w-60 h-60 rounded-full bg-mc-red text-white font-cartoon text-center border-b-10 border-mc-red-500 uppercase text-lg p-12 md:p-16"
          >
            Total <br />
            {{ cartTotal }}
          </p>

          <form @submit.prevent="checkout()" class="w-full px-8 pt-6 pb-8 bg-white rounded-xl -mt-12 shadow-sm">
            <legend class="w-full font-display mb-8 text-center">Artículos en tu carrito</legend>

            <p v-show="cart.length === 0" class="text-sm text-center mb-8">No hay artículos en tu carrito :(</p>

            <div
              class="grid grid-cols-cart-item gap-4 items-center py-3 border-b-2 border-dotted"
              v-for="item in cart"
              :key="item.id"
            >
              <p class="text-sm col-span-2">
                <span>{{ normalizedProducts[item.id].name }}</span>
                <span> — {{ formatMoney(normalizedProducts[item.id].price) }}</span>
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

            <p v-show="isInternationalShipping" class="text-sm pt-8">
              Se incluirán $10USD de gastos de envío al momento del pago ¯\_(ツ)_/¯
            </p>

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

            <button
              type="submit"
              class="w-full flex flex-nowrap justify-center items-center bg-mc-blue text-white py-2 px-4 rounded-lg font-display border-2 border-dashed border-transparent focus:border-white transition-colors duration-200 disabled:cursor-not-allowed disabled:opacity-70"
              :disabled="cart.length === 0"
            >
              <ShopIcon class="mr-4" />
              Pagar con PayPal
            </button>
          </form>
        </div>

        <SocialsNav />
      </aside>
    </main>
  </SiteLayout>
</template>

<page-query>
query {
  allStrapiProducts {
    edges {
      node {
        id
        name
        price
        media {
          url
        }
        publishedDate: published_at
        formattedPublishedDate: published_at(format: "MMMM D, YYYY", locale: "es-MX")
      }
    }
  }
}
</page-query>

<script>
import Product from '~/components/Product';
import SocialsNav from '~/components/SocialsNav';
import TrashIcon from '~/assets/icons/trash.svg';
import ShopIcon from '~/assets/icons/shopping-bag.svg';
import formatMoney from '~/utils/format-money';

export default {
  name: 'Tienda',
  components: {
    Product,
    SocialsNav,
    TrashIcon,
    ShopIcon,
  },
  data() {
    return {
      cart: [],
      isInternationalShipping: false,
    };
  },
  computed: {
    products() {
      return this.$page.allStrapiProducts.edges.map((p) => p.node);
    },
    normalizedProducts() {
      return this.products.reduce((acc, p) => {
        acc[p.id] = p;
        return acc;
      }, {});
    },
    cartTotal() {
      const total = this.cart.reduce((acc, item) => {
        return acc + this.normalizedProducts[item.id].price * item.quantity;
      }, 0);

      return formatMoney(total);
    },
  },
  methods: {
    formatMoney,
    addToCart(item) {
      const cartMatch = this.cart.find((i) => i.id === item);

      if (!cartMatch) {
        this.cart = [...this.cart, { id: item, quantity: 1 }];
        return;
      }

      this.cart = this.cart.map((i) => (i.id === item ? { id: item, quantity: i.quantity + 1 } : i));
    },
    removeFromCart(item) {
      this.cart = this.cart.filter((i) => i.id !== item);
    },
    checkout() {
      console.log(`Wanna buy stuff:`, this.cart);
    },
  },
};
</script>

<style>
.hero::before {
  content: '';
  display: block;
  position: absolute;
  top: 0;
  left: 32%;
  width: max(50rem, 80vw);
  height: max(80rem, 80vh);
  background-color: #ff695b;
  transform: translateX(-50%) rotate(20deg);
  border-top-right-radius: 4rem;
  z-index: 0;
}

.title {
  text-shadow: 5px 5px var(--mc-color-red-500);
}

main {
  display: grid;
  grid-gap: 5rem;
}

@media (min-width: 768px) {
  main {
    grid-template-columns: minmax(384px, 640px) 300px;
    justify-content: space-around;
    column-gap: 2rem;
  }

  .shelf {
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
  }
}

@media (min-width: 1024px) {
  main {
    grid-template-columns: minmax(460px, 1fr) 320px;
    justify-content: space-around;
    column-gap: 5rem;
  }
}

@media (min-width: 1280px) {
  .hero::before {
    left: 40%;
  }
}
</style>
