<script setup>
import { Link } from '@inertiajs/inertia-vue3';


const props = defineProps({
  links: {
    type: Array
  }
})


</script>

<template>
  <div v-if="links.length > 3">
    <div class="flex flex-wrap my-2 mx-4 items-center justify-center">
      <template v-for="(link, key) in links">
        <div :key="key" v-if="link.url === null" class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-black  rounded"
          v-html="link.label" />
        <Link :key="key + 1" v-else
          class="mr-1 mb-1 px-4 py-3 text-sm leading-4  border-2 rounded hover:bg-white focus:border-yellow-500 focus:text-yellow-500"
          :class="{ 'bg-white border-yellow-500 ': link.active }" :href="link.url" v-html="link.label" />
      </template>
    </div>
  </div>
</template>

