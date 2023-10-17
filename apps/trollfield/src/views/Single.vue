<template>
    <div class="single-view">
        <router-link to="/">Close</router-link>
        <h3 v-html="item.title.rendered"></h3>
        <div v-html="item.content.rendered"></div>
    </div>
</template>

<script>
 import { usePostsStore } from '@/stores/posts'

 export default {
     name: "TrollfieldSingleView",
     components: { },
     setup() {
         const store = usePostsStore();
         return { store }
     },
     created() {

         //this.store.select(this.$route.params.slug);
         //window.scroll({top: 0, behavior: 'smooth'});

         //         this.$watch(
         //            () => this.$route.params,
         //             (toParams, previousParams) => {
         //                 this.store.select(toParams.slug);
         //                 window.scroll({top: 0, behavior: 'smooth'});
         //             }
         //         )
     },
     computed: {
         item() {
             return this.store.getPostBySlug(this.$route.params.slug);
         }
     }
 }
</script>
<style scoped>
 * {
     box-sizing: border-box;
 }

 .single-view {
     position: absolute;
     z-index: 99;
     width: 50vw;
     padding: 1vw;
     background: white;
     top: 0;
     bottom: 0;
     right: 0;
     left: 0;
     margin: auto;
     height: 40vh;
     overflow: scroll;
 }
 .single-view img {
     width: 100%;
     height: auto;
 }
</style>
