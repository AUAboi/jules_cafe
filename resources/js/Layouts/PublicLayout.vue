<script setup>
import { usePage } from '@inertiajs/inertia-vue3';
import { computed } from '@vue/reactivity';
import PublicFooter from './PublicFooter.vue';
import PublicHeader from './PublicHeader.vue';

const appName = computed(() => usePage().props.value.appName)

</script>
<template>
	<PublicHeader :appName="appName" />
	<main>
		<slot />
	</main>
	<PublicFooter :appName="appName" />
</template>

