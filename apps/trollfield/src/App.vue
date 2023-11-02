<template>
    <div>
        <TheField />

        <router-view>
        </router-view>
    </div>
</template>

<script>
 import TheField from "@/components/TheField.vue";
 import { usePostsStore } from "@/stores/posts.js";
 import PerlinNoise from 'perlin-noise-2d'

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
             points: null,
             perlin: null
         }
     },
     async created() {
         // this.isLoading = true;

         this.pds = new FastPoissonDiskSampling({
             shape: [20, 20],
             radius: 3,
             tries: 5
         });
         this.points = this.pds.fill();

         this.perlin = new PerlinNoise(2938, 345, 1984);

         AFRAME.registerComponent('cursor-listener', {
             init() {
                 this.el.addEventListener('click', function (evt) {
                     //console.log(evt)
                     let slug = evt.target.attributes['post-url'];
                     //console.log(slug)
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
                 }).map(x => {
                     //console.log(x.position)
                     let p = this.perlin.perlin(x.position[0], x.position[1]);
                     if (p) {
                         x.height = Math.abs(p) * 7 + 0.8;
                     } else {
                         x.height = 0.5;
                     }
                     return x;
                 });

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
