import PerlinNoise from 'perlin-noise-2d';
import { points } from '@/data.js';

// use this to generate new points
// let new_points = samplePoints();

// This can be used to copy the points and then paste them
// to @/data.js
window.points = points;


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


export const samplePoints = () => {
    const x_max = 70;
    const y_max = 70;

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
}

export const assembleArchive = (entries, startIndex) => {
    const perlin = new PerlinNoise(2938, 345, 1984);

    return entries
        .map((x, i) => {
            let index = startIndex + i;
            x.position = points[index];
            return x;
        }).map((x, i) => {

            let p = perlin.perlin(Math.abs(x.position[0]), Math.abs(x.position[1]));

            x.height = 0.7;
            if (p) {
                x.height = Math.abs(p) * 4 + 0.85;
            }

            return x;
        }).map(x => {
            x.rot = Math.ceil((Math.random() * 2 - 1) * 35);
            return x;
        }).map(x => {
          //  x.position[0] = x.position[0] - (x_max/2.0);
          //  x.position[1] = x.position[1] - (y_max/2.0);
            return x;
        }).filter(x => {
            return !isNaN(x.position[0]) && !isNaN(x.position[1]);
        });
};
