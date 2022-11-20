
<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';

import LocationMap from "@/Components/Embeds/LocationMap.vue"

</script>

<template>

  <Head title="Home"></Head>
  <section class="hero-bg ">
    <div class="bg-black bg-opacity-70 sm:pl-3 py-40">
      <div>
        <h1 class="text-white text-5xl md:text-6xl font-bold">Welcome to Cafe</h1>
        <h2 class="text-white text-5xl md:text-6xl font-bold">Enjoy your time</h2>
      </div>
      <div class="mt-6  cursor-pointer">
        <Link :href="route('menu')" as="button"
          class="bg-yellow-400 transition-colors  duration-150 hover:bg-yellow-600 text-black text-lg sm:py-2 sm:px-4 font-bold mr-3 py-1 px-2 rounded-full">
        Order now
        </Link>
        <Link :href="route('category')" as="button"
          class="border cursor-pointer transition-colors  duration-150 border-yellow-600 hover:bg-yellow-600 text-white text-lg sm:py-2 sm:px-4 font-bold py-1 px-2 rounded-full">

        Browse Categories
        </Link>
      </div>
      <div class="text-white mt-8 ml-2 text-2xl">
        We are proud to serve you the best
      </div>
    </div>

  </section>
  <section>
    <div class="font-extrabold sm:text-3xl shadow-xl text-2xl md:text-5xl m-6 fancy-font ">
      <h2 class="text-center tracking-wider bg-yellow-300 p-2">Order Now or Visit us </h2>
    </div>
    <div class="text-center text-xl p-2 m-2">
      <h3 class="text-2xl py-2">We are located at</h3>
      <LocationMap class="mx-auto" />
    </div>

  </section>
</template>

<style scoped>
.hero-bg {
  background-image: url('/storage/site_images/hero.jpg');
  background-size: cover;

}
</style>