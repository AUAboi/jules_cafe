
<script setup>
import { Link } from '@inertiajs/inertia-vue3';



</script>

<template>
  <div class="hero-bg  ">
    <div class="bg-black bg-opacity-50 sm:pl-3 py-20">
      <div>
        <h1 class="text-white text-2xl sm:text-5xl md:text-6xl font-bold">Welcome to Cafe</h1>
        <h2 class="text-white text-2xl sm:text-5xl md:text-6xl font-bold">Enjoy your time</h2>
      </div>
      <div class="mt-6  cursor-pointer">
        <Link href="#" as="button"
          class="bg-yellow-400 transition-colors  duration-150 hover:bg-yellow-600 text-black text-sm sm:text-lg sm:py-2 sm:px-4 font-bold mr-3 py-1 px-2 rounded-full">
        Browse Categories
        </Link>
        <Link href="#" as="button"
          class="border cursor-pointer transition-colors  duration-150 border-yellow-600 hover:bg-yellow-600 text-white text-sm sm:text-lg sm:py-2 sm:px-4 font-bold py-1 px-2 rounded-full">
        Contact Us
        </Link>
      </div>
    </div>

  </div>
</template>

<style scoped>
.hero-bg {
  background-image: url('/storage/site_images/hero.jpg');
  background-size: cover;

}
</style>