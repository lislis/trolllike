<template>
    <a-entity :post-url="post.slug"
              cursor-listener
              :position="`${post.position[0]} ${post.height} ${post.position[1]}`" :rotation="`0 ${post.rot} 0`">

        <template v-if="hasImage">
            <a-image :post-url="post.slug"
                     :src="`#${post.slug}`"
                     width="1.5" :height="`${width / height * 1.5}`"></a-image>
        </template>
        <template v-else-if="isYouTube">
            <a-image :post-url="post.slug"
                     :src="`#${post.slug}`"
                     width="2" height="1.5"></a-image>
        </template>
        <template v-else>
            <a-entity :post-url="post.slug"  geometry="primitive: box; width: 1.5; height: 1.3; depth: 0.2"></a-entity>
            <a-text :post-url="post.slug"
                :value="post.title.rendered"
                position="-0.65 0 0.1"></a-text>
        </template>

    </a-entity>
</template>
<script>
 import {isPostYoutube,
         postYoutubeThumbnail,
         hasPostImage,
         postImgUrl } from '@/util.js';


 export default {
     name: "a-post",
     props: ['post'],
     computed: {
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
         }
     }
 }
</script>
