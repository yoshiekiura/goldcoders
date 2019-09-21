<template>
 <div v-for="(link, key) in links" :key="key">
          <div
            v-if="link.url === null"
            :key="key"
            class="mr-1 mb-1 px-4 py-3 text-sm border rounded text-grey"
            :class="{ 'ml-auto': link.label === 'Next' }"
          >{{ link.label }}</div>
          <inertia-link
            v-else
            :key="key"
            :class="{ 'bg-white': link.active, 'ml-auto': link.label === 'Next' }"
            :href="link.url"
          >{{ link.label }}</inertia-link>
        </div>
</template>

<script>
export default {
  
}
</script>
// when we change filter the page number is reset! to page 1
