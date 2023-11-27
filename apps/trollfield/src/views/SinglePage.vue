<template>
    <div class="single-view">
        <router-link to="/" class="close-btn">
            <span class="a11y-hidden">Close</span>
            <svg viewBox="0 0 384 512"><path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/></svg>
        </router-link>
        <div  v-if="isLoading" class="single-content-wrapper">Loading</div>
        <div v-else class="single-content-wrapper">
            <h1 v-html="page.title.rendered"></h1>
            <div v-html="page.content.rendered"></div>
        </div>
    </div>
</template>

<script>
 export default {
     name: "TrollfieldSinglePageView",
     components: { },
     data() {
         return {
             page: null,
             isLoading: false,
         }
     },
     created() {
         this.isLoading = true;
         fetch(`${window.wpData.rest_url}/wp/v2/pages/${window.wpData.about_page_id}`)
             .then(d => d.json())
             .then(d => {
                 this.page = d;
                 this.isLoading = false;
             }).catch(e => {
                 console.log("Error", e);
             });
     },
     computed: {

     }
 }
</script>
