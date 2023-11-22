<template>
    <a-entity :post-url="post.slug"
              cursor-listener
              :position="`${post.position[0]} ${post.height} ${post.position[1]}`" :rotation="`0 ${post.rot} 0`">

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
            <a-text :post-url="post.slug"
                    :value="post.title.rendered"
                    :text="textAttr"
                    position="-0.65 0 0.1"></a-text>
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
             return `font: exo2bold;side: double; wrapCount: 15; color: ${getRandomColor()}`;
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
         }
     }
 }
</script>
