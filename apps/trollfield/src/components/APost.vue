<template>
    <a-entity :post-url="post.slug"
              cursor-listener
              :position="`${posX} ${post.height} ${posZ}`" :rotation="`0 ${post.rot} 0`">

        <a-image  v-if="isYouTube"
                  :post-url="post .slug"
                  :src="`#${post.slug}`"
                  width="2.2" height="1.5"></a-image>

        <a-video  v-else-if="isVideo"
                  :post-url="post.slug"
                  :src="`#${post.slug}`"
                  :width="videoWidth" :height="videoHeight"
                  autoplay loop="true"></a-video>

        <a-image  v-else-if="hasImage"
                  :post-url="post.slug"
                  :src="`#${post.slug}`"
                  width="1.5" :height="`${height / width * 1.5}`"></a-image>

        <template v-else>
            <a-text
                    :value="post.title.rendered"
                    :text="textAttr"
                    position="-0.65 0 0.1">
                <a-entity
                    :post-url="post.slug"
                    position="2.1 0.5 0"
                    geometry="primitive: plane; width: 4.3; height: 2.5;" material="visible: false" ></a-entity>
            </a-text>
        </template>
    </a-entity>
</template>
<script>
 import {isPostYoutube,
         postYoutubeThumbnail,
         hasPostImage,
         postImgUrl,
         getRandomColor,
         isVideo } from '@/util.js';


 export default {
     name: "a-post",
     props: ['post'],
     data() {
         return {
             videoWidth: null,
             videoHeight: null
         }
     },
     mounted() {
         if (this.isVideo) {
             window.setTimeout(() => {
                 let el = document.querySelector(`#${this.post.slug}`);
                 let ratio = el.videoHeight / el.videoWidth;
                 this.videoWidth = 2.2;
                 this.videoHeight = this.videoWidth * ratio;
             }, 100);
         }
     },
     computed: {
         textAttr() {
             return `side: double; wrapCount: 13; baseline: bottom; color: ${getRandomColor()}`;
         },
         isYouTube() {
             const ytID = parseInt(window.wpData.youtube_tag_id, 10);
             return isPostYoutube(this.post, ytID);
         },
         hasImage() {
             return hasPostImage(this.post);
         },
         imgUrl() {
             return postImgUrl(this.post);
         },
         width() {
             return this.post['_embedded']['wp:featuredmedia'][0]['media_details']['sizes']['full']['width'];
         },
         height() {
             return this.post['_embedded']['wp:featuredmedia'][0]['media_details']['sizes']['full']['height'];
         },
         isVideo() {
             const vidID = parseInt(window.wpData.video_tag_id, 10);
             return isVideo(this.post, vidID);
         },
         posX() {
             return this.post.position[0];
         },
         posZ() {
             return this.post.position[1];
         }
     }
 }
</script>
