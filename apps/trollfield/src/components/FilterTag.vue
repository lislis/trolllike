<template>
    <li><button class="filter-tag"
                :class="{ 'is-current': amICurrentFilter() }"
        @click="selectFilter">{{ tag.name }}</button></li>
</template>
<script>
 import { usePostsStore } from "@/stores/posts.js";

 export default {
     name: "FilterTag",
     props: ['tag'],
     setup() {
         const store = usePostsStore();
         return { store }
     },
     methods: {
         selectFilter() {
             if (this.amICurrentFilter()) {
                 this.store.selectFilter(null);
             } else {
                 let tagId = this.tag.term_id;
                 this.store.selectFilter(tagId);
             }
         },
         amICurrentFilter() {
             return this.store.currentFilter == this.tag.term_id;
         }
     }
 }
</script>
