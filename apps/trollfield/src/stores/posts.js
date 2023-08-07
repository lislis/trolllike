import { defineStore } from 'pinia'

export const usePostsStore = defineStore('posts', {
    state: () => {
        return {
            posts: [],
        };
    },
    getters: {
        allPosts(state) {
            return state.posts;
        },
        getPostBySlug(state) {
            return (slug) => state.posts.find(x => x.slug === slug);
        }
        // getFilteredCategories(state) {
        //   if (state.filter === 'none') {
        //     return state.categories;
        //   } else {
        //     const tagId = parseInt(state.filter, 10);
        //     return state.categories.filter(x => x.listArticles.map(y => y.tags.includes(tagId)).length > 0);
        //   }
        // },
    },
    actions: {
        add(more) {
            let all = this.posts.concat(more);
            this.posts = all;
        }
    },
});
