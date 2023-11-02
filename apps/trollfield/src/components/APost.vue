<template>
    <a-entity :post-url="post.slug"
              cursor-listener
              :position="`${post.position[0]} ${post.height} ${post.position[1]}`" rotation="0 45 0">

        <template v-if="hasImage">
            <a-image :post-url="post.slug"
                     :src="`#${post.slug}`"
                     width="1.5" :height="`${width / height + 1.5}`"></a-image>
        </template>
        <template v-else-if="isYouTube">
            <a-image :post-url="post.slug"
                     :src="`#${post.slug}`"
                     width="2" height="1.5"></a-image>
        </template>
        <template v-else>
            <a-entity :post-url="post.slug"  geometry="primitive: box; width: 1.5; height: 1.3; depth: 0.2"></a-entity>
            <a-text :post-url="post.slug"
                :value="post.tags"
                position="-0.65 0 0.1"></a-text>
        </template>

    </a-entity>
</template>
<script>
 export default {
     name: "a-post",
     props: ['post'],
     computed: {
         isYouTube() {
             ////https://i3.ytimg.com/vi/9FgXXcKC5uU/maxresdefault.jpg
             const ytID = parseInt(window.wpData.youtube_tag, 10);
             console.log(`template is youtube ${this.post.tags.includes(ytID)}`);
             return this.post.tags.includes(ytID);
         },
         hasImage() {
             return (this.post['_embedded']['wp:featuredmedia'] &&
                 this.post['_embedded']['wp:featuredmedia'].length >= 1);
         },
         imgUrl() {
             return this.post['_embedded']['wp:featuredmedia'][0]['media_details']['sizes']['full']['source_url'];
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
