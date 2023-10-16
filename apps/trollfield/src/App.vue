<template>
    <div>
        <router-view v-slot='{ Component }'>
            <PageTransition name='zoom' appear>
                <component :is='Component' />
            </PageTransition>
        </router-view>
    </div>
</template>

<script>
 import { usePostsStore } from "@/stores/posts.js";


 export default {
     name: "TrollfieldApp",
     components: { },
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
        // debugger
        await fetch(`https://sternapau.de/wp-json/wp/v2/posts?categories=${this.mainCat}&per_page=99`)
         //await fetch(`${window.wpData.rest_url}/wp/v2/posts?categories=${this.mainCat}&per_page=99`)
             .then(d => d.json())
             .then(d => {
                 console.log(d);
             //    this.isLoading = false;
                 this.store.add(d);
             }).catch(e => {
           //      this.isLoading = false;
                 console.log("Error", e);
             });

     },
     methods: {
     },
     computed: {
     },
 }
</script>
