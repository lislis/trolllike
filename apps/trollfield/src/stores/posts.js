import { defineStore } from 'pinia'

export const usePostsStore = defineStore('posts', {
    state: () => {
        return {
            posts: [],
            tags: [],
            currentFilter: null
        };
    },
    getters: {
        allPosts(state) {
            return state.posts;
        },
        getPostBySlug(state) {
            return (slug) => state.posts.find(x => x.slug === slug);
        },
        getPostsByCurrentFilter(state) {
            if (state.currentFilter == null) {
                return state.posts;
            } else {
                return state.posts.filter(x => x.tags.includes(state.currentFilter));
            }
        },
        allTags(state) {
            return state.tags;
        },
    },
    actions: {
        addPosts(more) {
            let all = this.posts.concat(more);
            this.posts = all;
        },
        addTags(more) {
            let all = this.tags.concat(more);
            this.tags = all;
        },
        selectFilter(filter) {
            this.currentFilter = filter;
        }
    },
});
