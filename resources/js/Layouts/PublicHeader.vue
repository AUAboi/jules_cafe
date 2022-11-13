<script setup>
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
      <nav class="flex text-black lg:w-2/5 flex-wrap sm:mb-6 md:mb-0 items-center text-base md:ml-auto nav-links"
        :class="{ 'nav-active': show }">
        <Link :href="route('home')" class="sm:ml-5 md:mr-5 lg:mx-3 px-2 cursor-pointer md:text-lg "
          :class="{ 'border-b-2 border-black': $page.component.startsWith('Public/Home') }">Home</Link>
        <Link :href="route('menu')" class="sm:ml-5 md:mr-5 lg:mx-3 px-2 cursor-pointer md:text-lg "
          :class="{ 'underline': $page.component.startsWith('Public/Menu') }">Menu</Link>

      </nav>
      <div @click="show = !show" class="burger sm:hidden cursor-pointer" :class="{ 'burger-active': show }">
        <div class="line1 line bg-white"></div>
        <div class="line2 line bg-white"></div>
        <div class="line3 line bg-white"></div>
      </div>
      <Link href="/"
        class="flex order-first lg:order-none lg:w-1/5 title-font font-medium items-center text-gray-900 lg:items-center lg:justify-center mb-2 md:mb-0">
      <span class="ml-3 text-2xl md:text-3xl title mt-2">{{ appName }}</span>
      </Link>
      <div class="lg:w-2/5 inline-flex lg:justify-end ml-5 lg:ml-0 mb-2 sm:mb-0">
        <Link href="/order" target="_blank" class="btn-order inline-flex font-sans items-center bg-yellow-200 border-0 py-1 px-2 focus:outline-none
				hover:bg-yellow-300 rounded text-base md:mt-0">
        Order Now
        <i class="fab fa-whatsapp mx-2"></i>
        </Link>
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
    display: block;

    transition: all 250ms ease-in-out;
    transform: translateY(-600%);
  }

  .nav-active {
    transform: translateY(0);
  }
}
</style>
