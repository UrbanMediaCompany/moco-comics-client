<template>
  <div class="bg-mc-grey min-w-full min-h-screen">
    <nav
      class="fixed bottom-sa-3 left-4 right-4 rounded-lg bg-white py-3 shadow-md z-10 px-constrained md:absolute md:bottom-auto md:top-8 md:left-8 md:right-8 md:bg-transparent md:shadow-none md:flex md:flex-row md:flex-nowrap md:justify-between md:items-center"
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
            class="font-display text-sm text-gray-400 hover:text-gray-900 transition-colors duration-300 flex flex-col flex-nowrap items-center md:flex-row md:text-white md:transform md:hover:-rotate-6 md:transition-all md:hover:text-white"
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
  </div>
</template>

<script>
import HomeIcon from '~/assets/icons/home.svg';
import SearchIcon from '~/assets/icons/search.svg';
import ShopIcon from '~/assets/icons/shopping-bag.svg';

export default {
  components: {
    HomeIcon,
    SearchIcon,
    ShopIcon,
  },
};
</script>

<style></style>
