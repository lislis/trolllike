<template>
    <template>
        <img v-if="hasImage"
             :id="post.slug"
             :src="post['_embedded']['wp:featuredmedia'][0]['media_details']['sizes']['full']['source_url']"
             crossorigin="anonymous">

        <img v-else="isYouTube"
             :id="post.slug"
             :src="youTubeThumbnail"
             crossorigin="anonymous">
    </template>
</template>
<script>
 import { usePostsStore } from "@/stores/posts.js";
 import {isPostYoutube,
         postYoutubeThumbnail,
         hasPostImage,
         postImgUrl } from '@/util.js';


 export default {
     name: "AAsset",
     props: ['post'],
     setup() {
         const store = usePostsStore();
         return { store }
     },
     computed: {
         isYouTube() {
             const ytID = parseInt(window.wpData.youtube_tag_id, 10);
             return isPostYoutube(this.post, ytID);
         },
         youTubeThumbnail() {
             return postYoutubeThumbnail(this.post);
         },
         hasImage() {
             return hasPostImage(this.post);
         },
         imgUrl() {
             return postImgUrl(this.post);
         }
     }

 }
</script>
