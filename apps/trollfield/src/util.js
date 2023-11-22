export const isPostYoutube = (post, tagId) => {
    //https://i3.ytimg.com/vi/9FgXXcKC5uU/maxresdefault.jpg
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
    const id = post.id;
    let str = '';
    // this is an object that's filled by wordpress
    if (window.wpData.youtube_urls[id]) {
        str = window.wpData.youtube_urls[id];
    }
    return str;
};

export const isVideo = (post, tagId) => {
    return post.tags.includes(tagId);
};

export const postVideoUrl = (post) => {
    let str = '';
    if (post['meta']['video_link']) {
        str = post['meta']['video_link'];
    }
    return str;
};

export const samplePoints = (x_max, y_max) => {
    let pds = new FastPoissonDiskSampling({
        shape: [x_max, y_max],
        radius: 3,
        tries: 7
    });

    return pds.fill();
};

export const getRandomColor = () => {
  var letters = '0123456789ABCDEF';
  var color = '#';
  for (var i = 0; i < 6; i++) {
    color += letters[Math.floor(Math.random() * 16)];
  }
  return color;
};
