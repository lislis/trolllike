<template>
    <div>
        <TheField />

        <router-view></router-view>
    </div>
</template>

<script>
 import TheField from "@/components/TheField.vue";
 import { usePostsStore } from "@/stores/posts.js";

 export default {
     name: "TrollfieldApp",
     components: { TheField },
     setup() {
         const store = usePostsStore();
         return { store }
     },
     data() {
         return {
             //isLoading: false
         }
     },
     async created() {
         AFRAME.registerComponent('cursor-listener', {
             init() {
                 this.el.addEventListener('click', function (evt) {
                     let slug = evt.target.attributes['post-url'];
                     if (slug) {
                         window.vueRouter.push(`/${slug.value}`);
                     }
                 });
             }
         });

         this.fetchData(1);
         this.fetchTags();
     },
     methods: {
         fetchData(page) {
             fetch(`${window.wpData.rest_url}/wp/v2/posts?per_page=50&page=${page}&_embed=true`)
                 .then(resp => {
                     let currentPage = parseInt(resp.headers.get('x-wp-totalpages'), 10);
                     if (currentPage > page) {
                         this.fetchData(page+1);
                     }
                     return resp.json();
                 } )
                 .then(d => {
                     console.log('pass', page, d)
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
