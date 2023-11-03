<template>
    <a-scene v-if="store.allPosts.length != 0" vr-mode-ui="enabled: true">
        <a-assets>
            <AAsset v-for="(post, i) in store.allPosts"
                    :key="post.id"
                    :post="post">
            </AAsset>
        </a-assets>

        <a-sky color="#ECECEC"></a-sky>

        <a-entity environment="flatShading: true; horizonColor: #484848; gridColor: #eee; dressingColor: #c5c5c5; groundColor2: #cccccc; groundTexture: squares; groundYScale: 6.894; grid: 1x1; active: true; fog: 0.88; dressingScale: 1.01; dressingAmount: 7; dressing: apparatus; ground: noise; skyType: gradient; skyColor: #0d0d0d; lightPosition: [object Object]; groundColor: #252525; dressingVariance: [object Object]; preset: checkerboard"></a-entity>

        <!-- PLAYER -->
        <a-entity id="rig"
                  movement-controls="controls: keyboard, nipple"
                  nipple-controls="moveJoystickPosition: false"
                  position="8 0 14"
        >
            <a-entity camera
                      id="camera"
                      :look-controls="magicWindow"
                      position="0 1.6 0">
                <a-entity cursor="fuse: true"
                          animation__click="property: scale; startEvents: click; easing: easeInCubic; dur: 150; from: 0.1 0.1 0.1; to: 1 1 1"
                          animation__fusing="property: scale; startEvents: fusing; easing: easeInCubic; dur: 1500; from: 1 1 1; to: 0.1 0.1 0.1"
                          animation__mouseleave="property: scale; startEvents: mouseleave; easing: easeInCubic; dur: 500; to: 1 1 1"

                          position="0 0 -1"
                          geometry="primitive: ring; radiusInner: 0.02; radiusOuter: 0.03"
                          material="color: black; shader: flat">
                </a-entity>
            </a-entity>
        </a-entity>

        <a-light type="ambient" color="#ccc"></a-light>
        <a-light color="#ddf" distance="100" intensity="0.4" type="point"></a-light>
        <a-light color="#ddf" position="3 10 -10" distance="50" intensity="0.4" type="point"></a-light>

        <APost  v-for="(post, i) in store.getPostsByCurrentFilter"
                :key="post.id"
                :post="post">
        </APost>

    </a-scene>
    <div v-else>
        Loading
    </div>

    <div class="ui">
        <button class="magic-window"
                @click="toggleMagicWindow"
                :class="{ 'is-active': isMagicWindow}">
            <span class="a11y-hidden">Toggle mobile window tracking</span>
            <svg fill="black" viewBox="0 0 512 512"><path d="M464 6.1c9.5-8.5 24-8.1 33 .9l8 8c9 9 9.4 23.5 .9 33l-85.8 95.9c-2.6 2.9-4.1 6.7-4.1 10.7V176c0 8.8-7.2 16-16 16H384.2c-4.6 0-8.9 1.9-11.9 5.3L100.7 500.9C94.3 508 85.3 512 75.8 512c-8.8 0-17.3-3.5-23.5-9.8L9.7 459.7C3.5 453.4 0 445 0 436.2c0-9.5 4-18.5 11.1-24.8l111.6-99.8c3.4-3 5.3-7.4 5.3-11.9V272c0-8.8 7.2-16 16-16h34.6c3.9 0 7.7-1.5 10.7-4.1L464 6.1zM432 288c3.6 0 6.7 2.4 7.7 5.8l14.8 51.7 51.7 14.8c3.4 1 5.8 4.1 5.8 7.7s-2.4 6.7-5.8 7.7l-51.7 14.8-14.8 51.7c-1 3.4-4.1 5.8-7.7 5.8s-6.7-2.4-7.7-5.8l-14.8-51.7-51.7-14.8c-3.4-1-5.8-4.1-5.8-7.7s2.4-6.7 5.8-7.7l51.7-14.8 14.8-51.7c1-3.4 4.1-5.8 7.7-5.8zM87.7 69.8l14.8 51.7 51.7 14.8c3.4 1 5.8 4.1 5.8 7.7s-2.4 6.7-5.8 7.7l-51.7 14.8L87.7 218.2c-1 3.4-4.1 5.8-7.7 5.8s-6.7-2.4-7.7-5.8L57.5 166.5 5.8 151.7c-3.4-1-5.8-4.1-5.8-7.7s2.4-6.7 5.8-7.7l51.7-14.8L72.3 69.8c1-3.4 4.1-5.8 7.7-5.8s6.7 2.4 7.7 5.8zM208 0c3.7 0 6.9 2.5 7.8 6.1l6.8 27.3 27.3 6.8c3.6 .9 6.1 4.1 6.1 7.8s-2.5 6.9-6.1 7.8l-27.3 6.8-6.8 27.3c-.9 3.6-4.1 6.1-7.8 6.1s-6.9-2.5-7.8-6.1l-6.8-27.3-27.3-6.8c-3.6-.9-6.1-4.1-6.1-7.8s2.5-6.9 6.1-7.8l27.3-6.8 6.8-27.3c.9-3.6 4.1-6.1 7.8-6.1z"/></svg>
        </button>
    </div>
</template>

<script>
 import nipplejs from "nipplejs/dist/nipplejs.js";
 import { usePostsStore } from '@/stores/posts'
 import APost from '@/components/APost.vue';
 import AAsset from '@/components/AAsset.vue';

 export default {
     name: "TheField",
     components: {APost, AAsset},
     created() {
         isLoading: false;
         //console.log(this.points);
     },
     data() {
         return {
             isMagicWindow: false
         }
     },
     setup() {
         const store = usePostsStore();
         return { store }
     },
     methods: {
         toggleMagicWindow() {
             this.isMagicWindow = !this.isMagicWindow
         },
     },
     computed: {
         magicWindow() {
             //console.log(`magicWindowTrackingEnabled: ${this.isMagicWindow}`);
             return `magicWindowTrackingEnabled: ${this.isMagicWindow}`;
         }

     }
 }
</script>
