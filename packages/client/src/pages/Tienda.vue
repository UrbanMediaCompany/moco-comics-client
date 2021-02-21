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

    <main class="px-constrained -mt-20 grid gap-20 md:pb-64">
      <section class="shelf w-full grid grid-cols-1 gap-16 pb-20 relative">
        <Product v-bind="product" @add-to-cart="addToCart($event)" v-for="product in products" :key="product.id" />
      </section>

      <aside class="pb-48 md:-top-4 md:h-min" :class="intentToPayWithCard ? 'md:relative' : 'md:sticky'">
        <ShoppingCart
          :items="cart"
          :products="normalizedProducts"
          :removeFromCart="removeFromCart"
          @purchase-method-intent="adaptLayoutToPaymentMethod"
        />

        <SocialsNav />
      </aside>
    </main>
  </SiteLayout>
</template>

<page-query>
query {
  metadata {
    siteName
    siteUrl
    siteDescription
    author
  }

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
import ShoppingCart from '~/components/ShoppingCart';
import SocialsNav from '~/components/SocialsNav';

export default {
  name: 'Tienda',
  metaInfo() {
    const { siteName, siteUrl, siteDescription, author } = this.$page.metadata;

    const title = 'Tienda | Moco-Comics';
    const canonicalUrl = `${siteUrl}${this.$route.path}`;

    return {
      title,
      meta: [
        { property: 'og:type', content: 'website' },
        { property: 'og:site_name', content: siteName },
        { property: 'og:title', content: title },
        { property: 'og:description', content: siteDescription },
        { property: 'og:image', content: `${siteUrl}/social-card/moco-comics.png` },
        { property: 'og:image:type', content: 'image/png' },
        { property: 'og:image:width', content: '1280' },
        { property: 'og:image:height', content: '669' },
        { property: 'og:image:alt', content: '' },
        { property: 'og:url', content: canonicalUrl },
        { property: 'og:locale', content: 'es_MX' },
        { name: 'twitter:card', content: 'summary_large_image' },
        { name: 'twitter:site:id', content: author },
        { name: 'twitter:creator', content: author },
        { name: 'twitter:title', content: title },
        { name: 'twitter:description', content: siteDescription },
        { name: 'twitter:image', content: '' },
        { name: 'twitter:image_alt', content: '' },
        { name: 'twitter:url', content: canonicalUrl },
      ],
      link: [{ rel: 'canonical', href: canonicalUrl }],
    };
  },
  components: {
    Product,
    ShoppingCart,
    SocialsNav,
  },
  data() {
    return {
      cart: [],
      intentToPayWithCard: false,
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
  },
  methods: {
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
    adaptLayoutToPaymentMethod(method) {
      this.intentToPayWithCard = method === 'card';
      const { matches: isMediumViewport } = window.matchMedia('(min-width: 768px)');

      if (!this.intentToPayWithCard || !isMediumViewport) return;

      window.scrollTo({
        top: 280,
        left: 0,
      });
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
