<template>
  <div class="bg-mc-grey w-full min-h-screen">
    <nav
      class="fixed bottom-sa-3 left-4 right-4 rounded-lg bg-white py-3 shadow-md z-10 px-constrained md:absolute md:bottom-auto md:top-4 md:left-8 md:right-8 md:bg-transparent md:shadow-none md:flex md:flex-row md:flex-nowrap md:justify-between md:items-center"
    >
      <g-link to="/" class="hidden md:block">
        <g-image src="~/assets/images/logo.png" immediate quality="100" class="w-24" />
      </g-link>

      <ul class="flex flex-row flex-nowrap justify-evenly items-center">
        <li class="md:mr-14">
          <g-link
            to="/"
            class="md:hidden font-display text-sm text-gray-400 hover:text-gray-900 transition-colors duration-300 flex flex-col flex-nowrap items-center md:flex-row md:text-white md:transform md:hover:-rotate-6 md:transition-all"
            active-class="text-gray-900 hover:text-gray-600 md:text-mc-red"
          >
            <HomeIcon />
            <span class="mt-1 md:mt-0 md:ml-6 md:text-base">Inicio</span>
          </g-link>
        </li>
        <li class="md:mr-14">
          <g-link
            to="/buscar"
            class="font-display text-sm text-gray-400 hover:text-gray-900 transition-colors duration-300 flex flex-col flex-nowrap items-center md:flex-row md:text-white md:transform md:hover:rotate-6 md:transition-all md:hover:text-white"
            active-class="text-gray-900 hover:text-gray-600 md:text-mc-red"
          >
            <SearchIcon />
            <span class="mt-1 md:mt-0 md:ml-6 md:text-base">Buscar</span>
          </g-link>
        </li>
        <li>
          <g-link
            to="/tienda"
            class="font-display text-sm text-gray-400 hover:text-gray-900 transition-colors duration-300 flex flex-col flex-nowrap items-center md:flex-row md:text-white md:transform md:hover:-rotate-6 md:transition-all md:hover:text-white"
            active-class="text-gray-900 hover:text-gray-600 md:text-mc-red"
          >
            <ShopIcon />
            <span class="mt-1 md:mt-0 md:ml-6 md:text-base">Tienda</span>
          </g-link>
        </li>
      </ul>
    </nav>

    <slot />

    <footer class="text-center">
      <div class="flex flex-col flex-nowrap justify-center items-center md:flex-row md:items-end px-3.5 md:pr-20">
        <div
          class="bubble relative w-11/12 max-w-prose bg-mc-red py-12 px-6 mb-10 border-b-10 border-mc-red-500 md:mb-8 md:ml-10"
        >
          <p class="relative text-white text-sm font-bold md:text-base">
            Nací en 1982 luego de participar en la guerra de Vietnam. Tras haber estudiado cartonismo y ciencias de la
            procrastinación en la Universidad de la Sorbona en 1982, decicí salvar a los pingüinos de ellos mismos
            haciendo este comic. Es bien sabido que los pingüinos dejan de atacarse unos a otros y a su medio ambiente
            cuando están entretenidos con comics. Denme dinero.
          </p>
        </div>

        <g-image src="~/assets/images/juanele-with-arrow.svg" class="-ml-20 md:ml-0 md:order-first" />
      </div>

      <div class="bg-mc-yellow border-b-14 border-mc-yellow-500 pt-10 px-3.5 pb-40 md:pb-6">
        <h2 class="flex flex-nowrap justify-center items-center mb-20 -ml-8 md:ml-0">
          <g-image src="~/assets/images/logo.png" class="w-36 md:w-24 md:mr-8 mt-4" />

          <span class="wordmark font-display w-min uppercase text-3xl text-white leading-none md:w-auto"
            >Moco-Comics</span
          >
        </h2>

        <nav class="max-w-4xl mx-auto mb-10">
          <ul class="flex flex-wrap justify-evenly items-center">
            <li
              class="flex flex-nowrap items-center text-white font-display transform hover:-rotate-6 transition-all mb-8"
            >
              <SearchIcon />
              <g-link class="ml-3" to="/buscar">Buscar</g-link>
            </li>

            <li
              class="flex flex-nowrap items-center text-white font-display transform hover:rotate-6 transition-all mb-8"
            >
              <ShopIcon />
              <g-link class="ml-3" to="/tienda">Tienda</g-link>
            </li>

            <li
              class="flex flex-nowrap items-center text-white font-display transform hover:-rotate-6 transition-all mb-8"
            >
              <RSSIcon />
              <a class="ml-3" href="/rss.xml">RSS</a>
            </li>

            <li
              class="flex flex-nowrap items-center text-white font-display transform hover:rotate-6 transition-all mb-8"
            >
              <AnchorIcon />
              <a class="ml-3" href="/sitemap.xml">Sitemap</a>
            </li>
          </ul>
        </nav>

        <small class="font-bold opacity-50"
          >&copy; 2013-{{ new Date().getFullYear() }} Juan Manuel Ramírez de Arellano Niño Rincón</small
        >
      </div>
    </footer>

    <slot name="modal" />
  </div>
</template>

<script>
import HomeIcon from '~/assets/icons/home.svg';
import SearchIcon from '~/assets/icons/search.svg';
import ShopIcon from '~/assets/icons/shopping-bag.svg';
import RSSIcon from '~/assets/icons/rss.svg';
import AnchorIcon from '~/assets/icons/anchor.svg';

export default {
  components: {
    HomeIcon,
    SearchIcon,
    ShopIcon,
    RSSIcon,
    AnchorIcon,
  },
};
</script>

<style>
.wordmark {
  text-shadow: 5px 5px var(--mc-color-yellow-500);
}

.bubble {
  border-radius: 50% / 10%;
}

.bubble::before {
  content: '';
  display: block;
  position: absolute;
  top: 8%;
  bottom: 5%;
  right: -4%;
  left: -4%;
  background-color: inherit;
  border-radius: 5% / 50%;
}

@media (min-width: 768px) {
  .bubble::before {
    bottom: 4%;
  }
}
</style>
