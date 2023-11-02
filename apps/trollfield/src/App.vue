<template>
    <div>
        <TheField />

        <router-view v-slot='{ Component }'>
            <PageTransition name='zoom' appear>
                <component :is='Component' />
            </PageTransition>
        </router-view>
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
             //isLoading: false,
             mainCat: window.wpData.main_filter_cat,
             pds: null,
             points: null
         }
     },
     async created() {
         // this.isLoading = true;

         this.pds = new FastPoissonDiskSampling({
             shape: [30, 30],
             radius: 2,
             tries: 5
         });
         this.points = this.pds.fill();
         console.log(this.points);


         AFRAME.registerComponent('cursor-listener', {
             init() {
                 this.el.addEventListener('click', function (evt) {
                     console.log(evt)
                     let slug = evt.target.attributes['post-url'];
                     console.log(slug)
                     if (slug) {
                         window.vueRouter.push(`/${slug.value}`);
                     }
                 });
             }
         });



         //await fetch(`https://sternapau.de/wp-json/wp/v2/posts?categories=${this.mainCat}&per_page=99&_embed=true`)
         await fetch(`${window.wpData.rest_url}/wp/v2/posts?categories=${this.mainCat}&per_page=99&_embed=true`)
             .then(d => d.json())
             .then(d => {
                 //console.log(d);

                 let dd = d.map((x, i) => {
                     if (this.points.length > i) {
                         x.position = this.points[i];
                     } else {
                         x.position = this.pds.next();
                     }
                     return x;
                 })

                 this.store.addPosts(dd);

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
