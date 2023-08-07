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

        <Renderer ref="renderer" resize="window" v-if="store.allPosts.length != 0">
            <Camera :position="{ y: 5, z: 15 }" />
            <Scene ref="scene" background="#cccccc">
                <DirectionalLight color="#ffffff" intensity="3"
                                  :position="{x: 1, y: 1, z: 1}" />
                <DirectionalLight color="#002288" intensity="3"
                                  :position="{x: -1, y: -1, z: -1}" />
                <AmbientLight color="#555555" />


                <Box v-for="(val, key) in store.allPosts" :key="key" :ref="`mesh-${key}`"
                     :position="position(key)">
                    <LambertMaterial />
                </Box>

            </Scene>
        </Renderer>
    </div>
</template>

<script>
 import { usePostsStore } from '@/stores/posts'

 export default {
     name: "TrollfieldHomeView",
     components: { },
     created() {
         isLoading: false
         //window.scroll({top: 0, behavior: 'smooth'});
     },
     setup() {
         const store = usePostsStore();
         return { store }
     },
     mounted() {
         const renderer = this.$refs.renderer;
        // const box = this.$refs.box.mesh;
        // renderer.onBeforeRender(() => {
        //     box.rotation.x += 0.01;
         // });

         //debugger
     },
     methods: {
         position(i) {
             return {x: i + 1 , y: i + 1, z: -5 };
         }
     }
 }
</script>
