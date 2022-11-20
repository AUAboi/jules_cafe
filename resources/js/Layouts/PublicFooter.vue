<script setup>
import { Link } from '@inertiajs/inertia-vue3';
import axios from 'axios';
import { reactive } from 'vue';


const props = defineProps({
  appName: {
    type: String,
    required: true
  },
})

</script>

<template>
  <footer class="text-gray-400 bg-gray-900 body-font">
    <div class="container px-5 py-12 mx-auto">
      <div class="flex flex-wrap md:text-left text-center order-first justify-around">
        <div class="lg:w-1/4 md:w-1/2 w-full px-2">
          <h2 class="title-font font-medium text-white tracking-widest text-sm mb-3">Order now</h2>
          <nav class="list-none flex flex-col mb-10">
            <Link :href="route('category')" class="text-gray-400 hover:text-white">
            Categories
            </Link>
            <Link :href="route('menu')" class="text-gray-400 hover:text-white">
            Menu
            </Link>
          </nav>
        </div>

        <div class="lg:w-1/4 md:w-1/2 w-full px-2">
          <h2 class="title-font font-medium text-white tracking-widest text-sm mb-3">SUBSCRIBE</h2>
          <div
            class="flex xl:flex-nowrap md:flex-nowrap lg:flex-wrap flex-wrap justify-center items-end md:justify-start">
            <div class="relative w-40 sm:w-auto xl:mr-4 lg:mr-0 sm:mr-4 mr-2">
              <label for="footer-field" class="leading-7 text-sm text-gray-400">Newsletter</label>
              <input type="text" id="footer-field" name="footer-field"
                class="w-full bg-gray-800 rounded border bg-opacity-40 border-gray-700 focus:bg-transparent focus:ring-2 focus:ring-indigo-900 focus:border-indigo-500 text-base outline-none text-gray-100 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
            </div>
            <button
              class="lg:mt-2 xl:mt-0 flex-shrink-0 inline-flex text-white bg-orange border-0 py-2 px-6 focus:outline-none rounded">Send</button>
          </div>

        </div>
      </div>
    </div>
    <div class="bg-gray-800 bg-opacity-75">
      <div class="container px-5 py-6 mx-auto flex items-center sm:flex-row flex-col">
        <a class="flex title-font font-medium items-center md:justify-start justify-center text-white">

          <span class="ml-3 text-xl">{{ appName }}</span>
        </a>
        <p class="text-sm text-gray-400 sm:ml-6 sm:mt-0 mt-4">© {{ appName }} — 2022
        </p>
        <span class="inline-flex sm:ml-auto sm:mt-0 mt-4 justify-center sm:justify-start">

          <a href="https://www.instagram.com/julescafe2022/" class="ml-3 text-gray-400 flex items-center gap-2">

            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              class="w-5 h-5" viewBox="0 0 24 24">
              <rect width="20" height="20" x="2" y="2" rx="5" ry="5"></rect>
              <path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37zm1.5-4.87h.01"></path>
            </svg>
            <span>
              @julescafe2022
            </span>
          </a>

        </span>
      </div>
    </div>
  </footer>
</template>