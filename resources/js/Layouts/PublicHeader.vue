<script setup>
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import { Link } from "@inertiajs/inertia-vue3";
import { ref } from "vue";



const show = ref(false);

const props = defineProps({
  appName: {
    type: String,
    required: true
  }
})


</script>

<template>

  <header class="text-gray-700 body-font bg-yellow-400 fancy-font">
    <div class="container sm:mx-auto flex flex-wrap sm:p-5 flex-col md:flex-row items-center">
      <nav class="flex text-black lg:w-2/5 flex-wrap sm:mb-6 md:mb-0 items-center text-base md:ml-auto my-4 nav-links"
        :class="{ 'nav-active': show }">
        <Link :href="route('home')" class="sm:ml-5 md:mr-5 lg:mx-3 px-2 cursor-pointer md:text-lg "
          :class="{ 'border-b-2 border-black': $page.component.startsWith('Public/Home') }">Home</Link>
        <Link :href="route('category')" class="sm:ml-5 md:mr-5 lg:mx-3 px-2 cursor-pointer md:text-lg "
          :class="{ 'border-b-2 border-black': $page.component.startsWith('Public/Category') }">Categories</Link>
        <Link :href="route('menu')" class="sm:ml-5 md:mr-5 lg:mx-3 px-2 cursor-pointer md:text-lg "
          :class="{ 'border-b-2 border-black': $page.component.startsWith('Public/Menu') }">Menu</Link>
      </nav>
      <div @click="show = !show" class="burger sm:hidden cursor-pointer" :class="{ 'burger-active': show }">
        <div class="line1 line bg-white"></div>
        <div class="line2 line bg-white"></div>
        <div class="line3 line bg-white"></div>
      </div>
      <Link href="/"
        class="flex order-first lg:order-none lg:w-1/5 title-font font-medium items-center text-gray-900 lg:items-center lg:justify-center mb-2 md:mb-0">
      <span class="ml-3 text-2xl md:text-3xl title mt-2 w-36 z-10">
        <img src="/storage/site_images/logo.jpg" alt="site logo">
      </span>
      </Link>
      <div class="lg:w-2/5 inline-flex lg:justify-end ml-5 lg:ml-0 mb-2 sm:mb-0">
        <div class="flex gap-4" v-if="$page.props.auth.user">
          <Link :href="route('cart')" class="btn-order inline-flex font-sans items-center bg-yellow-200 border-0 py-1 px-2 focus:outline-none
				hover:bg-yellow-300 rounded text-base md:mt-0">
          {{ $page.props.cart.total }} <svg class="w-6 h-6 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
            </path>
          </svg>

          </Link>
          <div class="ml-3 relative">
            <Dropdown align="right" width="48">
              <template #trigger>
                <span class="inline-flex rounded-md">
                  <button type="button"
                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-900 bg-yellow-200 hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                    {{ $page.props.auth.user.name }}

                    <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                      fill="currentColor">
                      <path fill-rule="evenodd"
                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                    </svg>
                  </button>
                </span>
              </template>

              <template #content>
                <DropdownLink :href="route('orders')" as="button">
                  View Orders
                </DropdownLink>
                <DropdownLink :href="route('logout')" method="post" as="button">
                  Log Out
                </DropdownLink>
              </template>
            </Dropdown>
          </div>

        </div>


        <div class="flex gap-4 mb-4" v-else>
          <Link as="button" class="primary-btn" :href="route('register')">Register</Link>
          <Link as="button" class="secondary-btn" :href="route('login')">Login</Link>
        </div>
      </div>
    </div>
  </header>
</template>
<style scoped>
.burger {
  position: absolute;
  left: 30px;
  top: 30px;
}

.line {
  width: 20px;
  height: 2px;
  margin: 5px;
  transition: all 0.5s ease;
}

.burger-active .line1 {
  transform: rotate(-45deg) translate(-5px, 5px);
}

.burger-active .line2 {
  opacity: 0;
}

.burger-active .line3 {
  transform: rotate(45deg) translate(-5px, -5px);
}

@media screen and (max-width: 639px) {
  .burger {
    left: 20px;
    top: 20px;
  }

  .nav-links {
    z-index: 1;
    display: block;
    transition: all 250ms ease-in-out;
    transform: translateY(-700%);
  }

  .nav-active {
    transform: translateY(0);
  }
}
</style>
