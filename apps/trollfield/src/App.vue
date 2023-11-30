<template>
    <div v-if="isLoading" style="text-align: center">
        <LoadSpinner />
    </div>
    <div v-else>
        <TheField />

        <router-view></router-view>
    </div>
</template>

<script>
 import LoadSpinner from '@/components/LoadSpinner.vue';
 import TheField from "@/components/TheField.vue";
 import { usePostsStore } from "@/stores/posts.js";

 export default {
     name: "TrollfieldApp",
     components: { TheField, LoadSpinner },
     setup() {
         const store = usePostsStore();
         return { store }
     },
     data() {
         return {
             isLoading: false,
         }
     },
     async created() {
         this.isLoading = true;

         this.store.setPageCurrent(1);
         this.fetchData(1);
         this.fetchTags();
     },
     methods: {
         fetchData(page) {
             fetch(`${window.wpData.rest_url}/wp/v2/posts?per_page=30&page=${page}&_embed=wp:term,wp:featuredmedia`)
                 .then(resp => {
                     let currentPage = parseInt(resp.headers.get('x-wp-totalpages'), 10);
                     if (currentPage > page) {
                         this.fetchData(page+1);
                         this.store.setPageCurrent(page+1);
                     }
                     return resp.json();
                 } )
                 .then(d => {
                     if (this.store.pageState.current == page) {
                         this.isLoading = false;
                         this.store.setPageFinalFlag(true);
                     }

                     this.store.addPosts(d);
                 }).catch(e => {
                     console.log("Error here?", e);
                 });
         },
         fetchTags() {
             fetch(`${window.wpData.rest_url}/trolllike-theme/v1/tags`)
                 .then(d => d.json())
                 .then(d => {
                     let dat = d;
                     // filter unique
                     let temp = [];
                     let ids = [];
                     dat.forEach(x => {
                         if (!ids.includes(x.term_id)) {
                             temp.push(x);
                             ids.push(x.term_id);
                         }
                     });
                     this.store.addTags(Array.from(temp));
                 }).catch(e => {
                     console.log("Error", e);
                 });
         }
     },
     computed: {
     },
 }
</script>
