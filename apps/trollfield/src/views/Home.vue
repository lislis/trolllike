<template>
    <div>
        <h2>Home</h2>
        <ul v-if="store.allPosts.length != 0">
            <li v-for="post in store.allPosts">
                <router-link :to="post.slug" v-html="post.title.rendered"></router-link>
            </li>
        </ul>
        <div v-else>
            Loading
        </div>

        <Renderer ref="renderer" resize orbit-ctrl pointer v-if="store.allPosts.length != 0">
            <Camera :position="{ y: 8, z: 18 }" />
            <Scene ref="scene" background="#cccccc">
                <DirectionalLight color="#ffffff" intensity="3"
                                  :position="{x: 1, y: 1, z: 1}" />
                <DirectionalLight color="#002288" intensity="3"
                                  :position="{x: -1, y: -1, z: -1}" />
                <AmbientLight color="#555555" />

                <Box v-for="(val, key) in store.allPosts" :key="key" :ref="`mesh-${key}`"
                     :position="position(key)"
                     @pointerEnter="onPointerOver"
                     @pointerLeave="onPointerOver"
                     @click="onPointerClick(val)">
                    <PhongMaterial color="#667788" />
                </Box>

            </Scene>

        </Renderer>
    </div>
</template>

<script>
 import { usePostsStore } from '@/stores/posts'
 import { TrackballControls } from 'three/examples/jsm/controls/TrackballControls.js';
3
 export default {
     name: "TrollfieldHomeView",
     components: { },
     data() {
         return {
             baseColor: { r: 0.58, g: 0.14, b: 0.47},
             hoverColor: { r: 0.3, g: 0.3, b: 0.9},
         }
     },
     created() {
         isLoading: false
         //window.scroll({top: 0, behavior: 'smooth'});
     },
     setup() {
         const store = usePostsStore();
         return { store }
     },
     mounted() {
         //const renderer = this.$refs.renderer;
         //const orbitCtrl = renderer.three.cameraCtrl;

         //orbitCtrl.enablePan = false;
         //const box = this.$refs.box.mesh;
         //renderer.onBeforeRender(() => {
            // box.rotation.x += 0.01;
         //});
     },
     methods: {
         position(i) {
             return {x: Math.random() * 10 , y: 0, z: Math.random() * 10 };
         },
         onPointerOver({over, component}) {
             if (over) {
                 //console.log(component.material.color)
                 component.material.color = this.hoverColor;
             } else {
                 component.material.color = this.baseColor;
             }
         },
         onPointerClick(e) {
             //console.log(e);
             this.$router.push(e.slug)
             //debugger
         },
         materialColor() {
             return
         }
     }
 }
</script>
