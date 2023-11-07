<template>
    <div>
        <TheField />

        <router-view></router-view>
    </div>
</template>

<script>
 import TheField from "@/components/TheField.vue";
 import { usePostsStore } from "@/stores/posts.js";
 import PerlinNoise from 'perlin-noise-2d';
 import {points} from '@/data.js';
 import { samplePoints } from '@/util.js';

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
             //pds: null,
             points: null,
             perlin: null
         }
     },
     async created() {
         const x_max = 60;
         const y_max = 60;

         // use this to generate new points
         //this.points = samplePoints(x_max, y_max);
         // use this to use points from @/data.js
         this.points = points;
         // This can be used to copy the points and then paste them
         // to @/data.js
         window.points = this.points;

         // console.log(this.points)
         this.perlin = new PerlinNoise(2938, 345, 1984);

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

         //await fetch(`https://sternapau.de/wp-json/wp/v2/posts?categories=${this.mainCat}&per_page=99&_embed=true`)
         //await fetch(`${window.wpData.rest_url}/wp/v2/posts?categories=${this.mainCat}&per_page=99&_embed=true`)
         await fetch(`${window.wpData.rest_url}/wp/v2/posts?per_page=99&_embed=true`)
             .then(d => d.json())
             .then(d => {
                 let dd = d.map((x, i) => {
                     if (this.points.length > i) {
                         x.position = this.points[i];
                     } else {
                         x.position = this.pds.next();
                     }
                     return x;
                 }).map(x => {
                     if (x.position && x.position.length >= 2) {
                         let p = this.perlin.perlin(x.position[0], x.position[1]);
                         x.height = 0.6;
                         if (p) {
                             x.height = Math.abs(p) * 4 + 0.8;
                         }
                     }
                     return x;
                 }).map(x => {
                     x.rot = Math.ceil((Math.random() * 2 - 1) * 35);
                     return x;
                 }).map(x => {

                     x.position[0] = x.position[0] - (x_max/2.0);
                     x.position[1] = x.position[1] - (y_max/2.0);
                     console.log(x)
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

     },
     methods: {
     },
     computed: {
     },
 }
</script>
