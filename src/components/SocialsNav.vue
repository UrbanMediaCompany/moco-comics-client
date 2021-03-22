<template>
  <nav class="flex flex-nowrap justify-evenly items-center bg-mc-yellow rounded-xl p-4 border-b-6 border-mc-yellow-500">
    <a
      :href="$static.metadata.facebookUrl"
      rel="noreferrer noopener"
      class="text-facebook border-2 border-white bg-white rounded-full p-4 transform hover:rotate-12 transition-transform duration-300"
    >
      <FacebookIcon />
    </a>

    <a
      :href="$static.metadata.twitterUrl"
      rel="noreferrer noopener"
      class="text-twitter border-2 border-white bg-white rounded-full p-4 transform hover:-rotate-12 transition-transform duration-300"
    >
      <TwitterIcon />
    </a>

    <a
      :href="$static.metadata.instagramUrl"
      rel="noreferrer noopener"
      class="text-instagram border-2 border-white bg-white rounded-full p-4 transform hover:rotate-12 transition-transform duration-300"
    >
      <InstagramIcon />
    </a>
  </nav>
</template>

<static-query>
query {
  metadata {
    facebookUrl
    twitterUrl
    instagramUrl
  }
}
</static-query>

<script>
import FacebookIcon from '~/assets/icons/facebook.svg';
import TwitterIcon from '~/assets/icons/twitter.svg';
import InstagramIcon from '~/assets/icons/instagram.svg';

export default {
  name: 'SocialsNav',
  components: {
    FacebookIcon,
    TwitterIcon,
    InstagramIcon,
  },
};
</script>
