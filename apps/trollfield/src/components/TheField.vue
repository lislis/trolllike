we<template>
    <a-scene v-if="store.allPosts.length != 0">

        <!-- <a-plane position="0 0 -4" rotation="-90 0 0" width="20" height="20" color="#7BC8A4"></a-plane> -->
        <a-sky color="#ECECEC"></a-sky>
        <!-- <a-ocean width="50" depth="50" density="80" opacity="1" position="0 0.4 0"></a-ocean> -->

        <a-grid></a-grid>

        <!-- PLAYER -->
        <a-entity id="rig"
                  movement-controls="controls: keyboard,touch"
                  position="2 0 2">
            <a-entity camera
                      position="0 1.6 0"
                      look-controls>
                <a-entity cursor="fuse: true; fuseTimeout: 500"
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
                   :position="`${i * 1.5} 0.5 ${ i * -1}`" rotation="0 45 0"
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
     components: { },
     created() {
         isLoading: false;

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

         }
     }
 }
</script>
