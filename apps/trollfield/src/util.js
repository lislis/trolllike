export const isPostYoutube = (post, tagId) => {
    ////https://i3.ytimg.com/vi/9FgXXcKC5uU/maxresdefault.jpg
    return post.tags.includes(tagId);
};

export const hasPostImage = (post) => {
    return (post['_embedded']['wp:featuredmedia'] &&
            post['_embedded']['wp:featuredmedia'].length >= 1);
};

export const postImgUrl = (post) => {
    return post['_embedded']['wp:featuredmedia'][0]['media_details']['sizes']['full']['source_url'];
};

export const postYoutubeThumbnail = (post) => {
    // https://i3.ytimg.com/vi/9FgXXcKC5uU/maxresdefault.jpg
    // https://www.youtube.com/watch?v=zE7PKRjrid4
    let str = '';
    if (post.meta.youtube_link && post.meta.youtube_link !== "") {
        str = `/${post.meta.youtube_link.replace("www.youtube.com/watch?v=", "i3.ytimg.com/vi/")}/maxresdefault.jpg`;
    }
    return str;
};
