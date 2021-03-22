<template>
  <form @submit.prevent="identifyVisitor" class="flex flex-col items-stretch px-6 pt-10 pb-6">
    <div class="w-full max-w-xl mx-auto mb-4 md:flex flex-nowrap justify-evenly md:max-w-none">
      <label class="block flex-1 cursor-pointer mb-4 md:mr-4">
        <span class="font-display text-sm block mb-2">¿Cómo te llamas?</span>
        <input
          class="w-full px-3 py-1 bg-white focus:bg-clip-padding hover:bg-clip-padding rounded-lg placeholder-opacity-80 border-2 border-mc-grey-500 hover:border-white hover:border-dashed focus:border-dashed hover:border-mc-blue focus:border-mc-blue focus:border-white transition-all duration-200 appearance-none"
          type="text"
          name="name"
          v-model="name"
          autocomplete="name"
          placeholder="Juanito Pérez"
          autofocus
          required
        />
      </label>

      <label class="block flex-1 cursor-pointer">
        <span class="font-display text-sm block mb-2">¿Cuál es tu correo?</span>
        <input
          class="w-full px-3 py-1 bg-white focus:bg-clip-padding hover:bg-clip-padding rounded-lg placeholder-opacity-80 border-2 border-mc-grey-500 hover:border-white hover:border-dashed focus:border-dashed hover:border-mc-blue focus:border-mc-blue focus:border-white transition-all duration-200 appearance-none"
          type="email"
          name="email"
          v-model="email"
          autocomplete="email"
          placeholder="tu@dominio.com"
          required
        />
      </label>
    </div>

    <div class="w-full max-w-xl mx-auto mb-8 md:flex flex-nowrap justify-evenly items-end md:max-w-none">
      <label class="block flex-1 cursor-pointer mb-6 md:mr-4 md:mb-0">
        <span class="font-display text-sm block mb-2">¿Sitio web?</span>
        <input
          class="w-full px-3 py-1 bg-white focus:bg-clip-padding hover:bg-clip-padding rounded-lg placeholder-opacity-80 border-2 border-mc-grey-500 hover:border-white hover:border-dashed focus:border-dashed hover:border-mc-blue focus:border-mc-blue focus:border-white transition-all duration-200 appearance-none"
          type="url"
          name="website"
          v-model="website"
          autocomplete="url"
          placeholder="https://miblog.com"
        />
      </label>

      <div class="xs:flex-1 md:mb-1">
        <label
          class="flex flex-nowrap items-center cursor-pointer border-2 border-transparent px-3 py-1 rounded-lg focus-within:border-mc-blue focus-within:border-dashed transition-all duration-200"
        >
          <input
            type="checkbox"
            name="persist"
            v-model="wishesToPersist"
            value="yes"
            class="checkbox appearance-none w-8 h-8 rounded-lg mr-4 border-2 border-mc-grey-500 bg-white checked:bg-check-mark"
          />
          <span class="flex-1 font-display text-sm leading-none">Recuérdame en este navegador</span>
        </label>
      </div>
    </div>

    <button
      type="submit"
      class="self-center w-full max-w-xl flex flex-nowrap justify-center items-center bg-mc-blue text-white py-2 px-4 rounded-lg font-display text-sm border-2 border-dashed border-transparent focus:border-white transition-colors duration-200 md:mt-8"
    >
      <CommentIcon class="mr-2 w-8 h-8" />
      Ya ¡Lo que sigue!
    </button>
  </form>
</template>

<script>
import CommentIcon from '~/assets/icons/message-circle.svg';

export default {
  name: 'VisitorForm',
  components: {
    CommentIcon,
  },
  data() {
    return {
      name: '',
      email: '',
      website: '',
      wishesToPersist: false,
    };
  },
  methods: {
    identifyVisitor() {
      const visitor = { name: this.name, email: this.email, website: this.website };

      if (this.wishesToPersist) this.$store.dispatch({ type: 'persistVisitor', payload: { visitor } });

      this.$emit('identified-visitor', visitor);
    },
  },
};
</script>
