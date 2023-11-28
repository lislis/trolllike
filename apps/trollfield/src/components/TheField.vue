<template>
    <a-scene v-if="isFinal"
             vr-mode-ui="enabled: true"
             loading-screen="dotsColor: black; backgroundColor: white" >
        <a-assets>
            <img src="/sun.png" id="sun">
            <img src="/moon.png" id="moon">
            <img src="/blacksun.png" id="blacksun">
            <AAsset v-for="(post, i) in store.allPosts"
                    :key="post.id"
                    :post="post">
            </AAsset>
        </a-assets>

        <a-entity :environment="environment"></a-entity>


        <template v-if=isRagnarok>
            <a-image src="#blacksun" position="-25 32 -21" rotation="60 67 29" scale="12 12 12">
                <a-light color="#000000" distance="100" intensity="1.4" type="directional"></a-light>
            </a-image>
        </template>
        <template v-else>
        <a-image v-if="isDay" src="#sun" position="14 40 -6" rotation="69 -37 -92" scale="7 7 7">
            <a-light color="#ffffff" distance="100" intensity="1.4" type="directional"></a-light>
        </a-image>

        <a-image v-if="!isDay" src="#moon" position="12 35 6" rotation="67 -146 156" scale="5 5 5">
            <a-light color="#ffffff" distance="100" intensity="0.8" type="directional"></a-light>
        </a-image>
        </template>



        <!-- PLAYER -->
        <a-entity id="rig"
                  movement-controls="controls: keyboard, nipple"
                  nipple-controls="moveJoystickPosition: false"
                  position="0 0 0">
            <a-entity camera
                      id="camera"
                      :look-controls="magicWindow"
                      position="0 1.6 0">
                <a-entity cursor="rayOrigin:mouse"
                          position="0 0 -1"
                          material="color: black; shader: flat">
                </a-entity>
            </a-entity>
        </a-entity>

        <a-light type="ambient" color="#ccc" visible="false"></a-light>
        <a-light color="#ddf" distance="100" :visible="isPointOn" intensity="0.4" type="point"></a-light>

        <a-entity position="0 0 0" id="all-posts">
        <APost  v-for="(post, i) in store.getPostsByCurrentFilter"
                :key="post.id"
                :post="post">
        </APost>
        </a-entity>

    </a-scene>
    <div v-else>
        Loading
    </div>

    <div class="ui ui-bottom">
        <MagicWindowButton @magicWindowChanged="toggleMW" />
        <DaytimeButton v-if="!isRagnarok" @daytimeChanged="toggleDT" />
        <RagnarokButton @rChanged="toggleR" />
    </div>

    <div class="ui ui-top">
        <AboutButton />
    </div>
</template>

<script>
 import { usePostsStore } from '@/stores/posts'
 import APost from '@/components/APost.vue';
 import AAsset from '@/components/AAsset.vue';
 import MagicWindowButton from '@/components/MagicWindowButton.vue';
 import DaytimeButton from '@/components/DaytimeButton.vue';
 import RagnarokButton from '@/components/RagnarokButton.vue';
 import AboutButton from '@/components/AboutButton.vue';
 import { isGyroDevice } from '@/util';

 export default {
     name: "TheField",
     components: {APost, AAsset,
                  MagicWindowButton, DaytimeButton,
                  RagnarokButton, AboutButton},
     created() {
         isLoading: false;

         /* window.setTimeout(() => {
          *     document.querySelector("a-scene").addEventListener("loaded", () => {
          *         AFRAME.registerSystem("postprocessing", window.postprocessingSystem);
          *     });
          * }, 3000);
          */
         //console.log(this.points);
     },
     data() {
         return {
             isMagicWindow: false,
             isDay: true,
             isRagnarok: false,
             isPointOn: true,
         }
     },
     setup() {
         const store = usePostsStore();
         return { store }
     },
     methods: {
         toggleMW(state) {
             this.isMagicWindow = state;
         },
         toggleDT(state) {
             //console.log(state);
             this.isDay = state;
         },
         toggleR(state) {
             this.isRagnarok = state;
         }
     },
     computed: {
         isFinal() {
             return this.store.pageState.isFinal;
         },
         magicWindow() {
             return `magicWindowTrackingEnabled: ${this.isMagicWindow}`;
         },
         environment() {
             let skycolor, horizoncolor, fog;

             if (!this.isRagnarok) {
                 if (this.isDay) {
                     skycolor = '#1c71d8';
                     horizoncolor = '#99c1f1';
                     fog = 0.4;
                     this.isPointOn = true;
                 } else {
                     skycolor = '#192636';
                     horizoncolor = '#05111f';
                     fog = 0.7;
                     this.isPointOn = false;
                 }
             } else {
                 skycolor = '#a51d2d';
                 horizoncolor = '#c01c28';
                 fog = 0.8;
             }


             return `preset: checkerboard; active: true; seed: 8; skyType: gradient; skyColor:  ${skycolor}; horizonColor: ${horizoncolor}; fog: ${fog}; lightPosition: [object Object]; ground: noise; groundYScale: 1.18; groundTexture: squares; groundColor: #252525; groundColor2: #111111; dressing: trees; dressingAmount: 20; dressingColor: #888b1d; dressingScale: 1; dressingVariance: [object Object]; gridColor: #333333; grid: 1x1; gridColor: #ffffff`;
         }
     }
 }
</script>
