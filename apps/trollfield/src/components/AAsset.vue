<template>
    <template>
        <img v-if="isYouTube"
             :id="post.slug"
             :src="youTubeThumbnail"
             crossorigin="anonymous">

        <video v-else-if="isVideo"
               :id="post.slug"
               :src="videoUrl"
               webkit-playsinline
               playsinline
               crossorigin="anonymous"></video>

        <img v-else-if="hasImage"
             :id="post.slug"
             :src="post['_embedded']['wp:featuredmedia'][0]['media_details']['sizes']['full']['source_url']"
             crossorigin="anonymous">

    </template>
</template>
<script>
 import { usePostsStore } from "@/stores/posts.js";
 import {isPostYoutube,
         postYoutubeThumbnail,
         hasPostImage,
         postImgUrl,
         isVideo,
         postVideoUrl } from '@/util.js';


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
             console.log(postYoutubeThumbnail(this.post), this.post.title.rendered);
             return postYoutubeThumbnail(this.post);
         },
         hasImage() {
             return hasPostImage(this.post);
         },
         imgUrl() {
             return postImgUrl(this.post);
         },
         isVideo() {
             const vidID = parseInt(window.wpData.video_tag_id, 10);
             return isVideo(this.post, vidID);
         },
         videoUrl() {
             return postVideoUrl(this.post);
         }
     }

 }
</script>
