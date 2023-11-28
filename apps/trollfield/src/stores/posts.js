import { defineStore } from 'pinia'

import { assembleArchive } from '@/util.js';


export const usePostsStore = defineStore('posts', {
    state: () => {
        return {
            posts: [],
            tags: [],
            currentFilter: null,
            page: {
                isFinal: false,
                current: null,
            },
            about: null,
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
        pageState(state) {
            return state.page;
        },
        aboutPage(state) {
            return state.about;
        }
    },
    actions: {
        addPosts(more) {
            let enhanced = assembleArchive(more, this.posts.length);
            let all = this.posts.concat(enhanced);
            this.posts = all;
        },
        addTags(more) {
            let all = this.tags.concat(more);
            this.tags = all;
        },
        selectFilter(filter) {
            this.currentFilter = filter;
        },
        setPageFinalFlag(state) {
            this.page.isFinal = state;
        },
        setPageCurrent(num) {
            this.page.current = num;
        },
        setAboutPage(d) {
            this.about = d;
        },
        async fetchAbout(url) {
            return fetch(url)
                .then(d => d.json())
                .then(d => {
                    this.about = d;
                    return d;
                }).catch(e => {
                    console.log("Error", e);
                });
        }
    },
});
