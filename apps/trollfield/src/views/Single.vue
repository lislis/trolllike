<template>
    <div>
        <router-link to="/">Home</router-link>
        <p>Single {{$route.params.slug}}</p>
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
