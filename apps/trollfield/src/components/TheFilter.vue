<template>
    <div class="filter" :class="{ 'is-open': isOpen }">
        <button type="button"
                class="filter-toggle"
                @click="toggleFilter">
            <span class="a11y-hidden">Filter</span>
            <svg class="filter-icon" xmlns="http://www.w3.org/2000/svg" width="46" height="46" viewBox="0 0 512 512"><path d="M3.9 54.9C10.5 40.9 24.5 32 40 32H472c15.5 0 29.5 8.9 36.1 22.9s4.6 30.5-5.2 42.5L320 320.9V448c0 12.1-6.8 23.2-17.7 28.6s-23.8 4.3-33.5-3l-64-48c-8.1-6-12.8-15.5-12.8-25.6V320.9L9 97.3C-.7 85.4-2.8 68.8 3.9 54.9z"/></svg>
        </button>
        <div class="filter-inner" v-if="isOpen">
            <menu class="filter-menu">
                <FilterTag v-for="tag in store.allTags"
                           :key="tag.term_id"
                           :tag="tag" />
            </menu>
        </div>
    </div>
</template>
<script>
 import FilterTag from "@/components/FilterTag.vue";
 import { usePostsStore } from "@/stores/posts.js";

 export default {
     name: "TheFilter",
     components: { FilterTag },
     data() {
         return {
             isOpen: false,
         }
     },
     setup() {
         const store = usePostsStore();
         return { store }
     },
     methods: {
         toggleFilter() {
             this.isOpen = !this.isOpen;
         }
     }
 }

</script>
