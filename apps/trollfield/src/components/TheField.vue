<template>
    <a-scene v-if="isFinal"
             vr-mode-ui="enabled: true"
             loading-screen="dotsColor: black; backgroundColor: white" >
        <a-assets>
            <img :src="whichPath('assets/sun.png')" id="sun">
            <img :src="whichPath('assets/moon.png')" id="moon">
            <img :src="whichPath('assets/blacksun.png')" id="blacksun">
            <a-asset-item id="wolf"
                          response-type="arraybuffer"
                          :src="whichPath('assets/toon_mutant_wolf.glb')"></a-asset-item>

            <AAsset v-for="(post, i) in store.allPostsWithImage"
                    :key="post.id"
                    :post="post">
            </AAsset>

            <img v-for="([slug, url], key) in youtube_urls"
                 :id="slug"
                 :src="url"
                 crossorigin="anonymous">
        </a-assets>

        <a-entity :environment="environment" visible="true"></a-entity>


        <a-entity id="mountains"  position="0 -1 0"
                  rotation="0 -90 0"
                  scale="15 15 15"
                  :gltf-model="mountainUrl">
        </a-entity>

        <a-entity id="forest"  position="-11 -0.1 14"
                  rotation="0 60 0"
                  scale="10 10 10"
                  :gltf-model="forestUrl">
        </a-entity>

        <template v-if=isRagnarok>
            <a-image src="#blacksun" position="-60 32 -21" rotation="42 74 39" scale="12 12 12">
                <a-light color="#000000" distance="100" intensity="1.4" type="directional"></a-light>
            </a-image>

            <a-entity id="fenris"
                      position="25 0 -25"
                      rotation="0 -90 0"
                      scale="15 15 15"
                      animation-mixer="clip: walk; loop: repeat; timeScale: 1.0; repetitions: Infinity"
                      gltf-model="#wolf">
            </a-entity>
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

        <a-light type="ambient" color="#ccc" visible="true"></a-light>
        <a-light color="#ddf" distance="100" :visible="isPointOn" intensity="0.4" type="point"></a-light>


        <a-entity position="6.76 0 21" id="all-posts">
            <APost  v-for="(post, i) in store.getPostsByCurrentFilter"
                    :key="post.id"
                    :post="post"
                    :isRagnarok="isRagnarok">
            </APost>
        </a-entity>

    </a-scene>
    <div v-else>
        Loading
    </div>

    <div class="ui ui-bottom">
        <DaytimeButton v-if="!isRagnarok" @daytimeChanged="toggleDT" />
        <RagnarokButton @rChanged="toggleR" />
        <MagicWindowButton @magicWindowChanged="toggleMW" />
        <AboutButton />
    </div>

    <div class="ui ui-top">

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
         },
         whichPath(path) {
             let host = window.location.hostname;
             if (host === 'localhost') {
                 return `/${path}`;
             } else {
                 return `/wp-content/themes/trolllike/apps/trollfield/dist/${path}`;
             }
         },
     },
     computed: {
         isFinal() {
             return this.store.pageState.isFinal;
         },
         magicWindow() {
             return `magicWindowTrackingEnabled: ${this.isMagicWindow}`;
         },
         mountainUrl() {
             return `url(${this.whichPath('assets/mountains2.glb')})`;
         },
         forestUrl() {
             return `url(${this.whichPath('assets/forest.glb')})`;
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
                 fog = 0.9;
             }

             return `preset: checkerboard; active: true; seed: 8; skyType: gradient; skyColor:  ${skycolor}; horizonColor: ${horizoncolor}; fog: ${fog}; lightPosition: [object Object]; ground: noise; groundYScale: 1.18; groundTexture: squares; groundColor: #252525; groundColor2: #111111; dressing: none; gridColor: #333333; grid: 1x1; gridColor: #ffffff`;
         },
         youtube_urls() {
             return Object.entries(window.wpData.youtube_urls);
         },
         video_urls() {
             return Object.entries(window.wpData.video_urls);
         }
     }
 }
</script>
