<template>
    <a-scene v-if="store.allPosts.length != 0" vr-mode-ui="enabled: false">

        <!-- <a-plane position="0 0 -4" rotation="-90 0 0" width="20" height="20" color="#7BC8A4"></a-plane> -->
        <a-sky color="#ECECEC"></a-sky>

        <a-entity environment="flatShading: true; horizonColor: #484848; gridColor: #eee; dressingColor: #c5c5c5; groundColor2: #cccccc; groundTexture: squares; groundYScale: 3.5299999999999994; grid: 1x1; active: true; fog: 0.74; dressingScale: 1.01; dressingAmount: 7; dressing: apparatus; ground: noise; skyType: gradient; skyColor: #0d0d0d; lightPosition: [object Object]; groundColor: #252525; dressingVariance: [object Object]; preset: checkerboard"></a-entity>

        <!-- PLAYER -->
        <a-entity id="rig"
                  movement-controls="controls: keyboard, touch, nipple"
                  nipple-controls="mode: dynamic"
                  position="8 0 14"
        >
            <a-entity camera
                      id="camera"
                      look-controls
                      position="0 1.6 0"
                      rotation="3 48 0">
                <a-entity cursor="fuse: true; fuseTimeout: 500"
                          animation__click="property: scale; startEvents: click; easing: easeInCubic; dur: 150; from: 0.1 0.1 0.1; to: 1 1 1"
                          animation__fusing="property: scale; startEvents: fusing; easing: easeInCubic; dur: 1500; from: 1 1 1; to: 0.1 0.1 0.1"
                          animation__mouseleave="property: scale; startEvents: mouseleave; easing: easeInCubic; dur: 500; to: 1 1 1"
                          position="0 0 -1"
                          geometry="primitive: ring; radiusInner: 0.02; radiusOuter: 0.03"
                          material="color: black; shader: flat">
                </a-entity>
            </a-entity>
        </a-entity>


        <!-- <a-tube path="5 0 5, 5 0 -5, -5 0 -5" radius="0.5"></a-tube> -->

        <a-light type="ambient" color="#ccc"></a-light>
        <a-light color="#ddf" distance="100" intensity="0.4" type="point"></a-light>
        <a-light color="#ddf" position="3 10 -10" distance="50" intensity="0.4" type="point"></a-light>

        <a-entity  v-for="(post, i) in store.getPostsByCurrentFilter"
                   :post-url="post.slug" cursor-listener
                   geometry="primitive: box; width: 1.5; height: 1.3; depth: 0.2"
                   :position="`${post.position[0]} 0.5 ${post.position[1]}`" rotation="0 45 0"
                   color="#4CC3D9">
            <a-text :value="post.title.rendered"
            position="-0.65 0 0.1"></a-text>
        </a-entity>


    </a-scene>
    <div v-else>
        Loading
    </div>
</template>

<script>
 import { usePostsStore } from '@/stores/posts'

 export default {
     name: "TheField",
     created() {
         isLoading: false;
         console.log(this.points);

         AFRAME.registerComponent('cursor-listener', {
             init() {
                 this.el.addEventListener('click', function (evt) {
                     let slug = evt.target.attributes['post-url'];
                     console.log(slug)
                     if (slug) {
                         window.vueRouter.push(`/${slug.value}`);
                     }
                 });
             }
         });

     },
     setup() {
         const store = usePostsStore();
         return { store }
     },
     methods: {
         color() {

         },
         position(index) {
             return ``;
         }
     }
 }
</script>
