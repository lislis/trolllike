<template>
    <div class="single-view" v-if="item && item.title">
        <router-link to="/" class="close-btn">
            <span class="a11y-hidden">Close</span>
            <svg viewBox="0 0 384 512"><path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/></svg>
        </router-link>
        <h3 v-html="item.title.rendered" class="a11y-hidden"></h3>
        <div v-if="isExternal">
            <a :href="item.meta.external_link" class="external-link" target="_blank" referrerpolicy="no-referrer">{{item.title.rendered}}</a>
        </div>
        <div v-else v-html="item.content.rendered" class="single-content-wrapper"></div>
    </div>
</template>

<script>
 import { usePostsStore } from '@/stores/posts'

 export default {
     name: "TrollfieldSingleView",
     components: { },
     setup() {
         const store = usePostsStore();
         return { store }
     },
     created() {
         window.setTimeout(() => {this.showPDF()}, 100);
     },
     computed: {
         item() {
             return this.store.getPostBySlug(this.$route.params.slug);
         },
     },
     methods: {
         showPDF() {
             let obj = document.querySelector('.wp-block-file__embed');
             if (obj && obj.hidden) {
                 obj.hidden = false;
             }
         },
         isExternal() {
             const linkID = parseInt(window.wpData.link_tag_id, 10);
             return this.post.tags.includes(linkID);
         }
     }
 }
</script>
