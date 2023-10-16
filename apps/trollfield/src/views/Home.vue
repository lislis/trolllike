<template>
    <div>
        <a-scene>
            <a-box position="-1 0.5 -3" rotation="0 45 0" color="#4CC3D9"></a-box>
            <a-sphere position="0 1.25 -5" radius="1.25" color="#EF2D5E"></a-sphere>
            <a-cylinder position="1 0.75 -3" radius="0.5" height="1.5" color="#FFC65D"></a-cylinder>
            <a-plane position="0 0 -4" rotation="-90 0 0" width="4" height="4" color="#7BC8A4"></a-plane>
            <a-sky color="#ECECEC"></a-sky>
            <a-entity hello-world></a-entity>
        </a-scene>

        <ul v-if="store.allPosts.length != 0">
            <li v-for="post in store.allPosts">
                <router-link :to="post.slug" v-html="post.title.rendered"></router-link>
            </li>
        </ul>
        <div v-else>
            Loading
        </div>


    </div>
</template>

<script>
 import { usePostsStore } from '@/stores/posts'
 import '@/PostAvatar.js';


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
