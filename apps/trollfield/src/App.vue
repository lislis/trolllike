<template>
    <div>
        <TheFilter />

        <TheField />

        <router-view v-slot='{ Component }'>
            <PageTransition name='zoom' appear>
                <component :is='Component' />
            </PageTransition>
        </router-view>
    </div>
</template>

<script>
 import TheFilter from "@/components/TheFilter.vue";
 import TheField from "@/components/TheField.vue";
 import { usePostsStore } from "@/stores/posts.js";


 export default {
     name: "TrollfieldApp",
     components: { TheField, TheFilter },
     setup() {
         const store = usePostsStore();
         return { store }
     },
     data() {
         return {
             //isLoading: false,
             mainCat: window.wpData.main_filter_cat,
         }
     },
     async created() {
         // this.isLoading = true;

         //await fetch(`https://sternapau.de/wp-json/wp/v2/posts?categories=${this.mainCat}&per_page=99`)
         await fetch(`${window.wpData.rest_url}/wp/v2/posts?categories=${this.mainCat}&per_page=99`)
             .then(d => d.json())
             .then(d => {
                 //console.log(d);
                 this.store.addPosts(d);
             }).catch(e => {
                 console.log("Error", e);
             });

         await fetch(`${window.wpData.rest_url}/trolllike-theme/v1/tags`)
             .then(d => d.json())
             .then(d => {
                 let dat = d;
                 // filter unique
                 let temp = [];
                 let ids = []
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

     },
     methods: {
     },
     computed: {
     },
 }
</script>
